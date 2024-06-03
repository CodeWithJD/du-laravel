<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.email');
    }

    /**
     * Handle sending a password reset link email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email field
        $request->validate(['email' => 'required|email']);

        Log::info('Sending password reset link to: ' . $request->email);

        try {
            // Attempt to send the password reset link to the user's email
            $status = Password::sendResetLink($request->only('email'));

            Log::info('Password reset link status: ' . $status);

            // Check if the reset link was sent successfully
            if ($status == Password::RESET_LINK_SENT) {
                return back()->with('status', __($status));
            }

            // Custom error handling for specific email errors
            if ($status == Password::INVALID_USER) {
                $error = 'We can\'t find a user with that email address.';
            } elseif ($status == 'mail.throttle') {
                $error = 'Please wait before retrying.';
            } else {
                $error = 'Our email server is down, please check after few minutes.';
            }

        } catch (TransportExceptionInterface $e) {
            // Log the detailed exception
            Log::error('Error sending password reset email: ' . $e->getMessage());
            // Custom error message for email sending failure
            $error = 'There was an error sending the password reset email. Please try again later.';
        }

        // If there was an error, return with the appropriate message
        return back()->withErrors(['email' => $error]);
    }
}
