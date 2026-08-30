<ul class="wsus__icon_area">
    {{-- Wishlist --}}
    @if(Auth::check() && Auth::user()->role === 'client')
        <li>
            <a href="{{ route('frontend.wishlist') }}" title="Wishlist" class="wsus__icon_btn">
                <i class="far fa-heart"></i>
                <span class="wsus__icon_badge">{{ $wishlistCount }}</span>
            </a>
        </li>
    @else
        <li>
            <a href="{{ route('login') }}" title="Wishlist" class="wsus__icon_btn">
                <i class="far fa-heart"></i>
                <span class="wsus__icon_badge">0</span>
            </a>
        </li>
    @endif

    {{-- Compare --}}
    <li>
        <a href="{{ route('frontend.compare') }}" title="Compare" class="wsus__icon_btn">
            <i class="fas fa-balance-scale"></i>
            <span class="wsus__icon_badge">{{ $compareCount }}</span>
        </a>
    </li>

    {{-- Cart --}}
    @if(Auth::check() && Auth::user()->role === 'client')
        <li>
            <a href="{{ route('frontend.cart') }}" title="Cart" class="wsus__icon_btn">
                <i class="fas fa-shopping-cart"></i>
                <span class="wsus__icon_badge">{{ $cartCount }}</span>
            </a>
        </li>
    @else
        <li>
            <a href="{{ route('login') }}" title="Cart" class="wsus__icon_btn">
                <i class="fas fa-shopping-cart"></i>
                <span class="wsus__icon_badge">0</span>
            </a>
        </li>
    @endif
</ul>
