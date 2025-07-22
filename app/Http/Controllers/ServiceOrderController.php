<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServiceOrderController extends Controller
{
    //server copy
    public function serverCopyOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nid' => 'required',
            'dob' => 'required',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = Service::find(1);
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->nid_number = $request->nid;
        $order->dob = $request->dob;
        $order->save();
        $user->amount = $user->amount - $service->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    //sign copy
    public function signCopyOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'type_name' => 'required',
            'type_no' => 'required',
        ], [
            'type.required' => 'টাইপ সিলেক্ট করুন!',
            'type_name.required' => 'নাম লিখুন!',
            'type_no.required' => 'নম্বর লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }

        $service = Service::find(2);
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->type_name = $request->type_name;
        $order->type_number = $request->type_no;
        $order->save();
        $user->amount = $user->amount - $service->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    //nid pdf
    public function nidPdfOrder(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'type_name' => 'required',
            'type_no' => 'required',
            'name' => 'required',
        ], [
            'type.required' => 'টাইপ সিলেক্ট করুন!',
            'type_name.required' => 'অপশন সিলেক্ট করুন!',
            'type_no.required' => 'নম্বর লিখুন!',
            'name.required' => 'নাম লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = $request->type_name == 'smrt_nid_pdf' ? Service::find(4) : Service::find(3);

        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->type_name = $request->type_name;
        $order->type_number = $request->type_no;
        $order->name = $request->name;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    //nid pass
    public function nidPassOrder(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'data' => 'required',
        ], [
            'type.required' => 'টাইপ সিলেক্ট করুন!',
            'data.required' => 'প্রয়োজনীয় তথ্য দিন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = $request->type == 'nid_pass' ? Service::find(5) : Service::find(6);
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->description = $request->data;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    //biometric
    public function biometricOrder(Request $request)
    {
        $map = ['robi_airtel' => 7, 'banglalink' => 8, 'teletalk' => 9, 'grameenphone' => 10];
        $service = isset($map[$request->type]) ? Service::find($map[$request->type]) : null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'type_number' => 'required',
        ], [
            'type.required' => 'টাইপ সিলেক্ট করুন!',
            'type_number.required' => 'ফোন নম্বর লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->type_number = $request->type_number;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    //lost nid
    public function lostNidOrder(Request $request)
    {
        // dd($request->all());

        $service = Service::find(11);
        $validator = Validator::make($request->all(), [
            'data' => 'required',

        ], [
            'data.required' => 'তথ্য লিখুন!',

        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->description = $request->data;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    //passport
    public function passportOrder(Request $request)
    {
        // dd($request->all());
        $map = ['nid_to_epass' => 12, 'nid_to_mrp' => 13, 'mrp_to_serverCopy' => 14];
        $service = isset($map[$request->type]) ? Service::find($map[$request->type]) : null;

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'data' => 'required',
        ], [
            'type.required' => 'অপশন সিলেক্ট করুন!',
            'data.required' => 'তথ্য লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->description = $request->data;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    // location
    public function locationOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'number' => 'required',
        ],[
            'number.required' => 'আপনার মোবাইল নম্বর লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = Service::find(15);
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type_number = $request->number;
        $order->save();
        $user->amount = $user->amount - $service->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
       //sms
    public function smsOrder(Request $request)
    {
        $map = ['call_list' => 16, 'sms_gp' => 17, 'sms_banglalink' => 18, 'call_list_6M' => 43];
        $service = isset($map[$request->type]) ? Service::find($map[$request->type]) : null;
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'number' => 'required',
        ], [
            'type.required' => 'অপশন সিলেক্ট করুন!',
            'number.required' => 'আপনার মোবাইল নম্বর লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->type_number = $request->number;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ২৪-৪৮ ঘন্টা অপেক্ষা করুন।');
        return back();
    }
       //imei
    public function imeiOrder(Request $request)
    {
        // dd($request->all());
        $map = ['imei_to_number' => 19, 'nid_to_number' => 20, 'number_to_imei' => 21, 'nid_to_gp' => 22, 'nid_to_banglalink' => 23, 'imei_biometric_location' => 24];
        $service = isset($map[$request->type]) ? Service::find($map[$request->type]) : null;


        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'data' => 'required',
        ], [
            'type.required' => 'অপশন সিলেক্ট করুন!',
            'data.required' => 'তথ্য লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->description = $request->data;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ২৪-৪৮ ঘন্টা অপেক্ষা করুন।');
        return back();
    }
       //nagad bikash
    public function nagadOrder(Request $request)
    {
        // dd($request->all());
        $map = ['nagad_info' => 25, 'bikash_personal' => 26, 'rocket_info' => 27, 'nagadPersonal_3Month' => 28, 'bikash_merchant' => 29,'bikash_agent' => 30];
        $service = isset($map[$request->type]) ? Service::find($map[$request->type]) : null;

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'type_number' => 'required',
        ], [
            'type.required' => 'অপশন সিলেক্ট করুন!',
            'type_number.required' => 'তথ্য লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->type_number = $request->type_number;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ২৪-৪৮ ঘন্টা অপেক্ষা করুন।');
        return back();
    }
    //tin
    public function tinOrder(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'data' => 'required',
        ], [
            'type.required' => 'টাইপ সিলেক্ট করুন!',
            'data.required' => 'তথ্য লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = $request->type == 'zero_return' ? Service::find(32) : Service::find(33);

        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->description = $request->data;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    //land - bhumi
    public function landOrder(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'data' => 'required',
        ], [
            'data.required' => 'তথ্য লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = Service::find(34);

        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->description = $request->data;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }

    // register - nibondhon
    public function registerOrder(Request $request)
    {
        // dd($request->all());
        $map = ['bc_before_2000' => 35, 'bc_after_2000' => 36, 'bc_death_register' => 37, 'lost_bc' => 38];
        $service = isset($map[$request->type]) ? Service::find($map[$request->type]) : null;

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'data' => 'required',
        ], [
            'type.required' => 'অপশন সিলেক্ট করুন!',
            'data.required' => 'তথ্য লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->description = $request->data;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ২৪-৪৮ ঘন্টা অপেক্ষা করুন।');
        return back();
    }
    // number statement
    public function statementOrder(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'type_number' => 'required',
        ], [
            'type.required' => 'অপশন সিলেক্ট করুন!',
            'type_number.required' => 'ফোন নাম্বার লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service =$request->type == 'rocket'? Service::find(39) : Service::find(40);
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type = $request->type;
        $order->type_number = $request->type_number;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ২৪-৪৮ ঘন্টা অপেক্ষা করুন।');
        return back();
    }
    // vaccine
    public function vaccineOrder(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'data' => 'required',

        ], [
            'data.required' => 'তথ্য লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = Service::find(41);
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->description = $request->data;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    // birth certificate number change
    public function bc_changeOrder(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'bc' => 'required',
            'dob' => 'required',
            'number' => 'required',
        ], [
            'bc.required' => 'জন্ম নিবন্ধন নম্বর লিখুন!',
            'dob.required' => 'জন্ম তারিখ লিখুন!',
            'number.required' => 'আপনার মোবাইল নম্বর লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = Service::find(42);
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type_number = $request->bc;
        $order->dob = $request->dob;
        $order->description = $request->number;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }
    //bmet
    public function bmetOrder(Request $request)
    {
        dd($request->all());
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'data' => 'required',

        ], [
            'type.required' => 'অপশন সিলেক্ট করুন!',
            'data.required' => 'তথ্য লিখুন!',
        ]);
        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return back();
        }
        $service = Service::find(42);
        $user = auth()->user();
        if ($user->amount < $service->cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার পর্যাপ্ত পরিমাণ টাকা নেই।');
            return back();
        }
        $order = new Order();
        $order->slug = uniqid();
        $order->user_id = $user->id;
        $order->service_id = $service->id;
        $order->cost = $service->cost;
        $order->type_number = $request->bc;
        $order->dob = $request->dob;
        $order->description = $request->number;
        $order->save();
        $user->amount = $user->amount - $order->cost;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার সংরক্ষণ করা হয়েছে।');
        notyf()->position('x', 'right')->position('y', 'top')->info('অনুগ্রহ করে ৫-২০ মিনিট অপেক্ষা করুন।');
        return back();
    }

























    // public function orderCancel($id)
    // {
    //     $user = auth()->user();
    //     $order = Order::find($id);
    //     if ($order->user_id == $user->id && $order->status !== 'completed') {
    //         $order->status = 'cancelled';
    //         $order->save();
    //         $user->amount = $user->amount + $order->cost;
    //         $user->save();
    //         notyf()->position('x', 'right')->position('y', 'top')->success('আপনার অর্ডার বাতিল করা হয়েছে।');
    //     } else {
    //         notyf()->position('x', 'right')->position('y', 'top')->error('আপনার অর্ডার বাতিল করা যায়নি।');
    //     }
    //     return back();
    // }
    public function download(Order $order)
    {
        if (Auth::check() || Auth::guard('admin')->check()) {
            $filePath = public_path('upload/' . $order->downloaded_file);
            if (!file_exists($filePath) || $order->downloaded_file == null) {
                notyf()->position('x', 'right')->position('y', 'top')->error('File Not Found');
                return back();
            }
            return response()->download($filePath, $order->downloaded_file);
        } else {
            notyf()->position('x', 'right')->position('y', 'top')->error('Invalid Request');
            return back();
        }
    }
}
