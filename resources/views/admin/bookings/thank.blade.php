@extends('layouts.client')
@section('content')
    <link href="{{ asset('css/bootstrap-v5.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/toastr.css') }}">
    <!-------------------- Thanks -------------------->
    <div class="modal fade thank-modal" id="thanksModal" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="panel-thank modal-content d-flex justify-content-center align-items-center flex-column">
                <p class="thank-title">Cảm ơn!</p>
                <p class="thank-text">Bạn đã đặt tour thành công.</p>
                <p class="thank-text">Thông tin chi tiết về giá cả và đặt xe,</p>
                <p class="thank-text"> sẽ được nhân viên liên hệ với bạn vào thời gian sớm nhất.</p>
                <button class="btn-back-home"><a class="d-flex align-items-center justify-content-center"
                                                 href="{{ route('index') }}">Quay lại trang chủ</a></button>
            </div>
        </div>
    </div>
    <!-------------------- End Thanks -------------------->
    <script>
        $(function (){
            $('#thanksModal').modal('show');
        });
    </script>
@endsection
