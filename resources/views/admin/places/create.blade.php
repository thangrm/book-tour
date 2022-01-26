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
        <div class="card">
            <div class="card-body">
                <form action="{{ route('places.store', [$itinerary->tour_id, $itinerary->id]) }}"
                      class="form-horizontal"
                      method="post"
                      enctype="multipart/form-data"
                      id="formCreatePlace">
                    @csrf
                    <div class="form-group">
                        <label for="name">
                            Name place <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name place"
                               value="{{ old('name') }}">
                        @error('name')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">
                            Description
                        </label>
                        <textarea name="description" id="description" cols="30"
                                  rows="10">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-info waves-effect waves-light">Add new place</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            disableSubmitButton('#formCreatePlace');

            CKEDITOR.replace('description');
        });
    </script>
@endsection
