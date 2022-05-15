@extends('layouts.admin')

@section('style')
    <style>
        .table-show-contact td {
            padding: 10px;
            font-size: 16px;
        }

        .tb-title {
            font-weight: bold;
            width: 80px;
            margin-bottom: 60px;
            vertical-align: top;
        }

    </style>
@endsection

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Liên hệ</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-bordered" id="contactTable">
                    <div
                        class="p-0 d-flex justify-content-between align-items-start flex-column flex-sm-row w-100 m-b-10">
                        <div class="row w-75">
                            <div class="col-12 col-sm-6 col-md-5 mb-2">
                                <input type="text" class="form-control" name="search" id="searchContact"
                                       placeholder="Tìm kiếm">
                            </div>
                            <div class="col-10 col-sm-6 col-md-5 mb-2">
                                <select class="form-control" name="status" id="filterStatus">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="1">Chưa đọc</option>
                                    <option value="2">Đã đọc</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Ngày</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Liên hệ</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <table class="table-show-contact">
                                <tr>
                                    <td class="tb-title">Tên:</td>
                                    <td id="nameContact"></td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Email:</td>
                                    <td id="emailContact"></td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Số điện thoại:</td>
                                    <td id="phoneContact"></td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Nội dung:</td>
                                    <td id="messageContact"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        var datatable = null;
        $(document).ready(function () {
            datatable = $('#contactTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                language: getLanguageDataTable(),
                ajax: {
                    url: "{!! route('contacts.data') !!}",
                    data: function (d) {
                        d.search = $('#searchContact').val();
                        d.status = $('#filterStatus').val();
                    }
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'date', name: 'date'},
                    {data: 'action', name: 'action', className: 'align-middle text-center', width: 65},
                ],
                columnDefs: [
                    {className: 'align-middle', targets: '_all'},
                ],
            });

            $('#contactTable thead th').removeClass('align-middle text-center');

            $('#searchContact').on('keyup', function () {
                datatable.draw();
            });

            $('#filterStatus').on('change', function () {
                datatable.draw();
            });

            // View contact
            $('#contactTable').on('click', '.btn-modal', function (e) {
                let link = $(this).attr('href');
                $.ajax({
                    url: link,
                    method: "GET",
                    dataType: 'json',
                    success: function (response) {
                        $('#nameContact').text(response.name);
                        $('#emailContact').text(response.email);
                        $('#phoneContact').text(response.phone);
                        $('#messageContact').text(response.message);
                        datatable.ajax.reload(null, false);
                    },
                });
            });
        });
    </script>
@endsection
