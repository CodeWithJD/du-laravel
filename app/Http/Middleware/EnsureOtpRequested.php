<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpRequested
{
    public function handle(Request $request, Closure $next)
    {
        // Check if there is an OTP session set
        if (!$request->session()->has('otp_requested')) {
            return redirect('login')->withErrors(['error' => 'Please login to proceed with OTP verification.']);
        }

        return $next($request);
    }
}
