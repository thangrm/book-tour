@extends('admin.master')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Create Tour</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tours.store') }}" class="form-horizontal" method="post"
                      enctype="multipart/form-data"
                      id="formCreateTour">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="text-lg-right control-label col-form-label">
                            Title <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Title tour"
                               value="{{old('name')}}">
                        @error('name')
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
                                                {{ old('destination_id') == $destination->id ? "selected" : "" }}>
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
                                            <option
                                                value="{{ $type->id }}" {{ old('type_id') == $type->id ? "selected" : "" }}>
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
                                       value="{{old('duration')}}" step="1">
                                @error('duration')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="price" class="text-lg-right control-label col-form-label">Price<span
                                        class="text-danger">*</span> </label>
                                <input type="number" class="form-control" name="price" id="price" placeholder="Price"
                                       value="{{old('price')}}" step="0.01">
                                @error('price')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="trending" class="text-lg-right control-label col-form-label">Trending
                                </label>
                                <div class="input-group mb-3" style="width: 150px">
                                    <select class="form-control" name="trending" id="trending">
                                        <option value="1" {{ old('trending') == 1 ? "selected" : "" }}>Active</option>
                                        <option value="2" {{ old('trending') == 2 ? "selected" : "" }}>Inactive</option>
                                    </select>
                                </div>
                                @error('trending')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-6">
                                <label for="status" class="text-lg-right control-label col-form-label">Status
                                </label>
                                <div class="input-group mb-3" style="width: 150px">
                                    <select class="form-control" name="status" id="status">
                                        <option value="1" {{ old('status') == 1 ? "selected" : "" }}>Active</option>
                                        <option value="2" {{ old('status') == 2 ? "selected" : "" }}>Inactive</option>
                                    </select>
                                </div>
                                @error('status')
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
                            <img id="showImg" style="max-height: 150px; margin: 10px 2px">
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
                        <textarea name="overview" id="overview" cols="30" rows="10"></textarea>
                        @error('overview')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-info mr-2">Submit</button>
                    <a href="{{ route('tours.index') }}" class="btn btn-dark">Cancel</a>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let overviewEditor = null;

            $('#image').change(function (e) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            disableSubmitButton('#formCreateTour');

            ClassicEditor
                .create(document.querySelector('#overview'))
                .then(editor => {
                    overviewEditor = editor;
                    editor.setData('{!! old('overview') !!}');
                })
                .catch(error => {
                    console.error(error);
                });

            $('#formCreateTour').submit(function (e) {
                e.preventDefault();
                overviewEditor.updateSourceElement();
                e.currentTarget.submit();
            });
        });
    </script>
@endsection
