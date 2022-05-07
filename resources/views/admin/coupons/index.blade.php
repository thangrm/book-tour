@extends('layouts.admin')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Mã giảm giá</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tổng quan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Mã giảm giá</li>
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
                    <form action="{{ route('coupons.store') }}" id="formAddCoupon" method="post">
                        @csrf

                        <div class="form-group row">
                            <label for="code" class="col-3 col-xl-2 control-label col-form-label">Mã giảm giá
                                <span
                                    class="text-danger">*</span> </label>
                            <div class="col-9 col-xl-10">
                                <input type="text" class="form-control" name="code" id="code" placeholder="Mã giảm giá">
                                <p class="text-danger" id="errorCode"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="discount" class="col-3 col-xl-2 control-label col-form-label">Tỉ lệ (%)
                                <span
                                    class="text-danger">*</span> </label>
                            <div class="col-9 col-xl-10">
                                <input type="text" class="form-control" name="discount" id="discount"
                                       placeholder="Tỉ lệ">
                                <p class="text-danger" id="errorDiscount"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="number" class="col-3 col-xl-2 control-label col-form-label">Số lượng
                                <span
                                    class="text-danger">*</span> </label>
                            <div class="col-9 col-xl-10">
                                <input type="text" class="form-control" name="number"
                                       id="number"
                                       placeholder="Số lượng">
                                <p class="text-danger" id="errorNumber"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="status" class="col-3 col-xl-2 control-label col-form-label">Trạng thái
                            </label>
                            <div class="col-9 col-xl-10 d-flex align-items-center">
                                <div>
                                    @include('components.button_switch',['status' => 1,'id' => 'statusCoupon'])
                                </div>
                            </div>
                            <div class="col-3 col-xl-2"></div>
                            <div class="col-9">
                                <p class="text-danger" id="errorStatus"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info mb-3">
                                Thêm mã
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7 col-xl-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered" id="couponTable">
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
                            <th>Mã</th>
                            <th>Tỉ lệ (%)</th>
                            <th>Số lượng</th>
                            <th>Trạng thái</th>
                            <th></th>
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
                    <form id="formEditCoupon">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Chỉnh sửa mã giảm giá</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="codeEdit" class="col-12">
                                    Mã giảm giá<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="code" id="codeEdit"
                                           placeholder="Mã giảm giá">
                                    <p class="text-danger" id="errorCodeEdit"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="discountEdit" class="col-12">
                                    Tỉ lệ<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="discount" id="discountEdit"
                                           placeholder="Tỉ lệ">
                                    <p class="text-danger" id="errorDiscountEdit"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="numberEdit" class="col-12">
                                    Số lượng<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="discount"
                                           id="numberEdit"
                                           placeholder="Số lượng">
                                    <p class="text-danger" id="errorNumberEdit"></p>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-flex align-items-center">
                                    <label for="status" class="m-0">Trạng thái</label>
                                    <div class="m-l-10">
                                        @include('components.button_switch', ['status' => 1,'id' => 'statusCouponEdit'])
                                    </div>
                                </div>

                                <p class="text-danger" id="errorStatusEdit"></p>
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
            let linkEditCoupon;
            disableSubmitButton('#formAddCoupon');
            disableSubmitButton('#formEditCoupon');

            $('#code').on('keyup', function () {
                let value = $('#code').val().toUpperCase();
                $('#code').val(value);
            })

            $('#codeEdit').on('keyup', function () {
                let value = $('#codeEdit').val().toUpperCase();
                $('#codeEdit').val(value);
            })

            let datatable = $('#couponTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                ajax: {
                    url: "{!! route('coupons.data') !!}",
                    data: function (d) {
                        d.search = $('#searchName').val();
                        d.status = $('#filterStatus').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'code', name: 'code'},
                    {data: 'discount', name: 'discount'},
                    {data: 'number', name: 'number'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', className: 'align-middle text-center', width: 68},
                ],
                columnDefs: [
                    {className: 'align-middle', targets: '_all'},
                ],
            });

            $('#couponTable thead th').removeClass('align-middle text-center');

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
                    text: "Bạn sẽ không thể khôi phục lại!",
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
                                    console.log(response);
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
                            'Cancelled',
                            '',
                            'error'
                        )
                    }
                })
            })

            // Event edit type
            $(document).on('click', '.edit', function (e) {
                $('#errorCodeEdit').text('');
                $('#errorDiscountEdit').text('');
                $('#errorNumberEdit').text('');

                linkEditCoupon = $(this).attr('href');
                let couponId = $(this).data('id');
                let code = $('#coupon-' + couponId).children().eq(1).text();
                let discount = $('#coupon-' + couponId).children().eq(2).text();
                let number = $('#coupon-' + couponId).children().eq(3).text();
                let status = $('#coupon-' + couponId).children().eq(4).children().eq(0).children().eq(0);
                $('#statusCouponEdit').prop("checked", false);

                if ($(status).is(":checked")) {
                    $('#statusCouponEdit').prop("checked", true);
                }

                $('#codeEdit').val(code);
                $('#discountEdit').val(discount);
                $('#numberEdit').val(number);
            });

            // Change status type
            $('#couponTable').on('click', '.button-switch', function (e) {
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
                            toastr.error('Đổi trạng thái thất bại')
                        }, 500);
                    }
                });
            });

            // Add new Coupon
            $('#formAddCoupon').submit(function (e) {
                e.preventDefault();

                $('#errorCode').text('');
                $('#errorDiscount').text('');
                $('#errorNumber').text('');
                $('#errorStatus').text('');

                let link = $(this).attr('action');
                let code = $('#code').val();
                let discount = $('#discount').val();
                let number = $('#number').val();
                let status = 2;

                if ($('#statusCoupon').is(":checked")) {
                    status = 1;
                }

                let formData = new FormData();
                formData.append("code", code);
                formData.append("discount", discount);
                formData.append("number", number);
                formData.append("status", status);

                $.ajax({
                    url: link,
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        let type = response['alert-type'];
                        let message = response['message'];
                        toastrMessage(type, message);

                        if (type === 'success') {
                            datatable.draw();
                            $('#formAddCoupon')[0].reset();
                        }
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Mã giảm giá tạo không thành công');
                        if (response?.errors?.code !== undefined) {
                            $('#errorCode').text(response.errors.code[0]);
                        }

                        if (response?.errors?.discount !== undefined) {
                            $('#errorDiscount').text(response.errors.discount[0]);
                        }

                        if (response?.errors?.number !== undefined) {
                            $('#errorNumber').text(response.errors.number[0]);
                        }

                        if (response?.errors?.status !== undefined) {
                            $('#errorStatus').text(response.errors.image[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formAddCoupon', 300);
                    }
                });
            });

            // Submit Edit Type
            $('#formEditCoupon').submit(function (e) {
                e.preventDefault();
                $('#errorNameEdit').text('');
                $('#errorDiscountEdit').text('');
                $('#errorNumberEdit').text('');

                let code = $('#codeEdit').val();
                let discount = $('#discountEdit').val();
                let number = $('#numberEdit').val();
                let status = 2;

                if ($('#statusCouponEdit').is(":checked")) {
                    status = 1;
                }

                $.ajax({
                    url: linkEditCoupon,
                    method: "PUT",
                    dataType: 'json',
                    data: {code: code, discount: discount, number: number, status: status},
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
                        toastrMessage('error', 'Cập nhật thông tin không thành công');
                        if (response?.errors?.code !== undefined) {
                            $('#errorCodeEdit').text(response.errors.code[0]);
                        }

                        if (response?.errors?.discount !== undefined) {
                            $('#errorDiscountEdit').text(response.errors.discount[0]);
                        }

                        if (response?.errors?.number !== undefined) {
                            $('#errorNumberEdit').text(response.errors.number[0]);
                        }

                        if (response?.errors?.status !== undefined) {
                            $('#errorStatusEdit').text(response.errors.status[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formEditCoupon', 300);
                    }
                });
            });

        });
    </script>
@endsection
