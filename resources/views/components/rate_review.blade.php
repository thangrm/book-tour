@for($i = 0; $i < 5; $i++)
    @if($i + 1 <= $rate)
        <i class="bi bi-star-fill fill-yellow"></i>
    @else
        <i class="bi bi-star fill-yellow"></i>
    @endif
@endfor
