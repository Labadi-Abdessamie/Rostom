<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="wsus__cart_list wishlist">
                <div class="table-responsive">
                    @if ($wishlist == [])
                        <div class="col-xl-12">
                            <div class="wsus__cart_list cart_empty p-3 p-sm-5 text-center">
                                <p class="mb-4">your wishlist is empty</p>
                                <a href="{{ route('frontend.products') }}" class="common_btn"><i
                                        class="fal fa-store me-2"></i>view our products</a>
                            </div>
                        </div>
                    @else
                        <table>
                            <tbody>
                                <tr class="d-flex">
                                    <th class="wsus__pro_img">
                                        product item
                                    </th>

                                    <th class="wsus__pro_name">
                                        product details
                                    </th>

                                    <th class="wsus__pro_status">
                                        status
                                    </th>

                                    <th class="wsus__pro_select">
                                        quantity
                                    </th>

                                    <th class="wsus__pro_tk">
                                        price
                                    </th>

                                    <th class="wsus__pro_icon">
                                        action
                                    </th>
                                </tr>

                                @foreach ($wishlist as $key => $item)
                                    <tr class="d-flex">
                                        <td class="wsus__pro_img">
                                            <img src="{{ asset('frontend/images/pro9_9.jpg') }}" alt="product"
                                                class="img-fluid w-100">
                                            <button wire:click="DeleteFromWishlist({{ $key }})" class="">
                                                <i class="far fa-times"></i>
                                            </button>
                                        </td>

                                        <td class="wsus__pro_name">
                                            <p>
                                                <a href="{{ route('frontend.product_details', ['id' => $key]) }}">
                                                    {{ $item['product']['name'] }}
                                                </a>
                                            </p>
                                            @if (false)
                                                <span>color: red</span>
                                                <span>size: XL</span>
                                            @endif
                                        </td>

                                        <td class="wsus__pro_status">
                                            <p>
                                                @if ($item['product']['actual_quantity'] > 0)
                                                    in stock
                                                @else
                                                    out of stock
                                                @endif
                                            </p>
                                        </td>

                                        <td class="wsus__pro_select">
                                            <form class="select_number d-flex">
                                                @livewire('update-quantity', ['type' => 'wishlist', 'id' => $key, 'qt' => $item['quantity']], key($key))
                                                {{--
                                                    <input class="number_area" type="number" min="1" max="100"
                                                    value="{{ $item['quantity'] }}" />
                                                --}}
                                            </form>
                                        </td>

                                        <td class="wsus__pro_tk">
                                            <h6>DZ {{ ($item['product']['price'] ?? $item['product']['base_price'] ?? 0) * ($item['quantity'] ?? 1) }}</h6>
                                        </td>

                                        <td class="wsus__pro_icon">
                                            <button wire:click="addToCart({{ $key }},{{ $item['quantity'] }})"
                                                class="common_btn">
                                                Add to Cart
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
