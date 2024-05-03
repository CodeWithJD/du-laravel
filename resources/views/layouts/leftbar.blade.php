<div class="col-2 left-content bg-primary d-none d-lg-block">
    <div class="d-flex justify-content-center">
        <img class="logo" src="{{ URL::asset('assets/images/logo/logo.png')}}" alt="">
    </div>
    <div class="left-bar h-100 align-content-center">
        <ul>
            <li class="nav-link"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="nav-link"><a href="{{ route('wallet.index') }}">Wallet</a></li>
            <li class="nav-link"><a href="{{ route('investments.index') }}">Investments</a></li>
            <li class="nav-link"><a href="#">Profile</a> <span class="badge badge-pill badge-info text-white">Coming Soon</span></li>
            <li class="nav-link"><a href="#">Support</a><span class="badge badge-pill badge-info text-white">Coming Soon</span></li>
            <li class="nav-link"><a href="#">Bills Payments</a><span class="badge badge-pill badge-info text-white">Coming Soon</span></li>
            <li class="nav-link"><a href="#">My Swap</a><span class="badge badge-pill badge-info text-white">Coming Soon</span></li>

{{--
            <li><span class="text-white">Support</span> <span class="badge badge-pill badge-info text-pink">Coming Soon</span></li>
            <li><span class="text-white">Bills Payments</span> <span class="badge badge-pill badge-info text-pink">Coming Soon</span></li>
            <li><span class="text-white">My Swap</span> <span class="badge badge-pill badge-info text-pink">Coming Soon</span></li> --}}

        </ul>
    </div>
</div>
