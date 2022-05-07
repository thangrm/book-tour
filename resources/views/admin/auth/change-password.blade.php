@extends('layouts.admin')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Đổi mật khẩu</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Tổng quan</a></li>
                            <li class="breadcrumb-item"><a href="#">Người dùng</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Đổi mật khẩu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body row">
                <div class="col-12 col-lg-3"></div>
                <div class="col-12 col-lg-6">
                    <form class="form pt-3" action="{{ route('admin.password.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="oldPassword">Mật khẩu cũ<span class="text-danger">*</span> </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon33"><i class="ti-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" placeholder="Mật khẩu cũ"
                                       aria-label="Password"
                                       id="oldPassword" name="old_password" aria-describedby="basic-addon33">
                            </div>
                            @error ('old_password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Mật khẩu<span class="text-danger">*</span> </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon33"><i class="ti-lock"></i></span>
                                </div>
                                <input class="form-control" id="password" name="password"
                                       type="password" placeholder="Mật khẩu">
                            </div>
                            @error ('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Xác nhận mật khẩu<span class="text-danger">*</span> </label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon4"><i class="ti-lock"></i></span>
                                </div>
                                <input class="form-control" name="password_confirmation" type="password"
                                       id="confirmPassword" placeholder="Xác nhận mật khẩu">
                            </div>
                            @error ('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-info mr-2">Đổi mật khẩu</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
