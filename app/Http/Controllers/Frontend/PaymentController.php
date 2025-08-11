<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\BkashPaymentService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:50',
        ], [
            'amount.required' => 'আপনার পরিমাণ লিখুন',
            'amount.min' => ' কমপক্ষে ৫০৳ রিচার্জ করতে হবে',
        ]);

        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return redirect()->back();
        }

        try {
            $amount = $request->amount;
            $bkash = new BkashPaymentService();
            $response = $bkash->createPayment($amount);

            // Check if there's an error in the response
            if (isset($response['error'])) {
                Log::error('bKash Payment Error: ', $response);
                notyf()->position('x', 'right')->position('y', 'top')->error('Payment initiation failed: ' . $response['error']);
                return redirect()->back();
            }

            // Check if payment was created successfully
            if (isset($response['paymentID']) && isset($response['bkashURL'])) {
                // Store payment info in session for later verification
                session(['bkash_payment_id' => $response['paymentID']]);
                return redirect($response['bkashURL']);
            }

            Log::error('bKash Payment Response: ', $response);
            notyf()->position('x', 'right')->position('y', 'top')->error('Failed to initiate bKash payment. Please try again.');
            return redirect()->back();

        } catch (\Exception $e) {
            Log::error('Payment Exception: ' . $e->getMessage());
            notyf()->position('x', 'right')->position('y', 'top')->error('An error occurred while processing payment.');
            return redirect()->back();
        }
    }

    public function bkashCallback(Request $request)
    {
        try {
            $paymentID = $request->input('paymentID');
            $status = $request->input('status');

            if (!$paymentID) {
                Log::error('bKash Callback: No paymentID provided');
                notyf()->position('x', 'right')->position('y', 'top')->error('Invalid payment response');
                return redirect()->route('user_payment');
                // dd($request->all());
            }

            // Check if payment was cancelled
            if ($status === 'cancel' || $status === 'failure') {
                Log::info('bKash Payment Cancelled/Failed: ' . $paymentID);
               notyf()->position('x', 'right')->position('y', 'top')->error('Payment was cancelled or failed');
                return redirect()->route('user_payment');
            }

            $bkash = new BkashPaymentService();
            $result = $bkash->executePayment($paymentID);

            if (isset($result['error'])) {
                Log::error('bKash Execute Error: ', $result);
                notyf()->position('x', 'right')->position('y', '')->error('Payment execution failed');
                return redirect()->route('user_payment');
                // dd($result);
            }

            if (isset($result['transactionStatus']) && $result['transactionStatus'] === 'Completed') {
                session()->forget('bkash_payment_id');
                Log::info('bKash Payment Successful: ', $result);
                //user
                $user = auth()->user();
                $user->amount += $result['amount'];
                $user->save();
                //payment
                $payment = new Payment();
                $payment->user_id = $user->id;
                $payment->amount = $result['amount'];
                $payment->payment_id = $paymentID;
                $payment->transaction_id = $result['trxID'];
                $payment->invoice = $result['merchantInvoiceNumber'];
                $payment->status = $result['transactionStatus'];
                $payment->statusMessage = $result['statusMessage'];
                $payment->status_code = $result['statusCode'];
                $payment->msisdn = $result['customerMsisdn'];
                $payment->save();
                notyf()->position('x', 'right')->position('y', 'bottom')->success('আপনার পেমেন্ট সম্পুর্ণ হয়েছে।');
                return redirect()->route('user_home');
            }

            Log::error('bKash Payment Status Not Completed: ', $result);
            return redirect()->route('user_payment')->with('error', 'Payment verification failed');


        } catch (\Exception $e) {
            Log::error('bKash Callback Exception: ' . $e->getMessage());
            return redirect()->route('user_payment')->with('error', 'An error occurred while processing callback');

        }
    }


}
