<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Reservation;
use App\Enums\PaymentStatus;
use App\Services\LockTicket;
use Illuminate\Http\Request;
use App\Services\CacheTickets;
use App\Services\ZibalService;
use App\Enums\ReservationStatus;
use App\Events\UpdateTicketsCount;
use App\Jobs\SendReservationEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequestStore;

class PaymentController extends Controller
{
    private $cacheTickets;
    private $lockTicket;
    private $zibalService;

    public function __construct(CacheTickets $cacheTickets, LockTicket $lockTicket, ZibalService $zibalService)
    {
        $this->cacheTickets = $cacheTickets;
        $this->lockTicket = $lockTicket;
        $this->zibalService = $zibalService;
    }

    public function requestPayment(PaymentRequestStore $request)
    {
        $zibalResponse = $this->zibalService->sendRequestToZibal(
            $request->input('amount'),
            $request->input('ticket_id')
        );

        if (isset($zibalResponse['trackId'])) {
            $this->storePayment($request, $zibalResponse['trackId']);
            return redirect('https://gateway.zibal.ir/start/' . $zibalResponse['trackId']);
        }

        return $this->handleError('Error in payment system!');
    }



    private function storePayment(PaymentRequestStore $request, string $trackId)
    {
        Payment::create([
            'ticket_id' => $request->input('ticket_id'),
            'track_id' => $trackId,
            'amount' => $request->input('amount'),
            'payer_name' => $request->input('payerName'),
            'payer_identity' => $request->input('payerIdentity'),
            'status' => PaymentStatus::PENDING->value,
            'user_id' => Auth::id(),
            'reservation_id' => $request->input('reservation_id'),
        ]);
    }

    public function verifyPayment(Request $request)
    {
        $trackId = $request->input('trackId');
        $success = $request->input('success');

        if ($success == '1') {
            $verifyResponse = $this->zibalService->verifyPaymentWithZibal($trackId);

            if ($verifyResponse['result'] == 100) {

                return $this->handleSuccessfulPayment($trackId);
            }
        }

        return $this->handleFailedPayment($trackId);
    }


    protected function handleSuccessfulPayment($trackId)
    {
        $payment = Payment::where('track_id', $trackId)->first();

        if (!$payment) {
            return $this->handleError('payment not found!');
        }
        $ticket = $payment->reservation->ticket;


        $inquiryResponse = $this->zibalService->inquiry($trackId);
        if (!isset($inquiryResponse['status'], $inquiryResponse['amount'], $inquiryResponse['paidAt'])) {
            return $this->handleError('Invalid response from payment inquiry.');
        }

        if ($inquiryResponse['status'] == PaymentStatus::SUCCESS_CONFIRMED->value) {
            $reservation = $payment->reservation;
            $ticket = $reservation->ticket;

            $this->updatePaymentAndReservationStatus($payment, $reservation, $ticket);
        } else {
            $this->handleError('Payment was not successful.');
        }


        $amount = $inquiryResponse['amount'];
        $paidAt = $inquiryResponse['paidAt'];
        $paidAt = Carbon::parse($paidAt)->format('Y-m-d H:i:s');

        return $this->handlePaymentStatus($payment->status, $amount, $paidAt);
    }

    protected function updatePaymentAndReservationStatus(Payment $payment, Reservation $reservation, Ticket $ticket)
    {
        DB::transaction(function () use ($payment, $reservation, $ticket) {
            try {
                // Update payment and reservation status
                $payment->status = PaymentStatus::SUCCESS_CONFIRMED->value;
                $payment->save();

                $reservation->status = ReservationStatus::RESERVED->value;
                $reservation->save();

                $ticket->decrement('available_count');

                // Commit transaction if everything is fine
                DB::commit();

                // After transaction commit, handle Redis and cache clearing
                broadcast(new UpdateTicketsCount($ticket))->toOthers();


                // Clear cache related to tickets
                $this->cacheTickets->clearCache();

                // Remove the ticket lock
                $this->lockTicket->removeRedisLock($ticket);
            } catch (\Exception $e) {
                // If there is an error, rollback the transaction
                DB::rollback();

                // Release the lock in case of error
                $this->lockTicket->removeRedisLock($ticket);

                throw $e; // Optionally rethrow the exception for further handling
            }
        });

        //sending email related reservation
        $user = $payment->user;
        $reservation = $payment->reservation;
        SendReservationEmail::dispatch($user, $reservation);
    }

    protected function handleFailedPayment($trackId)
    {
        $payment = Payment::where('track_id', $trackId)->first();

        if ($payment) {
            $payment->status = PaymentStatus::INTERNAL_ERROR->value;
            $payment->save();

            $reservation = $payment->reservation;
            if ($reservation) {
                $reservation->status = ReservationStatus::CANCELED->value;
                $reservation->save();
            }
        }
        $ticket = $payment->reservation->ticket;

        // Remove the ticket lock
        $this->lockTicket->removeRedisLock($ticket);
        return redirect('/tickets')->with('error', 'Payment failed. Please try again later.');
    }


    protected function handlePaymentStatus(int $status, $amount, $paidAt)
    {
        return match (PaymentStatus::from($status)) {
            PaymentStatus::SUCCESS_CONFIRMED =>
            redirect('/tickets')->with('success', 'Your payment was made with the amount of ' . $amount . ' on ' . $paidAt),

            PaymentStatus::SUCCESS_UNCONFIRMED =>
            redirect('/tickets')->withErrors(['payment' => 'Payment successful but not yet confirmed.']),

            PaymentStatus::CANCELED_BY_USER =>
            redirect('/tickets')->withErrors(['payment' => 'Payment canceled by the user.']),

            PaymentStatus::PENDING =>
            redirect('/tickets')->withErrors(['payment' => 'Payment is pending.']),

            PaymentStatus::INTERNAL_ERROR =>
            redirect('/tickets')->withErrors(['payment' => 'An internal error occurred.']),

            default =>
            redirect('/tickets')->withErrors(['payment' => 'Unknown payment status.']),
        };
    }


    protected function handleError(string $message)
    {

        return redirect('/tickets')->withErrors(['payment' => $message]);
    }
}
