@extends('vendor.master')

@section('title', 'Vendor | Import Products')

@section('styles')
@endsection

@section('scripts')
<script>
    var finalCategoriesData = @json(collect($finalCategories)->map(fn($group) => $group->map(fn($c) => ['id' => $c->id, 'name' => $c->name])));

    function updateFinalCategories(subcatId) {
        var select = document.getElementById('subcategory_id');
        select.innerHTML = '<option value="">-- Select Category --</option>';
        var options = (subcatId && finalCategoriesData[subcatId]) ? finalCategoriesData[subcatId] : [];
        if (options.length > 0) {
            options.forEach(function(cat) {
                var opt = document.createElement('option');
                opt.value = cat.id;
                opt.text = cat.name;
                select.appendChild(opt);
            });
            document.getElementById('subcategory_wrapper').classList.remove('d-none');
        } else {
            document.getElementById('subcategory_wrapper').classList.add('d-none');
        }
        select.value = '';
    }
</script>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Bulk Import Products</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="{{ route('vendor.products') }}">Products</a></div>
            <div class="breadcrumb-item active">Import</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Before You Import</h5>
                        <p class="text-muted">Download the template first, fill it with your products, then upload it below.</p>
                        <a href="{{ route('vendor.download_product_template') }}" class="btn btn-success">Download Template</a>
                        <button type="button" onclick="openImportReminder()" class="btn btn-primary ml-2">Bulk Import</button>
                    </div>
                </div>
            </div>
        </div>

        <form id="importForm" action="{{ route('vendor.import_products') }}" method="POST" enctype="multipart/form-data" style="display:none;" class="mt-3">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>Step 1 — Choose Category</h5>
                            <p class="text-muted">All products in this file will be added to the selected category.</p>

                            <div class="form-group row mb-3">
                                <label class="col-form-label col-12 col-md-3">Subcategory</label>
                                <div class="col-sm-12 col-md-7">
                                    <select name="category_id" id="category_id" class="form-control" required onchange="updateFinalCategories(this.value)">
                                        <option value="">-- Select Subcategory --</option>
                                        @foreach ($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-4 d-none" id="subcategory_wrapper">
                                <label class="col-form-label col-12 col-md-3">Final Category</label>
                                <div class="col-sm-12 col-md-7">
                                    <select name="subcategory_id" id="subcategory_id" class="form-control">
                                        <option value="">-- Select Category --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>Step 2 — Upload CSV</h5>
                            <p class="text-muted">Use the <strong>Download Template</strong> button to get the correct format. No sample rows are included in the template.</p>
                            <div class="form-group mb-3">
                                <input type="file" name="file" accept=".csv,.txt" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload & Import</button>
                            <a href="{{ route('vendor.products') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Reminder Modal -->
<div id="importReminderModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1050; justify-content:center; align-items:center;">
    <div style="background:#fff; border-radius:8px; max-width:500px; width:90%; padding:20px; box-shadow:0 10px 30px rgba(0,0,0,0.3);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
            <h5 style="margin:0; color:#17a2b8;">Before Importing</h5>
            <button onclick="hideImportReminder()" style="background:none; border:none; font-size:24px; cursor:pointer;">&times;</button>
        </div>
        <div>
            <p><strong>You need the template to fill your products correctly.</strong></p>
            <ul>
                <li>Download the CSV template.</li>
                <li>Fill in <code>name</code> and <code>price</code> (required).</li>
                <li>Upload the filled file here.</li>
            </ul>
            <a href="{{ route('vendor.download_product_template') }}" class="btn btn-success btn-block mb-2">Download Template</a>
        </div>
        <div style="text-align:right;">
            <button onclick="hideImportReminder()" class="btn btn-secondary">Close</button>
            <button onclick="continueToImport()" class="btn btn-primary">I already have it — Continue</button>
        </div>
    </div>
</div>

<script>
    function openImportReminder() {
        var m = document.getElementById('importReminderModal');
        m.style.display = 'flex';
        m.style.animation = 'fadeIn 0.2s ease';
    }
    function hideImportReminder() {
        document.getElementById('importReminderModal').style.display = 'none';
    }
    function continueToImport() {
        hideImportReminder();
        document.getElementById('importForm').style.display = 'block';
        document.getElementById('importForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
</script>
@endsection
