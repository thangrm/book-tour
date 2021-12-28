@extends('admin.master')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Tour</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tour</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <table class="table table-bordered" id="destinationTable">

            <form class="form-horizontal">
                <div class="card-body pl-0 pt-0">
                    <a class="btn btn-info mb-3" href="{{ route('tours.create') }}" class="text-white">
                        New Tour
                    </a>
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                                <label for="searchName"
                                       class="col-sm-2 control-label col-form-label">Search:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="search" id="searchName"
                                           placeholder="Search by name">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-lg-4">
                            <div class="form-group row">
                                <label for="filterDestination"
                                       class="col-sm-3 control-label col-form-label">Destination</label>
                                <div class="col-9 col-lg-6">
                                    <select class="form-control" name="destination_id" id="filterDestination">
                                        <option value="">All</option>
                                        @isset($destinations)
                                            @foreach($destinations as $destination)
                                                <option
                                                    value="{{ $destination->id }}"> {{ $destination->name }} </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4">
                            <div class="form-group row">
                                <label for="filterType"
                                       class="col-sm-3 control-label col-form-label">Type of tour:</label>
                                <div class="col-9 col-lg-6">
                                    <select class="form-control" name="type_id" id="filterType">
                                        <option value="">All</option>
                                        @isset($types)
                                            @foreach($types as $type)
                                                <option value="{{ $type->id }}"> {{ $type->name }} </option>
                                            @endforeach
                                        @endisset
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
                <th>Price</th>
                <th>Status</th>
                <th>Trending</th>
                <th>Detail</th>
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
                    url: "{!! route('tours.data') !!}",
                    data: function (d) {
                        d.search = $('#searchName').val();
                        d.destination_id = $('#filterDestination').val();
                        d.type_id = $('#filterType').val();
                        d.status = $('#filterStatus').val();
                    }
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'image', name: 'image'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    {data: 'trending', name: 'trending'},
                    {data: 'detail', name: 'detail', width: '20%'},
                    {data: 'action', name: 'action'},
                ]
            });

            $('#searchName').on('keyup', function () {
                datatable.draw();
            });

            $('#filterDestination, #filterType, #filterStatus').on('change', function () {
                datatable.draw();
            });

            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                let link = $(this).attr("href");
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success m-2',
                        cancelButton: 'btn btn-danger m-2'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax(
                            {
                                url: link,
                                type: 'delete',
                                success: function (response) {
                                    toastr.success('Tour deleted successfully');
                                    datatable.ajax.reload();
                                },
                                error: function (response) {
                                    toastr.error('Delete failed')
                                }
                            });
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            '',
                            'error'
                        )
                    }
                })
            })
        });
    </script>
@endsection
