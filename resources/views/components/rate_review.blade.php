@for($i = 0; $i < 5; $i++)
    @if($i + 1 <= $rate)
        <i class="fa fa-star-fill fill-yellow"></i>
    @else
        <i class="fa fa-star fill-yellow"></i>
    @endif
@endfor
