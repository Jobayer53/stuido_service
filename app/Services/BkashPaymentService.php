<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BkashPaymentService
{
    private $baseUrl;
    private $appKey;
    private $appSecret;
    private $username;
    private $password;

    public function __construct()
    {
        $this->baseUrl = env('BKASH_BASE_URL');
        $this->appKey = env('BKASH_APP_KEY');
        $this->appSecret = env('BKASH_APP_SECRET');
        $this->username = env('BKASH_USERNAME');
        $this->password = env('BKASH_PASSWORD');

        // dd($this->baseUrl, $this->appKey, $this->appSecret, $this->username, $this->password);
        // Debug log the configuration (without sensitive data)
        Log::info('bKash Config Check', [
            'base_url' => $this->baseUrl,
            'app_key_set' => !empty($this->appKey),
            'app_secret_set' => !empty($this->appSecret),
            'username_set' => !empty($this->username),
            'password_set' => !empty($this->password),
        ]);
    }

    private function getToken()
    {
        try {
            $tokenUrl = $this->baseUrl . '/checkout/token/grant';

            // Prepare the request body as specified in documentation
            $requestBody = [
                'app_key' => $this->appKey,
                'app_secret' => $this->appSecret
            ];

            // Prepare headers as per bKash requirements
            $headers = [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'username' => $this->username,
                'password' => $this->password,
                'X-APP-Key' => $this->appKey
            ];

            Log::debug('bKash Token Request', [
                'url' => $tokenUrl,
                'headers' => $headers,
                'body' => $requestBody
            ]);

            $response = Http::withHeaders($headers)
                ->timeout(30)
                ->post($tokenUrl, $requestBody);

            $responseData = $response->json();

            Log::debug('bKash Token Response', [
                'status' => $response->status(),
                'response' => $responseData
            ]);

            if ($response->successful() && isset($responseData['id_token'])) {
                return $responseData['id_token'];
            }

            throw new \Exception('Token grant failed: ' . json_encode([
                'status' => $response->status(),
                'response' => $responseData
            ]));
        } catch (\Exception $e) {
            Log::error('bKash Token Error: ' . $e->getMessage());
            return null;
        }
    }



    public function createPayment($amount, $invoice = null)
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return ['error' => 'Failed to get token'];
            }
            $payload = [
                'mode' => '0011',
                'payerReference' => 'N/A', // or customer’s phone number
                'callbackURL' => env('BKASH_CALLBACK_URL'),
                'amount' => number_format($amount, 2, '.', ''), // convert to string with 2 decimals
                'currency' => 'BDT',
                'intent' => 'sale',
                'merchantInvoiceNumber' => uniqid('INV-')
            ];


            $response = Http::withHeaders([
                'Authorization' => $token,
                'X-APP-Key' => env('BKASH_APP_KEY')
            ])->post(env('BKASH_BASE_URL') . '/checkout/create', $payload);

            $responseData = $response->json();

            if ($response->successful()) {
                return $responseData;
            }

            Log::error('bKash Create Payment Error: ', $responseData);
            return ['error' => 'Payment creation failed', 'details' => $responseData];
        } catch (\Exception $e) {
            Log::error('bKash Create Payment Exception: ' . $e->getMessage());
            return ['error' => 'Payment creation exception: ' . $e->getMessage()];
        }
    }

    public function executePayment($paymentID)
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return ['error' => 'Failed to get token'];
            }

            // Use checkout endpoint for execute payment
            $executeUrl = rtrim($this->baseUrl, '/') . '/checkout/execute';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $token,
                'X-APP-Key' => $this->appKey,
            ])->post($executeUrl, [
                'paymentID' => $paymentID
            ]);

            $responseData = $response->json();

            if ($response->successful()) {
                return $responseData;
            }

            Log::error('bKash Execute Payment Error: ', $responseData);
            return ['error' => 'Payment execution failed', 'details' => $responseData];
        } catch (\Exception $e) {
            Log::error('bKash Execute Payment Exception: ' . $e->getMessage());
            return ['error' => 'Payment execution exception: ' . $e->getMessage()];
        }
    }

    public function queryPayment($paymentID)
    {
        try {
            $token = $this->getToken();

            if (!$token) {
                return ['error' => 'Failed to get token'];
            }

            // Use checkout endpoint for query payment
            $queryUrl = rtrim($this->baseUrl, '/') . '/checkout/query';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $token,
                'X-APP-Key' => $this->appKey,
            ])->post($queryUrl, [
                'paymentID' => $paymentID
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('bKash Query Payment Exception: ' . $e->getMessage());
            return ['error' => 'Payment query exception: ' . $e->getMessage()];
        }
    }
}
