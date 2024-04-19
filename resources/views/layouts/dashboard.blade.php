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
                            <span class="welcome-title d-none d-md-block">Welcome to DuStake</span>
                            <p class="welcome-massage p-0 m-0">Hello, <span class="text-info">Farhan Ahmed</span> <span
                                    class="d-none d-md-block">You
                                    can manage your DU staking and access all analyses from this dashboard.</span></p>
                        </div>
                        <div class="align-content-center">
                            <a class="btn btn-danger" href="#">Logout</a>
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
