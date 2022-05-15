@extends('layouts.admin')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Điểm đến</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Điểm đến</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('destinations.store') }}" id="formAddDestination" method="post"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="text-left control-label col-form-label">
                                Tên điểm đến<span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Tên điểm đến"
                                       value="{{old('name')}}">
                            </div>
                            <p class="text-danger" id="errorName"></p>
                        </div>

                        <div class="form-group">
                            <label for="slug" class="text-left control-label col-form-label">
                                Tiêu đề rút gọn<span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="slug" id="slug"
                                       placeholder="Rút gọn">
                            </div>
                            <p class="text-danger" id="errorSlug"></p>
                        </div>

                        <div class="form-group">
                            <label for="image" class="text-left control-label col-form-label">
                                Ảnh<span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="file" id="image" name="image">
                            </div>
                            <div>
                                <img id="showImg" style="max-height: 150px; margin: 10px 2px">
                            </div>
                            <p class="text-danger" id="errorImage"></p>
                        </div>

                        <div class="form-group">
                            <div class="d-flex align-items-center">
                                <label for="status" class="m-0">Trạng thái</label>
                                <div class="m-l-10">
                                    @include('components.button_switch', ['status' => 1,'id' => 'statusDestination'])
                                </div>
                            </div>

                            <p class="text-danger" id="errorStatus"></p>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-info mb-3">
                                Thêm
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered" id="destinationTable">
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
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>Tên rút gọn</th>
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
                    <form id="formEditDestination">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Sửa địa điểm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name" class="text-left control-label col-form-label">
                                    Tên địa điểm<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="name" id="nameEdit"
                                           placeholder="Title">
                                </div>
                                <p class="text-danger" id="errorNameEdit"></p>
                            </div>

                            <div class="form-group">
                                <label for="slug" class="text-left control-label col-form-label">
                                    Tên rút gọn<span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="slug" id="slugEdit"
                                           placeholder="Slug">
                                </div>
                                <p class="text-danger" id="errorSlugEdit"></p>
                            </div>

                            <div class="form-group">
                                <label for="image" class="text-left control-label col-form-label">
                                    Ảnh
                                </label>
                                <div class="input-group">
                                    <input type="file" id="imageEdit" name="image">
                                </div>
                                <div>
                                    <img id="showImgEdit" style="max-height: 150px; margin: 10px 2px">
                                </div>
                                <p class="text-danger" id="errorImageEdit"></p>
                            </div>


                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label for="status" class="m-0">Trạng thái</label>
                                    <div class="m-l-10">
                                        @include('components.button_switch', ['status' => 1,'id' => 'statusDestinationEdit'])
                                    </div>
                                </div>

                                <p class="text-danger" id="statusDestinationEditError"></p>
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
            let linkEditDestination;
            disableSubmitButton('#formAddDestination');
            disableSubmitButton('#formEditDestination');

            // Datatable
            let datatable = $('#destinationTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                language: getLanguageDataTable(),
                ajax: {
                    url: "{!! route('destinations.data') !!}",
                    data: function (d) {
                        d.search = $('#searchName').val();
                        d.status = $('#filterStatus').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'image', name: 'image'},
                    {data: 'name', name: 'name'},
                    {data: 'slug', name: 'slug'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', className: 'align-middle text-center', width: 65},
                ],
                columnDefs: [
                    {className: 'align-middle', targets: '_all'},
                ],
            });

            $('#destinationTable thead th').removeClass('align-middle text-center');

            $('#searchName').on('keyup', function () {
                datatable.draw();
            });

            $('#filterStatus').on('change', function () {
                datatable.draw();
            });

            // Read image
            function readImage(e, id) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(id).attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            }

            $('#image').change(function (e) {
                readImage(e, '#showImg')
            });

            $('#imageEdit').change(function (e) {
                readImage(e, '#showImgEdit')
            });

            // Delete
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
                        $.ajax({
                            url: link,
                            type: 'delete',
                            dataType: 'json',
                            success: function (response) {
                                let type = response['alert-type'];
                                let message = response['message'];
                                toastrMessage(type, message);
                                if (type === 'success') {
                                    datatable.ajax.reload(null, false);
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

            // Edit
            $(document).on('click', '.edit', function (e) {
                $('#errorNameEdit').text('');
                $('#errorImageEdit').text('');
                $('#errorSlugEdit').text('');
                $('#formEditDestination').trigger('reset');

                linkEditDestination = $(this).attr('href');
                let id = $(this).data('id');
                let srcImage = $('#destination-' + id).children().eq(1).children().eq(0).attr('src');
                let nameDestination = $('#destination-' + id).children().eq(2).text();
                let slugDestination = $('#destination-' + id).children().eq(3).text();
                let status = $('#destination-' + id).children().eq(4).children().eq(0).children().eq(0);
                $('#statusDestinationEdit').prop("checked", false);

                if ($(status).is(":checked")) {
                    $('#statusDestinationEdit').prop("checked", true);
                }

                $('#showImgEdit').attr('src', srcImage);
                $('#nameEdit').val(nameDestination);
                $('#slugEdit').val(slugDestination);
            });


            // Change status
            $('#destinationTable').on('click', '.button-switch', function (e) {
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

            // Add new destination
            $('#formAddDestination').submit(function (e) {
                e.preventDefault();
                $('#errorName').text('');
                $('#errorImage').text('');
                $('#errorSlug').text('');

                let link = $(this).attr('action');
                let name = $('#name').val();
                let slug = $('#slug').val();
                let image = $("#image").prop('files')[0];
                let status = 2;

                if ($('#statusDestination').is(":checked")) {
                    status = 1;
                }

                let formData = new FormData();
                formData.append("name", name);
                formData.append("status", status);
                formData.append("slug", slug);
                if (image !== undefined) {
                    formData.append("image", image);
                }

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

                        if (type === 'success') {
                            datatable.draw();
                            $('#formAddDestination')[0].reset();
                            $('#showImg').attr('src', '');
                        }
                        toastrMessage(type, message);
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Tạo điểm đến không thành công');
                        if (response?.errors?.name !== undefined) {
                            $('#errorName').text(response.errors.name[0]);
                        }

                        if (response?.errors?.slug !== undefined) {
                            $('#errorSlug').text(response.errors.slug[0]);
                        }

                        if (response?.errors?.image !== undefined) {
                            $('#errorImage').text(response.errors.image[0]);
                        }

                        if (response?.errors?.status !== undefined) {
                            $('#errorStatus').text(response.errors.status[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formAddDestination', 300);
                    }
                });

            });

            // Submit Edit
            $('#formEditDestination').submit(function (e) {
                e.preventDefault();
                $('#errorNameEdit').text('');
                $('#errorImageEdit').text('');
                $('#errorSlugEdit').text('');


                let name = $('#nameEdit').val();
                let slug = $('#slugEdit').val();
                let image = $("#imageEdit").prop('files')[0];
                let status = 2;

                if ($('#statusDestinationEdit').is(":checked")) {
                    status = 1;
                }

                let formData = new FormData();
                formData.append("_method", 'PUT');
                formData.append("name", name);
                formData.append("slug", slug);
                formData.append("status", status);

                if (image !== undefined) {
                    formData.append("image", image);
                }

                $.ajax({
                    url: linkEditDestination,
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        response = JSON.parse(response);
                        let type = response['alert-type'];
                        let message = response['message'];

                        if (type === 'success') {
                            datatable.ajax.reload(null, false);
                            $('#editModal').modal('hide');
                        }
                        toastrMessage(type, message);
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Cập nhật điểm đến không thành công');
                        if (response?.errors?.name !== undefined) {
                            $('#errorNameEdit').text(response.errors.name[0]);
                        }

                        if (response?.errors?.slug !== undefined) {
                            $('#errorSlugEdit').text(response.errors.slug[0]);
                        }

                        if (response?.errors?.image !== undefined) {
                            $('#errorImageEdit').text(response.errors.image[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formEditDestination', 300);
                    }
                });

            });

            // Auto format title to slug
            $('#name').on('keyup', function () {
                $('#slug').val(changeToSlug($('#name').val()));
            });

            $('#slug').on('change', function () {
                $('#slug').val(changeToSlug($('#slug').val()));
            });

            $('#nameEdit').on('keyup', function () {
                $('#slugEdit').val(changeToSlug($('#nameEdit').val()));
            });

            $('#slugEdit').on('change', function () {
                $('#slugEdit').val(changeToSlug($('#slugEdit').val()));
            });
        });
    </script>
@endsection
