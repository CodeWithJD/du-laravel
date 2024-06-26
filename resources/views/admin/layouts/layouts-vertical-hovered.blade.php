<!doctype html>
<html data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover" data-layout-width="fluid">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | Du Control Penal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Du Network" name="description" />
    <meta content="CodeWithJd" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
    @include('admin.layouts.head-css')
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

     @include('admin.layouts.topbar')
     @include('admin.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <!-- Start content -->
                <div class="container-fluid">
                    @yield('content')
                </div> <!-- content -->
            </div>
            @include('admin.layouts.footer')
        </div>
        <!-- ============================================================== -->
        <!-- End Right content here -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    @include('admin.layouts.customizer')
    <!-- END Right Sidebar -->

    @include('admin.layouts.vendor-scripts')
</body>

</html>
