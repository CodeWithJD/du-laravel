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
