@extends('admin.master')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit Destination</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">
                                <a href="{{ route('types.index') }}">Type of tour</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('types.update',$type->id) }}" class="form-horizontal" method="post"
              enctype="multipart/form-data"
              id="formEditDestination">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 text-lg-right control-label col-form-label">Name of type <span
                            class="text-danger">*</span> </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name Destination"
                               value="{{ $type->name }}">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-sm-2 text-lg-right control-label col-form-label">Status
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group mb-3" style="width: 150px">
                            <select class="form-control" name="status">
                                <option value="1" {{ $type->status == 1 ? "selected" : "" }}>Active</option>
                                <option value="2" {{ $type->status == 2 ? "selected" : "" }}>Inactive</option>
                            </select>
                        </div>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group m-b-0 text-right row">
                    <div class="col-11">
                        <button type="submit" class="btn btn-info waves-effect waves-light">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
@endsection
