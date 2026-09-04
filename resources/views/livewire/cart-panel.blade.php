{{-- Cart side panel — Livewire-driven. Toggled via .is-open on root. --}}
<div class="wsus__cart_panel_root {{ $isOpen ? 'is-open' : '' }}"
     id="wsusCartPanelRoot">

    {{-- Hidden controls for Livewire open/close --}}
    <button id="cartPanelOpenBtn" type="button" wire:click="open" aria-hidden="true" style="position:absolute;opacity:0;pointer-events:none;width:0;height:0;"></button>
    <button id="cartPanelCloseBtn" type="button" wire:click="close" aria-hidden="true" style="position:absolute;opacity:0;pointer-events:none;width:0;height:0;"></button>

    {{-- Backdrop --}}
    <div class="wsus__cart_panel_backdrop" data-cart-panel-close></div>

    {{-- Panel --}}
    <aside class="wsus__cart_panel" role="dialog" aria-modal="true" aria-label="Shopping cart">
        {{-- ===== Header ===== --}}
        <header class="wsus__cart_panel_header">
            <div class="wsus__cart_panel_title">
                <span class="wsus__cart_panel_icon">
                    <i class="fas fa-shopping-bag"></i>
                </span>
                <div>
                    <h4>Your Cart</h4>
                    <span class="wsus__cart_panel_count">
                        {{ $itemCount }} {{ $itemCount === 1 ? 'item' : 'items' }}
                    </span>
                </div>
            </div>
            <button type="button" class="wsus__cart_panel_close" data-cart-panel-close aria-label="Close cart">
                <i class="fas fa-times"></i>
            </button>
        </header>

        {{-- ===== Body: items ===== --}}
        <div class="wsus__cart_panel_body" wire:key="cart-panel-body">
            @if (count($cart) > 0)
            <ul class="wsus__cart_panel_list" style="list-style:none;padding:0;margin:0;">
            @forelse ($cart as $key => $item)
                <li class="wsus__cart_panel_item" wire:key="cart-item-{{ $key }}">
                    <a class="wsus__cart_panel_img" href="{{ route('frontend.product_details', ['id' => (int) $key]) }}">
                        <img src="{{ asset('storage/products_images/' . (int) $key . '/' . $item['product']['image']) }}"
                             alt="{{ $item['product']['name'] }}" loading="lazy">
                    </a>
                    <div class="wsus__cart_panel_info">
                        <a class="wsus__cart_panel_name" href="{{ route('frontend.product_details', ['id' => (int) $key]) }}">
                            {{ $item['product']['name'] }}
                        </a>
                        <div class="wsus__cart_panel_price_unit">
                            DZ {{ ($item["product"]["price"] ?? $item["product"]["base_price"] ?? 0) + ($item['extra_price'] ?? 0) }} <span>per unit</span>
                        </div>

                        {{-- Qty controls --}}
                        <div class="wsus__cart_panel_qty">
                            <button type="button" class="wsus__qty_btn"
                                    wire:click="decreaseQuantity('{{ $key }}')"
                                    {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                                    aria-label="Decrease quantity">
                                <i class="fas fa-minus"></i>
                            </button>
                            <span class="wsus__qty_value">{{ $item['quantity'] }}</span>
                            <button type="button" class="wsus__qty_btn"
                                    wire:click="increaseQuantity('{{ $key }}')"
                                    aria-label="Increase quantity">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="wsus__cart_panel_actions_col">
                        <div class="wsus__cart_panel_subtotal">
                            DZ {{ (($item["product"]["price"] ?? $item["product"]["base_price"] ?? 0) + ($item['extra_price'] ?? 0)) * $item['quantity'] }}
                        </div>
                        <button type="button" class="wsus__cart_panel_remove"
                                wire:click="DeleteFromCart('{{ $key }}')"
                                aria-label="Remove {{ $item['product']['name'] }}">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </li>
            @empty
            @endforelse
            </ul>
            @else
                <div class="wsus__cart_panel_empty">
                    <div class="wsus__cart_panel_empty_icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <h5>Your cart is empty</h5>
                    <p>Looks like you haven't added anything yet. Let's find something you love!</p>
                    <a href="{{ route('frontend.products') }}" class="common_btn" data-cart-panel-close>
                        <i class="fal fa-store me-2"></i> Start shopping
                    </a>
                </div>
            @endif
        </div>

        {{-- ===== Footer ===== --}}
        <footer class="wsus__cart_panel_footer">
            <div class="wsus__cart_panel_summary">
                <div class="wsus__cart_panel_row">
                    <span>Subtotal</span>
                    <strong>DZ {{ $subtotal }}</strong>
                </div>
                <div class="wsus__cart_panel_row wsus__cart_panel_row_muted">
                    <span><i class="fas fa-truck"></i> Delivery</span>
                    <span>calculated at checkout</span>
                </div>
            </div>

            <div class="wsus__cart_panel_actions">
                <a class="wsus__cart_panel_btn wsus__cart_panel_btn_ghost"
                   href="{{ route('frontend.cart') }}" data-cart-panel-close>
                    <i class="fas fa-shopping-bag"></i> View cart
                </a>
                <a class="wsus__cart_panel_btn wsus__cart_panel_btn_primary"
                   href="{{ route('frontend.check_out') }}" data-cart-panel-close>
                    Checkout <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            @if (count($cart) > 0)
                <button type="button" class="wsus__cart_panel_clear"
                        wire:click="ClearCart">
                    <i class="far fa-trash-alt"></i> Clear cart
                </button>
            @endif

            <div class="wsus__cart_panel_secure">
                <i class="fas fa-lock"></i> Secure checkout · Easy returns
            </div>
        </footer>
    </aside>
</div>
