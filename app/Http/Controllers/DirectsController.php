<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class DirectsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('login');
        }

        $query = $user->referrals();

        // Check if a search query is present
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $perPage = 7;
        $referrals = $query->paginate($perPage, ['id', 'name', 'email', 'phone', 'created_at']);

        return view('dashboard.directs', [
            'name' => $user->name,
            'paginatedUsers' => $referrals
        ]);
    }

}
