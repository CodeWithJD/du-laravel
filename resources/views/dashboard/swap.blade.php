@extends('layouts.dashboard')
@section('title')
    @lang('Swap')
@endsection
@section('page')
    @lang('Welcome to Swap')
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center">
                    <p class="display-5 text-primary">Swap anytime,</p>
                    <p class="display-5 text-primary">Anywhere.</p>
                </div>
                <div class="swap-box p-4 shadow-lg">
                    <h4>Swap</h4>
                    <p>Swap Du Assets Simply and Securely With<br>Du Network Developed Algorithm</p>
                        <form action="{{ route('swap.process') }}" method="GET">
                        @csrf
                        <div class="mt-5">
                            <!-- Form Control Lg -->
                            <div class="d-flex justify-content-between">
                                <label class="fw-bold">
                                    <select class="form-select text-danger" id="currency-select" name="currency">
                                        <option value="usdt">USDT / DU</option>
                                        <option value="du">DU</option>
                                    </select>
                                </label>
                                <label class="fw-bold align-content-center">Balance: {{ number_format($available_balance, 2) }} Du</label>
                            </div>
                            <input class="form-control form-control-lg bg-body" type="number" name="amount" placeholder="0">
                        </div>
                        <div class="mt-5 text-center">
                            <button type="submit" class="btn btn-primary">Swap Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
@endsection
