@extends('layouts.dashboard')
@section('title')
    @lang('Staking')
@endsection
@section('page')
    @lang('Welcome to Du Network')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {{-- error shoe here --}}
            <div class="col-md-6 mt-5">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="bg-white p-4 shadow-lg">
                    <div class="text-center">
                        <h4 class="fw-light">Confirm Swap</h4>
                        <hr>
                        <ul>
                            <li class="nav-link">Swap Amount: <span class="text-primary fw-bold">{{ $swapAmount }}
                                    {{ $currency }}</span></li>
                            <li class="nav-link">Exchange Rate: <span class="text-primary fw-bold"> {{ $exchangeRate }}
                                    {{ $currency }} </span></li>
                            <li class="nav-link mt-1"><span class="text-success fw-bold"> You will Receive: {{ $exchangeAmount }}
                                    Du</span></li>
                        </ul>
                        <hr>
                        <p class="h3 text-info">STEP 01</p>
                        <p>transfer <span class="text-primary fw-bold">{{ $swapAmount }}</span> {{ $currency }} on
                            this wallet address</p>
                        <p class="m-0">Address:</p>
                        <p class="m-0 mt-1 mb-1"><span
                                class="text-primary fw-bold">0x2325f60c4a7408aBbc4047530FE7dEafafB9B607</span></p>
                        <p>
                            <span class="text-primary fw-bold">Network :
                                @if ($currency == 'usdt')
                                    BNB Smart Chain (BEP20)
                                @elseif ($currency == 'du')
                                    DU Smartchain
                                @endif
                            </span>
                        </p>
                        <br>
                        <img src="{{ URL::asset('assets/images/swap/2.png') }}" alt="">
                        <hr>
                        <p class="h3 text-info m-2">STEP 02</p>
                        <form action="{{ route('swap.confirm') }}" method="GET">
                            @csrf
                            <div class="mt-2">
                                <input type="hidden" name="amount" value="{{ $swapAmount }}">
                                <input type="hidden" name="currency" value="{{ $currency }}">
                                <label>Please put here your {{ $currency }} address</label>
                                <input class="form-control bg-body" type="text" name="wallet"
                                    placeholder=" {{ $currency }} wallet address ">
                            </div>
                            <div class="mt-2">
                                <label>Please put here your {{ $currency }} Transaction ID</label>
                                <input class="form-control bg-body" type="text" name="transaction_id"
                                    placeholder=" {{ $currency }} Transactions ID ">
                            </div>
                            <div class="my-5 text-center">
                                <button type="submit" class="btn btn-success btn-label waves-effect waves-light">
                                    <i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i> Complate
                                    Transactions
                                </button>
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
