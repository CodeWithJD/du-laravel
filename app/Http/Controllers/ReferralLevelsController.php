<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralLevelsController extends Controller
{
    // Display referral level details based on the provided level
    public function showLevelDetails(Request $request, $level)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('login');
        }

        return $this->getLevelDetails($request, $user, $level);
    }

    // Handle fetching and displaying details for a specific referral level
    private function getLevelDetails(Request $request, $user, $level)
    {
        $level = (int) $level;
        if ($level < 1 || $level > 12) {
            abort(404, "Referral level out of range.");
        }

        // Initialize the collection with the current user to start the referral chain
        $currentLevelReferrals = collect([$user]);

        // Iterate to collect referrals up to the specified level
        for ($i = 1; $i <= $level; $i++) {
            $nextLevelReferrals = collect();
            foreach ($currentLevelReferrals as $referral) {
                foreach ($referral->referrals as $nextReferral) {
                    $nextLevelReferrals->push($nextReferral);
                }
            }
            $currentLevelReferrals = $nextLevelReferrals;
        }

        // Apply filtering for search query
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $currentLevelReferrals = $currentLevelReferrals->filter(function ($referral) use ($search) {
                return stripos($referral->name, $search) !== false ||
                       stripos($referral->email, $search) !== false ||
                       stripos($referral->phone, $search) !== false;
            });
        }

        // Apply masking only for levels greater than 1
        if ($level > 1) {
            $currentLevelReferrals = $currentLevelReferrals->map(function ($referral) {
                $emailParts = explode('@', $referral->email);
                $maskedEmail = substr($emailParts[0], 0, 4) . '***@' . $emailParts[1];
                $phoneLength = strlen($referral->phone);
                $maskedPhone = substr($referral->phone, 0, $phoneLength - 5) . '*****';

                return (object) [
                    'id' => $referral->id,
                    'name' => $referral->name,
                    'email' => $maskedEmail,
                    'phone' => $maskedPhone,
                    'created_at' => $referral->created_at,
                    'investmentSum' => $referral->stakings->where('unstake', false)->sum('investedAmount')
                ];
            });
        } else {
            // For Level 1, we simply calculate investments
            $currentLevelReferrals->transform(function ($referral) {
                $referral->investmentSum = $referral->stakings->where('unstake', false)->sum('investedAmount');
                return $referral;
            });
        }

        // Pagination setup
        $perPage = 7;
        $page = $request->input('page', 1);
        $paginatedReferrals = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentLevelReferrals->forPage($page, $perPage)->values(),
            $currentLevelReferrals->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Return the view with data
        return view('dashboard.level-details', [
            'name' => $user->name,
            'level' => $level,
            'referralsCount' => $currentLevelReferrals->count(),
            'investmentSum' => $currentLevelReferrals->sum('investmentSum'),
            'paginatedUsers' => $paginatedReferrals
        ]);
    }
}
