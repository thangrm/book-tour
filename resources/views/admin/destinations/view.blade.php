@extends('admin.master')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Dashboard</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Destination</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <table class="table table-bordered" id="destinationTable">

            <form class="form-horizontal">
                <div class="card-body pl-0">
                    <button class="btn btn-info mb-3">
                        New Destination
                    </button>
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="searchName"
                                       class="col-sm-2 control-label col-form-label">Search:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="search" id="searchName"
                                           aria-describedby="emailHelp"
                                           placeholder="Name destination">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="filterStatus"
                                       class="col-sm-2 control-label col-form-label">Status:</label>
                                <div class="col-10 col-lg-6">
                                    <select class="form-control" name="status" id="filterStatus">
                                        <option value="">All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let datatable = $('#destinationTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                ajax: {
                    url: "{!! route('destination.data') !!}",
                    data: function (d) {
                        d.search = $('#searchName').val();
                        d.status = $('#filterStatus').val();
                    }
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#searchName').on('keyup', function () {
                datatable.draw();
            });

            $('#filterStatus').on('change', function () {
                datatable.draw();
            });
        });
    </script>
@endsection