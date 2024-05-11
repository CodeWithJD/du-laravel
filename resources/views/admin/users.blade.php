@extends('admin.layouts.master')
@section('title')
    @lang('Users List')
@endsection
@section('content')
    @component('admin.components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            User List
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="customerList">
                <div class="card-body border-bottom-dashed border-bottom">
                    <form action="{{ route('admin.user.list') }}" method="GET">
                        <div class="row g-3 align-items-center">
                            <div class="col-6">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="status">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Review" {{ request('status') == 'Review' ? 'selected' : '' }}>Review</option>
                                    <option value="Blocked" {{ request('status') == 'Blocked' ? 'selected' : '' }}>Blocked</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>
                    <!--end col-->
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Phone</th>
                                        <th>Balance</th>
                                        <th>Ref ID</th>

                                        <th>invite_code</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($users as $user)
                                        <tr>
                                            <td class="id">{{ $user->id }}</td>
                                            <td class="customer_name">{{ $user->name }}</td>
                                            <td class="email">{{ $user->email }}</td>
                                            <td>
                                                @php
                                                    $status = $user->userDetails->account_status ?? 'Unknown';
                                                @endphp
                                                @switch($status)
                                                    @case('Active')
                                                        <span class="badge bg-success">{{ $status }}</span>
                                                        @break
                                                    @case('Review')
                                                        <span class="badge bg-warning text-dark">{{ $status }}</span>
                                                        @break
                                                    @case('Blocked')
                                                        <span class="badge bg-danger">{{ $status }}</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $status }}</span>
                                                @endswitch
                                            </td>
                                            <td class="phone">{{ $user->phone }}</td>
                                            <td>{{$user->userDetails->available_balance}}</td>
                                            <td class="date">{{ $user->ref_id }}</td>
                                            <td class="date">{{ $user->invite_code }}</td>
                                            <td>
                                                <a href="{{ route('admin.user.edit', $user->id) }}" class="text-primary d-inline-block edit-item-btn">
                                                    <i class="ri-pencil-fill fs-16"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--end col-->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
