<div id="read-only-stars" title="regular">
    @for ($i = 0; $i < 5; $i++)
        @if($i < $rate)
            <img alt="{{ $i + 1 }}" src="{{ asset('/admins/assets/images/rating/star-on.png')  }}" title="regular">
        @else
            <img alt="{{ $i + 1 }}" src="{{ asset('/admins/assets/images/rating/star-off.png')  }}" title="regular">
        @endif
    @endfor
</div>
