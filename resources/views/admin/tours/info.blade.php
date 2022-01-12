@extends('admin.master')

@section('admin')
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

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="duration" class="text-lg-right control-label col-form-label">
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
                                <label for="price" class="text-lg-right control-label col-form-label">Video</label>
                                <input type="text" class="form-control" name="video" id="video" placeholder="Video"
                                       value="{{ empty(old('video')) ? $tour->video : old('video') }}">
                                @error('video')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror

                                @isset($tour->video)
                                    <iframe class="w-100 m-t-10" height="300"
                                            src="https://www.youtube.com/embed/{{ $tour->video }}"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                @endisset
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description"
                               class="text-lg-right control-label col-form-label">
                            Included
                        </label>
                        <textarea name="included" id="included" cols="30" rows="10"></textarea>
                        @error('included')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description"
                               class="text-lg-right control-label col-form-label">
                            Additional
                        </label>
                        <textarea name="additional" id="additional" cols="30" rows="10"></textarea>
                        @error('additional')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description"
                               class="text-lg-right control-label col-form-label">
                            Departure
                        </label>
                        <textarea name="departure" id="departure" cols="30" rows="10"></textarea>
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
            let includedEditor = null;
            let additionalEditor = null;
            let departureEditor = null;

            $('#image').change(function (e) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $('#showImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            disableSubmitButton('#formEditTour');

            ClassicEditor
                .create(document.querySelector('#included'))
                .then(editor => {
                    includedEditor = editor;
                    editor.setData(`{!!  empty(old('included')) ? $tour->included : old('included') !!}`);
                })

            ClassicEditor
                .create(document.querySelector('#additional'))
                .then(editor => {
                    additionalEditor = editor;
                    editor.setData(`{!!  empty(old('additional')) ? $tour->additional : old('additional') !!}`);
                })

            ClassicEditor
                .create(document.querySelector('#departure'))
                .then(editor => {
                    departureEditor = editor;
                    editor.setData(`{!!  empty(old('departure')) ? $tour->departure : old('departure') !!}`);
                })

            $('#formEditTour').submit(function (e) {
                e.preventDefault();
                includedEditor.updateSourceElement();
                additionalEditor.updateSourceElement();
                departureEditor.updateSourceElement();
                e.currentTarget.submit();
            });
        });
    </script>
@endsection
