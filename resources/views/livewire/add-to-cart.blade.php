<div class="d-flex align-items-center gap-2">
    <div class="qty-selector d-inline-flex align-items-center" style="border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background:#fff;">
        <button type="button" onclick="adjustAddToCartQty(-1)" class="btn btn-sm" style="padding: 6px 12px; background:#f8f9fa; color:#333; border-right:1px solid #ddd; font-weight:bold;">−</button>
        <input type="number" id="add-to-cart-qty" value="1" min="1" class="text-center" style="width: 55px; border: none; outline: none; padding: 6px; font-weight:600; color:#222; background:#fff;" />
        <button type="button" onclick="adjustAddToCartQty(1)" class="btn btn-sm" style="padding: 6px 12px; background:#f8f9fa; color:#333; border-left:1px solid #ddd; font-weight:bold;">+</button>
    </div>
    <button type="button" onclick="addToCartWithValidation()" class="btn add_cart" style="background:#2563eb;color:#fff;border-radius:999px;padding:10px 22px;font-weight:700;display:inline-flex;align-items:center;gap:8px;transition:all .2s ease;border:0;">
        <i class="fas fa-cart-plus"></i> Add to Cart
    </button>
</div>
