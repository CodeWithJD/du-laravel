@extends('layouts.dashboard')
@section('title')
    @lang('Staking')
@endsection
@section('page')
    @lang('Welcome to Du Network')
@endsection

@section('content')
    <div class="dashboard row py-5">
        <!--MyStake-->
        <div class="col-xxl-3 mb-3">
            <div class="card">
                <div class="card-header bg-primary d-flex align-items-center">
                    <span class="card-title m-0">My Staking</span>
                </div><!-- end cardheader -->
                <div class="card-body boxStaking">
                    <div id="portfolio_donut_charts" data-colors='["#FF5733", "#33FF57", "#3357FF", "#FF33E6"]'
                        class="apex-charts" dir="ltr">
                    </div>

                    <ul class="list-group list-group-flush mb-0 mt-3 p-2 bg-body rounded-3">
                        <ul class="list-group list-group-flush mb-0 mt-3 p-2">
                            @if ($stakingData->isNotEmpty())
                                @foreach ($stakingData as $staking)
                                    <li class="list-group-item px-0 bg-body">
                                        <div class="d-flex">
                                            <div class="ms-2 flex-grow-1">
                                                <h6 class="mb-1 text-primary">Stake {{ $staking['stake_no'] }}</h6>
                                                <p class="fs-12 mb-0 text-primary">Remaining Days</p>
                                            </div>
                                            <div class="text-end">
                                                <h6 class="mb-1 fw-bold text-primary fw-bold">{{ number_format($staking['stake_amount'], 2) }} <span
                                                        class="small">DU</span></h6>
                                                <p class="text-primary fs-12 mb-0">
                                                    {{ number_format($staking['roaming_day'], 0) }} Days</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item px-0 text-center">
                                    No active stakes available.
                                </li>
                            @endif
                        </ul>
                        <li class="pb-3">
                        </li>
                        <!-- end -->
                        <!-- end -->
                    </ul><!-- end -->
                </div><!-- end card body -->
            </div><!-- end-->
        </div>

        <!--MyStake End-->
        <div class="col-xxl-9 order-xxl-0">
            <div class="d-flex flex-column h-100">
                <div class="row h-100">
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                            <i class="ri-time-fill align-middle fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-bold fs-12 text-dark mb-1">
                                            Balance </p>
                                        <h4 class=" mb-0"><span class="counter-value"
                                                data-target="{{ $userDetails->available_balance }}">0</span> <span
                                                class="memeber-title text-success">Du</span></h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-end">
                                        <span class="badge bg-success-subtle text-success">
                                            <i
                                                class="ri-arrow-up-s-fill align-middle me-1"></i>{{ $userDetails->reward_balance }}
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                            <i class="ri-currency-fill align-middle fs-2"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-uppercase fw-bold fs-12 text-dark mb-1">
                                            My Team</p>
                                        <h4 class=" mb-0"><span class="counter-value"
                                                data-target="{{ $totalTeamSize }}">0</span> <span
                                                class="memeber-title">Users</span></h4>
                                    </div>
                                    <div class="flex-shrink-0 align-self-end">
                                        <span class="badge bg-success-subtle text-primary">
                                            {{ number_format($totalInvestmentSum, 0) }} Du
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                    <div class="col-lg-4 col-md-6 mb-2">
                        <a href="{{ route('directs') }}">
                            <div class="card shadow-lg">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                                <i class="ri-money-dollar-circle-fill align-middle fs-2"></i>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <p class="text-uppercase fw-bold fs-12 text-dark mb-1">
                                                Total Directs</p>
                                            <h4 class="mb-0"><span class="counter-value"
                                                    data-target="{{ $referredUsersCount }}">0</span> <span
                                                    class="memeber-title">Users</span>
                                            </h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-end">
                                            <span class="badge bg-success-subtle text-primary">
                                                {{ number_format($directsInvestmentSum, 0) }} Du
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </a>
                    </div><!-- end col -->

                    <!-- info slide -->
                    @component('components.level-card')
                        @slot('directsReferralsCount')
                            {{ $referredUsersCount }}
                        @endslot
                        @slot('directsInvestmentSum')
                            {{ $directsInvestmentSum }}
                        @endslot

                        @slot('levelTwoReferralsCount')
                            {{ $levelTwoReferralsCount }}
                        @endslot
                        @slot('levelTwoInvestmentSum')
                            {{ $levelTwoInvestmentSum }}
                        @endslot

                        @slot('levelThreeReferralsCount')
                            {{ $levelThreeReferralsCount }}
                        @endslot
                        @slot('levelThreeInvestmentSum')
                            {{ $levelThreeInvestmentSum }}
                        @endslot

                        @slot('levelFourReferralsCount')
                            {{ $levelFourReferralsCount }}
                        @endslot
                        @slot('levelFourInvestmentSum')
                            {{ $levelFourInvestmentSum }}
                        @endslot

                        @slot('levelFiveReferralsCount')
                            {{ $levelFiveReferralsCount }}
                        @endslot
                        @slot('levelFiveInvestmentSum')
                            {{ $levelFiveInvestmentSum }}
                        @endslot

                        @slot('levelSixReferralsCount')
                            {{ $levelSixReferralsCount }}
                        @endslot
                        @slot('levelSixInvestmentSum')
                            {{ $levelSixInvestmentSum }}
                        @endslot

                        @slot('levelSevenReferralsCount')
                            {{ $levelSevenReferralsCount }}
                        @endslot
                        @slot('levelSevenInvestmentSum')
                            {{ $levelSevenInvestmentSum }}
                        @endslot

                        @slot('levelEightReferralsCount')
                            {{ $levelEightReferralsCount }}
                        @endslot
                        @slot('levelEightInvestmentSum')
                            {{ $levelEightInvestmentSum }}
                        @endslot

                        @slot('levelNineReferralsCount')
                            {{ $levelNineReferralsCount }}
                        @endslot
                        @slot('levelNineInvestmentSum')
                            {{ $levelNineInvestmentSum }}
                        @endslot

                        @slot('levelTenReferralsCount')
                            {{ $levelTenReferralsCount }}
                        @endslot
                        @slot('levelTenInvestmentSum')
                            {{ $levelTenInvestmentSum }}
                        @endslot

                        @slot('levelElevenReferralsCount')
                            {{ $levelElevenReferralsCount }}
                        @endslot
                        @slot('levelElevenInvestmentSum')
                            {{ $levelElevenInvestmentSum }}
                        @endslot

                        @slot('levelTwelveReferralsCount')
                            {{ $levelTwelveReferralsCount }}
                        @endslot
                        @slot('levelTwelveInvestmentSum')
                            {{ $levelTwelveInvestmentSum }}
                        @endslot
                    @endcomponent
                    <!-- info slide end -->

                    <!--Chart Start-->
                    <div class="col-xl-12 mt-2">
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

        <div class="referral-box">
            <div class="row">
                <div class="col-lg-2 referral-title">Referral Link</div>
                <div class="col-lg-6 referral-link"><input type="text" class="form-control me-3" id="copyInput"
                        value="{{ config('app.url') }}/register?ref={{ $invite_code }}"></div>
                <div class="col-lg-2 referral-button"><button class="btn btn-primary" onclick="copyText(this)">Copy</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ URL::asset('assets/js/swiper.js') }}"></script>
    <script>
        var predefinedColors = ["#405189", "#f672a7", "#f1963b", "#0ab39c", "#ff5733", "#33ff57", "#3357ff", "#ff33e6", '#3577f1', '#405189', '#6559cc', '#f672a7', '#f06548', '#f1963b', '#f7b84b',
            '#0ab39c', '#02a8b5', '#299cdb', '#f672a7', '#6559cc'];
        var donutchartportfolioColors = [];
        var stakeAmounts = [];
        var labelsName = [];
        @foreach ($stakingData as $index => $stakings)
            stakeAmounts.push({{ $stakings['stake_amount'] }});
            labelsName.push("Stake {{ $stakings['stake_no'] }}");
            // Select color from predefinedColors array based on index
            var colorIndex = {{ $index % count($stakingData) }};
            var selectedColor = predefinedColors[colorIndex];
            donutchartportfolioColors.push(selectedColor);
        @endforeach

        @if (empty($stakeAmounts))
            stakeAmounts.push(0);
            labelsName.push("No Staking");
        @endif

        var options = {
            series: stakeAmounts,
            labels: labelsName,
            chart: {
                type: "donut",
                height: 224,
            },

            plotOptions: {
                pie: {
                    size: 100,
                    offsetX: 0,
                    offsetY: 0,
                    donut: {
                        size: "70%",
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: "18px",
                                offsetY: -5,
                            },
                            value: {
                                show: true,
                                fontSize: "20px",
                                color: "#343a40",
                                fontWeight: 500,
                                offsetY: 5,
                                formatter: function(val) {
                                    return "Du" + val;
                                },
                            },
                            total: {
                                show: true,
                                fontSize: "12px",
                                label: "Total Stake",
                                color: "#9599ad",
                                fontWeight: 500,
                                formatter: function(w) {
                                    return (
                                        w.globals.seriesTotals.reduce(function(a, b) {
                                            return a + b;
                                        }, 0).toLocaleString()
                                    );
                                },
                            },
                        },
                    },
                },
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return "DU" + value;
                    },
                },
            },
            stroke: {
                lineCap: "round",
                width: 2,
            },
            colors: donutchartportfolioColors,
        };
        var chart = new ApexCharts(document.querySelector("#portfolio_donut_charts"), options);
        chart.render();
    </script>
    <script>
        // Distributed Columns Charts
        var chartColumnDistributedColors = ['#3577f1', '#405189', '#6559cc', '#f672a7', '#f06548', '#f1963b', '#f7b84b',
            '#0ab39c', '#02a8b5', '#299cdb', '#f672a7', '#6559cc'
        ]; // Random colors
        var options = {
            series: [{
                data: [{{ $referredUsersCount }}, {{ $levelTwoReferralsCount }},
                    {{ $levelThreeReferralsCount }}, {{ $levelFourReferralsCount }},
                    {{ $levelFiveReferralsCount }}, {{ $levelSixReferralsCount }},
                    {{ $levelSevenReferralsCount }}, {{ $levelEightReferralsCount }},
                    {{ $levelNineReferralsCount }}, {{ $levelTenReferralsCount }},
                    {{ $levelElevenReferralsCount }}, {{ $levelTwelveReferralsCount }}
                ],
            }],
            chart: {
                height: 250,
                type: 'bar',
                events: {
                    click: function(chart, w, e) {
                        // console.log(chart, w, e)
                    }
                },
                toolbar: {
                    show: false // Disable toolbar
                }
            },
            colors: chartColumnDistributedColors,
            plotOptions: {
                bar: {
                    columnWidth: '50%',
                    distributed: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            xaxis: {
                categories: [
                    ['L1'],
                    ['L2'],
                    ['L3'],
                    ['L4'],
                    ['L5'],
                    ['L6'],
                    ['L7'],
                    ['L8'],
                    ['L9'],
                    ['L10'],
                    ['L11'],
                    ['L12'],
                ],
                labels: {
                    style: {
                        colors: chartColumnDistributedColors,
                        fontSize: '12px'
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#column_distributed"), options);
        chart.render();
    </script>
@endsection
