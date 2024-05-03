<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(5);  // OTP is valid for 5 minutes

        OtpCode::updateOrCreate(
            ['user_id' => $user->id],
            ['otp_code' => $otp, 'expires_at' => $expiresAt]
        );

        Mail::to($user->email)->send(new OtpMail($otp));

        return back()->with('message', 'OTP sent to your email.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)->first();
        $otpRecord = OtpCode::where('user_id', $user->id)->first();

        if ($otpRecord && $otpRecord->otp_code == $request->otp && $otpRecord->expires_at > now()) {
            Auth::login($user);
            $otpRecord->delete();
            return redirect()->route('dashboard');
        } else {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }
    }
}

