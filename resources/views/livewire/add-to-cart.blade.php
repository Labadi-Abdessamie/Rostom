<div class="d-flex align-items-center gap-2">
    <div class="qty-selector d-inline-flex align-items-center" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
        <button type="button" onclick="adjustAddToCartQty(-1)" class="btn btn-sm" style="padding: 4px 10px;">−</button>
        <input type="number" id="add-to-cart-qty" value="1" min="1" class="text-center" style="width: 50px; border: none; outline: none; padding: 4px;" />
        <button type="button" onclick="adjustAddToCartQty(1)" class="btn btn-sm" style="padding: 4px 10px;">+</button>
    </div>
    <button type="button" onclick="addToCartWithValidation()" class="btn add_cart">
        Add to Cart
    </button>
</div>
