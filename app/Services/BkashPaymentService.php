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
                // dd($responseData);
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
        $token = $this->getToken();
        if (!$token) return ['error' => 'Token failed'];

        $response = Http::withHeaders([
            'Authorization' => $token,
            'X-APP-Key' => $this->appKey,
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . '/tokenized/checkout/execute', [
            'paymentID' => $paymentID
        ]);

        $responseData = $response->json();
        if ($response->status() === 403) {

            dd($responseData);;
        }
        // Handle specific errors
        if (
            isset($responseData['statusMessage']) &&
            str_contains($responseData['statusMessage'], 'locked')
        ) {
            dd($responseData);
        }

        dd($responseData);
    }
    // public function executePayment($paymentID)
    // {
    //     try {
    //         $token = $this->getToken();

    //         if (!$token) {
    //             return ['error' => 'Failed to get token'];
    //         }

    //         // Use checkout endpoint for execute payment
    //         $executeUrl = rtrim($this->baseUrl, '/') . '/checkout/execute';

    //         $response = Http::withHeaders([
    //             'Content-Type' => 'application/json',
    //             'Accept' => 'application/json',
    //             'Authorization' => $token,
    //             'X-APP-Key' => $this->appKey,
    //         ])->post(env('BKASH_BASE_URL') . '/checkout/execute', [
    //             'paymentID' => $paymentID
    //         ]);

    //         $responseData = $response->json();

    //         dd($responseData);
    //         if ($response->successful()) {
    //             // return $responseData;
    //         }

    //         Log::error('bKash Execute Payment Error: ', $responseData);
    //         return ['error' => 'Payment execution failed', 'details' => $responseData];
    //     } catch (\Exception $e) {
    //         Log::error('bKash Execute Payment Exception: ' . $e->getMessage());
    //         return ['error' => 'Payment execution exception: ' . $e->getMessage()];
    //     }
    // }

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
            ])->post(env('BKASH_BASE_URL') . '/checkout/query', [
                'paymentID' => $paymentID
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('bKash Query Payment Exception: ' . $e->getMessage());
            return ['error' => 'Payment query exception: ' . $e->getMessage()];
        }
    }
public function resetSandboxWallet($msisdn = '01619777282')
{
    try {
        // 1. Get token (ensure this works first)
        $token = $this->getToken();
        if (!$token) {
            throw new \Exception('Failed to get authentication token');
        }
        if (strlen($token) < 50) { // Basic token validity check
    // Force token refresh by calling grantToken
    $refreshResponse = Http::withHeaders([
        'Content-Type' => 'application/json',
        'username' => $this->username, // Make sure these are set
        'password' => $this->password
    ])->post($this->baseUrl.'/checkout/token/grant', [
        'app_key' => $this->appKey,
        'app_secret' => $this->appSecret
    ]);

    if ($refreshResponse->successful()) {
        $token = $refreshResponse->json()['id_token'];
    } else {
        throw new \Exception('Token refresh failed');
    }
}

        // 2. Define API endpoint
        $resetUrl = $this->baseUrl . '/tokenized/wallet/reset';
        $payload = ['msisdn' => $msisdn];
        $parsedUrl = parse_url($resetUrl);

        // 3. AWS Signature v4 - Timezone fix for Bangladesh (UTC+6)
        $service = 'execute-api';
        $region = 'ap-southeast-1'; // bKash's region
        $algorithm = 'AWS4-HMAC-SHA256';

        // Critical fix: Use UTC time (not local Bangladesh time)
        $now = now()->timezone('UTC'); // Force UTC timezone
        $amzDate = $now->format('Ymd\THis\Z'); // AWS format
        $dateStamp = $now->format('Ymd');

        // 4. Generate Canonical Request
        $canonicalHeaders = "content-type:application/json\nhost:{$parsedUrl['host']}\nx-amz-date:{$amzDate}\n";
        $signedHeaders = 'content-type;host;x-amz-date';
        $payloadHash = hash('sha256', json_encode($payload));
        $canonicalRequest = "POST\n{$parsedUrl['path']}\n\n{$canonicalHeaders}\n{$signedHeaders}\n{$payloadHash}";

        // 5. String to Sign
        $credentialScope = "{$dateStamp}/{$region}/{$service}/aws4_request";
        $stringToSign = "{$algorithm}\n{$amzDate}\n{$credentialScope}\n" . hash('sha256', $canonicalRequest);

        // 6. Calculate Signature
        $kSecret = 'AWS4' . $this->appSecret;
        $kDate = hash_hmac('sha256', $dateStamp, $kSecret, true);
        $kRegion = hash_hmac('sha256', $region, $kDate, true);
        $kService = hash_hmac('sha256', $service, $kRegion, true);
        $kSigning = hash_hmac('sha256', 'aws4_request', $kService, true);
        $signature = hash_hmac('sha256', $stringToSign, $kSigning);

        // 7. Build Authorization Header
        $authorizationHeader = "{$algorithm} Credential={$this->appKey}/{$credentialScope}, SignedHeaders={$signedHeaders}, Signature={$signature}";

        // 8. Make the API Call
        $response = Http::withHeaders([
            'Authorization' => $authorizationHeader,
            'x-amz-date' => $amzDate,
            'X-APP-Key' => $this->appKey,
            'Content-Type' => 'application/json',
        ])->post($resetUrl, $payload);

        $responseData = $response->json();

        // 9. Handle Response
        if ($response->successful() && ($responseData['statusCode'] ?? '') === '0000') {
            return [
                'success' => true,
                'message' => 'Wallet reset successfully',
                'data' => $responseData
            ];
        }

        return [
            'success' => false,
            'message' => $responseData['statusMessage'] ?? 'Wallet reset failed',
            'data' => $responseData
        ];

    } catch (\Exception $e) {
        Log::error('Wallet Reset Error: ' . $e->getMessage());
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}
}
