@extends('admin.master')
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
            max-width: 700px;
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
                            <input type="file" class="form-control-file" name="image" id="image" required>
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
                        @foreach($galleries as $gallery)
                            <div class="img col-6 col-md-4 col-lg-3" id="image{{ $gallery->id }}">
                                <img src="{{ asset('storage/images/galleries/'.$gallery->image) }}">
                                <a href="{{ route("galleries.destroy", [$tourId, $gallery->id]) }}"
                                   class="btn btn-danger btn-sm rounded-0 text-white delete" types="button"
                                   data-toggle="tooltip" title="Delete"
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
            <img class="modal-content" id="imgModal">
            <div id="caption"></div>
        </div>
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

            // Modal view image
            let modal = document.getElementById('myModal');
            let span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function () {
                modal.style.display = "none";
            }

            // Get all images and insert the clicked image inside the modal
            let images = document.getElementsByTagName('img');
            let modalImg = document.getElementById("imgModal");
            let i;
            for (i = 0; i < images.length; i++) {
                images[i].onclick = function () {
                    modal.style.display = "block";
                    modalImg.src = this.src;
                    modalImg.alt = this.alt;
                }
            }

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