<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTermination
{
     public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->terminate == 0) {
            Auth::logout();
            notyf()->position('x', 'right')->position('y', 'top')->error('আপনার অ্যাকাউন্ট ডিএক্টিভেট, এডমিনের সাথে যোগাযোগ করুন।');
            return redirect()->route('login');
        }

        return $next($request);
    }
}
