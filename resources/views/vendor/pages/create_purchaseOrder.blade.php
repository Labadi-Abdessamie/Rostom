@extends('vendor.master')

@section('title', 'Create Purchase Order')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create Purchase Order</h1>
    </div>

    <form action="{{ route('vendor.purchase_orders.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="supplierName">Supplier Name</label>
            <input type="text" name="supplierName" id="supplierName" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="paymentStatus">Payment Status</label>
            <select name="paymentStatus" id="paymentStatus" class="form-control" required>
                <option value="" disabled selected>Select status</option>
                <option value="full">Full</option>
                <option value="partial">Partial</option>
                <option value="debt">Debt</option>
            </select>
        </div>

        <hr>

        <div class="form-group">
            <label>Select Product</label>
            <select id="productSelect" class="form-control">
                <option value="" disabled selected>Choose a product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-has-variants="{{ ($product->combinations && $product->combinations->count() > 0) ? '1' : '0' }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- VARIANT PRODUCTS: show combo list, then quantity input --}}
        <div class="form-group d-none" id="variantSelectDiv">
            <label>Select Variant (each is a separate line)</label>
            <select id="variantSelect" class="form-control">
                <option value="" disabled selected>Choose a variant</option>
            </select>
            <small class="text-muted">Select which variant you want to import, then enter how many to order.</small>
            <div class="form-group mt-2 d-none" id="variantQuantityDiv">
                <label>Quantity for this variant</label>
                <input type="number" id="variantQuantity" class="form-control" min="1" value="1">
                <button type="button" id="addVariantLine" class="btn btn-primary mt-2">Add Variant Line</button>
            </div>
        </div>

        {{-- DEFAULT PRODUCTS: quantity input --}}
        <div class="form-group d-none" id="quantityDiv">
            <label>Quantity</label>
            <input type="number" id="productQuantity" class="form-control" min="1">
            <button type="button" id="addProduct" class="btn btn-primary mt-2">Add to Order</button>
        </div>

        <hr>

        <h5>Products in Order</h5>
        <table class="table" id="orderTable" style="font-size:0.9rem;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Quantity</th>
                    <th>Unit Price (DZ)</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-right">Total Amount (DZ):</th>
                    <th><span id="totalAmountDisplay">0</span></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

        <input type="hidden" name="products_data" id="productsData">
        <input type="hidden" name="totalAmount" id="totalAmount">

        <button type="submit" class="btn btn-success">Submit Order</button>
    </form>
</section>
@endsection

