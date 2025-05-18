<div class="wsus__mini_cart">
    <h4>shopping cart <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
    <ul>
        @if ($cart != [])
            @php $total = 0 @endphp
            @foreach ($cart as $key => $item)
                <li>
                    <div class="wsus__cart_img">
                        <a href="{{ route('frontend.product_details', ['id' => $key]) }}"><img
                                src="{{ asset('storage/products_images/' . $key . '/' . $item['product']['image']) }}"
                                alt="product" class="img-fluid w-100"></a>
                        <a wire:click="DeleteFromCart({{ $key }})" class="wsis__del_icon cursor-pointer">
                            <i class="fas fa-minus-circle"></i>
                        </a>
                    </div>
                    <div class="wsus__cart_text">
                        <a class="wsus__cart_title" href="{{ route('frontend.product_details', ['id' => $key]) }}">
                            {{ $item['product']['name'] }} </a>
                        <span> × {{ $item['quantity'] }}</span>
                        <p>DZ {{ $item['product']['price'] }}
                            @if (false)
                                <del>DZ 150</del>
                            @endif
                        </p>
                    </div>
                </li>
                @php $total += $item['product']['price'] * $item['quantity']; @endphp
            @endforeach
        @else
        @endif
    </ul>
    <h5>sub total <span>
            @if (@empty($cart))
                DZ 0
            @else
                DZ {{ $total }}
            @endif
        </span></h5>
    <div class="wsus__minicart_btn_area">
        <a class="common_btn" href="{{ route('frontend.cart') }}">view cart</a>
        <a class="common_btn" href="{{ route('frontend.check_out') }}">checkout</a>
    </div>
</div>
