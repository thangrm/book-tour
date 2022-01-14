<a href="{{ empty($link) ? 'javascript:void(0)' : $link }}"
   class="btn btn-info btn-modal text-white mt-1" {{ empty($width) ? '' : 'style=width:'.$width .'px' }}
   data-toggle="modal" data-target="#showModal" data-id="{{ $id }}">
    {{ $title }}
</a>

