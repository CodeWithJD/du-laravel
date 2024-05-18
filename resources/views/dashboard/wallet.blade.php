@extends('layouts.dashboard')

@section('title')
    @lang('Wallet')
@endsection

@section('page')
    @lang('Wallet Control')
@endsection

@section('content')
    <div class="row py-5">
        {{-- Balance blocks --}}
        @if (session('message'))
            <!-- Success Alert -->
            <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                <i class="ri-notification-off-line me-3 align-middle"></i> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="wallet m-0 p-0">
            <div class="row">
                <div class="col-lg-6 mt-2">
                    <div class="card box-effect-blue border-primary border-1">
                        <div class="card-body">
                            <div>
                                <span class="display-6 text-primary fs-6 fw-bold">Available Balance</span>
                            </div>
                            <div class="mt-2">
                                <span class="display-5 text-primary"><span class="counter-value"
                                        data-target="{{ $userDetails->available_balance }}">0</span>
                                    {{-- <span class="fs-1"> Du</span> --}}
                                </span>
                            </div>
                            <div class="d-flex gap-2 mt-2">
                                <a class="btn btn-primary bg-gradient waves-effect waves-light"
                                    href=" {{route('swap.index')}} ">Deposit</a>
                                <a class="btn btn-primary bg-gradient waves-effect waves-light" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal" href="#">Withdrawal</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-2">
                    <div class="card box-effect-blue border-primary border-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div>
                                        <span class="display-5 text-primary fs-5 fw-bold">Reward Balance</span>
                                    </div>
                                    <div class="my-2">
                                        <span class="text-primary display-5"><span class="counter-value"
                                                data-target="{{ $userDetails->reward_balance }}">0</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div>
                                        <span class="display-5 text-primary fs-5 fw-bold">Direct Rewards</span>
                                    </div>
                                    <div class="my-2">
                                        <span class="text-primary display-5"><span class="counter-value"
                                                data-target="0">0</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div>
                                        <span class="display-5 text-primary fs-5 fw-bold">Team Rewards</span>
                                    </div>
                                    <div class="my-2">
                                        <span class="text-primary display-5"><span class="counter-value"
                                            data-target="{{ $userDetails->team_reward }}">0</span>
                                    </span>
                                    </div>
                                </div>
                                <div>
                                    <a type="button" class="btn btn-primary btn-load">
                                        <span class="d-flex align-items-center">
                                            <span class="spinner-grow flex-shrink-0" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </span>
                                            <span class="flex-grow-1 ms-2">
                                                Transfer to Balance
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-body">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Select Payment Method</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-5">
                            <a class="disabled" href="{{ route('wallet.transfer') }}">
                                <div class="wallet text-center rounded bg-white">
                                    <span class="text-primary fs-5">Send via Email ID</span>
                                    <p>transfer to other users via via Email ID</p>
                                </div>
                            </a>
                            <a class="disabled" href="">
                                <div class="smartchain text-center rounded bg-white">
                                    <span class="text-primary fs-5">Send Via Crypto Network</span>
                                    <p>transfer to other users via Du Smartchain</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Displaying transactions -->
            <div class="transactions row p-0 m-0">
                <div class="col-lg-12 mt-3 p-0">
                    <div class="card border-primary border-1">
                        <!-- end card header -->
                        <div class="card-body p-0 m-0">
                            <div class="table-responsive">
                                <table class="table align-middle" id="transactionsTable">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="type-head text-white">Type</th>
                                            <th class="amout-head text-white">Amount</th>
                                            <th class=".status-head text-white">Status</th>
                                            <th class="source-head text-white">Source</th>
                                            <th class="date-head text-white">Date</th>
                                            <th class="details-head text-white">Transaction Details</th>
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
                                                    <span class="amount">{{ number_format($transaction->amount, 2) }}</span>
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
                                                <td class="type text-primary">{{ $transaction->transaction_source }}</td>
                                                <td>{{ $transaction->created_at }}</td>
                                                <td>{{ $transaction->description }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- Pagination Controls --}}
                                <div class="d-flex justify-content-end">
                                    {{ $transactions->links() }}
                                </div>
                                <div style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                            orders for you search.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
@endsection


@section('script-bottom')
    <script src="{{ URL::asset('assets/js/charts.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.js') }}"></script>
@endsection
