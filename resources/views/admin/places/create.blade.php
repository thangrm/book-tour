@extends('layouts.admin')

@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Create Place</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('itineraries.index', $itinerary->tour_id) }}">Itinerary</a>
                            </li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('places.index', [$itinerary->tour_id, $itinerary->id]) }}">Place</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('places.store', [$itinerary->tour_id, $itinerary->id]) }}" class="form-horizontal"
              method="post"
              enctype="multipart/form-data"
              id="formCreatePlace">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 text-lg-right control-label col-form-label">
                        Name place <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name place"
                               value="{{ old('name') }}">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="description"
                           class="col-sm-2 text-lg-right control-label col-form-label">
                        Description
                    </label>
                    <div class="col-sm-9">
                        <textarea name="description" id="description" cols="30" rows="10"></textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="card-body">
                <div class="form-group m-b-0 text-lg-right row">
                    <div class="col-11">
                        <button type="submit" class="btn btn-info waves-effect waves-light">Add new place</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let descriptionEditor = null;
            disableSubmitButton('#formCreatePlace');

            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {
                    descriptionEditor = editor;
                    editor.setData('{!! old('description') !!}');
                })
                .catch(error => {
                    console.error(error);
                });

            $('#formCreatePlace').submit(function (e) {
                e.preventDefault();
                descriptionEditor.updateSourceElement();
                e.currentTarget.submit();
            });
        });
    </script>
@endsection
