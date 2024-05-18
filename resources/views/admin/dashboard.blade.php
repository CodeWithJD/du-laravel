@extends('admin.layouts.master')
@section('title')
    @lang('Admin Dashboard')
@endsection
@section('content')
    @component('admin.components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Du Network
        @endslot
    @endcomponent

    {{-- top bar --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total Users
                                    <i class="text-success fs-18 float-end align-middle">0</i>
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-space-ship-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value"
                                                data-target="{{ $totalUsers }}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total Stake <i
                                        class="fs-18 float-end align-middle">0</i> </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-trophy-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value"
                                                data-target="{{ $totalStake }}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total Unstake<i
                                        class="fs-18 float-end align-middle">0</i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-pulse-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value"
                                                data-target="{{ $totalUnstake }}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Available Balance <i
                                        class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i> </h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-exchange-dollar-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">Du <span class="counter-value"
                                                data-target="{{ $totalAvailableBalance }}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                        <div class="col">
                            <div class="mt-3 mt-lg-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Active Users <i
                                        class="ri-arrow-down-circle-line text-danger fs-18 float-end align-middle"></i></h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-service-line display-6 text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><span class="counter-value"
                                                data-target="{{ $totalUsersWithStaking }}">0</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
    {{-- top bar --}}

    <div class="row">
        <div class="col-xl-3">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Users by Device</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div id="user_device_pie_charts" data-colors='["--vz-primary", "--vz-warning", "--vz-info"]'
                        class="apex-charts" dir="ltr"></div>

                    <div class="table-responsive mt-3">
                        <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                            <tbody class="border-0">
                                <tr>
                                    <td>
                                        <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Desktop
                                            Users</h4>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>{{$deviceCounts['desktop']}}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>Mobile
                                            Users</h4>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-0"><i data-feather="users"
                                                class="me-2 icon-sm"></i>{{$deviceCounts['mobile']}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                class="ri-stop-fill align-middle fs-18 text-info me-2"></i>Tablet
                                            Users</h4>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-0"><i data-feather="users"
                                                class="me-2 icon-sm"></i>{{$deviceCounts['tablet']}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xxl-3 col-md-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                </div><!-- end card header -->
                <div class="card-body pb-0">
                    <div id="deal-type-charts" data-colors='["--vz-warning", "--vz-danger", "--vz-success"]'
                        class="apex-charts" dir="ltr"></div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xxl-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Balance Overview</h4>
                </div><!-- end card header -->
                <div class="card-body px-0">
                    <ul class="list-inline main-chart text-center mb-0">
                        <li class="list-inline-item chart-border-left me-0 border-0">
                            <h4 class="text-success">{{ $totalStake }} <span
                                    class="text-muted d-inline-block fs-13 align-middle ms-2">Total Stake</span></h4>
                        </li>
                        <li class="list-inline-item chart-border-left me-0">
                            <h4 class="text-danger">{{ $totalUnstake }}<span
                                    class="text-muted d-inline-block fs-13 align-middle ms-2">Total Unstake</span>
                            </h4>
                        </li>
                        <li class="list-inline-item chart-border-left me-0">
                            <h4><span data-plugin="counterup">test</span><span
                                    class="text-muted d-inline-block fs-13 align-middle ms-2">Yesterday Stake</span></h4>
                        </li>
                    </ul>

                    <div id="revenue-expenses-charts" data-colors='["--vz-success", "--vz-danger"]' class="apex-charts"
                        dir="ltr"></div>
                </div>
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->

    <script>
        var monthlyData = @json($monthlyData);
        var deviceCounts = @json($deviceCounts);
    </script>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/dashboard-crm.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
