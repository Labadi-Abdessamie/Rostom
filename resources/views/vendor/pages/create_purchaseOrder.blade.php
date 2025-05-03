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
                    <option value="{{ $product->id }}" data-name="{{ $product->name }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group d-none" id="quantityDiv">
            <label>Quantity</label>
            <input type="number" id="productQuantity" class="form-control" min="1">
            <button type="button" id="addProduct" class="btn btn-primary mt-2">Add to Order</button>
        </div>

        <hr>

        <h5>Products in Order</h5>
        <table class="table" id="orderTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price (DZ)</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-right">Total Amount (DZ):</th>
                    <th><span id="totalAmountDisplay">0</span></th>
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
    let products = [];

    document.getElementById('productSelect').addEventListener('change', function () {
        document.getElementById('quantityDiv').classList.remove('d-none');
        document.getElementById('productQuantity').value = '';
    });

    document.getElementById('addProduct').addEventListener('click', function () {
        let select = document.getElementById('productSelect');
        let productId = select.value;
        let productName = select.options[select.selectedIndex].dataset.name;
        let quantity = parseInt(document.getElementById('productQuantity').value);

        if (!productId || quantity <= 0) return;

        products.push({ id: productId, name: productName, quantity: quantity, unit_price: 0 });

        updateTable();
        select.selectedIndex = 0;
        document.getElementById('quantityDiv').classList.add('d-none');
    });

    function updateTable() {
        let tableBody = document.querySelector('#orderTable tbody');
        tableBody.innerHTML = '';

        products.forEach((product, index) => {
            let row = `<tr>
                <td>${index + 1}</td>
                <td>${product.name}</td>
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

        // Re-bind unit price inputs
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
