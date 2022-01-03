@extends('admin.master')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit Tour</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('tours.update', $tour->id) }}" class="form-horizontal" method="post"
              enctype="multipart/form-data"
              id="formEditTour">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 text-lg-right control-label col-form-label">
                        Name tour <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name tour"
                               value="{{ empty(old('name')) ? $tour->name : old('name') }}">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="destinationId"
                           class="col-sm-2 text-lg-right control-label col-form-label">
                        Destination <span class="text-danger">*</span>
                    </label>
                    <div class="col-3">
                        <select class="form-control" name="destination_id" id="destinationId">
                            @isset($destinations)
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}"
                                        {{ (empty(old('destination_id')) ? $tour->destination_id : old('destination_id')) == $destination->id ? "selected" : "" }}>
                                        {{ $destination->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('destination_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-1"></div>
                    <label for="typeId"
                           class="col-sm-2 text-lg-right control-label col-form-label">
                        Type <span class="text-danger">*</span>
                    </label>
                    <div class="col-3">
                        <select class="form-control" name="type_id" id="typeId">
                            @isset($types)
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ (empty(old('type_id')) ? $tour->type_id : old('type_id')) == $type->id ? "selected" : "" }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                        @error('type_id')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="image" class="col-sm-2 text-lg-right control-label col-form-label">Select Image</label>
                    <div class="col-sm-9">
                        <div class="input-group mb-3">
                            <input type="file" id="image" name="image">
                        </div>
                        <div>
                            <img id="showImg" src="{{ asset('storage/images/tours/'.$tour->image) }}"
                                 style="max-height: 150px; margin: 10px 2px">
                        </div>
                        @error('image')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="duration" class="col-sm-2 text-lg-right control-label col-form-label">Duration <span
                            class="text-danger">*</span> </label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="duration" id="duration" placeholder="Duration"
                               value="{{ empty(old('duration')) ? $tour->duration : old('duration') }}" step="1">
                        @error('duration')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="price" class="col-sm-2 text-lg-right control-label col-form-label">Price<span
                            class="text-danger">*</span> </label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" name="price" id="price" placeholder="Price"
                               value="{{ empty(old('price')) ? $tour->price : old('price') }}" step="0.01">
                        @error('price')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-sm-2 text-lg-right control-label col-form-label">Status
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group mb-3" style="width: 150px">
                            <select class="form-control" name="status" id="status">
                                <option
                                    value="1" {{  (empty(old('status')) ? $tour->status : old('status')) == 1 ? "selected" : "" }}>
                                    Active
                                </option>
                                <option
                                    value="2" {{  (empty(old('status')) ? $tour->status : old('status')) == 2 ? "selected" : "" }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                        @error('status')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="trending" class="col-sm-2 text-lg-right control-label col-form-label">Trending
                    </label>
                    <div class="col-sm-9">
                        <div class="input-group mb-3" style="width: 150px">
                            <select class="form-control" name="trending" id="trending">
                                <option
                                    value="1" {{  (empty(old('trending')) ? $tour->trending : old('trending')) == 1 ? "selected" : "" }}>
                                    Active
                                </option>
                                <option
                                    value="2" {{  (empty(old('trending')) ? $tour->trending : old('trending')) == 2 ? "selected" : "" }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                        @error('trending')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="form-group m-b-0 text-lg-right row">
                    <div class="col-11">
                        <button type="submit" class="btn btn-info waves-effect waves-light">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#image').change(function (e) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            disableSubmitButton('#formEditTour');
        });
    </script>
@endsection
