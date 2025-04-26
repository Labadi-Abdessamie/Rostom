<span class="spinner d-flex">
    <span wire:click="decrease()" class="sub">-</span>
    <input type="number" class="form-control text-center" min="1" max="100" value="{{ $quantity }}"
        style="width:40%" readonly>
    <span wire:click="increase()" class="add">+</span>
</span>
