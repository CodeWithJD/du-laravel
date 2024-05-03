@extends('layouts.dashboard')

@section('title')
    @lang('Unstake Confirmation')
@endsection

@section('content')
    <div class="unstake-confirmation py-5 d-flex justify-content-center">
        <div class="col-xxl-4 col-lg-6">
            <div class="card border-primary border-1">
                <div class="card-header">
                    <a href="{{ route('investments.index') }}" class="btn-close float-end fs-11" aria-label="Close"></a>
                    <h6 class="card-title mb-0 fw-bold text-primary">Staking Confirmation</h6>
                </div>
                <div class="card-body">
                    <p>@lang('You are about to stake the following investment:')</p>
                    <p>@lang('Investment Amount'): <span class="text-primary fw-bold">{{ number_format($amount, 2) }} DU</span> </p>
                    <p>@lang('Investment Period'): <span class="text-primary fw-bold"> {{ number_format($timeframe, 0) }} Days</span></p>
                    <p>@lang('Daily Reward'):  <span class="text-primary fw-bold"> {{ number_format($dailyReward, 2) }} % </span></p>
                    <p>@lang('Gas fee'): <span class="text-primary fw-bold"> {{ number_format($stakingGasFee, 2) }} DU</span></p>
                </div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('stake.confirm') }}">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $amount }}">
                        <input type="hidden" name="timeframe" value="{{ $timeframe }}">

                        <button type="submit" class="btn btn-primary btn-label waves-effect waves-light">
                            <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> @lang('Confirm Staking')
                        </button>
                        <a href="{{ route('investments.index') }}"
                            class="btn btn-soft-primary waves-effect waves-light">@lang('Cancel')</a>
                    </form>
                </div>
            </div>
        </div><!-- end col -->
    </div>
@endsection
