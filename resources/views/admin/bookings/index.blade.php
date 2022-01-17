@extends('layouts.admin')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Booking</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Booking</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="bookingTable">
                    <div
                        class="p-0 w-100 m-b-10 d-flex justify-content-between align-items-start flex-column align-items-sm-end flex-sm-row ">

                        <div class="form-group row w-75 mb-0">
                            <div class="col-12 col-md-8 mb-2">
                                <input type="text" class="form-control" name="search" id="searchName"
                                       placeholder="Search">
                            </div>
                            <div class="col-10 col-sm-6 col-lg-3 mb-2">
                                <select class="form-control" name="status" id="filterStatus">
                                    <option value="">Choose status</option>
                                    <option value="1">New</option>
                                    <option value="2">Confirmed</option>
                                    <option value="3">Completed</option>
                                    <option value="4">Cancel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Tour</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>People</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var datatable = null;
        $(document).ready(function () {
            datatable = $('#bookingTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                ajax: {
                    url: "{!! route('bookings.data') !!}",
                    data: function (d) {
                        d.search = $('#searchName').val();
                        d.status = $('#filterStatus').val();
                    }
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'tour.name', name: 'tour'},
                    {data: 'customer.email', name: 'customer.email'},
                    {data: 'customer.phone', name: 'customer.phone'},
                    {data: 'people', name: 'people', className: 'align-middle text-center'},
                    {data: 'status', name: 'status', className: 'align-middle text-center'},
                    {data: 'total', name: 'total'},
                    {data: 'action', name: 'action', className: 'align-middle text-center', width: 65},
                ],
                columnDefs: [
                    {className: 'align-middle', targets: '_all'},
                ],
            });
            $('#bookingTable thead th').removeClass('align-middle text-center');

            $('#searchName').on('keyup', function () {
                datatable.draw();
            });

            $('#filterStatus').on('change', function () {
                datatable.draw();
            });
        })
        ;
    </script>
@endsection
