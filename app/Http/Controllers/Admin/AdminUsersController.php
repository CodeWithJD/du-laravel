<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;




class AdminUsersController extends Controller
{
    public function userListShow(Request $request) {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('login')->withErrors('Please Login first...!.');
        }

        $adminUser = Auth::guard('admin')->user();

        $search = $request->input('search');
        $status = $request->input('status');

        // Build the query using search and status filters
        $users = User::with('userDetails')
                    ->where(function($query) use ($search) {
                        if (!empty($search)) {
                            $query->where('name', 'like', '%' . $search . '%')
                                  ->orWhere('email', 'like', '%' . $search . '%')
                                  ->orWhere('phone', 'like', '%' . $search . '%')
                                  ->orWhere('id', 'like', '%' . $search . '%')
                                  ->orWhere('invite_code', 'like', '%' . $search . '%');
                        }
                    })
                    ->whereHas('userDetails', function ($query) use ($status) {
                        if (!empty($status) && $status != 'all') {
                            $query->where('account_status', $status);
                        }
                    })
                    ->paginate(10);

        return view('admin.users', [
            'name' => $adminUser->name,
            'role' => $adminUser->role,
            'users' => $users
        ]);
    }

    public function editUser($id) {
        if (!Auth::guard('admin')->check() || Auth::guard('admin')->user()->role !== 'admin') {
            return redirect()->route('login')->withErrors('Please Login first...!.');
        }

        $adminUser = Auth::guard('admin')->user();

        $user = User::with('userDetails')->findOrFail($id);  // Retrieve the user along with their details using the ID

        return view('admin.user_edit', [
            'name' => $adminUser->name,
            'role' => $adminUser->role,
            'user' => $user,
        ]);
    }
}
