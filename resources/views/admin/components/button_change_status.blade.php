@if($isBlock)
    <button onclick="changeStatus('{{ $link }}')" class="btn btn-danger btn-sm rounded-0 text-white block">
        <i class="fa fa-arrow-down"></i>
    </button>
@else
    <button onclick="changeStatus('{{ $link }}')" class="btn btn-success btn-sm rounded-0 text-white block">
        <i class="fa fa-arrow-up"></i>
    </button>
@endif
