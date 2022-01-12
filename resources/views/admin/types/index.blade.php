@extends('admin.master')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Type of tour</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Type of tour</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('types.store') }}" id="formAddType" method="post">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-sm-2 text-right control-label col-form-label">Title
                                <span
                                    class="text-danger">*</span> </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Title"
                                       value="{{old('name')}}">
                                @error('name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-sm-2 text-lg-right control-label col-form-label">Status
                            </label>
                            <div class="col-sm-10 d-flex align-items-center">
                                <div>
                                    <input type="hidden" name="status" id="status">
                                    @include('admin.components.button_switch',
                                    [
                                        'status' => empty(old('status')) ? 1 : old('status'),
                                        'id' => 'statusType'
                                    ])
                                </div>
                            </div>

                            <div class="col-2"></div>
                            <div class="col-10">
                                @error('status')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info mb-3">
                                Add Type
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered" id="typeTable">
                        <div
                            class="p-0 d-flex justify-content-between align-items-start flex-column flex-sm-row w-100 m-b-10">
                            <div class="row w-75">
                                <div class="col-12 col-sm-6 col-md-5 mb-2">
                                    <input type="text" class="form-control" name="search" id="searchName"
                                           placeholder="Search">
                                </div>
                                <div class="col-10 col-sm-6 col-md-5 mb-2">
                                    <select class="form-control" name="status" id="filterStatus">
                                        <option value="">Choose status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="formEditType">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit type</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-12">
                                    Title<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="name" id="titleEdit"
                                           placeholder="Name itinerary">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info" id="btnSubmitEdit">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let linkEditType;

            let datatable = $('#typeTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                ajax: {
                    url: "{!! route('types.data') !!}",
                    data: function (d) {
                        d.search = $('#searchName').val();
                        d.status = $('#filterStatus').val();
                    }
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
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

            // Event delete type
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
                                dataType: 'json',
                                success: function (response) {
                                    let type = response['alert-type'];
                                    let message = response['message'];
                                    toastrMessage(type, message);
                                    if (type === 'success') {
                                        datatable.draw();
                                    }
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

            // Event edit type
            $(document).on('click', '.edit', function (e) {
                linkEditType = $(this).attr('href');
                let typeId = $(this).data('id');
                let titleType = $('#type-' + typeId).children().eq(1).text();
                $('#titleEdit').val(titleType);
            });

            // Change status type
            $('#typeTable').on('click', '.button-switch', function (e) {
                let buttonSwitch = this;
                let link = $(this).data('link');
                let status = 2;

                if ($(this).is(":checked")) {
                    status = 1;
                }

                $.ajax({
                    url: link,
                    type: 'put',
                    dataType: 'json',
                    data: {status: status},
                    success: function (response) {
                        //toastr.success('Change status successfully')
                    },
                    error: function (response) {
                        setTimeout(function () {
                            if ($(buttonSwitch).is(":checked")) {
                                $(buttonSwitch).prop('checked', false);
                            } else {
                                $(buttonSwitch).prop('checked', true);
                            }
                            toastr.error('Change status failed')
                        }, 500);
                    }
                });
            });

            // Add new Type
            $('#formAddType').submit(function (e) {
                e.preventDefault();

                if ($('#statusType').is(":checked")) {
                    $('#status').val(1);
                } else {
                    $('#status').val(2);
                }

                this.submit();
            });

            // Edit Type
            $('#formEditType').submit(function (e) {
                e.preventDefault();

                let name = $('#titleEdit').val();
                $.ajax({
                    url: linkEditType,
                    method: "PUT",
                    dataType: 'json',
                    data: {name: name},
                    success: function (response) {
                        let type = response['alert-type'];
                        let message = response['message'];
                        toastrMessage(type, message);

                        if (type === 'success') {
                            datatable.draw();
                            $('#editModal').modal('hide');
                        }
                    },
                    error: function () {
                        toastrMessage('error', 'Type update failed');
                    },
                    complete: function () {
                        enableSubmitButton('#formEditType', 300);
                    }
                });
            });

        });
    </script>
@endsection
