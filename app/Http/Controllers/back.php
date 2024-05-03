<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralLevelsController extends Controller
{
    public function showLevelDetails(Request $request, $level)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('login');
        }

        $methodName = 'getLevel' . $level . 'Details';
        if (method_exists($this, $methodName)) {
            return $this->$methodName($request, $user);
        } else {
            abort(404); // Not found
        }
    }

    private function applySearch($query, $search)
    {
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    private function getLevel1Details(Request $request, $user)
    {
        $perPage = 7;
        $query = $user->referrals()->select('id', 'name', 'email', 'phone', 'created_at');

        // Apply search filter using the helper method
        $query = $this->applySearch($query, $request->search);

        $referrals = $query->with(['stakings' => function($q) {
            $q->where('unstake', false); // Assuming 'unstake' is a flag in your database
        }])->paginate($perPage);

        // Calculate investment sums for each referral
        $referrals->getCollection()->transform(function ($referral) {
            $investmentSum = $referral->stakings->sum('investedAmount');
            $referral->investmentSum = $investmentSum;
            return $referral;
        });

        $referralsCount = $user->levelOneReferralsCount();
        $investmentSum = $referrals->getCollection()->sum('investmentSum');

        return view('dashboard.level-details', [
            'name' => $user->name,
            'level' => 1,
            'referralsCount' => $referralsCount,
            'investmentSum' => $investmentSum,
            'paginatedUsers' => $referrals
        ]);
    }




    private function getLevel2Details(Request $request, $user)
    {
        // Collect all level 2 referrals
        $levelTwoReferrals = collect();
        foreach ($user->referrals as $levelOneReferral) {
            $levelTwoReferrals = $levelTwoReferrals->concat($levelOneReferral->referrals);
        }

        // Calculate investments for each referral before any potential filtering
        $levelTwoReferrals->transform(function ($referral) {
            $investmentSum = $referral->stakings->where('unstake', false)->sum('investedAmount');
            $referral->investmentSum = $investmentSum;
            return $referral;
        });

        // Apply search filter if present
        if (!empty($request->search)) {
            $search = $request->search;
            $levelTwoReferrals = $levelTwoReferrals->filter(function ($referral) use ($search) {
                return stripos($referral->name, $search) !== false ||
                    stripos($referral->email, $search) !== false ||
                    stripos($referral->phone, $search) !== false;
            });
        }

        // Mask email addresses and mobile numbers
        $levelTwoReferrals = $levelTwoReferrals->map(function ($referral) {
            $emailParts = explode('@', $referral->email);
            $maskedEmail = substr($emailParts[0], 0, 4) . '***@' . $emailParts[1];
            $phoneLength = strlen($referral->phone);
            $maskedPhone = substr($referral->phone, 0, $phoneLength - 4) . '****';
            return (object) [
                'id' => $referral->id,
                'name' => $referral->name,
                'email' => $maskedEmail,
                'phone' => $maskedPhone,
                'created_at' => $referral->created_at,
                'investmentSum' => $referral->investmentSum
            ];
        });

        // Pagination
        $perPage = 7;
        $page = $request->input('page', 1);
        $paginatedReferrals = new \Illuminate\Pagination\LengthAwarePaginator(
            $levelTwoReferrals->forPage($page, $perPage)->values(),
            $levelTwoReferrals->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Return view with data
        return view('dashboard.level-details', [
            'name' => $user->name,
            'level' => 2,
            'referralsCount' => $levelTwoReferrals->count(),
            'investmentSum' => $levelTwoReferrals->sum('investmentSum'),
            'paginatedUsers' => $paginatedReferrals
        ]);
    }





}
