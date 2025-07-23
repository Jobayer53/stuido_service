<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->terminate == 0) {
                notyf()->position('x', 'right')->position('y', 'top')->error('অ্যাকাউন্ট ডিএক্টিভেট, এডমিনের সাথে যোগাযোগ করুন।');
                Auth::logout();
                return back();
            }
            notyf()->position('x', 'right')->position('y', 'top')->success('সফলভাবে লগইন করা হয়েছে');
            return redirect()->route('user_home');
        } else {
            notyf()->position('x', 'right')->position('y', 'top')->error('ভুল ইমেইল/পাসওয়ার্ড!');
            return back();
        }


    }
    public function logout(Request $request) {
        Auth::logout();
        notyf()->position('x', 'right')->position('y', 'top')->info('লগআউট সম্পুর্ণ হয়েছে');
        notyf()->position('x', 'right')->position('y', 'top')->success('আমাদের সাথে থাকার জন্য ধন্যবাদ');
        return redirect()->route('login');
    }
}

