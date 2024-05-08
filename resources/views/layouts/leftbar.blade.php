<div class="col-2 left-content bg-primary d-none d-lg-block p-0">
    <div class="d-flex justify-content-center mt-5">
        <img class="logo" src="{{ URL::asset('assets/images/logo/logo.png')}}" alt="" height="100px">
    </div>

    <div class="left-bar align-content-center mt-5">
        <ul class="p-0">
            <li class="nav-item py-1 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link text-white">
                <i class="ri-dashboard-2-fill fs-3 text-white me-2"></i>
                <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item py-1 {{ request()->routeIs('wallet.*') ? 'active' : '' }}">
                <a href="{{ route('wallet.index') }}" class="nav-link text-white">
                    <i class="ri-bank-fill fs-3 text-white me-2"></i>
                    <span>Wallet</span>
                </a>
            </li>
            <li class="nav-item py-1 {{ request()->routeIs('investments.*') ? 'active' : '' }}">
                <a href="{{ route('investments.index') }}" class="nav-link text-white">
                    <i class="ri-cash-fill fs-3 text-white me-2"></i>
                    <span>Investments</span>
                </a>
            </li>
            <li class="nav-item py-1 {{ request()->routeIs('swap.*') ? 'active' : '' }}">
                <a href="{{ route('swap.index') }}" class="nav-link text-white">
                    <i class="ri-money-dollar-box-fill fs-3 text-white me-2"></i>
                    <span>My Swap</span>
                </a>
            </li>
            <li class="nav-item py-1 {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <a href=" {{route('profile.index')}} " class="nav-link text-white">
                    <i class="ri-user-fill fs-3 text-white me-2"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="nav-item py-1">
                <a href="#" class="nav-link text-white">
                    <i class=" ri-headphone-line fs-3 text-white me-2"></i>
                    <span>Support</span>
                </a>
            </li>
            <li class="nav-item py-1">
                <a href="#" class="nav-link text-white">
                    <i class="ri-secure-payment-fill fs-3 text-white me-2"></i>
                    <span>Bills Payments</span>
                </a>
            </li>
        </ul>
    </div>
</div>
