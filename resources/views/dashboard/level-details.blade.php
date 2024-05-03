@extends('layouts.dashboard')

@section('title')
    @lang('Levels')
@endsection

@section('page')
    @lang('Levels Analysis')
@endsection

@section('content')
    <div class="dashboard row py-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0 text-primary">Level {{$level}} List</h4>
                            <span>Total <span class="text-primary fw-bold">{{ $referralsCount }}</span> Users | Total Invest <span class="text-success fw-bold"> {{$investmentSum}}</span></span>
                        </div>
                        <!-- end card header -->

                        <div class="card-body">
                            <div class="listjs-table" id="customerList">
                                <div class="mb-3">
                                    <form action="{{ route('levels.show', ['level' => $level]) }}" method="GET">
                                        <div class="col-sm">
                                            <div class="d-flex">
                                                <div class="ms-2">
                                                    <input type="text" name="search" class="form-control bg-body" placeholder="Search..." value="{{ request('search') }}">
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-primary ms-2">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>

                                <div class="table-responsive mt-3 mb-1">
                                    <table class="table align-middle" id="customerTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Joining Date</th>
                                                <th>Invest</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($paginatedUsers as $user)
                                                <tr>
                                                    <td style="display:none;"><a href="javascript:void(0);"
                                                            class="fw-medium link-primary">{{ $user->id }}</a></td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->created_at }}</td>
                                                    <td><span class="fw-bold text-primary">{{ number_format($user->investmentSum, 2) }}</span><span class="fw-bold text-success"> Du</span></td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div style="display: none">
                                        <div class="text-center">
                                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                colors="primary:#121331,secondary:#08a88a"
                                                style="width:10px;height:10px"></lord-icon>
                                            <h5 class="mt-2">Sorry! No Result Found</h5>
                                            <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find
                                                any orders for you search.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <div class="pagination-wrap gap-2">
                                        {{ $paginatedUsers->appends(['search' => request('search')])->links() }}
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end col -->
            </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/charts.js') }}"></script>
@endsection
