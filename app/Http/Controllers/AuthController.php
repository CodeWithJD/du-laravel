<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        $referralCode = request()->query('ref');

        return view('auth.register', ['referralCode' => $referralCode]);
    }

    public function register(Request $request)
{
    // Validate the user input
    $validatedData = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'mobile_number' => ['required', 'string', 'regex:/^\+(?:[0-9] ?){6,14}[0-9]$/'],
        'invite_code' => 'nullable|string|max:255',
        'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/'],
    ]);

    // Check if invite code is valid
    $referrer = null;
    if ($validatedData['invite_code']) {
        $referrer = User::where('invite_code', $validatedData['invite_code'])->first();
        if (!$referrer) {
            return back()->withErrors(['error' => 'Invalid invite code.']);
        }
    }

    // Fetch activation charge from reward_settings
    $activationCharge = DB::table('reward_settings')
        ->select('activation_charge')
        ->value('activation_charge');

    // Determine account status based on activation charge
    $accountStatus = $activationCharge > 0 ? 'notActive' : 'Active';

    // Generate a unique invite code
    do {
        $letters = strtoupper(Str::random(4)); // 4 capital letters
        $digits = mt_rand(100000, 999999); // 6 digits
        $inviteCode = $letters . $digits; // Combine them
    } while (User::where('invite_code', $inviteCode)->exists()); // Check uniqueness

    try {
        // Create the user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'ref_id' => $referrer ? $referrer->id : null,
            'invite_code' => $inviteCode,
        ]);

        // Create user details
        UserDetails::create([
            'user_id' => $user->id,
            'account_status' => $accountStatus,
        ]);

        // Log in the user
        Auth::login($user);

        // Redirect to dashboard
        return redirect('/dashboard');
    } catch (\Exception $e) {
        return back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
    }
}


    // Login funcation start from here
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        // Validate the user input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            // Capture device details
            $userAgent = $request->header('User-Agent');
            $ipAddress = $request->ip();

            // Update user details with last login time and device info
            UserDetails::where('user_id', Auth::id())->update([
                'last_login' => now(),
                'last_login_device' => $userAgent,
                'last_login_ip' => $ipAddress,
            ]);

            // Redirect to dashboard
            return redirect('/dashboard');
        }

        // If login fails, redirect back with error
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        // Log out the user
        Auth::logout();

        // Redirect the user to the desired page
        return redirect('/login');
    }
}
