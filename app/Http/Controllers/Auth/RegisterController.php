<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    // use RegistersUsers;

    // /**
    //  * Where to redirect users after registration.
    //  *
    //  * @var string
    //  */
    // protected $redirectTo = '/';

    // /**
    //  * Create a new controller instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    // /**
    //  * Get a validator for an incoming registration request.
    //  *
    //  * @param  array  $data
    //  * @return \Illuminate\Contracts\Validation\Validator
    //  */
    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'number' => ['required', 'numeric', 'min:11','max:11', 'confirmed'],
    //     ]);
    // }

    // /**
    //  * Create a new user instance after a valid registration.
    //  *
    //  * @param  array  $data
    //  * @return \App\Models\User
    //  */
    // protected function create(array $data)
    // {
    //     dd($data);
    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //     ]);
    // }
       public function showRegistrationForm()
    {
        if(Auth::check()){
            return redirect()->route('user_home');
        }
        return view('frontend.auth.register');
    }
    public function user_register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'number' => 'required|numeric|digits:11',
        ],[
            'name.required' => 'আপনার নাম লিখুন',
            'email.required' => 'আপনার ইমেইল লিখুন',
            'email.email' => 'সঠিক ইমেইল লিখুন',
            'email.unique' => 'ইমেইল ইতিমধ্যে ব্যবহার করা হয়েছে',
            'password.required' => 'আপনার পাসওয়ার্ড লিখুন',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে',
            'number.required' => 'আপনার মোবাইল নাম্বার লিখুন',
            'number.digits' => 'মোবাইল নাম্বার কমপক্ষে ১১ অক্ষরের হতে হবে',
        ]);

       $user = new User();
       $user->name = $request->name;
       $user->email = $request->email;
       $user->password = Hash::make($request->password);
       $user->number = $request->number;
       $user->uuid = uniqid( 'UUID-' );
       $user->save();

   notyf()->position('x', 'right')->position('y', 'top')->success('আপনার একাউন্ট সফলভাবে তৈরি করা হয়েছে।');
        return redirect()->route('login');
    }
}
