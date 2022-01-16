@extends('layouts.admin')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Review</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Review</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="reviewTable">
                    <div class="card-body pl-0 pt-0">
                        <h4 class="m-b-20">List of Reviews</h4>
                        <div class="row">
                            <div class="col-sm-12 col-lg-4">
                                <div class="form-group row">
                                    <label for="filterDestination"
                                           class="col-sm-3 control-label col-form-label">Rate</label>
                                    <div class="col-9 col-lg-6">
                                        <select class="form-control" name="rate" id="filterRate">
                                            <option value="">All</option>
                                            <option value="5">5 Star</option>
                                            <option value="4">4 Star</option>
                                            <option value="3">3 Star</option>
                                            <option value="2">2 Star</option>
                                            <option value="1">1 Star</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-lg-4">
                                <div class="form-group row">
                                    <label for="filterStatus"
                                           class="col-sm-3 control-label col-form-label">Status:</label>
                                    <div class="col-9 col-lg-6">
                                        <select class="form-control" name="status" id="filterStatus">
                                            <option value="">All</option>
                                            <option value="1">Public</option>
                                            <option value="2">Block</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Comment</th>
                        <th>Rate</th>
                        <th>Status</th>
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
            datatable = $('#reviewTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                ajax: {
                    url: "{!! route('reviews.data', $tourId) !!}",
                    data: function (d) {
                        d.rate = $('#filterRate').val();
                        d.status = $('#filterStatus').val();
                    }
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'comment', name: 'comment'},
                    {data: 'rate', name: 'rate', width: 125},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', className: 'align-middle text-center', width: 30},
                ],
                columnDefs: [
                    {className: 'align-middle', targets: '_all'},
                ],
            });

            $('#filterRate, #filterStatus').on('change', function () {
                datatable.draw();
            });
        });

        function changeStatus(url, status) {
            $.ajax({
                url: url,
                method: 'PUT',
                dataType: 'json',
                data: {status: status},
                success: function (response) {
                    let type = response['alert-type'];
                    let message = response['message'];
                    toastrMessage(type, message);

                    if (type === 'success') {
                        datatable.ajax.reload(null, false);
                    }
                },
                error: function () {
                    toastrMessage('error', 'Change status failed');
                },
            });
        }
    </script>
@endsection
