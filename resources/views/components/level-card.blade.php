<div class="row slider-box">
    <div class="col-lg-12">
        <div class="swiper cryptoSlider">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 1]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/01.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 01</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">{{ $directsReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">{{ $directsInvestmentSum }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 2]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/02.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 02</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">{{ $levelTwoReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelTwoInvestmentSum }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->


                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 3]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/03.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 03</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelThreeReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelThreeInvestmentSum }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 4]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/04.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 04</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelFourReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelFourInvestmentSum }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 5]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/05.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 05</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelFiveReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelFiveInvestmentSum }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 6]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/06.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 06</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">{{ $levelSixReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelSixInvestmentSum }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 7]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/06.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 07</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelSevenReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelSevenInvestmentSum }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 8]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/06.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 08</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelEightReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelEightInvestmentSum }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 9]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/06.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 09</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelNineReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelNineInvestmentSum }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 10]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/06.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 10</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelTenReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelTenInvestmentSum }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 11]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/06.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 11</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelElevenReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelElevenInvestmentSum }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

                <div class="swiper-slide">
                    <a href="{{ route('levels.show', ['level' => 12]) }}">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-6">
                                        <img class="img-fluid" src="{{ URL::asset('assets/images/slide/06.png') }}"
                                            alt="">
                                    </div>
                                    <div class="col-6">
                                        <div
                                            class="d-flex align-items-center justify-content-between flex-column h-100">
                                            <div class="col">
                                                <h6 class="m-0 fs-14">Level 12</h6>
                                                <p class="fs-13 fw-medium mb-0 text-pink">
                                                    {{ $levelTwelveReferralsCount }}
                                                    Users</p>
                                                <p class="fs-13 fw-medium mb-0 text-success">
                                                    {{ $levelTwelveInvestmentSum }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> <!-- end -->

            </div><!-- end swiper wrapper -->
        </div><!-- end swiper -->
    </div><!-- end col -->
</div><!-- end row -->
