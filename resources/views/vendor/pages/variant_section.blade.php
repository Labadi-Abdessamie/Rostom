<!-- Variants Section -->
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3">Variant Types</label>
    <div class="col-sm-12 col-md-7">
        <p class="text-muted small">Admin-defined types. Select which apply to this product.</p>

        {{-- Type selection (multi-select per type) --}}
        <div class="mb-3">
            @foreach (\App\Models\VariantType::orderBy('position')->get() as $vt)
                <div class="border rounded p-2 mb-2 bg-light" data-variant-type-id="{{ $vt->id }}">
                    <strong>{{ $vt->display_name }}</strong> ({{ $vt->type }})
                    <div class="mt-2">
                        @if ($vt->type === 'color_swatch' && $vt->options)
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @foreach ((is_array($vt->options) ? $vt->options : json_decode($vt->options, true)) as $opt)
                                    <button type="button"
                                        class="btn btn-sm color-swatch-btn rounded-circle border shadow-sm position-relative"
                                        style="width: 28px; height: 28px; background-color: {{ $opt }}; padding: 0;"
                                        onclick="toggleVariantOption(this, '{{ $opt }}', '{{ $vt->id }}', 'swatch')"
                                        title="{{ $opt }}"
                                        aria-label="{{ $opt }}"></button>
                                @endforeach
                            </div>
                        @else
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @php
                                    $opts = is_array($vt->options) ? $vt->options : (json_decode($vt->options, true) ?? []);
                                @endphp
                                @foreach ($opts as $opt)
                                    <button type="button"
                                        class="btn btn-sm btn-outline-secondary btn-sm variant-opt-btn"
                                        onclick="toggleVariantOption(this, '{{ $opt }}', '{{ $vt->id }}', 'text')"
                                        style="font-size: 0.85rem;">{{ $opt }}</button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="small text-muted">Select all that apply for this product.</div>
                </div>
            @endforeach
        </div>

        {{-- Generated combinations table --}}
        <div id="variant-combo-table" class="d-none">
            <h6 class="mb-2">Combinations (set qty/price for each)</h6>
            <table class="table table-sm table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Variant Combo</th>
                        <th>Quantity</th>
                        <th>Extra Price</th>
                        <th>SKU (optional)</th>
                    </tr>
                </thead>
                <tbody id="combo-body"></tbody>
            </table>
        </div>

        {{-- Hidden inputs to submit selections --}}
        <div id="hidden-combos"></div>
    </div>
</div>

<style>
.color-swatch-btn.active::after {
    content: '✓'; position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%) scale(1); color: white; font-weight: bold; font-size: 12px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.5); pointer-events: none; animation: checkIn 0.2s ease-out;
}
@keyframes checkIn {
    0%   { transform: translate(-50%, -50%) scale(0); opacity: 0; }
    100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
}
.variant-opt-btn.active {
    background-color: #0d6efd; color: #fff; border-color: #0d6efd;
}
</style>

<script>
var selectedOptions = {}; // { variantTypeId: [options] }

function toggleVariantOption(btn, value, vtId, mode) {
    if (!selectedOptions[vtId]) selectedOptions[vtId] = [];
    var arr = selectedOptions[vtId];
    var idx = arr.indexOf(value);
    if (idx >= 0) {
        arr.splice(idx, 1);
        btn.classList.remove('active');
    } else {
        arr.push(value);
        btn.classList.add('active');
    }
    generateCombinations();
}

function generateCombinations() {
    // Build Cartesian product of selected options per type
    var types = Object.keys(selectedOptions).filter(function(k){ return selectedOptions[k].length > 0; });
    if (types.length === 0) {
        document.getElementById('variant-combo-table').classList.add('d-none');
        document.getElementById('hidden-combos').innerHTML = '';
        // If variants deselected, restore base quantity field
        var qtyField = document.getElementById('actual_quantity');
        var baseHelp = document.getElementById('base-qty-help');
        if (qtyField) { qtyField.disabled = false; qtyField.value = qtyField.dataset.default || qtyField.value; }
        if (baseHelp) baseHelp.style.display = 'block';
        return;
    }

    // Get type names
    var typeNames = {};
    types.forEach(function(tid){
        var card = document.querySelector('[data-variant-type-id="'+tid+'"]');
        if (card) typeNames[tid] = card.querySelector('strong').innerText.trim();
    });

    // Recursive cartesian
    function cartesian(arrays) {
        return arrays.reduce(function(a,b){ return a.flatMap(function(d){ return b.map(function(e){ return d.concat([e]); }); }); }, [[]]);
    }

    var arrays = types.map(function(tid){ return selectedOptions[tid]; });
    // Pair with type ids
    var combos = cartesian(arrays);

    var tbody = document.getElementById('combo-body');
    tbody.innerHTML = '';
    var hiddenHtml = '';

    combos.forEach(function(combo, i){
        // combo is array of option values; need to map to type ids by order of types array
        var row = document.createElement('tr');
        var comboLabel = types.map(function(tid, idx){ return (typeNames[tid] || 'Type') + ': ' + combo[idx]; }).join(' / ');

        // Build JSON for hidden input
        var comboObj = {};
        types.forEach(function(tid, idx){ comboObj[typeNames[tid] || tid] = combo[idx]; });

        row.innerHTML = '<td>' + comboLabel + '</td>' +
            '<td><input type="number" name="combinations['+i+'][quantity]" class="form-control form-control-sm" value="0" min="0" /></td>' +
            '<td><input type="number" step="0.01" name="combinations['+i+'][extra_price]" class="form-control form-control-sm" value="0" /></td>' +
            '<td><input type="text" name="combinations['+i+'][sku]" class="form-control form-control-sm" placeholder="SKU" /></td>';
        tbody.appendChild(row);

        hiddenHtml += '<input type="hidden" name="combinations['+i+'][combination]" value="' + JSON.stringify(comboObj).replace(/"/g, '&quot;') + '" />';
    });

    document.getElementById('hidden-combos').innerHTML = hiddenHtml;
    document.getElementById('variant-combo-table').classList.remove('d-none');
}
</script>
