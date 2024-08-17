<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserDetails;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Balance etc info
        $userDetails = UserDetails::where('user_id', $user->id)->first();

        // Fetch only the email of the referrer, or indicate direct registration
        $referrerEmail = 'Direct Register'; // Default value if there's no referrer
        if ($user->ref_id) {
            $referrerEmail = User::where('id', $user->ref_id)->value('name');
            if (!$referrerEmail) { // In case no user is found with the given ref_id
                $referrerEmail = 'No referrer found'; // You can adjust the message as needed
            }
        }

        return view('dashboard.profile', [
            'user' => $user,
            'name' => $user->name,
            'userDetails' => $userDetails,
            'referrerEmail' => $referrerEmail,

        ]);
    }

    public function updateName(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255', // Validation rules
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        try {
            $user->name = $request->input('name');
            $user->save();
            return response()->json(['message' => 'Name successfully updated!']);
        } catch (\Exception $e) {
            \Log::error('Failed to update user name', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update the name.'], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'], 400);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password successfully updated']);
    }

    public function updateWallet(Request $request)
    {
        $request->validate([
            'wallet_address' => 'required|string|max:255',
        ]);

        // Save the wallet address to the user's details
        $userDetails = auth()->user()->userDetails; // Assuming `userDetails` is the relationship in the User model
        $userDetails->withdrawal_wallet = $request->wallet_address;
        $userDetails->save();

        return response()->json(['message' => 'Wallet address updated successfully!'], 200);
    }
}
