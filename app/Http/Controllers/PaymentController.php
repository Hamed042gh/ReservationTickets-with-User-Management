<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Payment;
use App\Models\Reservation;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Enums\ReservationStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\PaymentRequestStore;

class PaymentController extends Controller
{
    private const ZIBAL_API_REQUEST = 'https://gateway.zibal.ir/v1/request';
    private const ZIBAL_API_VERIFY = 'https://gateway.zibal.ir/v1/verify';
    private const ZIBAL_API_INQUIRY = 'https://gateway.zibal.ir/v1/inquiry';
    private const CALLBACK_URL = 'http://localhost/payment/callback';

    public function requestPayment(PaymentRequestStore $request)
    {
        $zibalResponse = $this->sendRequestToZibal($request);

        if (isset($zibalResponse['trackId'])) {
            $this->storePayment($request, $zibalResponse['trackId']);
            return redirect('https://gateway.zibal.ir/start/' . $zibalResponse['trackId']);
        }

        return $this->handleError('Error in payment system!');
    }

    private function sendRequestToZibal(PaymentRequestStore $request)
    {
        $response =  Http::post(self::ZIBAL_API_REQUEST, [
            'merchant' => 'zibal',
            'amount' => $request->input('amount'),
            'ticket_id' => $request->input('ticket_id'),
            'callbackUrl' => self::CALLBACK_URL,
            'description' => 'Order payment',
        ])->json();

        return $response;
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
            $verifyResponse = $this->verifyPaymentWithZibal($trackId);

            if ($verifyResponse['result'] == 100) {

                return $this->handleSuccessfulPayment($trackId);
            }
        }

        return $this->handleFailedPayment($trackId);
    }

    protected function verifyPaymentWithZibal($trackId)
    {
        $response = Http::post(self::ZIBAL_API_VERIFY, [
            'merchant' => 'zibal',
            'trackId' => $trackId,
        ])->json();
        if (isset($response['error'])) {
            return [
                'result' => 0,
                'message' => $response['error'],
            ];
        }
        return $response;
    }

    protected function handleSuccessfulPayment($trackId)
    {
        $payment = Payment::where('track_id', $trackId)->first();

        if (!$payment) {
            return $this->handleError('payment not found!');
        }

        $inquiryResponse = $this->inquiry($trackId);
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

            $payment->status = PaymentStatus::SUCCESS_CONFIRMED->value;
            $payment->save();

            $reservation->status = ReservationStatus::RESERVED->value;
            $reservation->save();


            $ticket->decrement('available_count');
            for ($i = 1; $i <= 2; $i++) {
                Cache::forget('Cache:tickets_page_' . $i);
            }
            
        });
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

        return redirect('/tickets')->with('error', 'Payment failed. Please try again later.');
    }

    protected function inquiry($trackId)
    {
        $response = Http::post(self::ZIBAL_API_INQUIRY, [
            'merchant' => 'zibal',
            'trackId' => $trackId,
        ])->json();

        return $response;
    }

    protected function handlePaymentStatus(int $status, $amount, $paidAt)
    {
        switch (PaymentStatus::from($status)) {
            case PaymentStatus::SUCCESS_CONFIRMED:
                return redirect('/tickets')->with('success', 'Your payment was made with the amount of ' . $amount . ' on ' . $paidAt);
            case PaymentStatus::SUCCESS_UNCONFIRMED:
                return redirect('/tickets')->withErrors(['payment' => 'Payment successful but not yet confirmed.']);
            case PaymentStatus::CANCELED_BY_USER:
                return redirect('/tickets')->withErrors(['payment' => 'Payment canceled by the user.']);
            case PaymentStatus::PENDING:
                return redirect('/tickets')->withErrors(['payment' => 'Payment is pending.']);
            case PaymentStatus::INTERNAL_ERROR:
                return redirect('/tickets')->withErrors(['payment' => 'An internal error occurred.']);
            default:
                return redirect('/tickets')->withErrors(['payment' => 'Unknown payment status.']);
        }
    }

    protected function handleError(string $message)
    {

        return redirect('/tickets')->withErrors(['payment' => $message]);
    }
}
