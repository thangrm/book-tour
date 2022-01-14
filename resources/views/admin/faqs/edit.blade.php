@extends('layouts.admin')
@section('style')
    <style>
        #formUpdateFAQ textarea {
            resize: none;
        }
    </style>
@endsection
@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Edit FAQ</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('faqs.index', $faq->tour_id) }}">FAQ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('faqs.update', [$faq->tour_id, $faq->id]) }}" class="form-horizontal" method="post"
              enctype="multipart/form-data"
              id="formUpdateFAQ">
            @method('PUT')
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 text-lg-right control-label col-form-label">
                        Question <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="question" id="question" placeholder="Question"
                                  rows="3">{{ empty(old('question')) ? $faq->question : old('question')  }}</textarea>
                        @error('question')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="name" class="col-sm-2 text-lg-right control-label col-form-label">
                        Answer <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="answer" id="answer" placeholder="Answer"
                                  rows="5">{{  empty(old('answer')) ? $faq->answer : old('answer') }}</textarea>
                        @error('answer')
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

            disableSubmitButton('#formUpdateFAQ');
        });
    </script>
@endsection
