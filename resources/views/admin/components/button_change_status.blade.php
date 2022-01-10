@if($status == 1)
    <button onclick="changeStatus('{{ $link }}', {{ $status }})"
            class="btn btn-success btn-sm rounded-0 text-white block">
        <i class="fa fa-arrow-up"></i>
    </button>
@else
    <button onclick="changeStatus('{{ $link }}', {{ $status }})"
            class="btn btn-danger btn-sm rounded-0 text-white block">
        <i class="fa fa-arrow-down"></i>
    </button>
@endif
