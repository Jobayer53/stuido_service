<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
        public function index(){
        return view('frontend.index');
    }
    public function user_setting(){
        return view('frontend.setting');
    }
    public function user_update(Request $request){
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'number' => 'required|numeric|digits:11',
            'old_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|required_with:old_password|string|min:8',

        ],[
            'name.required' => 'আপনার নাম লিখুন',
            'password.required' => 'আপনার পাসওয়ার্ড লিখুন',
            'old_password.required_with' => 'পুরাতন পাসওয়ার্ড লিখুন',
            'new_password.required_with' => 'নতুন পাসওয়ার্ড লিখুন',
            'new_password.min' => 'নতুন পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে',
            'number.required' => 'আপনার মোবাইল নাম্বার লিখুন',
            'number.digits' => 'মোবাইল নাম্বার কমপক্ষে ১১ অক্ষরের হতে হবে',
        ]);

        if ($validator->fails()) {
            notyf()->position('x', 'right')->position('y', 'top')->error($validator->errors()->first());
            return redirect()->back();
        }
        if($request->old_password){
            if(!Hash::check($request->old_password, $user->password)){
                notyf()->position('x', 'right')->position('y', 'top')->error('পুরাতন পাসওয়ার্ড ভুল');
                return redirect()->back();
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
        }
        $user->name = $request->name;
        $user->number = $request->number;
        $user->save();
        notyf()->position('x', 'right')->position('y', 'top')->success('আপনার প্রোফাইল সফলভাবে আপডেট করা হয়েছে।');
        return redirect()->back();
    }
    public function payment(){
        return view('frontend.payment');
    }
 
}
