@extends('layouts.dashboard')

@section('title')
    @lang('Unstake Confirmation')
@endsection

@section('content')
    <div class="unstake-confirmation py-5 d-flex justify-content-center">
        <div class="col-xxl-4 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('investments.index') }}" class="btn-close float-end fs-11" aria-label="Close"></a>
                    <h6 class="card-title mb-0">Unstake Confirmation</h6>
                </div>
                <div class="card-body">
                    <p>@lang('You are about to unstake the following investment:')</p>
                    <p>@lang('Total Amount'): {{ number_format($totalAmount, 2) }} DU</p>
                    <p>@lang('Penalty Amount'): {{ number_format($penaltyAmount, 2) }} DU</p>
                    <p>@lang('Reward Paid'): {{ number_format($staking->reward_paid, 2) }} DU </p>
                            <p>@lang('Unstake Amount'): {{ number_format($unstakeAmount, 2) }} DU</p>
                </div>
                <div class="card-footer">
                    <form method="POST" action="{{ route('unstake.confirm') }}">
                        @csrf
                        <input type="hidden" name="staking_id" value="{{ $staking->staking_id }}">
                        <button type="submit"
                            class="btn btn-soft-danger waves-effect waves-light">@lang('Confirm Unstake')</button>
                        <a href="{{ route('investments.index') }}" type="button"
                            class="btn btn-success btn-label waves-effect waves-light">
                            <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> @lang('Cancel')
                        </a>
                    </form>
                </div>
            </div>
        </div><!-- end col -->
    </div>
@endsection
