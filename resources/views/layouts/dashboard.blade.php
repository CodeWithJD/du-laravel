<!doctype html>
<html lang="en">

<head>
    @include('layouts.title-meta')
    @include('layouts.head-css')
</head>

<body>
    <div class="wraper p-0 m-0">
        <div class="row">
            <!-- Sidebar Start -->
            @include('layouts.leftbar')
            <!-- Sidebar End -->

            <!-- Sidebar mobile -->
            <div class="mobile-menu bg-primary fixed-bottom fixed border-top border-white">
                <div class="menu d-flex justify-content-center gap-5 border-1 border-primary">
                    <a href="{{ route('dashboard') }}">
                        <div class="menu-item text-center bg-primary {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="ri-dashboard-line fs-1 text-white"></i>
                            <p class="text-white">Dashboard</p>
                        </div>
                    </a>
                    <a href="{{ route('wallet.index') }}">
                        <div class="menu-item text-center bg-primary {{ request()->routeIs('wallet.index') ? 'active' : '' }}">
                            <i class="text-white ri-bank-line fs-1"></i>
                            <p class="text-white">Wallet</p>
                        </div>
                    </a>
                    <a href="{{ route('investments.index') }}">
                        <div class="menu-item text-center bg-primary {{ request()->routeIs('investments.*') ? 'active' : '' }}">
                            <i class="text-white ri-cash-line fs-1"></i>
                            <p class="text-white">Investments</p>
                        </div>
                    </a>
                    <div class="menu-item text-center bg-primary @class(['active' => request()->routeIs('profile')])">
                        <i class="text-white ri-user-line fs-1"></i>
                        <p class="text-white">Profile</p>
                    </div>
                </div>
            </div>

            <!-- MainContents Start -->
            <div class="col-md-10 right-content">
                <div class="right-item bg-body h-100 rounded-5 p-4">
                    <div class="header d-flex justify-content-between">
                        <div>
                            <span class="welcome-title d-none d-md-block">@yield('page')</span>
                            <p class="welcome-massage p-0 mt-1">Hello, <span class="text-info">{{ $name }}</span> <span
                                    class="d-none d-md-block">You
                                    can manage your DU Network and access all analyses from this dashboard.</span></p>
                        </div>
                        <div class="align-content-center">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Logout</button>
                            </form>
                        </div>
                    </div>
                     <!-- contents of this page -->
                    @yield('content')
                </div>
            </div>
            <!-- MainContents End -->
        </div>
    </div>
    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
</body>

</html>
