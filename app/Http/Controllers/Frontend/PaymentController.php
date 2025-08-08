<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BkashPaymentService;
use Illuminate\Support\Facades\Validator;

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
        $amount = $request->amount;
        $bkash = new BkashPaymentService();
        $response = $bkash->createPayment($amount);

        if (isset($response['paymentID'])) {
            return redirect($response['bkashURL']);
        }

        return back()->with('error', 'Failed to initiate bKash payment.');
    }

    public function bkashCallback(Request $request)
    {
        $paymentID = $request->input('paymentID');
        $bkash = new BkashPaymentService();
        $result = $bkash->executePayment($paymentID);

        if ($result['transactionStatus'] == 'Completed') {
            dd('success');
        }

        return redirect()->route('payment.failed');
    }
}
