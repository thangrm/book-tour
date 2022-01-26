@extends('layouts.admin')

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
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tours.update', $tour->id) }}" class="form-horizontal" method="post"
                      enctype="multipart/form-data"
                      id="formEditTour">
                    @method('PUT')
                    @csrf

                    <div class="form-group">
                        <label for="name" class="text-lg-right control-label col-form-label">
                            Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name tour"
                               value="{{ old('name', $tour->name) }}">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug" class="text-lg-right control-label col-form-label">
                            Slug <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Slug"
                               value="{{ old('slug', $tour->slug) }}">
                        @error('slug')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="destinationId"
                                       class="text-lg-right control-label col-form-label">
                                    Destination <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="destination_id" id="destinationId">
                                    @isset($destinations)
                                        @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}"
                                                {{ old('destination_id', $tour->destination_id) == $destination->id ? "selected" : "" }}>
                                                {{ $destination->name }}
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                                @error('destination_id')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="typeId"
                                       class="text-lg-right control-label col-form-label">
                                    Type <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" name="type_id" id="typeId">
                                    @isset($types)
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}"
                                                {{ old('type_id', $tour->type_id) == $type->id ? "selected" : "" }}>
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
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="duration" class="text-lg-right control-label col-form-label">Duration
                                    <span
                                        class="text-danger">*</span> </label>
                                <input type="number" class="form-control" name="duration" id="duration"
                                       placeholder="Duration"
                                       value="{{ old('duration',$tour->duration) }}"
                                       step="1">
                                @error('duration')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="price" class="text-lg-right control-label col-form-label">Price<span
                                        class="text-danger">*</span> </label>
                                <input type="number" class="form-control" name="price" id="price" placeholder="Price"
                                       value="{{ old('price',$tour->price) }}" step="0.01">
                                @error('price')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image" class="text-lg-right control-label col-form-label">Select Image
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group mb-3">
                            <input type="file" id="image" name="image" value="{{old('image')}}">
                        </div>
                        <div>
                            <img id="showImg" src="{{ asset('storage/images/tours/'.$tour->image) }}"
                                 style="max-height: 150px; margin: 10px 2px">
                        </div>
                        @error('image')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description"
                               class="text-lg-right control-label col-form-label">
                            Overview
                        </label>
                        <textarea name="overview" id="overview" cols="30"
                                  rows="10">{{ old('overview', $tour->overview) }}</textarea>
                        @error('overview')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-info mr-2">Update</button>
                    <a href="{{ route('tours.index') }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('#destinationId').select2();
            $('#typeId').select2();
            
            $('#image').change(function (e) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            disableSubmitButton('#formEditTour');

            CKEDITOR.replace('overview');

            // Auto format title to slug
            $('#name').on('keyup', function () {
                $('#slug').val(changeToSlug($('#name').val()));
            });

            $('#slug').on('change', function () {
                $('#slug').val(changeToSlug($('#slug').val()));
            });
        });
    </script>
@endsection
