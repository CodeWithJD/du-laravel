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

            <!-- Today and Yesterday Rewards -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card border-primary border-1 mb-3">
                    <div class="card-header bg-primary text-white">Today Team Reward</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $todayRewards }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card border-primary border-1 mb-3">
                    <div class="card-header bg-primary text-white">Yesterday Team Reward</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $yesterdayRewards }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="wallet m-0 p-0">

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
                                            <th class="type-head text-white">Reward From</th>
                                            <th class=".status-head text-white">Level</th>
                                            <th class="source-head text-white">Reward Amount</th>
                                            <th class="date-head text-white">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($referralRewards as $referralReward)
                                            <tr>
                                                <td>{{ $referralReward->referee->name }}</td>
                                                <td>{{ $referralReward->level }}</td>
                                                <td class="fw-bold">{{ $referralReward->reward_amount }}</td>
                                                <td>{{ $referralReward->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $referralRewards->links() }}
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
