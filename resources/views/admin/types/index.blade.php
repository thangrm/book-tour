@extends('layouts.admin')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Thể loại tour</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Thể loại tour</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid row">
        <div class="col-12 col-lg-5 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('types.store') }}" id="formAddType" method="post">
                        @csrf

                        <div class="form-group row mb-0">
                            <label for="name" class="col-12 control-label col-form-label">Tên thể loại
                                <span
                                    class="text-danger">*</span> </label>
                            <div class="col-12">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Tên thể loại">
                                <p class="text-danger" id="errorName"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-12 control-label col-form-label">Trạng thái
                            </label>
                            <div class="col-12 d-flex align-items-center">
                                <div>
                                    @include('components.button_switch',['status' => 1,'id' => 'statusType'])
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="text-danger" id="errorStatus"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info mb-3">Thêm</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered" id="typeTable">
                        <div
                            class="p-0 d-flex justify-content-between align-items-start flex-column flex-sm-row w-100 m-b-10">
                            <div class="row w-75">
                                <div class="col-12 col-sm-6 col-md-5 mb-2">
                                    <input type="text" class="form-control" name="search" id="searchName"
                                           placeholder="Tìm kiếm">
                                </div>
                                <div class="col-10 col-sm-6 col-md-5 mb-2">
                                    <select class="form-control" name="status" id="filterStatus">
                                        <option value="">Chọn trạng thái</option>
                                        <option value="1">Hoạt động</option>
                                        <option value="2">Không hoạt động</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên thể loại</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
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
                            <h5 class="modal-title" id="editModalLabel">Sửa thể loại</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-12">
                                    Tên thể loại<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="name" id="titleEdit"
                                           placeholder="Tên thể loại">
                                    <p class="text-danger" id="errorNameEdit"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label for="status" class="m-0">Trạng thái</label>
                                    <div class="m-l-10">
                                        @include('components.button_switch', ['status' => 1,'id' => 'statusTypeEdit'])
                                    </div>
                                </div>

                                <p class="text-danger" id="statusTypeEditError"></p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-info" id="btnSubmitEdit">Lưu</button>
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
            disableSubmitButton('#formAddType');
            disableSubmitButton('#formEditType');

            let datatable = $('#typeTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                language: getLanguageDataTable(),
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
                    {data: 'action', name: 'action', className: 'align-middle text-center', width: 68},
                ],
                columnDefs: [
                    {className: 'align-middle', targets: '_all'},
                ],
            });

            $('#typeTable thead th').removeClass('align-middle text-center');

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
                    title: 'Bạn có chắc chắn?',
                    text: "Bạn sẽ không thể hoàn tác lại điều này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Vâng, xóa nó!',
                    cancelButtonText: 'Không, hủy!',
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
                                    toastr.error('Xóa không thành công')
                                }
                            });
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Đã hủy',
                            '',
                            'error'
                        )
                    }
                })
            })

            // Event edit type
            $(document).on('click', '.edit', function (e) {
                $('#errorNameEdit').text('');
                linkEditType = $(this).attr('href');
                let typeId = $(this).data('id');
                let titleType = $('#type-' + typeId).children().eq(1).text();
                let status = $('#type-' + typeId).children().eq(2).children().eq(0).children().eq(0);
                $('#statusTypeEdit').prop("checked", false);

                if ($(status).is(":checked")) {
                    $('#statusTypeEdit').prop("checked", true);
                }

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
                        toastr.clear();
                        toastr.success('Thay đổi trạng thái thành công')
                    },
                    error: function (response) {
                        setTimeout(function () {
                            if ($(buttonSwitch).is(":checked")) {
                                $(buttonSwitch).prop('checked', false);
                            } else {
                                $(buttonSwitch).prop('checked', true);
                            }
                            toastr.error('Thay đổi trạng thái không thành công')
                        }, 500);
                    }
                });
            });

            // Add new Type
            $('#formAddType').submit(function (e) {
                e.preventDefault();

                $('#errorName').text('');
                $('#errorStatus').text('');

                let link = $(this).attr('action');
                let name = $('#name').val();
                let status = 2;

                if ($('#statusType').is(":checked")) {
                    status = 1;
                }

                let formData = new FormData();
                formData.append("name", name);
                formData.append("status", status);

                $.ajax({
                    url: link,
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        response = JSON.parse(response);
                        let type = response['alert-type'];
                        let message = response['message'];
                        toastrMessage(type, message);

                        if (type === 'success') {
                            datatable.draw();
                            $('#formAddType')[0].reset();
                        }
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Tạo thể loại tour không thành công');
                        if (response?.errors?.name !== undefined) {
                            $('#errorName').text(response.errors.name[0]);
                        }

                        if (response?.errors?.status !== undefined) {
                            $('#errorStatus').text(response.errors.image[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formAddType', 300);
                    }
                });
            });

            // Submit Edit Type
            $('#formEditType').submit(function (e) {
                e.preventDefault();
                $('#errorNameEdit').text('');

                let name = $('#titleEdit').val();
                let status = 2;

                if ($('#statusTypeEdit').is(":checked")) {
                    status = 1;
                }

                $.ajax({
                    url: linkEditType,
                    method: "PUT",
                    dataType: 'json',
                    data: {name: name, status: status},
                    success: function (response) {
                        let type = response['alert-type'];
                        let message = response['message'];
                        toastrMessage(type, message);

                        if (type === 'success') {
                            datatable.draw();
                            $('#editModal').modal('hide');
                        }
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Cập nhật thể loại tour không thành công');
                        if (response?.errors?.name !== undefined) {
                            $('#errorNameEdit').text(response.errors.name[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formEditType', 300);
                    }
                });
            });

        });
    </script>
@endsection
