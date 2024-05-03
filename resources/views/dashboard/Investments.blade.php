@extends('layouts.dashboard')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/choices.js/choices.min.css') }}">
@endsection

@section('title')
    @lang('Directs')
@endsection

@section('page')
    @lang('Investments Analysis')
@endsection

@section('content')
    <div class="row py-5 justify-content-center">
        @if (session('message'))
            <!-- Success Alert -->
            <div class="alert alert-success alert-border-left alert-dismissible fade show" role="alert">
                <i class="ri-notification-off-line me-3 align-middle"></i> {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <!-- Error Alert -->
            <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
                <i class="ri-notification-off-line me-3 align-middle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <!-- Error Alert -->
            <div class="alert alert-danger alert-border-left alert-dismissible fade show" role="alert">
                <i class="ri-notification-off-line me-3 align-middle"></i>
                @foreach ($errors->all() as $error)
                    {{ $error }} <br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Select Option --}}
        <div class="stake-box row m-0 p-0 bg-white">
            <div class="col-6 m-0 p-0 pe-1">
                <a href="#stake" data-bs-toggle="tab">
                    <div class="select-item rounded-top active">
                        <span>Staking</span>
                    </div>
                </a>
            </div>
            {{-- Select Option --}}
            <div class="col-6 m-0 p-0 ps-1">
                <a href="#unstake">
                    <div class="select-item rounded-top">
                        <span>UnStaking</span>
                    </div>
                </a>
            </div>

            {{-- tab contents --}}
            <div class="tab-content">

                {{-- stake code start from here --}}
                <div class="tab-pane fade show active" id="stake">
                    <div class="my-5 pb-2 d-flex justify-content-between border-bottom border-3">
                        <span>Daily Reward:</span>
                        <span>{{ $rewardSettings->staking_400d_reward }}%</span>
                    </div>

                    <!-- Form for staking -->
                    <form action="{{ route('stake.process') }}" method="POST">
                        @csrf

                        <!-- Default Select -->
                        <div class="mt-1">
                            <h6 class="text-primary">Choose Lock Period:</h6>
                            <select class="form-control bg-body" name="timeframe">
                                <option value="200">200 Days</option>
                                <option value="400">400 Days</option>
                            </select>
                        </div><!-- end col -->

                        <div class="mt-5">
                            <!-- Form Control Lg -->
                            <div class="d-flex justify-content-between">
                                <label class="fw-bold">Amount: (Minimum 10 DU)</label>
                                <label class="fw-bold">Balance: {{ number_format($available_balance, 2) }} Du</label>
                            </div>

                            <input class="form-control form-control-lg bg-body" type="number" name="amount" placeholder="0">
                        </div>

                        <div class="my-5 text-center">
                            <button type="submit" class="btn btn-success btn-label waves-effect waves-light">
                                <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> APPROVE
                            </button>
                        </div>
                    </form>
                </div>


                {{-- unstake code start from here --}}
                <div class="tab-pane fade show" id="unstake">
                    <div class="my-5 pb-2 d-flex justify-content-between border-bottom border-3">
                        <span>Penalty:</span>
                        <span>{{ $rewardSettings->unstaking_gas_fee }} %</span>
                    </div>
                    <div class="mt-4">
                        <h6 class="text-primary">Previous Investment:</h6>
                        <form action="{{ route('unstake.process') }}" method="POST">
                            @csrf
                            <select class="form-control bg-body unstake-input text-primary" name="staking_id">
                                @foreach ($stakingOptions as $staking)
                                    <option value="{{ $staking['id'] }}">
                                        {{ $staking['amount'] }} Du |
                                        {{ $staking['timeframe'] }} Day
                                    </option>
                                @endforeach
                            </select>

                            <div class="my-5 text-center">
                                <button type="submit" class="btn btn-danger btn-label waves-effect waves-light"><i
                                        class="ri-error-warning-line label-icon align-middle fs-16 me-2"></i>
                                    Unstake</button>
                            </div>
                        </form>
                    </div>
                </div>

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
    <script src="{{ URL::asset('assets/libs/choices.js/choices.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/investments.js') }}"></script>
@endsection