@section('scripts')
<script>
    // Preload product data including combinations
    let productData = {};
    @foreach($products as $product)
        @php
            $_hasVariants = $product->combinations && $product->combinations->count() > 0;
            $_combos = $_hasVariants ? $product->combinations->map(function($c) {
                return [
                    'id' => $c->id,
                    'combination' => $c->combination,
                    'quantity' => $c->quantity,
                    'extra_price' => $c->extra_price,
                    'sku' => $c->sku,
                ];
            })->values() : [];
        @endphp
        productData[{{ $product->id }}] = {
            hasVariants: {{ $_hasVariants ? 'true' : 'false' }},
            combinations: @json($_combos)
        };
    @endforeach

    let products = [];
    let selectedVariantId = null;

    document.getElementById('productSelect').addEventListener('change', function () {
        let productId = this.value;
        let info = productData[productId] || { hasVariants: false, combinations: [] };
        let qtyDiv = document.getElementById('quantityDiv');
        let varDiv = document.getElementById('variantSelectDiv');
        let varSelect = document.getElementById('variantSelect');
        let varQtyDiv = document.getElementById('variantQuantityDiv');

        // Reset
        qtyDiv.classList.add('d-none');
        varDiv.classList.add('d-none');
        varQtyDiv.classList.add('d-none');
        document.getElementById('productQuantity').value = '';
        document.getElementById('variantQuantity').value = 1;
        varSelect.innerHTML = '<option value="" disabled selected>Choose a variant</option>';

        if (!productId) return;

        if (info.hasVariants) {
            // Show variant selector
            varDiv.classList.remove('d-none');
            info.combinations.forEach(function (combo) {
                let label = combo.combination ? Object.values(combo.combination).map(function (v) { return v; }).join(' / ') : 'Default';
                let opt = document.createElement('option');
                opt.value = JSON.stringify({ comboId: combo.id, comboData: combo.combination, comboQuantity: combo.quantity, comboExtra: combo.extra_price, comboSku: combo.sku });
                opt.text = label + ' (Stock: ' + combo.quantity + ')';
                varSelect.appendChild(opt);
            });
        } else {
            // Show quantity input for non-variant products
            qtyDiv.classList.remove('d-none');
        }
    });

    document.getElementById('variantSelect').addEventListener('change', function () {
        let val = this.value;
        if (!val) {
            document.getElementById('variantQuantityDiv').classList.add('d-none');
            return;
        }
        // Show the quantity input for the chosen variant
        document.getElementById('variantQuantityDiv').classList.remove('d-none');
        document.getElementById('variantQuantity').value = 1;
    });

    document.getElementById('addVariantLine').addEventListener('click', function () {
        let val = document.getElementById('variantSelect').value;
        let qty = parseInt(document.getElementById('variantQuantity').value);
        if (!val || qty <= 0) return;
        let data = JSON.parse(val);
        let select = document.getElementById('productSelect');
        let productName = select.options[select.selectedIndex].dataset.name;
        let comboLabel = data.comboData ? Object.entries(data.comboData).map(function (kv) { return kv[0] + ': ' + kv[1]; }).join(' / ') : 'Default';

        products.push({
            id: select.value,
            name: productName,
            variant_combination: data.comboData,
            combo_id: data.comboId,
            quantity: qty,
            combo_quantity: data.comboQuantity,
            combo_extra: data.comboExtra,
            combo_sku: data.comboSku,
            variant_label: comboLabel,
            unit_price: 0
        });

        updateTable();
        document.getElementById('variantSelect').selectedIndex = 0;
        document.getElementById('variantQuantityDiv').classList.add('d-none');
        document.getElementById('variantSelectDiv').classList.add('d-none');
        document.getElementById('productSelect').selectedIndex = 0;
    });

    document.getElementById('addProduct').addEventListener('click', function () {
        let select = document.getElementById('productSelect');
        let productId = select.value;
        let productName = select.options[select.selectedIndex].dataset.name;
        let quantity = parseInt(document.getElementById('productQuantity').value);

        if (!productId || quantity <= 0) return;

        products.push({ id: productId, name: productName, quantity: quantity, unit_price: 0, variant_combination: null, combo_id: null, combo_quantity: null, combo_extra: null, combo_sku: null, variant_label: null });

        updateTable();
        select.selectedIndex = 0;
        document.getElementById('quantityDiv').classList.add('d-none');
    });

    function updateTable() {
        let tableBody = document.querySelector('#orderTable tbody');
        tableBody.innerHTML = '';

        products.forEach((product, index) => {
            let variantCell = product.variant_label ? `<span class="badge badge-info">${product.variant_label}</span>` : '<span class="text-muted">—</span>';
            let row = `<tr>
                <td>${index + 1}</td>
                <td>${product.name}</td>
                <td>${variantCell}</td>
                <td>${product.quantity}</td>
                <td>
                    <input type="number" min="0" step="0.01" class="form-control unit-price-input" data-index="${index}" value="${product.unit_price}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeProduct(${index})">Remove</button>
                </td>
            </tr>`;
            tableBody.innerHTML += row;
        });

        document.querySelectorAll('.unit-price-input').forEach(input => {
            input.addEventListener('input', function () {
                const index = this.dataset.index;
                const value = parseFloat(this.value);
                products[index].unit_price = isNaN(value) ? 0 : value;
                updateTotal();
            });
        });

        updateTotal();
        document.getElementById('productsData').value = JSON.stringify(products);
    }

    function removeProduct(index) {
        products.splice(index, 1);
        updateTable();
    }

    function updateTotal() {
        let total = products.reduce((sum, product) => sum + (product.quantity * product.unit_price), 0);
        document.getElementById('totalAmountDisplay').innerText = total.toFixed(2);
        document.getElementById('totalAmount').value = total.toFixed(2);
        document.getElementById('productsData').value = JSON.stringify(products);
    }
</script>
@endsection
