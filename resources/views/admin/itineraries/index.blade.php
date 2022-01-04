@extends('admin.master')
@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Itinerary</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Itinerary</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <form href="{{ route('itineraries.store',$tourId) }}" id="formAddItinerary" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-12">
                                Name Itinerary<span class="text-danger">*</span>
                            </label>
                            <div class="col-12">
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="Name itinerary">
                                @error('name')
                                <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info mb-3">
                                Add Itinerary
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">List of Itineraries</h4>
                    <table class="table table-bordered" id="destinationTable">
                        <thead>
                        <tr>
                            <th>Day</th>
                            <th>Name</th>
                            <th>Place</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="formEditItinerary">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit itinerary</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-12">
                                    Name Itinerary<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="name" id="nameEdit"
                                           placeholder="Name itinerary">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info" id="btnSubmitEdit">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            var itinerariesId = null;
            let tourId = $('#tourId').val();
            disableSubmitButton('#formAddItinerary');
            disableSubmitButton('#formEditItinerary');

            let datatable = $('#destinationTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                ajax: {
                    url: "{!! route('itineraries.data',$tourId) !!}",
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'place', name: 'place'},
                    {data: 'action', name: 'action'},
                ],
                drawCallback: function () {
                    $('.edit').click(function () {
                        itinerariesId = $(this).data('id');
                        let nameItineray = $('#itinerary-' + itinerariesId).children().eq(1).text();
                        $('#nameEdit').val(nameItineray);
                    });
                }
            });

            // Edit Itinerary
            $('#formEditItinerary').submit(function (e) {
                e.preventDefault();

                let name = $('#nameEdit').val();
                $.ajax({
                    url: '{{ route('itineraries.update', $tourId) }}',
                    method: "POST",
                    dataType: 'json',
                    data: {id: itinerariesId, name: name},
                    success: function (response) {
                        let type = response['alert-type'];
                        let message = response['message'];
                        toastrMessage(type, message);

                        if (type === 'success') {
                            datatable.draw();
                            $('#editModal').modal('hide');
                        }
                    },
                    error: function () {
                        toastrMessage('error', 'Itinerary update failed');
                    },
                    complete: function () {
                        enableSubmitButton('#formEditItinerary', 300);
                    }
                });
            });

            // Evenet Delete Itinerary
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                let link = $(this).attr("href");
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
                                success: function (response) {
                                    toastr.success('Itinerary deleted successfully');
                                    datatable.ajax.reload();
                                },
                                error: function (response) {
                                    toastr.error('Delete failed')
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
