@extends('layouts.dashboard')

@section('title')
    @lang('Transactions')
@endsection

@section('page')
    @lang('Transactions Analysis')
@endsection

@section('content')
    <div class="transactions row py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title mb-0">Transactions List</span>
                    </div>
                    <!-- end card header -->

                    <div class="card-body">
                        <div class="listjs-table" id="customerList">

                            <div class="table-responsive mt-3 mb-1">
                                <table class="table align-middle" id="transactionsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Timestamp</th>
                                            <th>Form</th>
                                            <th>To</th>
                                            <th>Details</th>
                                            <th>Transaction ID</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td><span class="date">24 Dec, 2021</span> <span class="time">08:58AM</span></td>
                                            <td class="from">Wallet</td>
                                            <td>Ali Ahmed</td>
                                            <td><span class="transfer bg-danger p-2 rounded-1 text-white">Transfer</span></td>
                                            <td>0x98702349</td>
                                            <td><span class="income bg-success p-2 rounded-1 text-white">internal</span></td>
                                            <td><span class="amount text-primary">1500</span><span class="small text-primary">.00 DU</span></td>
                                            <td><span class="bg-success p-2 rounded-1 text-white">Complated</span></td>

                                        </tr>
                                        <tr>
                                            <td style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td><span class="date">24 Dec, 2021</span> <span class="time">08:58AM</span></td>
                                            <td class="from">Javed Ali</td>
                                            <td>Wallet</td>
                                            <td><span class="transfer bg-success p-2 rounded-1 text-white">Deposit</span></td>
                                            <td>0x98702349</td>
                                            <td><span class="income bg-success p-2 rounded-1 text-white">Income</span></td>
                                            <td><span class="amount text-primary">1500</span><span class="small text-primary">.00 DU</span></td>
                                            <td><span class="bg-success p-2 rounded-1 text-white">Complated</span></td>

                                        </tr>
                                        <tr>
                                            <td style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td><span class="date">24 Dec, 2021</span> <span class="time">08:58AM</span></td>
                                            <td class="from text-success fw-bold">Stake</td>
                                            <td>Wallet</td>
                                            <td><span class="transfer bg-pink p-2 rounded-1 text-white">Deposit</span></td>
                                            <td>0x98702349</td>
                                            <td><span class="income bg-success p-2 rounded-1 text-white">Income</span></td>
                                            <td><span class="amount text-primary">1500</span><span class="small text-primary">.00 DU</span></td>
                                            <td><span class="bg-success p-2 rounded-1 text-white">Complated</span></td>

                                        </tr>
                                        <tr>
                                            <td style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td><span class="date">24 Dec, 2021</span> <span class="time">08:58AM</span></td>
                                            <td class="from">Zeeshan Mir</td>
                                            <td>Wallet</td>
                                            <td><span class="transfer bg-info p-2 rounded-1 text-white">Deposit</span></td>
                                            <td>0x98702349</td>
                                            <td><span class="income bg-success p-2 rounded-1 text-white">Income</span></td>
                                            <td><span class="amount text-primary">1500</span><span class="small text-primary">.00 DU</span></td>
                                            <td><span class="bg-success p-2 rounded-1 text-white">Complated</span></td>

                                        </tr>
                                        <tr>
                                            <td style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td><span class="date">24 Dec, 2021</span> <span class="time">08:58AM</span></td>
                                            <td class="from text-info fw-bold">Reward</td>
                                            <td>Wallet</td>
                                            <td><span class="transfer bg-warning p-2 rounded-1 text-white">Deposit</span></td>
                                            <td>0x98702349</td>
                                            <td><span class="income bg-success p-2 rounded-1 text-white">Income</span></td>
                                            <td><span class="amount text-primary">1500</span><span class="small text-primary">.00 DU</span></td>
                                            <td><span class="bg-success p-2 rounded-1 text-white">Complated</span></td>

                                        </tr>
                                        <tr>
                                            <td style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td><span class="date">24 Dec, 2021</span> <span class="time">08:58AM</span></td>
                                            <td class="from text-success fw-bold">Stake</td>
                                            <td>wallet</td>
                                            <td><span class="transfer bg-info p-2 rounded-1 text-white">Deposit</span></td>
                                            <td>0x98702349</td>
                                            <td><span class="income bg-success p-2 rounded-1 text-white">Income</span></td>
                                            <td><span class="amount text-primary">1500</span><span class="small text-primary">.00 DU</span></td>
                                            <td><span class="bg-success p-2 rounded-1 text-white">Complated</span></td>

                                        </tr>
                                        <tr>
                                            <td style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td><span class="date">24 Dec, 2021</span> <span class="time">08:58AM</span></td>
                                            <td class="from">Wallet</td>
                                            <td>Ali Ahmed</td>
                                            <td><span class="transfer bg-danger p-2 rounded-1 text-white">Transfer</span></td>
                                            <td>0x98702349</td>
                                            <td><span class="income bg-danger p-2 rounded-1 text-white">Extrnal</span></td>
                                            <td><span class="amount text-primary">1500</span><span class="small text-primary">.00 DU</span></td>
                                            <td><span class="bg-success p-2 rounded-1 text-white">Complated</span></td>

                                        </tr>
                                        <tr>
                                            <td style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td><span class="date">24 Dec, 2021</span> <span class="time">08:58AM</span></td>
                                            <td class="from">Wallet</td>
                                            <td>Outside</td>
                                            <td><span class="transfer bg-danger p-2 rounded-1 text-white">Transfer</span></td>
                                            <td>0x98702349</td>
                                            <td><span class="income bg-danger p-2 rounded-1 text-white">Extrnal</span></td>
                                            <td><span class="amount text-primary">1500</span><span class="small text-primary">.00 DU</span></td>
                                            <td><span class="bg-success p-2 rounded-1 text-white">Complated</span></td>

                                        </tr>
                                    </tbody>
                                </table>
                                <div style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                            colors="primary:#121331,secondary:#08a88a"
                                            style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ Orders We did not find any
                                            orders for you search.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="pagination-wrap gap-2">
                                    <a class="page-item disabled" href="javascript:void(0);">
                                        Previous
                                    </a>
                                    <ul class="pagination mb-0"></ul>
                                    <a class="page-item" href="javascript:void(0);">
                                        Next
                                    </a>
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
