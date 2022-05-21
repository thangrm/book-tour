@extends('layouts.admin')
@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Room</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Phòng</li>
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
                    <form href="{{ route('rooms.store', $tourId) }}" id="formAddRoom" method="post">
                        @csrf
                        <div class="form-group">
                            Tên phòng
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Tên phòng">
                            <p class="text-danger" id="errorName"></p>
                        </div>

                        <div class="form-group">
                            Giá phòng
                            <span class="text-danger">*</span>
                            <input type="number" min="0" class="form-control" name="price" id="price"
                                   placeholder="Giá phòng">
                            <p class="text-danger" id="errorPrice"></p>
                        </div>

                        <div class="form-group row">
                            <label for="number" class="col-12">
                                Số lượng<span class="text-danger">*</span>
                            </label>
                            <div class="col-12">
                                <input type="number" min="0" class="form-control" name="number" id="number"
                                       placeholder="Số lượng">
                                <p class="text-danger" id="errorNumber"></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info mb-3">
                                Thêm phòng
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Danh sách phòng</h4>
                    <table class="table table-striped table-bordered" id="destinationTable">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
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
                    <form id="formEditRoom">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Sửa thông tin phòng</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-12">
                                    Tên phòng<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="name" id="nameEdit"
                                           placeholder="Tên phòng">
                                    <p class="text-danger" id="errorNameEdit"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="price" class="col-12">
                                    Giá phòng<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="number" min="0" class="form-control" name="price" id="priceEdit"
                                           placeholder="Giá phòng">
                                    <p class="text-danger" id="errorPriceEdit"></p>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="number" class="col-12">
                                    Số lượng<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="number" min="0" class="form-control" name="number" id="numberEdit"
                                           placeholder="Số lượng">
                                    <p class="text-danger" id="errorNumberEdit"></p>
                                </div>
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
            let linkEditRoom;
            disableSubmitButton('#formAddRoom');
            disableSubmitButton('#formEditRoom');

            let datatable = $('#destinationTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                ajax: {
                    url: "{!! route('rooms.data', $tourId) !!}",
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price'},
                    {data: 'number', name: 'number'},
                    {data: 'action', name: 'action', className: 'align-middle text-center', width: 65},
                ],
            });

            // Evenet Delete Room
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
                        $.ajax({
                            url: link,
                            type: 'delete',
                            success: function (response) {
                                toastr.success('Xóa phòng thành công');
                                datatable.ajax.reload(null, false);
                            },
                            error: function (response) {
                                toastr.error('Xóa phòng không thành công vì phòng đã được khách hàng chọn')
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

            // Edit
            $(document).on('click', '.edit', function (e) {
                linkEditRoom = $(this).attr('href');
                let id = $(this).data('id');
                let nameRoom = $('#Room-' + id).children().eq(1).text();
                let priceRoom = $('#Room-' + id).children().eq(2).text();
                let numberRoom = $('#Room-' + id).children().eq(3).text();
                priceRoom = priceRoom.replace(/\D+/g, '');

                $('#nameEdit').val(nameRoom);
                $('#priceEdit').val(priceRoom);
                $('#numberEdit').val(numberRoom);
            });

            // Add New Room
            $('#formAddRoom').submit(function (e) {
                e.preventDefault();

                $('#errorName').text('');
                $('#errorPrice').text('');

                let link = $(this).attr('action');
                let name = $('#name').val();
                let price = $('#price').val();
                let number = $('#number').val();

                let formData = new FormData();
                formData.append("name", name);
                formData.append("price", price);
                formData.append("number", number);

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
                            $('#formAddRoom')[0].reset();
                        }
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Tạo phòng không thành công');
                        if (response?.errors?.name !== undefined) {
                            $('#errorName').text(response.errors.name[0]);
                        }
                        if (response?.errors?.price !== undefined) {
                            $('#errorPrice').text(response.errors.price[0]);
                        }
                        if (response?.errors?.number !== undefined) {
                            $('#errorNumber').text(response.errors.number[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formAddRoom', 300);
                    }
                });
            });

            // Edit Room
            $('#formEditRoom').submit(function (e) {
                e.preventDefault();

                $('#errorNameEdit').text('');
                let name = $('#nameEdit').val();
                let price = $('#priceEdit').val();
                let number = $('#numberEdit').val();

                $.ajax({
                    url: linkEditRoom,
                    method: "PUT",
                    dataType: 'json',
                    data: {name: name, price: price, number: number},
                    success: function (response) {
                        let type = response['alert-type'];
                        let message = response['message'];
                        toastrMessage(type, message);

                        if (type === 'success') {
                            datatable.ajax.reload(null, false);
                            $('#editModal').modal('hide');
                        }
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Cập nhật thông tin phòng không thành công');
                        if (response?.errors?.name !== undefined) {
                            $('#errorNameEdit').text(response.errors.name[0]);
                        }
                        if (response?.errors?.price !== undefined) {
                            $('#errorPriceEdit').text(response.errors.price[0]);
                        }
                        if (response?.errors?.number !== undefined) {
                            $('#errorNumberEdit').text(response.errors.number[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formEditRoom', 300);
                    }
                });
            });
        });
    </script>
@endsection
