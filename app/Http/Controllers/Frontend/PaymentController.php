<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BkashPaymentService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function initiatePayment(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'amount' => 'required|numeric|min:50',
        // ], [
        //     'amount.required' => 'আপনার পরিমাণ লিখুন',
        //     'amount.min' => ' কমপক্ষে ৫০৳ রিচার্জ করতে হবে',
        // ]);

        // if ($validator->fails()) {
        //     notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
        //     return redirect()->back();
        // }

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
                return redirect()->route('payment.failed')->with('error', 'Invalid payment response');
            }

            // Check if payment was cancelled
            if ($status === 'cancel' || $status === 'failure') {
                Log::info('bKash Payment Cancelled/Failed: ' . $paymentID);
                return redirect()->route('payment.failed')->with('error', 'Payment was cancelled or failed');
            }

            $bkash = new BkashPaymentService();
            $result = $bkash->executePayment($paymentID);

            if (isset($result['error'])) {
                Log::error('bKash Execute Error: ', $result);
                return redirect()->route('payment.failed')->with('error', 'Payment execution failed');
            }

            if (isset($result['transactionStatus']) && $result['transactionStatus'] === 'Completed') {
                // Clear session data
                session()->forget('bkash_payment_id');

                // Log successful payment
                Log::info('bKash Payment Successful: ', $result);

                // Here you should update your database with payment information
                // Example:
                // $user = auth()->user();
                // $user->balance += $result['amount'];
                // $user->save();

                // Create payment record
                // Payment::create([
                //     'user_id' => auth()->id(),
                //     'transaction_id' => $result['trxID'],
                //     'payment_id' => $paymentID,
                //     'amount' => $result['amount'],
                //     'status' => 'completed'
                // ]);

                notyf()->position('x', 'right')->position('y', 'top')->success('Payment completed successfully!');
                return redirect()->route('dashboard')->with('success', 'Payment completed successfully!');
            }

            Log::error('bKash Payment Status Not Completed: ', $result);
            return redirect()->route('payment.failed')->with('error', 'Payment verification failed');

        } catch (\Exception $e) {
            Log::error('bKash Callback Exception: ' . $e->getMessage());
            return redirect()->route('payment.failed')->with('error', 'An error occurred while processing callback');
        }
    }

    public function paymentFailed()
    {
        return view('payment.failed');
    }
}
