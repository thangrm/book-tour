@extends('layouts.admin')
@section('style')
    <style>
        .box-map iframe {
            width: 100%;
            height: 350px;
        }
    </style>
@endsection
@section('admin')
    @error('name')
    <p class="text-danger">{{ $message }}</p>
    @enderror
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Info Tour</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Info</li>
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

                    <input type="hidden" name="name" value="{{ $tour->name }}">
                    <input type="hidden" name="destination_id" value="{{ $tour->destination_id }}">
                    <input type="hidden" name="type_id" value="{{ $tour->type_id }}">
                    <input type="hidden" name="duration" value="{{ $tour->duration }}">
                    <input type="hidden" name="price" value="{{ $tour->price }}">
                    <input type="hidden" name="status" value="{{ $tour->status }}">
                    <input type="hidden" name="trending" value="{{ $tour->trending }}">
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="metaTitle" class="text-lg-right control-label col-form-label">Meta title</label>
                            <input type="text" class="form-control" name="meta_title" id="metaTitle"
                                   placeholder="Meta title"
                                   value="{{ old('meta_title', $tour->meta_title) }}">
                            @error('meta_title')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror

                        <!-- Meta description -->
                            <label for="metaDescription" class="text-lg-right control-label col-form-label">Meta
                                Description</label>
                            <textarea type="text" class="form-control" name="meta_description" id="metaDescription"
                                      placeholder="Meta description"
                                      rows="6">{{ old('meta_description', $tour->meta_description) }}</textarea>
                            @error('meta_description')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="imageSeo" class="text-lg-right control-label col-form-label">SEO Image</label>
                            <div class="input-group mb-3">
                                <input type="file" id="imageSeo" name="image_seo" value="{{old('image_seo')}}">
                            </div>
                            <div>
                                <img id="showImgSeo" style="max-height: 156px; margin: 10px 2px"
                                     src="{{ asset('storage/images/tours/'. (empty($tour->image_seo) ? $tour->image : $tour->image_seo) ) }}">
                            </div>
                            @error('image_seo')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-6">
                            <label for="panoramicImage" class="text-lg-right control-label col-form-label">
                                Image 360
                            </label>
                            <input type="text" class="form-control" name="panoramic_image" id="panoramicImage"
                                   placeholder="Link image"
                                   value="{{ empty(old('panoramic_image')) ? $tour->panoramic_image : old('panoramic_image') }}">
                            @error('panoramic_image')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror

                            @isset($tour->panoramic_image)
                                <iframe class="w-100 m-t-10" height="300" src="{{$tour->panoramic_image}}"
                                        frameborder="0">
                                </iframe>
                            @endisset
                        </div>
                        <div class="col-6">
                            <label for="video" class="text-lg-right control-label col-form-label">Video</label>
                            <input type="text" class="form-control" name="video" id="video" placeholder="Video"
                                   value="{{ empty(old('video')) ? $tour->video : old('video') }}">
                            @error('video')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror

                            @isset($tour->video)
                                <iframe class="w-100 m-t-10" height="300"
                                        src="https://www.youtube.com/embed/{{ $tour->video }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope;
                                    picture-in-picture"
                                        allowfullscreen></iframe>
                            @endisset
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="map" class="text-lg-right control-label col-form-label">Map</label>
                        <input type="text" class="form-control" name="map" id="map" placeholder="Map"
                               value="{{ old('map', $tour->map) }}">
                        @error('map')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <div class="box-map m-t-15">
                            {!! $tour->map !!}
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="included"
                               class="text-lg-right control-label col-form-label">
                            Included
                        </label>
                        <textarea name="included" id="included" cols="30"
                                  rows="10">{{ old('included', $tour->included) }}</textarea>
                        @error('included')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="additional"
                               class="text-lg-right control-label col-form-label">
                            Additional
                        </label>
                        <textarea name="additional" id="additional" cols="30"
                                  rows="10">{{ old('additional', $tour->additional) }}</textarea>
                        @error('additional')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="departure"
                               class="text-lg-right control-label col-form-label">
                            Departure
                        </label>
                        <textarea name="departure" id="departure" cols="30"
                                  rows="10">{{ old('departure', $tour->departure) }}
                        </textarea>
                        @error('departure')
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
            $('#imageSeo').change(function (e) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImgSeo').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            disableSubmitButton('#formEditTour');

            CKEDITOR.replace('included');
            CKEDITOR.replace('additional');
            CKEDITOR.replace('departure');
        });
    </script>
@endsection
