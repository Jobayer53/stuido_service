<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        if(Auth::check()){
            return redirect()->route('user_home');
        }
        return view('frontend.auth.login');
    }
    public function user_login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            notyf()->position('x', 'right')->position('y', 'top')->error('ভুল ইমেইল/পাসওয়ার্ড!');
            return back();
        }
             notyf()->position('x', 'right')->position('y', 'top')->success('সফলভাবে লগইন করা হয়েছে');
        return redirect()->route('user_home');


    }
    public function logout(Request $request) {
        Auth::logout();
        notyf()->position('x', 'right')->position('y', 'top')->info('লগআউট সম্পুর্ণ হয়েছে');
        notyf()->position('x', 'right')->position('y', 'top')->success('আমাদের সাথে থাকার জন্য ধন্যবাদ');
        return redirect()->route('login');
    }
}

