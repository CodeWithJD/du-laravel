<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminAuthController extends Controller
{
    public function showAdminLoginForm()
    {
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate with the admin guard without sessions
        if (Auth::guard('admin')->validate($credentials)) {
            $user = Auth::guard('admin')->getLastAttempted();

            // Check if the user has the admin role
            if ($user->role === 'admin' && Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
                // Record the successful login
                $this->recordAdminLogin($user->id, $user->email, $request->ip(), $request->header('User-Agent'), 'success');

                // Redirect to admin dashboard
                return redirect()->route('admin.dashboard');
            } else {
                // Record the failed login attempt due to role mismatch
                $this->recordAdminLogin(null, $user->email, $request->ip(), $request->header('User-Agent'), 'role_mismatch');
            }
        }

        // Record the failed login attempt
        $this->recordAdminLogin(null, $credentials['email'], $request->ip(), $request->header('User-Agent'), 'failed');

        // If login fails, redirect back with error
        return back()->withErrors(['email' => 'Invalid credentials or not authorized team member'])->withInput($request->only('email'));
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    private function recordAdminLogin($adminId, $email, $ip, $userAgent, $status)
    {
        DB::table('admin_login_history')->insert([
            'admin_id' => $adminId, // This can be null if admin does not exist
            'attempt_email' => $email, // Log the email used in the attempt
            'login_time' => now(),
            'login_ip' => $ip,
            'user_agent' => $userAgent,
            'status' => $status,
        ]);
    }
}
