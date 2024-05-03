@extends('layouts.dashboard')

@section('title')
    @lang('Directs')
@endsection

@section('page')
    @lang('Directs Analysis')
@endsection

@section('content')
    <div class="transfer mt-5">
        <div class="transfer-box">
            <div class="text-center display-5 mb-2">@lang('Du Transfer')</div>
            <span>
                <span class="fw-bold">My Balance:</span>
                <span class="text-primary">{{ number_format($balance, 2) }}</span>
                <span class="text-pink">DU</span>
            </span>
            <form method="POST" action="{{ route('wallet.validateTransfer') }}">
                @csrf
                <div class="input-group input-group-lg bg-white shadow-sm">
                    <span class="input-group-text bg-primary text-white">@lang('Email ID')</span>
                    <input id="email" type="email" class="form-control border" name="email" required>
                </div>
                <div class="input-group input-group-lg bg-white shadow-sm mt-3">
                    <span class="input-group-text bg-primary text-white">@lang('Amount')</span>
                    <input type="number" class="form-control border" id="amount" name="amount" required>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success btn-label waves-effect waves-light"><i
                            class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> @lang('Go to Payment')</button>
                    <a href="{{ route('wallet.index') }}" class="btn btn-warning btn-label waves-effect waves-light"><i
                            class="ri-error-warning-line label-icon align-middle fs-16 me-2"></i> @lang('Back to Wallet')</a>
                </div>
            </form>

            <!-- Danger Alert -->

            <div class="text-center mt-3">
                @error('email')
                <div class="alert alert-danger alert-dismissible alert-additional fade show mt-4" role="alert">
                    <div class="alert-body">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-error-warning-line fs-16 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading">Email ID seems to be incorrect.</h5>
                                <p class="mb-0 fw-bold">{{ $message }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="alert-content">
                        <p class="mb-0">Please review it carefully and try once more</p>
                    </div>
                </div>
                @enderror
                @error('amount')
                <div class="alert alert-danger alert-dismissible alert-additional fade show mt-4" role="alert">
                    <div class="alert-body">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-error-warning-line fs-16 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading">Amount seems to be incorrect.</h5>
                                <p class="mb-0 fw-bold">{{ $message }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="alert-content">
                        <p class="mb-0">Please review it carefully and try once more</p>
                    </div>
                </div>
                @enderror
            </div>

            @isset($recipient)
                <div class="mt-5">
                </div>

                <!-- Success Alert -->
                <div class="alert alert-success alert-dismissible alert-additional fade show" role="alert">
                    <div class="alert-body">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-notification-line fs-16 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading">Recipient Information</h5>
                                <p>Name: {{ $recipient->name }}</p> <!-- Display full name -->
                                <p>Email: {{ $recipient->email }}</p>
                                <p>Amount: {{ number_format($amount, 2) }} DU</p>
                                <p>Gas Fee: {{ number_format($transferCharge, 2) }} DU</p>
                                <p class="fw-bold">Total Amount: {{ number_format($totalAmount, 2) }} DU</p>

                                <form method="POST" action="{{ route('wallet.completeTransfer') }}">
                                    @csrf
                                    <input type="hidden" name="recipient_id" value="{{ $recipient->id }}">
                                    <input type="hidden" name="amount" value="{{ $amount }}">

                                    <button type="submit" class="btn btn-success btn-label waves-effect waves-light"><i
                                            class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> @lang('Confirm Transfer')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="alert-content">
                        <p class="mb-0">Review the recipient's information carefully, including their name, email, and transfer amount. Once confirmed, complete the transaction.</p>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection



@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/transfer.js') }}"></script>
@endsection
