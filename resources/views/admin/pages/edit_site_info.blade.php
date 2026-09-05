@extends('admin.master')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title">{{ isset($info) ? 'Edit Statistic' : 'Add Statistic' }}</h4>
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.site_info') }}">Site Statistics</a></li>
                <li class="breadcrumb-item active">{{ isset($info) ? 'Edit' : 'Add' }}</li>
            </ol>
        </div>

        @php
            // Refresh live counts from real tables every time the form opens
            \App\Models\SiteInfo::refreshLiveStats();

            // Predefined stat definitions
            $predefined = [
                'total_vendors'   => ['label'=>'Active Vendors',        'labelText'=>'Active Vendors',        'icon'=>'fas fa-store',            'locked'=>true],
                'total_products'  => ['label'=>'Products Listed',      'labelText'=>'Products Listed',      'icon'=>'fas fa-box',              'locked'=>true],
                'total_members'   => ['label'=>'Team Members',          'labelText'=>'Team Members',          'icon'=>'fas fa-users',            'locked'=>true],
                'total_wilayas'  => ['label'=>'Wilayas',               'labelText'=>'Wilayas',               'icon'=>'fas fa-map',              'locked'=>false],
                'total_orders'   => ['label'=>'Orders Placed',         'labelText'=>'Orders Placed',         'icon'=>'fas fa-shopping-cart',    'locked'=>true],
                'total_reviews'  => ['label'=>'Customer Reviews',      'labelText'=>'Customer Reviews',      'icon'=>'fas fa-star',             'locked'=>true],
                'total_customers'=> ['label'=>'Registered Customers',  'labelText'=>'Registered Customers',  'icon'=>'fas fa-user',             'locked'=>true],
            ];

            // Fetch actual DB values for each predefined key
            $siteInfos = \App\Models\SiteInfo::whereIn('key', array_keys($predefined))
                ->pluck('value', 'key');

            // Merge DB values into predefined so JS gets real data
            foreach ($predefined as $k => &$cfg) {
                $cfg['dbValue'] = $siteInfos->get($k, '');
            }
            unset($cfg);

            $currentKey    = old('key', $info->key ?? '');
            $currentLocked = isset($predefined[$currentKey]) ? $predefined[$currentKey]['locked'] : false;
            $predefJson    = json_encode($predefined);
        @endphp

        <div class="row">
            <div class="col-lg-7">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form
                            action="{{ isset($info) ? route('admin.site_info.update', $info->id) : route('admin.site_info.store') }}"
                            method="POST">
                            @csrf
                            @if(isset($info)) @method('PUT') @endif

                            <div class="mb-3">
                                <label for="key" class="form-label">Statistic Type <span class="text-danger">*</span></label>
                                <select name="key" id="key" class="form-select" required>
                                    <option value="">— Select predefined type —</option>
                                    @foreach($predefined as $k => $cfg)
                                        <option
                                            value="{{ $k }}"
                                            data-locked="{{ $cfg['locked'] ? '1' : '0' }}"
                                            data-db-value="{{ $cfg['dbValue'] }}"
                                            data-icon="{{ $cfg['icon'] }}"
                                            data-label="{{ $cfg['labelText'] }}"
                                            {{ $currentKey === $k ? 'selected' : '' }}>
                                            {{ $cfg['label'] }} ({{ $k }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Choose a statistic. Locked ones pull their value automatically from the database.</small>
                                @error('key') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="alert alert-light border d-flex align-items-center gap-2" style="font-size:.88rem;">
                                <i class="fas fa-info-circle text-primary"></i>
                                <span>The <strong>value</strong> is automatically pulled from the database — updated every 24 hours. No manual entry needed.</span>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="label" class="form-label">Label <span class="text-danger">*</span></label>
                                        <input type="text" name="label" id="label" class="form-control"
                                            value="{{ old('label', $info->label ?? '') }}"
                                            placeholder="e.g. Active Vendors" required maxlength="100"
                                            {{ ($currentLocked ?? false) ? 'readonly' : '' }}>
                                        @error('label') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="icon" class="form-label">Icon (FontAwesome class)</label>
                                        <input type="text" name="icon" id="icon" class="form-control"
                                            value="{{ old('icon', $info->icon ?? '') }}"
                                            placeholder="e.g. fas fa-store">
                                        <small class="text-muted">e.g. <code>fas fa-store</code>, <code>fas fa-box</code></small>
                                        @error('icon') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">Sort Order</label>
                                        <input type="number" name="sort_order" id="sort_order" class="form-control"
                                            value="{{ old('sort_order', $info->sort_order ?? 0) }}" min="0">
                                        @error('sort_order') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label d-block">Visibility</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_visible" name="is_visible"
                                                value="1" {{ old('is_visible', $info->is_visible ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_visible">Show on About page</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <a href="{{ route('admin.site_info') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save"></i> {{ isset($info) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Preview</h5>
                    </div>
                    <div class="card-body">
                        <div id="statPreview" class="p-3 rounded-3 text-center" style="background:#f8fafc; border:1px dashed #cbd5e1;">
                            <i id="previewIcon" class="fas fa-chart-bar mb-2 d-block" style="font-size:1.5rem; color:#4338ca;"></i>
                            <h3 id="previewValue" class="mb-1" style="color:#1e293b;">{{ old('value', $info->value ?? '') ?: '—' }}</h3>
                            <small id="previewLabel" class="text-muted">{{ old('label', $info->label ?? 'Label') ?: 'Label' }}</small>
                        </div>
                        <p class="text-muted mt-2 mb-0" style="font-size:.8rem;">Value auto-updated from the database.</p>
                    </div>
                </div>

                <div class="alert alert-warning mt-3" style="font-size:.85rem;">
                    <i class="fas fa-sync-alt me-1"></i>
                    <strong>Auto-updated every 24h.</strong> The value shown here reflects the latest sync from real database tables.
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const predefined = {!! $predefJson !!};

    const keySelect   = document.getElementById('key');
    const labelInput  = document.getElementById('label');
    const iconInput   = document.getElementById('icon');

    const previewValue = document.getElementById('previewValue');
    const previewLabel = document.getElementById('previewLabel');
    const previewIcon  = document.getElementById('previewIcon');

    function applyState(cfg) {
        if (!cfg) return;

        // Always show the live DB value in the preview
        previewValue.textContent = cfg.dbValue || '—';

        if (cfg.locked) {
            // Locked: label/icon also come from config (read-only feel)
            labelInput.value = cfg.labelText || '';
            iconInput.value  = cfg.icon || '';
            labelInput.readOnly  = true;
            iconInput.readOnly   = true;
            labelInput.style.cursor = 'not-allowed';
            iconInput.style.cursor  = 'not-allowed';
        } else {
            // Unlocked (total_wilayas): admin can edit
            labelInput.readOnly  = false;
            iconInput.readOnly   = false;
            labelInput.style.cursor = '';
            iconInput.style.cursor  = '';
        }
    }

    function updatePreview() {
        previewLabel.textContent = labelInput.value || 'Label';
        previewIcon.className = iconInput.value || 'fas fa-chart-bar';
    }

    keySelect.addEventListener('change', function () {
        const cfg = predefined[this.value];
        applyState(cfg);
        updatePreview();
    });

    labelInput.addEventListener('input', updatePreview);
    iconInput.addEventListener('input', updatePreview);

    // Initialize on page load
    applyState(predefined[keySelect.value]);
</script>
@endpush
@endsection
