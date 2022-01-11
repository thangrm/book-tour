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
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="destinationTable">
                        <div
                            class="p-0 w-100 m-b-10 d-flex justify-content-between align-items-start flex-column align-items-sm-end flex-sm-row ">

                            <div class="form-group row w-75 mb-0">
                                <div class="col-12 col-md-8 mb-2">
                                    <input type="text" class="form-control" name="search" id="searchName"
                                           placeholder="Search">
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-10 col-sm-6 col-lg-4 mb-2">
                                            <select class="form-control" name="type_id" id="filterType">
                                                <option value="">Choose type</option>
                                                @isset($types)
                                                    @foreach($types as $type)
                                                        <option value="{{ $type->id }}"> {{ $type->name }} </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>

                                        <div class="col-10 col-sm-6 col-lg-5 mb-2">
                                            <select class="form-control" name="destination_id" id="filterDestination">
                                                <option value="">Choose destination</option>
                                                @isset($destinations)
                                                    @foreach($destinations as $destination)
                                                        <option
                                                            value="{{ $destination->id }}"> {{ $destination->name }} </option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>

                                        <div class="col-10 col-sm-6 col-lg-3 mb-2">
                                            <select class="form-control" name="status" id="filterStatus">
                                                <option value="">Choose status</option>
                                                <option value="1">Active</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a class="btn btn-info mb-2" href="{{ route('tours.create') }}" class="text-white">
                                New Tour
                            </a>

                        </div>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Trending</th>
                            <th>Detail</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
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
                    {data: 'image', name: 'image'},
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'status', name: 'status'},
                    {data: 'trending', name: 'trending'},
                    {data: 'detail', name: 'detail', width: '185px'},
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
