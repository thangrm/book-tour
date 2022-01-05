@extends('admin.master')

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
        <table class="table table-bordered" id="bookingTable">
            <thead>
            <tr>
                <th>#</th>
                <th>Tour</th>
                <th>Customer</th>
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
                        d.rate = $('#filterRate').val();
                        d.status = $('#filterStatus').val();
                    }
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'tour.name', name: 'tour'},
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'customer.email', name: 'customer.email'},
                    {data: 'customer.phone', name: 'customer.phone'},
                    {data: 'people', name: 'people'},
                    {data: 'status', name: 'status'},
                    {data: 'total', name: 'total'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#filterRate, #filterStatus').on('change', function () {
                datatable.draw();
            });
        });
    </script>
@endsection
