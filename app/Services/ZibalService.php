<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZibalService
{
    private $apiRequest;
    private $apiVerify;
    private $apiInquiry;
    private $callbackUrl;
    private $merchant;

    public function __construct()
    {
        $this->apiRequest = env('ZIBAL_API_REQUEST', 'https://gateway.zibal.ir/v1/request');
        $this->apiVerify = env('ZIBAL_API_VERIFY', 'https://gateway.zibal.ir/v1/verify');
        $this->apiInquiry = env('ZIBAL_API_INQUIRY', 'https://gateway.zibal.ir/v1/inquiry');
        $this->callbackUrl = env('ZIBAL_CALLBACK_URL', 'http://h00wen41.ir/payment/callback');
        $this->merchant = env('ZIBAL_MERCHANT', 'zibal');
    }

    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    public function sendRequestToZibal($amount, $ticket_id)
    {
        return Http::post($this->apiRequest, [
            'merchant' => $this->merchant,
            'amount' => $amount,
            'ticket_id' => $ticket_id,
            'callbackUrl' => $this->getCallbackUrl(),
            'description' => 'Order payment',
        ])->json();
    }

    public function verifyPaymentWithZibal($trackId)
    {
        $response = Http::post($this->apiVerify, [
            'merchant' => $this->merchant,
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

    public function inquiry($trackId)
    {
        $response = Http::post($this->apiInquiry, [
            'merchant' => $this->merchant,
            'trackId' => $trackId,
        ])->json();

        return $response;
    }
}
