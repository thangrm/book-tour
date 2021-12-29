@extends('admin.master')
@section('style')
    <style>
        div.img:hover {
            border: 1px solid #ccc;
        }

        /* The Image */
        div.img img {
            width: 100%;
            height: auto;
            object-fit: cover;
            cursor: pointer;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.9);
        }


        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        @-webkit-keyframes zoom {
            from {
                transform: scale(0)
            }
            to {
                transform: scale(1)
            }
        }

        @keyframes zoom {
            from {
                transform: scale(0.1)
            }
            to {
                transform: scale(1)
            }
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

    </style>
@endsection
@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Gallery</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <form class="form-horizontal">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Image</h4>
                        <form class="m-t-20" id="formAddNewImage">
                            <fieldset class="form-group">
                                <input type="file" class="form-control-file" name="image" id="image">
                            </fieldset>
                            <div>
                                <img id="showImg" style="max-height: 150px; margin: 10px 2px">
                            </div>
                            @error('image')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                            <button type="submit" class="btn btn-info mb-3">
                                Add Image
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Image Gallery</h4>
                        <div class="row">
                            <div class="img col-3">
                                <img src="https://www.w3schools.com/css/img_lights.jpg" alt="Trolltunga Norway">
                            </div>

                            <div class="img col-3">
                                <img src="https://www.w3schools.com/css/img_lights.jpg" alt="Trolltunga Norway">

                            </div>

                            <div class="img col-3">
                                <img src="https://www.w3schools.com/css/img_lights.jpg" alt="Trolltunga Norway">

                            </div>

                            <div class="img col-3">
                                <img src="https://www.w3schools.com/css/img_lights.jpg" alt="Trolltunga Norway">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- The Modal -->
            <div id="myModal" class="modal">
                <span class="close">×</span>
                <img class="modal-content" id="imgModal">
                <div id="caption"></div>
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

            disableSubmitButton('#formAddNewImage');

            //

            // Get the modal
            let modal = document.getElementById('myModal');

            // Get the <span> element that closes the modal
            let span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // Get all images and insert the clicked image inside the modal
            // Get the content of the image description and insert it inside the modal image caption
            let images = document.getElementsByTagName('img');
            let modalImg = document.getElementById("imgModal");
            let captionText = document.getElementById("caption");
            let i;
            for (i = 0; i < images.length; i++) {
                images[i].onclick = function () {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    modalImg.alt = this.alt;
                    captionText.innerHTML = this.nextElementSibling.innerHTML;
                }
            }
        });
    </script>
@endsection
