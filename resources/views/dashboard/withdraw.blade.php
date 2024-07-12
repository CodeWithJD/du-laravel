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
            <div class="text-center display-5 mb-2">@lang('Du Withdraw')</div>
            <span>
                <span class="fw-bold">My Balance:</span>
                <span class="text-primary">{{ number_format($balance, 2) }}</span>
                <span class="text-pink">DU</span>
            </span>
            <br>
            <span>
            <span class="fw-bold">Remaining Limit:</span>
            <span class="text-primary">{{ 100 - number_format($limit, 2) }}</span>
            <span class="text-pink">DU</span>
            </span>

            <form method="GET" action="{{ route('wallet.validateWithdraw') }}">
                @csrf
                <div class="input-group input-group-lg bg-white shadow-sm mt-3">
                    <span class="input-group-text bg-primary text-white">@lang('Wallet Address')</span>
                    <input id="text" type="text" class="form-control border" name="walletaddress" value="{{ old('walletaddress') }}" required>
                </div>

                <div class="input-group input-group-lg bg-white shadow-sm mt-3">
                    <span class="input-group-text bg-primary text-white">@lang('Amount')</span>
                    <input type="number" class="form-control border" id="amount" name="amount" value="{{ old('amount') }}" required>
                </div>

                <div class="input-group input-group-lg bg-white shadow-sm mt-3">
                    <span class="input-group-text bg-primary text-white">@lang('OTP')</span>
                    <input type="number" class="form-control border" id="otp" name="otp" value="{{ old('otp') }}" required>
                    <button type="button" id="sendOtp" class="btn btn-secondary ms-2">@lang('Send OTP')</button>
                </div>

                <!-- Response message container -->
                <div id="otp-response" class="mt-2"></div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success btn-label waves-effect waves-light">
                        <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> @lang('Go to Payment')
                    </button>
                    <a href="{{ route('wallet.index') }}" class="btn btn-warning btn-label waves-effect waves-light">
                        <i class="ri-error-warning-line label-icon align-middle fs-16 me-2"></i> @lang('Back to Wallet')
                    </a>
                </div>
            </form>



            <!-- Danger Alert -->

            <div class="text-center mt-3">
                @error('walletaddress')
                    <div class="alert alert-danger alert-dismissible alert-additional fade show mt-4" role="alert">
                        <div class="alert-body">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <i class="ri-error-warning-line fs-16 align-middle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="alert-heading">Wallet Address seems to be incorrect.</h5>
                                    <p class="mb-0 fw-bold">{{ $message }} </p>
                                </div>
                            </div>
                        </div>
                        <div class="alert-content">
                            <p class="mb-0">Please review it carefully and try once more</p>
                        </div>
                    </div>
                @enderror
                @error('otp')
                <div class="alert alert-danger alert-dismissible alert-additional fade show mt-4" role="alert">
                    <div class="alert-body">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-error-warning-line fs-16 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading">OTP Code seems to be incorrect.</h5>
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
                @error('blockchain')
                <div class="alert alert-danger alert-dismissible alert-additional fade show mt-4" role="alert">
                    <div class="alert-body">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-error-warning-line fs-16 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading">Du Smartchain Error.</h5>
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

            @isset($recipient_address)
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
                                <p>Wallet Address: {{ $recipient_address }}</p>
                                <p>Amount: {{ number_format($amount, 2) }} DU</p>
                                <p>Gas Fee: {{ number_format($withdrawCharge, 2) }} DU</p>
                                <p class="fw-bold">Total Amount: {{ number_format($totalAmount, 2) }} DU</p>
                                <p>OTP: {{ $otp }}</p>

                                <form method="POST" action="{{ route('wallet.completewithdraw') }}">
                                    @csrf
                                    <input type="hidden" name="walletaddress" value="{{ $recipient_address }}">
                                    <input type="hidden" name="amount" value="{{ $amount }}">
                                    <input type="hidden" name="otp" value="{{ $otp }}">

                                    <button type="submit" class="btn btn-success btn-label waves-effect waves-light"><i
                                            class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>
                                        @lang('Confirm Transfer')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="alert-content">
                        <p class="mb-0">Review the recipient's information carefully, including their name, Wallet Address, and
                            transfer amount. Once confirmed, complete the transaction.</p>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/transfer.js') }}"></script>
    <script>
        document.getElementById('sendOtp').addEventListener('click', function() {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('wallet.sendOtp') }}', true);
            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    var responseContainer = document.getElementById('otp-response');
                    if (xhr.status === 200) {
                        responseContainer.textContent = 'OTP sent successfully.';
                        responseContainer.className = 'text-success'; // Add a success class
                    } else {
                        var response = JSON.parse(xhr.responseText);
                        responseContainer.textContent = response.message || 'Failed to send OTP.';
                        responseContainer.className = 'text-danger'; // Add an error class
                    }
                }
            };

            xhr.send();
        });
    </script>

@endsection
