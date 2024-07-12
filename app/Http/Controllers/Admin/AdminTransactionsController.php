<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction; // Import Transaction model
use Illuminate\Support\Facades\Auth; // Import Auth facade

class AdminTransactionsController extends Controller
{
    public function showTransactions(Request $request)
    {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('login')->withErrors('Please Login first...!.');
        }

        $adminUser = Auth::guard('admin')->user();

        // Get filter values
        $search = $request->input('search');
        $status = $request->input('status', 'all');

        // Build the query with filters
        $query = Transaction::with('user'); // Load user relation

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('transaction_source', 'like', '%' . $search . '%')
                  ->orWhere('recipient_address', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Fetch paginated transactions with latest first
        $transactions = $query->latest()->paginate(10);

        // Pass transactions and adminUser details to the view
        return view('admin.transactions', [
            'transactions' => $transactions,
            'name' => $adminUser->name,
            'role' => $adminUser->role,
        ]);
    }
    public function updateTransaction(Request $request)
    {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('login')->withErrors('Please Login first...!.');
        }

        $validatedData = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'transaction_hash' => 'nullable|string',
            'status' => 'required|in:Complete,in Progress,Rejected',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($validatedData['transaction_id']);
        $transaction->transaction_hash = $validatedData['transaction_hash'];
        $transaction->status = $validatedData['status'];
        $transaction->description = $validatedData['description'];
        $transaction->save();

        return redirect()->route('admin.transactions')->with('success', 'Transaction updated successfully.');
    }
}
