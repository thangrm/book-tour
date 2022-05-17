@extends('layouts.admin')
@section('admin')
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="formEditDeposit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Thanh toán / cọc</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="text-left control-label col-form-label">
                                Số tiền<span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" min="0" class="form-control" name="deposit" id="deposit"
                                       value="{{ $booking->deposit }}" placeholder="Số tiền">
                            </div>
                            <p class="text-danger" id="errorDeposit"></p>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-info" id="btnSubmitDeposit">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
