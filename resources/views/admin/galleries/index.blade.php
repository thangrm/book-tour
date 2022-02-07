@extends('layouts.admin')
@section('style')
    <style>
        div.img img:hover {
            transform: scale(1.01);
        }

        /* The Image */
        div.img img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            cursor: pointer;
            margin-bottom: 50px;
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
            max-width: 60vw;
            max-height: 80vh;
            object-fit: cover;
            object-position: center;
        }

        /* Nav slider image */
        .nav {
            position: absolute;
            color: #bbb;
            top: 50%;
            transform: translateY(-50%);
        }

        .nav:hover {
            color: white;
            cursor: pointer;
        }

        .nav-left {
            left: 30px;
        }

        .nav-right {
            right: 30px;
        }

        .nav-disabled {
            color: #333;
        }

        .nav-disabled:hover {
            color: #333;
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

        /* The Delete Button */
        .delete {
            position: absolute;
            top: 0;
            right: 10px;
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add New Image</h4>
                    <form href="{{ route('galleries.store',$tourId) }}" class="m-t-20" id="formAddNewImage"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <fieldset class="form-group">
                            <input type="file" class="form-control-file" name="images[]" id="images" multiple>
                        </fieldset>
                        <div id="showListImg">
                        </div>
                        @error('images')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                        <p class="text-danger">{{ $message }}</p>
                        @enderror
                        {{--                        <button type="submit" class="btn btn-info mb-3">--}}
                        {{--                            Add--}}
                        {{--                        </button>--}}
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Image Gallery</h4>
                    <div class="row" id="listImages">
                        @foreach($galleries as $gallery)
                            <div class="img col-6 col-md-4 col-lg-3" id="image{{ $gallery->id }}">
                                <img class="image-item" src="{{ asset('storage/images/galleries/'.$gallery->image) }}">
                                <a href="{{ route("galleries.destroy", [$tourId, $gallery->id]) }}"
                                   class="btn btn-danger btn-sm rounded-0 text-white delete" types="button"
                                   {{--                                   data-toggle="tooltip" title="Delete"--}}
                                   data-id="{{ $gallery->id }}">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div id="myModal" class="modal">
            <span class="close">×</span>
            <img class="modal-content animated zoomIn" id="imgModal">
            <div class="nav nav-left nav-disabled" id="navLeftGallery">
                <i class="fa fa-arrow-left fa-2x"></i>
            </div>
            <div class="nav nav-right" id="navRightGallery">
                <i class=" fa fa-arrow-right fa-2x"></i>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            // disableSubmitButton('#formAddNewImage');

            // Render image
            // function imageIsLoaded(e) {
            //     $('#showListImg').append('<img style="max-height: 100px; margin: 10px 2px" src=' + e.target.result + '>');
            // };

            $('#images').change(function (e) {
                $('#formAddNewImage').submit();
                $(this).prop('disabled', true);

                // $('#showListImg').empty();
                // if (this.files && this.files[0]) {
                //     for (let i = 0; i < this.files.length; i++) {
                //         let reader = new FileReader();
                //         reader.onload = imageIsLoaded;
                //         reader.readAsDataURL(this.files[i]);
                //     }
                // }
            });

            // Modal view image
            let modal = document.getElementById('myModal');

            // When the user clicks on <span> (x), close the modal
            $('.close').on('click', function () {
                modal.style.display = "none";
            });

            // When the user press esc
            $(document).keyup(function (e) {
                if (e.key === "Escape") {
                    modal.style.display = "none";
                }
            });

            // Get all images and insert the clicked image inside the modal
            let listImages = [];
            $("#listImages img").each(function () {
                listImages.push($(this).attr('src'))
            });

            let imageTarget;
            let modalImg = document.getElementById("imgModal");
            $('.image-item').on('click', function (e) {
                imageTarget = $(this).attr('src')
                modal.style.display = "block";
                modalImg.src = this.src;
                checkDisabledNav(getCurrentIndex());
            });

            // Get index slider
            function getCurrentIndex() {
                let i = 0;
                for (i; i < listImages.length; i++) {
                    if (imageTarget === listImages[i]) {
                        return i;
                    }
                }
            }

            // Check disabled nav
            function checkDisabledNav(index) {
                $('#navLeftGallery').removeClass('nav-disabled');
                $('#navRightGallery').removeClass('nav-disabled');

                if (index <= 0) {
                    $('#navLeftGallery').addClass('nav-disabled');
                }

                if (index >= listImages.length - 1) {
                    $('#navRightGallery').addClass('nav-disabled');
                }
            }

            // Nav image
            function navImage(step) {
                let nextIndex = getCurrentIndex() + step;
                checkDisabledNav(nextIndex);
                if (nextIndex < 0 || nextIndex >= listImages.length) {
                    return;
                }
                modalImg.src = listImages[nextIndex];
                imageTarget = listImages[nextIndex];
            }

            // Nav left slider
            $('#navLeftGallery').on('click', function () {
                navImage(-1)
            });

            // Nav right slider
            $('#navRightGallery').on('click', function () {
                navImage(1);
            });

            // Modal Delete
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                let link = $(this).attr("href");
                let id = $(this).data('id');

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success m-2',
                        cancelButton: 'btn btn-danger m-2'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax(
                            {
                                url: link,
                                type: 'delete',
                                dataType: 'json',
                                success: function (response) {
                                    if (response) {
                                        $("#image" + id).remove();
                                        toastr.success('The image has been deleted');
                                    } else {
                                        toastr.error('Delete failed');
                                    }
                                },
                                error: function (response) {
                                    toastr.error('Delete failed');
                                }
                            });
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            '',
                            'error'
                        )
                    }
                })
            })
        });
    </script>
@endsection
