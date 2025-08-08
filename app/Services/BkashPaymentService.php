<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BkashPaymentService
{
    private $token;

    public function __construct()
    {
        $this->token = $this->getToken();
    }

    private function getToken()
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'username' => env('BKASH_USERNAME'),
            'password' => env('BKASH_PASSWORD'),
        ])->post(env('BKASH_BASE_URL') . '/token/grant', [
            'app_key' => env('BKASH_APP_KEY'),
            'app_secret' => env('BKASH_APP_SECRET'),
        ]);

        return $response['id_token'] ?? null;
    }

    public function createPayment($amount, $invoice = null)
    {
        return Http::withHeaders([
            'Authorization' => $this->token,
            'X-APP-Key' => env('BKASH_APP_KEY'),
        ])->post(env('BKASH_BASE_URL') . '/create', [
            'amount' => $amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber' => $invoice ?? uniqid('inv_'),
            'callbackURL' => env('BKASH_CALLBACK_URL'),
        ])->json();
    }

    public function executePayment($paymentID)
    {
        return Http::withHeaders([
            'Authorization' => $this->token,
            'X-APP-Key' => env('BKASH_APP_KEY'),
        ])->post(env('BKASH_BASE_URL') . '/execute/' . $paymentID)->json();
    }
}
