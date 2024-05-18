@extends('admin.layouts.master')
@section('title')
    @lang('Users List')
@endsection
@section('content')
    @component('admin.components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Edit User
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-xxl-3">
            <div class="mb-3">
                <div class="card">
                    <div class="card-header text-center">
                        <span class="fw-bold">User Info</span>
                    </div>
                    <div class="card-body">
                        <div class="table-card">
                            <table class="table mb-2">
                                <tbody>
                                    <tr>
                                        <td class="fw-medium">User Id</td>
                                        <td>{{ $user->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Full Name</td>
                                        <td> {{ $user->name }} </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium"> Email </td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Role</td>
                                        <td>{{ $user->role }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">invite code </td>
                                        <td>{{ $user->invite_code }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Country</td>
                                        <td> {{ $user->country }} </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Phone</td>
                                        <td> {{ $user->phone }} </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Ref ID</td>
                                        <td>
                                            @if ($user->ref_id)
                                                <a href="{{ route('admin.user.edit', $user->ref_id) }}" target="_blank">
                                                    {{ $user->ref_id }}
                                                </a>
                                            @else
                                                Direct User
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Created At</td>
                                        <td> {{ $user->created_at }} </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Last Update</td>
                                        <td> {{ $user->updated_at }} </td>
                                    </tr>
                                </tbody>
                            </table><!--end table-->
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header text-center">
                        <span class="fw-bold">User Details</span>
                    </div>
                    <div class="card-body">
                        <div class="table-card">
                            <table class="table mb-2">
                                <tbody>
                                    <tr>
                                        <td class="fw-medium">Available Balance</td>
                                        <td><span
                                                class="bg-success-subtle text-primary p-1">{{ $user->userDetails->available_balance }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Reward Balance</td>
                                        <td><span
                                                class="bg-info-subtle text-primary p-1">{{ $user->userDetails->reward_balance }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Open Level</td>
                                        <td> {{ $user->userDetails->level }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Total Team</td>
                                        <td> {{ $referredUsersCount }} Members</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Staking</td>
                                        <td class="text-success"> {{ $totalStakingSum }} Du</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Unstake</td>
                                        <td class="text-danger"> {{ $totalunstakeSum }} Du</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Fee Paid</td>
                                        <td><span
                                                class="bg-success-subtle text-success fw-bold p-1">{{ $totalFees }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Whatsapp Notifications</td>
                                        <td>{{ $user->userDetails->whatsapp_notification }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Account Status</td>
                                        <td>
                                            @php
                                                $status = $user->userDetails->account_status ?? 'Unknown';
                                            @endphp
                                            @switch($status)
                                                @case('Active')
                                                    <span class="badge bg-success">{{ $status }}</span>
                                                @break

                                                @case('Review')
                                                    <span class="badge bg-warning text-dark">{{ $status }}</span>
                                                @break

                                                @case('Blocked')
                                                    <span class="badge bg-danger">{{ $status }}</span>
                                                @break

                                                @default
                                                    <span class="badge bg-secondary">{{ $status }}</span>
                                            @endswitch
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Last login</td>
                                        <td>{{ $user->userDetails->last_login }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Last IP</td>
                                        <td>{{ $user->userDetails->last_login_ip }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Email Verified</td>
                                        <td>{{ $user->userDetails->email_verified }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Mobile Verified</td>
                                        <td>{{ $user->userDetails->mobile_verified }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-medium">Last Update</td>
                                        <td>{{ $user->userDetails->updated_at }}</td>
                                    </tr>
                                </tbody>
                            </table><!--end table-->
                        </div>
                    </div>
                </div>
            </div><!--end card-->
        </div><!---end col-->

        <div class="col-xxl-9">
            <div class="card">
                <div class="card-header">
                    <div>
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#transcations" role="tab">
                                    Transcations
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#charges" role="tab">
                                    Charges Paid
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#stake-list" role="tab">
                                    Stake List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#stake-rewards" role="tab">
                                    Stake Rewards
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#referral_rewards" role="tab">
                                    Referral Rewards
                                </a>
                            </li>
                        </ul><!--end nav-->
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="transcations" role="tabpanel">
                            <h6 class="card-title mb-4 pb-2">Time Entries</h6>
                            <div class="table-responsive table-card">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Type</th>
                                            <th scope="col">Amoun</th>
                                            <th scope="col">Statu</th>
                                            <th scope="col">Sender</th>
                                            <th scope="col">Source</th>
                                            <th scope="col">Receiver</th>
                                            <th scope="col">Transaction ID</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Transaction Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td class="p-3">
                                                    @if ($transaction->user_id == $user->id)
                                                        <span class="withdraw rounded px-3 py-1">Withdraw</span>
                                                    @elseif($transaction->recipient_id == $user->id)
                                                        <span class="deposit rounded px-3 py-1">Deposit</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-info">{{ number_format($transaction->amount, 2) }}</span>
                                                    <span class="text-primary small fw-bold">Du</span>
                                                </td>
                                                <td>
                                                    @if ($transaction->status == 'Complete')
                                                        <span class="text-success">{{ $transaction->status }}</span>
                                                    @elseif($transaction->status == 'in Progress')
                                                        <span class="text-warning">{{ $transaction->status }}</span>
                                                    @elseif($transaction->status == 'Rejected')
                                                        <span class="text-danger">{{ $transaction->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($transaction->user_id)
                                                        @if ($transaction->user_id == $user->id)
                                                            <span class="text-danger">{{ $transaction->user_id }}</span>
                                                        @else
                                                            <a href="{{ route('admin.user.edit', $transaction->user_id) }}"
                                                                target="_blank">
                                                                <span class="fw-bold text-danger">{{ $transaction->user_id }}</span>
                                                            </a>
                                                        @endif
                                                    @else
                                                        <span class="text-warning">System</span>
                                                    @endif
                                                </td>

                                                <td class="type text-primary">{{ $transaction->transaction_source }}</td>
                                                <td>
                                                    @if ($transaction->recipient_id)
                                                        @if ($transaction->recipient_id == $user->id)
                                                            <span class="text-success">{{ $transaction->recipient_id }} Self</span>
                                                        @else
                                                            <a href="{{ route('admin.user.edit', $transaction->recipient_id) }}"
                                                                target="_blank">
                                                                <span class="fw-bold text-success">{{ $transaction->recipient_id }}</span>
                                                            </a>
                                                        @endif
                                                    @else
                                                        System
                                                    @endif
                                                </td>
                                                <td>{{ $transaction->transaction_hash }}</td>
                                                <td>{{ $transaction->created_at }}</td>
                                                <td>{{ $transaction->description }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table><!--end table-->
                            </div>
                        </div><!--edn tab-pane-->

                        <div class="tab-pane" id="charges" role="tabpanel">
                            <h6 class="card-title mb-4 pb-2">Time Entries</h6>
                            <div class="table-responsive table-card">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Fee type</th>
                                            <th scope="col">Total Fees</th>
                                            <th scope="col">Transaction Hash</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($feesData as $hash => $fees)
                                        @foreach ($fees as $fee)
                                            <tr>
                                                <td>{{ $hash }}</td>
                                                <td>{{ $fee->fee_type }}</td>
                                                <td><span class="fw-bold text-success">{{ $fee->total_fee }}</span> Du</td>
                                                <td>{{ $fee->created_at->format('d-m-Y H:i:s') }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table><!--end table-->
                            </div>
                        </div><!--edn tab-pane-->

                        <div class="tab-pane" id="stake-list" role="tabpanel">
                            <h6 class="card-title mb-4 pb-2">Time Entries</h6>
                            <div class="table-responsive table-card">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">amount</th>
                                            <th scope="col">Roaming Day</th>
                                            <th scope="col">Deposit Time</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stakingData as $stake)
                                        <tr>
                                            <td>{{ $stake['stake_no'] }}</td>
                                            <td>{{ number_format($stake['stake_amount'], 2) }}</td>
                                            <!-- Adjust roaming days display based on the 'withdrawn' status -->
                                            <td>
                                                @if ($stake['withdrawn'])
                                                    <span class="text-danger">0 Day</span>
                                                @else
                                                    {{ number_format($stake['roaming_day'], 0) }} days
                                                @endif
                                            </td>
                                            <td>{{ $stake['deposit_time']->format('d-m-Y H:i:s') }}</td>
                                            <td>
                                                @if ($stake['withdrawn'])
                                                    <span class="text-danger">Unstaked</span>
                                                @else
                                                    <span class="text-success">Active</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table><!--end table-->
                            </div>
                        </div><!--edn tab-pane-->

                        <div class="tab-pane" id="stake-rewards" role="tabpanel">
                            <h6 class="card-title mb-4 pb-2">Time Entries</h6>
                            <div class="table-responsive table-card">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Staking ID</th>
                                            <th scope="col">amount</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stakingRewards as $stakingReward)
                                        <tr>
                                            <td>{{$stakingReward['staking_id']}}</td>
                                            <td><span class="fw-bold">{{$stakingReward['reward_amount']}}</span> <span class="text-danger">Du</span> </td>
                                            <td>{{$stakingReward['created_at']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table><!--end table-->
                            </div>
                        </div><!--edn tab-pane-->

                        <div class="tab-pane" id="referral_rewards" role="tabpanel">
                            <h6 class="card-title mb-4 pb-2">Time Entries</h6>
                            <div class="table-responsive table-card">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Referee ID</th>
                                            <th scope="col">level</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($referralRewards as $referralReward)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.user.edit', $referralReward['referee_id']) }}" target="_blank">
                                                    {{$referralReward['referee_id']}}
                                                </a>
                                            </td>
                                            <td>{{$referralReward['level']}}</td>
                                            <td><span class="fw-bold">{{$referralReward['reward_amount']}}</span> <span class="text-danger">Du</span> </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table><!--end table-->
                            </div>
                        </div><!--edn tab-pane-->

                    </div><!--end tab-content-->
                </div>
            </div><!--end card-->
        </div><!--end col-->

    </div><!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
