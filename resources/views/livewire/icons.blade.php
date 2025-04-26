<ul class="wsus__icon_area">
    @if (Auth::check())
        @if (Auth::user()->role === 'client')
            <li><a href="{{ route('frontend.wishlist') }}"><i class="fal fa-heart"></i>
                    @if (session()->has('wishlist'))
                        <span>{{ count(session('wishlist', [])) }}</span>
                    @else
                        <span>0</span>
                    @endif
                </a></li>
        @endif
    @else
        <li><a href="{{ route('login') }}"><i class="fal fa-heart"></i><span>05</span></a></li>
    @endif
    <li><a href="{{ route('frontend.compare') }}"><i class="fal fa-random"></i>
            @if (session()->has('compare'))
                <span>{{ count(session('compare', [])) }}</span>
            @else
                <span>0</span>
            @endif
        </a>
    </li>
    @if (Auth::check())
        @if (Auth::user()->role === 'client')
            <li><a class="wsus__cart_icon cursor-pointer"><i class="fal fa-shopping-bag"></i>
                    @if (session()->has('cart'))
                        <span>{{ count(session('cart', [])) }}</span>
                    @else
                        <span>0</span>
                    @endif
                </a>
            </li>
        @endif
    @else
        <li><a class="wsus__cart_icon" href="{{ route('login') }}"><i class="fal fa-shopping-bag"></i><span>4</span></a>
        </li>
    @endif
</ul>
