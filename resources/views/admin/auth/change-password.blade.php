@extends('admin.master')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Change Password</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">User</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form class="form-horizontal m-t-20" action="{{ route('admin.password.store') }}" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-0 col-lg-3"></div>
                        <div class="col-12 col-lg-6 ">
                            <label for="oldPassword">Current Password <span class="text-danger">*</span> </label>
                            <input class="form-control form-control-lg" id="oldPassword" name="old_password"
                                   type="password" required=" "
                                   placeholder="Old Password">
                            @error ('old-password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-0 col-lg-3"></div>
                        <div class="col-12 col-lg-6 ">
                            <label for="password">New Password <span class="text-danger">*</span> </label>
                            <input class="form-control form-control-lg" id="password" name="password" type="password"
                                   required=" "
                                   placeholder="Password">
                            @error ('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-0 col-lg-3"></div>
                        <div class="col-12 col-lg-6 ">
                            <label for="confirmPassword">Confirm Password <span class="text-danger">*</span> </label>
                            <input class="form-control form-control-lg" name="password_confirmation" type="password"
                                   id="confirmPassword"
                                   required="" placeholder="Confirm Password">
                            @error ('password_confirmation')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-center row">
                        <div class="col-0 col-lg-3"></div>
                        <div class="col-12 col-lg-6 p-b-20 ">
                            <button class="btn btn-block btn-lg btn-info " type="submit ">Reset Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>

    </script>
@endsection
