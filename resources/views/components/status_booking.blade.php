@if($status == 1)
    <span class="badge badge-pill badge-info">Mới</span>
@elseif($status == 2)
    <span class="badge badge-pill badge-success">Xác nhận</span>
@elseif($status == 3)
    <span class="badge badge-pill badge-primary">Hoàn thành</span>
@elseif($status == 4)
    <span class="badge badge-pill badge-danger">Hủy</span>
@endif
