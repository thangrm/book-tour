@extends('layouts.admin')
@section('style')
    <style>
        .tb-title {
            font-weight: bold;
            width: 120px;
            margin-bottom: 20px;
        }
    </style>
@endsection
@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Đặt tour</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tổng quan</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Đặt tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chi tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('bookings.update', $booking->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title d-flex justify-content-between align-items-center">
                                <span>Thông tin đặt tour</span>
                                @if($booking->is_payment == PAYMENT_UN_PAID && $booking->status != BOOKING_COMPLETE)
                                    <button type="button" class="btn btn-info text-white edit" title="Thanh toán / cọc"
                                            data-toggle="modal" data-target="#editModal">
                                        Thánh toán / cọc
                                    </button>
                                @endif
                            </h4>
                            <hr>
                            <table>
                                <tr>
                                    <td class="tb-title">Tour:</td>
                                    <td>{{ $booking->tour->name }}</td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Thời gian:</td>
                                    <td>{{ date('d/m/Y',strtotime($booking->departure_time)) }}</td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Thanh toán:</td>
                                    <td>
                                        @switch($booking->payment_method)
                                            @case(1)
                                                Tiền mặt
                                                @break
                                            @case(2)
                                                Momo
                                                @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Trạng thái:</td>
                                    <td>
                                        @include('components.status_booking', ['status' => $booking->status])
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Giá:</td>
                                    <td>{{ number_format($booking->price) . ' đ'}}</td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Số người:</td>
                                    <td>
                                        @if($booking->status != BOOKING_COMPLETE)
                                            <input type="number" class="form-control" min="1"
                                                   value="{{ $booking->people }}" name="people">
                                        @else
                                            {{ $booking->people }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Giảm giá:</td>
                                    <td>{{ $booking->discount }}%</td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Tổng:</td>
                                    <td>{{ number_format($booking->total) . ' đ'}}</td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Đã thanh toán:</td>
                                    <td>{{ number_format($booking->deposit) . ' đ'}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @if($booking->status == 1)
                                            <button onclick="changeStatusBooking(2)" type="button"

                                                    class="btn btn-success btn-status m-r-5 m-t-30">
                                                Xác nhận
                                            </button>
                                        @elseif($booking->status == 2)
                                            <button onclick="changeStatusBooking(3)" type="button"
                                                    class="btn btn-primary btn-status m-r-5 m-t-30">
                                                Hoàn thành
                                            </button>
                                        @endif

                                        @if($booking->status < 3 )
                                            <button onclick="changeStatusBooking(4)" type="button"
                                                    class="btn btn-danger btn-status m-t-30">
                                                Hủy đơn hàng
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Ngày tạo: {{  $booking->created_at->format('d/m/Y') }}</h4>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Thông tin khách hàng</h4>
                            <hr>
                            <table>
                                <tr>
                                    <td class="tb-title">Tên:</td>
                                    <td>{{ $booking->customer->first_name . ' ' . $booking->customer->last_name }}</td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Email:</td>
                                    <td>{{ $booking->customer->email }}</td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Điện thoại:</td>
                                    <td>{{ $booking->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Địa chỉ:</td>
                                    <td>
                                        {{ trim(implode(", ", [
                                            $booking->customer->address,
                                             $booking->customer->province,
                                             $booking->customer->city,
                                             $booking->customer->country
                                             ]),', ')  }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tb-title">Zipcode:</td>
                                    <td>{{  $booking->customer->zipcode  }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Yêu cầu</h4>
                            <hr>
                            <p> {{ $booking->requirement }} </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Thông tin phòng</h4>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên phòng</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Giá phòng</th>
                                    <th scope="col">Tông tiền</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($booking->rooms as $room)
                                    <tr>
                                        <td>{{ $loop->index + 1  }}</td>
                                        <td>{{ $room->name }}</td>
                                        <td>
                                            @if($booking->status != BOOKING_COMPLETE)
                                                <input type="number" class="form-control"
                                                       value="{{ $room->pivot->number }}"
                                                       name="room[{{ $room->pivot->id }}]">
                                            @else
                                                {{ $room->pivot->number }}
                                            @endif
                                        </td>
                                        <td>{{ number_format($room->pivot->price) }}đ</td>
                                        <td>{{ number_format($room->pivot->number * $room->pivot->price) }}đ</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @if($booking->status != BOOKING_COMPLETE)
                                <button type="submit" class="btn btn-info text-white edit" title="Cập nhật">
                                    Cập nhật
                                </button>
                            @endif
                            <a href="{{ route('bookings.invoice', $booking->id) }}"
                               target="_blank"
                               class="btn btn-success text-white edit"
                               title="Hóa đơn">
                                <i class="fa fa-download"></i>
                                Hóa đơn
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="formEditDeposit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Thanh toán / cọc</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="text-left control-label col-form-label">
                                Số tiền<span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" min="0" class="form-control" name="deposit" id="deposit"
                                       value="{{ $booking->deposit }}" placeholder="Số tiền">
                            </div>
                            <p class="text-danger" id="errorDeposit"></p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-info" id="btnSubmitDeposit">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success m-2',
                cancelButton: 'btn btn-danger m-2'
            },
            buttonsStyling: false
        })
        const NEW = 1;
        const CONFIRMED = 2;
        const COMPLETE = 3;
        const CANCEL = 4;

        function changeStatusBooking(status) {
            let text = '';
            switch (status) {
                case CONFIRMED:
                    text = 'xác nhận';
                    break;
                case COMPLETE:
                    text = 'hoàn thành';
                    break;
                case CANCEL:
                    text = 'hủy';
                    break;
                default:
                    return;
            }

            swalWithBootstrapButtons.fire({
                title: 'Bạn có chắc chắn?',
                text: `Bạn muốn ${text} lịch đặt tour này!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Vâng, xác nhận',
                cancelButtonText: 'Hủy',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('bookings.status', $booking->id) }}',
                        method: 'PUT',
                        dataType: 'json',
                        data: {'status': status},
                        success: function (response) {
                            if (response) {
                                location.reload(true);
                            } else {
                                toastrMessage('error', 'Thay đổi trạng thái thất bại');
                            }
                        }
                    });
                }
            })
        }

        $('#formEditDeposit').submit(function (e) {
            e.preventDefault();
            disableSubmitButton('#formEditDeposit');
            $('#errorDeposit').text('');

            let deposit = $('#deposit').val();
            if (deposit > {{ $booking->total }}) {
                $('#errorDeposit').text('Số tiền không được lớn hơn tổng tiền thanh toán');
                return;
            }
            let formData = new FormData();
            formData.append("_method", 'PUT');
            formData.append("deposit", deposit);

            $.ajax({
                url: '{{ route('bookings.deposit', $booking->id) }}',
                method: "POST",
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    if (response) {
                        location.reload(true);
                    } else {
                        toastrMessage('error', 'Cập nhật tiền thanh toán không thành công');
                    }
                },
                error: function (jqXHR) {
                    toastrMessage('error', 'Cập nhật tiền thanh toán không thành công');
                },
                complete: function () {
                    enableSubmitButton('#formEditDeposit', 300);
                }
            });

        });
    </script>
@endsection
