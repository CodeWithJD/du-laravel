<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserDetails;
use App\Models\Transaction;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        // Retrieve wallet details from the user_details table
        $userDetails = UserDetails::where('user_id', $user->id)->first();

        // Retrieve transactions involving the user
        $transactionsQuery = Transaction::where('user_id', $user->id)
            ->orWhere('recipient_id', $user->id)
            ->orderBy('timestamp', 'desc'); // Order by recent transactions

        // Paginate the transactions
        $perPage = 5;
        $transactions = $transactionsQuery->paginate($perPage);

        return view('dashboard.wallet', [
            'user' => $user,
            'name' => $user->name,
            'userDetails' => $userDetails,
            'transactions' => $transactions,
        ]);
    }
}
