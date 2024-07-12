@extends('admin.layouts.master')
@section('title')
    @lang('Transactions List')
@endsection
@section('content')
    @component('admin.components.breadcrumb')
        @slot('li_1')
            Dashboards
        @endslot
        @slot('title')
            Transactions List
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="transactionList">
                <div class="card-body border-bottom-dashed border-bottom">
                    <form action="{{ route('admin.transactions') }}" method="GET">
                        <div class="row g-3 align-items-center">
                            <div class="col-6">
                                <input type="text" class="form-control" name="search" placeholder="Search..."
                                    value="{{ request('search') }}">
                            </div>
                            <div class="col-4">
                                <select class="form-control" name="status">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                                    <option value="in Progress" {{ request('status') == 'in Progress' ? 'selected' : '' }}>
                                        in Progress</option>
                                    <option value="Complete" {{ request('status') == 'Complete' ? 'selected' : '' }}>
                                        Complete</option>
                                    <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>
                                        Rejected</option>
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
                            <table class="table align-middle" id="transactionTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>User Email</th>
                                        <th>User ID</th>
                                        <th>Recipient ID</th>
                                        <th>Recipient Address</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Transaction Hash</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td class="d-none">{{ $transaction->id }}</td>
                                            <td>{{ $transaction->user->email ?? 'N/A' }}</td>
                                            <td>{{ $transaction->user_id }}</td>
                                            <td>{{ $transaction->recipient_id }}</td>
                                            <td>{{ $transaction->recipient_address }}</td>
                                            <td>
                                                @switch($transaction->status)
                                                    @case('Complete')
                                                        <span class="badge bg-success">{{ $transaction->status }}</span>
                                                        @break
                                                    @case('in Progress')
                                                        <span class="badge bg-warning text-dark">{{ $transaction->status }}</span>
                                                        @break
                                                    @case('Rejected')
                                                        <span class="badge bg-danger">{{ $transaction->status }}</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $transaction->status }}</span>
                                                @endswitch
                                            </td>
                                            <td class="fw-bold">{{ $transaction->amount }}</td>
                                            <td>{{ $transaction->transaction_hash }}</td>
                                            <td>{{ $transaction->created_at }}</td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal{{ $transaction->id }}">Edit</button>
                                            </td>
                                        </tr>

                                        <!-- Update Modal -->
                                        <div class="modal fade" id="updateModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="updateModalLabel{{ $transaction->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateModalLabel{{ $transaction->id }}">Update Transaction</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('admin.transactions.update') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                                            <div class="mb-3">
                                                                <label for="amount{{ $transaction->id }}" class="form-label">Amount</label>
                                                                <input type="number" class="form-control" id="amount{{ $transaction->id }}" name="amount" value="{{ $transaction->amount }}" disabled>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="transaction_hash{{ $transaction->id }}" class="form-label">Transaction Hash</label>
                                                                <input type="text" class="form-control" id="transaction_hash{{ $transaction->id }}" name="transaction_hash" value="{{ $transaction->transaction_hash ? $transaction->transaction_hash : '' }}" {{ $transaction->transaction_hash ? 'disabled' : '' }}>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="status{{ $transaction->id }}" class="form-label">Status</label>
                                                                <select class="form-control" id="status{{ $transaction->id }}" name="status" required>
                                                                    <option value="Complete" {{ $transaction->status == 'Complete' ? 'selected' : '' }}>Complete</option>
                                                                    <option value="in Progress" {{ $transaction->status == 'in Progress' ? 'selected' : '' }}>in Progress</option>
                                                                    <option value="Rejected" {{ $transaction->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="description{{ $transaction->id }}" class="form-label">Description</label>
                                                                <textarea class="form-control" id="description{{ $transaction->id }}" name="description">{{ $transaction->description }}</textarea>
                                                            </div>
                                                            <div class="mb-3 text-center">
                                                                <div class="mb-2">
                                                                    <p class="m-0 p-0 text-primary fw-bold">User Email</p>
                                                                    <p class="m-0 p-0 text-danger">{{ $transaction->user->email ?? 'N/A'  }}</p>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <p class="m-0 p-0 text-primary fw-bold">Transcation Charges</p>
                                                                    <p class="m-0 p-0 text-danger">{{ $transaction->transfer_charge }}</p>
                                                                </div>
                                                                <div>
                                                                    <p class="m-0 p-0 text-primary fw-bold">Withdrwal Address</p>
                                                                    <p class="m-0 p-0 text-danger">{{ $transaction->recipient_address }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Pagination -->
                            <div class="mt-4">
                                {{ $transactions->links() }}
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
