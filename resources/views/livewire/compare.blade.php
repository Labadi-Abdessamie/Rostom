<tbody>
    {{-- Product Images --}}
    <tr class="d-flex">
        <td>
            <p>Product Image</p>
        </td>
        @foreach ($this->items as $key => $product)
            <td class="wsus__compare_img">
                <img src="{{ asset('storage/products_images/' . $key . '/' . $product['image']) }}" alt="product"
                    class="img-fluid w-100">
            </td>
        @endforeach
    </tr>

    {{-- Product Names --}}
    <tr class="d-flex">
        <td>
            <p>Product Name</p>
        </td>
        @foreach ($this->items as $key => $product)
            <td class="wsus__compare_text">
                <p>{{ $product['name'] }}</p>
            </td>
        @endforeach
    </tr>
    {{-- rates --}}
    <tr class="d-flex">
        <td>
            <p>Rate</p>
        </td>
        @foreach ($this->items as $key => $product)
            <td class="wsus__compare_text">
                <p class="wsus__compare_rate">
                    @if ($product['rate'] != 0)
                        @for ($i = 1; $i <= $product['rate']; $i++)
                            <i class="fas fa-star "></i>
                        @endfor
                        @if ($product['rate'] != floor($product['rate']))
                            <i class="fas fa-star-half-alt"></i>
                        @endif
                    @else
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    @endif
            </td>
        @endforeach
    </tr>

    {{-- Prices --}}
    <tr class="d-flex">
        <td>
            <p>Price</p>
        </td>
        @foreach ($this->items as $key => $product)
            <td class="wsus__compare_text">
                <p class="wsus__compare_price">DZ {{ $product['price'] }}</p>
            </td>
        @endforeach
    </tr>

    {{-- Stock --}}
    <tr class="d-flex">
        <td>
            <p>Availability</p>
        </td>
        @foreach ($this->items as $key => $product)
            <td class="wsus__compare_text">
                @if ($product['actual_quantity'] > 0)
                    <span class="wsus__compare_stock">In Stock</span>
                @else
                    <span class="wsus__compare_stock_out">Out of Stock</span>
                @endif
            </td>
        @endforeach
    </tr>

    {{-- Add to Cart --}}
    <tr class="d-flex">
        <td>
            <p>Add to Cart</p>
        </td>
        @foreach ($this->items as $key => $product)
            <td class="wsus__compare_text">
                <button wire:click="addToCart({{ $key }})" class="btn add_cart">
                    Add to Cart
                </button>
            </td>
        @endforeach
    </tr>

    {{-- Remove --}}
    <tr class="d-flex">
        <td>
            <p>Remove</p>
        </td>
        @foreach ($this->items as $key => $product)
            <td class="wsus__compare_text wsus__del_area">
                <button wire:click="DeleteFromCompare({{ $key }})" class="btn wsus__compare_del">
                    <i class="far fa-times"></i>
                </button>
            </td>
        @endforeach
    </tr>
</tbody>
