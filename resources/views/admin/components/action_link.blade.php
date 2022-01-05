<a href="{{ empty($linkEdit) ? 'javascript:void(0)' : $linkEdit }}"
   class="btn btn-success btn-sm rounded-0 text-white edit" title="Edit"
   data-toggle="tooltip" data-placement="top" data-id="{{ $id }}">
    <i class="fa fa-edit"></i>
</a>
<a href="{{ empty($linkDelete) ? 'javascript:void(0)' : $linkDelete }}"
   class="btn btn-danger btn-sm rounded-0 text-white delete" title="Delete"
   data-toggle="tooltip" data-placement="top" data-id="{{ $id }}">
    <i class="fa fa-trash"></i>
</a>
