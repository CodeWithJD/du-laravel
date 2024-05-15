<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'invite_code', 'ref_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userDetails() {
        return $this->hasOne(UserDetails::class, 'user_id');
    }

    // In User model
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    // In App\Models\UserDetails.php
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationships
    public function referrals()
    {
        return $this->hasMany(User::class, 'ref_id');
    }

    public function stakings()
    {
        return $this->hasMany(Staking::class, 'user_id');
    }

    // All Investments
    public function getTotalInvestments()
    {
        // Start with the user's own active investments
        $totalInvestment = $this->stakings->where('unstake', false)->sum('investedAmount');

        // Add investments from all referrals recursively
        foreach ($this->referrals as $referral) {
            $totalInvestment += $referral->getTotalInvestments(); // Ensure this method is recursively calculating correctly
        }

        // Return the calculated total investments
        return $totalInvestment;
    }


    // Referral counts and investments
    public function getTotalReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $referral) {
            $total += 1 + $referral->getTotalReferralsCount();
        }
        return $total;
    }


    public function directsInvestments()
    {
        return $this->referrals->sum(function ($referral) {
            return $referral->stakings->where('unstake', false)->sum('investedAmount');
        });
    }
    // Level 1
    public function levelOneReferralsCount()
    {
        return $this->referrals()->count();  // Count direct referrals
    }

    public function levelOneInvestments()
    {
        return $this->referrals()->with('stakings')->get()->sum(function ($referral) {
            return $referral->stakings->where('unstake', false)->sum('investedAmount');
        });
    }
    // Level 2
    public function levelTwoReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $referral) {
            $total += $referral->referrals()->count();
        }
        return $total;
    }

    public function levelTwoInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                $totalInvestment += $levelTwoReferral->stakings->where('unstake', false)->sum('investedAmount');
            }
        }
        return $totalInvestment;
    }

    // Level 3
    public function levelThreeReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                $total += $levelTwoReferral->referrals()->count();
            }
        }
        return $total;
    }

    public function levelThreeInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    $totalInvestment += $levelThreeReferral->stakings->where('unstake', false)->sum('investedAmount');
                }
            }
        }
        return $totalInvestment;
    }

    // Level 4
    public function levelFourReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    $total += $levelThreeReferral->referrals()->count();  // Count each Level 4 referral
                }
            }
        }
        return $total;
    }

    public function levelFourInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        $totalInvestment += $levelFourReferral->stakings->where('unstake', false)->sum('investedAmount');
                    }
                }
            }
        }
        return $totalInvestment;
    }

    // Level 5
    public function levelFiveReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        $total += $levelFourReferral->referrals()->count();  // Count each Level 5 referral
                    }
                }
            }
        }
        return $total;
    }

    public function levelFiveInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            $totalInvestment += $levelFiveReferral->stakings->where('unstake', false)->sum('investedAmount');
                        }
                    }
                }
            }
        }
        return $totalInvestment;
    }

    // Level 6
    public function levelSixReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            $total += $levelFiveReferral->referrals()->count();  // Count each Level 6 referral
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function levelSixInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                $totalInvestment += $levelSixReferral->stakings->where('unstake', false)->sum('investedAmount');
                            }
                        }
                    }
                }
            }
        }
        return $totalInvestment;
    }

    // Level 7

    public function levelSevenReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                $total += $levelSixReferral->referrals()->count();  // Count each Level 7 referral
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function levelSevenInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    $totalInvestment += $levelSevenReferral->stakings->where('unstake', false)->sum('investedAmount');
                                }
                            }
                        }
                    }
                }
            }
        }
        return $totalInvestment;
    }

    //Level 8
    public function levelEightReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    $total += $levelSevenReferral->referrals()->count();  // Count each Level 8 referral
                                }
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function levelEightInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        $totalInvestment += $levelEightReferral->stakings->where('unstake', false)->sum('investedAmount');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $totalInvestment;
    }
    // Level 9
    public function levelNineReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        $total += $levelEightReferral->referrals()->count();  // Count each Level 9 referral
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function levelNineInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        foreach ($levelEightReferral->referrals as $levelNineReferral) {
                                            $totalInvestment += $levelNineReferral->stakings->where('unstake', false)->sum('investedAmount');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $totalInvestment;
    }
    // Level 10
    public function levelTenReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        foreach ($levelEightReferral->referrals as $levelNineReferral) {
                                            $total += $levelNineReferral->referrals()->count();  // Count each Level 10 referral
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function levelTenInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        foreach ($levelEightReferral->referrals as $levelNineReferral) {
                                            foreach ($levelNineReferral->referrals as $levelTenReferral) {
                                                $totalInvestment += $levelTenReferral->stakings->where('unstake', false)->sum('investedAmount');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $totalInvestment;
    }
    // Level 11

    public function levelElevenReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        foreach ($levelEightReferral->referrals as $levelNineReferral) {
                                            foreach ($levelNineReferral->referrals as $levelTenReferral) {
                                                foreach ($levelTenReferral->referrals as $levelElevenReferral) {
                                                    $total += $levelElevenReferral->referrals()->count();  // Count each Level 11 referral
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function levelElevenInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        foreach ($levelEightReferral->referrals as $levelNineReferral) {
                                            foreach ($levelNineReferral->referrals as $levelTenReferral) {
                                                foreach ($levelTenReferral->referrals as $levelElevenReferral) {
                                                    $totalInvestment += $levelElevenReferral->stakings->where('unstake', false)->sum('investedAmount');
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $totalInvestment;
    }
    // Level 12

    public function levelTwelveReferralsCount()
    {
        $total = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        foreach ($levelEightReferral->referrals as $levelNineReferral) {
                                            foreach ($levelNineReferral->referrals as $levelTenReferral) {
                                                foreach ($levelTenReferral->referrals as $levelElevenReferral) {
                                                    foreach ($levelElevenReferral->referrals as $levelTwelveReferral) {
                                                        $total += $levelTwelveReferral->referrals()->count();  // Count each Level 12 referral
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $total;
    }

    public function levelTwelveInvestments()
    {
        $totalInvestment = 0;
        foreach ($this->referrals as $levelOneReferral) {
            foreach ($levelOneReferral->referrals as $levelTwoReferral) {
                foreach ($levelTwoReferral->referrals as $levelThreeReferral) {
                    foreach ($levelThreeReferral->referrals as $levelFourReferral) {
                        foreach ($levelFourReferral->referrals as $levelFiveReferral) {
                            foreach ($levelFiveReferral->referrals as $levelSixReferral) {
                                foreach ($levelSixReferral->referrals as $levelSevenReferral) {
                                    foreach ($levelSevenReferral->referrals as $levelEightReferral) {
                                        foreach ($levelEightReferral->referrals as $levelNineReferral) {
                                            foreach ($levelNineReferral->referrals as $levelTenReferral) {
                                                foreach ($levelTenReferral->referrals as $levelElevenReferral) {
                                                    foreach ($levelElevenReferral->referrals as $levelTwelveReferral) {
                                                        $totalInvestment += $levelTwelveReferral->stakings->where('unstake', false)->sum('investedAmount');
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $totalInvestment;
    }


}
