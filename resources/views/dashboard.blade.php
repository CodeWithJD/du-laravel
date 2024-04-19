@extends('layouts.dashboard')
@section('title')
    @lang('Staking')
@endsection
{{-- @section('css')
    <link href="{{ URL::asset('build/libs/aos/aos.css') }}" rel="stylesheet">
@endsection --}}

@section('content')
<div class="dashboard row py-5">
    <!--MyStake-->
    @component('layouts.components.staking-box')
    @endcomponent
    <!--MyStake End-->
    <div class="col-xxl-9 order-xxl-0">
        <div class="d-flex flex-column h-100">
            <div class="row h-100">
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span
                                        class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-time-fill align-middle fs-2"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        Balance </p>
                                    <h4 class=" mb-0"><span class="counter-value"
                                            data-target="12423">0</span> DU</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="ri-arrow-up-s-fill align-middle me-1"></i>6.24 %
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span
                                        class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-currency-fill align-middle fs-2"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">
                                        Total Earning</p>
                                    <h4 class=" mb-0"><span class="counter-value"
                                            data-target="12423">0</span> DU</h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="ri-arrow-up-s-fill align-middle me-1"></i>3.67 %
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span
                                        class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i
                                            class="ri-money-dollar-circle-fill align-middle fs-2"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-light fs-12 text-muted mb-1">
                                        Total Directs</p>
                                    <h4 class=" mb-0  fw-light"><span class="counter-value"
                                            data-target="12423">10</span> <span
                                            class="memeber-title">Members</span></h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <span class="badge bg-danger-subtle text-danger">
                                        <i class="ri-arrow-down-s-fill align-middle me-1"></i>4.80
                                        %
                                    </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->

                <!--Chart Start-->
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-primary">Referral Level Chart</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div id="column_distributed" class="apex-charts" dir="ltr">
                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->
                </div><!--Chart End-->
            </div><!-- end row -->
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/charts.js') }}"></script>
@endsection
