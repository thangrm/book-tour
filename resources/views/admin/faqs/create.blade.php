@extends('admin.master')
@section('style')
    <style>
        #formCreateFAQ textarea {
                resize: none;
        }
    </style>
@endsection
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
                            <li class="breadcrumb-item"><a href="{{ route('faqs.index', $tourId) }}">FAQ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Create</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form action="{{ route('faqs.store', $tourId) }}" class="form-horizontal" method="post"
              enctype="multipart/form-data"
              id="formCreateFAQ">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 text-lg-right control-label col-form-label">
                        Question <span class="text-danger">*</span>
                    </label>
                    <div class="col-sm-9">
                        <textarea type="text" class="form-control" name="question" id="question" placeholder="Question" rows="3" >{{old('question')}}</textarea>
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
                        <textarea type="text" class="form-control" name="answer" id="answer" placeholder="Answer" rows="5">{{old('answer')}}</textarea>
                        @error('answer')
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

            <div class="card-body">
                <div class="form-group m-b-0 text-lg-right row">
                    <div class="col-11">
                        <button type="submit" class="btn btn-info waves-effect waves-light">Add new FAQ</button>
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

            disableSubmitButton('#formCreateFAQ');
        });
    </script>
@endsection
