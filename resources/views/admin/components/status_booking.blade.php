@if($status == 1)
    <span class="badge badge-pill badge-info">New</span>
@elseif($status == 2)
    <span class="badge badge-pill badge-success">Confirmed</span>
@elseif($status == 3)
    <span class="badge badge-pill badge-primary">Completed</span>
@elseif($status == 4)
    <span class="badge badge-pill badge-danger">Cancel</span>
@endif
