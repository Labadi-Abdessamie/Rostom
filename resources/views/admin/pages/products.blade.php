@extends('admin.master')

@section('styles')
<style>
/* ── Product Card Grid ── */
.prd-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
}

.prd-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(30,27,75,.06);
    display: flex;
    flex-direction: column;
    position: relative;
    transition: transform .25s ease, box-shadow .25s ease;
    border: 1px solid #f1f5f9;
}
.prd-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(30,27,75,.12);
    border-color: #e2e8f0;
}

.prd-img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 1/1;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    overflow: hidden;
}

.prd-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .3s ease;
}
.prd-card:hover .prd-img {
    transform: scale(1.05);
}

.prd-badge-stock {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255,255,255,.95);
    color: #1e1b4b;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: .72rem;
    font-weight: 700;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    backdrop-filter: blur(4px);
}
.prd-badge-stock.low { color: #b45309; background: rgba(254,243,199,.97); }
.prd-badge-stock.out { color: #991b1b; background: rgba(254,226,226,.97); }

.prd-actions {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateX(8px);
    transition: opacity .2s, transform .2s;
}
.prd-card:hover .prd-actions {
    opacity: 1;
    transform: translateX(0);
}
.prd-action-btn {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,.97);
    color: #1e1b4b;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
    font-size: 1rem;
    transition: all .2s;
}
.prd-action-btn:hover { background: #4f46e5; color: #fff; }
.prd-action-btn.danger:hover { background: #e11d48; }

.prd-body {
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex: 1;
}

.prd-name {
    font-weight: 700;
    color: #1e1b4b;
    font-size: .95rem;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.5em;
}

.prd-store {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: .8rem;
    color: #64748b;
}
.prd-store i { color: #4f46e5; }

.prd-rating {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: .78rem;
}
.prd-rating .star { color: #f59e0b; }
.prd-rating .star.empty { color: #e2e8f0; }
.prd-rating .count { color: #94a3b8; margin-left: 4px; }

.prd-sold-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: .78rem;
    color: #64748b;
}
.prd-sold-wrap strong { color: #1e1b4b; }

.prd-sold-bar {
    height: 4px;
    background: #f1f5f9;
    border-radius: 999px;
    overflow: hidden;
    flex: 1;
    margin-left: 10px;
}
.prd-sold-fill {
    height: 100%;
    background: linear-gradient(90deg, #4f46e5, #7c3aed);
    border-radius: 999px;
    transition: width .5s ease;
}

.prd-bottom {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 12px;
    border-top: 1px solid #f1f5f9;
}
.prd-price {
    font-weight: 800;
    color: #4f46e5;
    font-size: 1.1rem;
}
.prd-price-label {
    font-size: .7rem;
    color: #94a3b8;
    font-weight: 500;
}

.prd-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 80px 20px;
    color: #64748b;
}
.prd-empty i { font-size: 4rem; opacity: .3; }

/* ── Category pill badges ── */
.prd-category {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 8px;
    background: #f1f5f9;
    border-radius: 6px;
    font-size: .7rem;
    color: #64748b;
}
</style>
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">

            <!-- Page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Products</h4>
                    </div>
                </div>
            </div>

            <!-- ── Advanced Filter Panel (matching vendors page style) ── -->
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ url()->current() }}" id="filterForm">
                        <div style="border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; background:#f8fafc;">
                            <div class="row g-3 align-items-end">

                                {{-- Text Search --}}
                                <div class="col-md-3 col-sm-6">
                                    <label class="form-label small fw-semibold text-muted mb-1">Search</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Product name or store..."
                                            value="{{ $search ?? '' }}">
                                    </div>
                                </div>

                                {{-- Stock Status --}}
                                <div class="col-md-2 col-sm-6">
                                    <label class="form-label small fw-semibold text-muted mb-1">Stock Status</label>
                                    <select name="stock_status" class="form-select">
                                        <option value="">All</option>
                                        <option value="in" {{ ($stockStatus ?? '') === 'in' ? 'selected' : '' }}>In Stock</option>
                                        <option value="low" {{ ($stockStatus ?? '') === 'low' ? 'selected' : '' }}>Low Stock</option>
                                        <option value="out" {{ ($stockStatus ?? '') === 'out' ? 'selected' : '' }}>Out of Stock</option>
                                    </select>
                                </div>

                                {{-- Category --}}
                                <div class="col-md-2 col-sm-6">
                                    <label class="form-label small fw-semibold text-muted mb-1">Category</label>
                                    <select name="category_id" class="form-select">
                                        <option value="">All Categories</option>
                                        @isset($categories)
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" {{ ($categoryId ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                {{-- Price From --}}
                                <div class="col-md-2 col-sm-6">
                                    <label class="form-label small fw-semibold text-muted mb-1">Min Price</label>
                                    <input type="number" name="price_from" class="form-control"
                                        placeholder="0" value="{{ $priceFrom ?? '' }}" min="0">
                                </div>

                                {{-- Price To --}}
                                <div class="col-md-2 col-sm-6">
                                    <label class="form-label small fw-semibold text-muted mb-1">Max Price</label>
                                    <input type="number" name="price_to" class="form-control"
                                        placeholder="Any" value="{{ $priceTo ?? '' }}" min="0">
                                </div>

                                {{-- Sort By --}}
                                <div class="col-md-2 col-sm-6">
                                    <label class="form-label small fw-semibold text-muted mb-1">Sort By</label>
                                    <div class="input-group">
                                        <select name="sort_by" class="form-select">
                                            <option value="created_at" {{ ($sortBy ?? 'created_at') === 'created_at' ? 'selected' : '' }}>Date Added</option>
                                            <option value="name" {{ ($sortBy ?? '') === 'name' ? 'selected' : '' }}>Name</option>
                                            <option value="price" {{ ($sortBy ?? '') === 'price' ? 'selected' : '' }}>Price</option>
                                            <option value="actual_quantity" {{ ($sortBy ?? '') === 'actual_quantity' ? 'selected' : '' }}>Stock</option>
                                            <option value="rate_average" {{ ($sortBy ?? '') === 'rate_average' ? 'selected' : '' }}>Rating</option>
                                        </select>
                                        <button type="button" class="btn btn-outline-secondary" id="sortDirToggle" title="Toggle order">
                                            <i class="mdi {{ ($sortDir ?? 'desc') === 'asc' ? 'mdi-sort-ascending' : 'mdi-sort-descending' }}"></i>
                                        </button>
                                    </div>
                                    <input type="hidden" name="sort_dir" id="sortDirInput" value="{{ $sortDir ?? 'desc' }}">
                                </div>

                                {{-- Actions --}}
                                <div class="col-md-3 col-sm-6 d-flex gap-2 align-items-end mt-3">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="mdi mdi-filter-variant me-1"></i> Apply Filters
                                    </button>
                                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary">
                                        <i class="mdi mdi-refresh"></i>
                                    </a>
                                </div>

                            </div>
                        </div>

                        {{-- Per Page + Results Count --}}
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2" id="perPageForm">
                                    <input type="hidden" name="search" value="{{ $search ?? '' }}">
                                    <input type="hidden" name="stock_status" value="{{ $stockStatus ?? '' }}">
                                    <input type="hidden" name="category_id" value="{{ $categoryId ?? '' }}">
                                    <input type="hidden" name="price_from" value="{{ $priceFrom ?? '' }}">
                                    <input type="hidden" name="price_to" value="{{ $priceTo ?? '' }}">
                                    <input type="hidden" name="sort_by" value="{{ $sortBy ?? 'created_at' }}">
                                    <input type="hidden" name="sort_dir" value="{{ $sortDir ?? 'desc' }}">
                                    <label class="text-muted small mb-0">Show</label>
                                    <select name="per_page" class="form-select form-select-sm" style="width:auto;" onchange="document.getElementById('perPageForm').submit()">
                                        <option value="12" {{ ($perPage ?? 12) == 12 ? 'selected' : '' }}>12</option>
                                        <option value="24" {{ ($perPage ?? 12) == 24 ? 'selected' : '' }}>24</option>
                                        <option value="48" {{ ($perPage ?? 12) == 48 ? 'selected' : '' }}>48</option>
                                        <option value="all" {{ ($perPage ?? 12) == 'all' ? 'selected' : '' }}>All</option>
                                    </select>
                                    <span class="text-muted small">per page</span>
                                </form>

                                @if($products->total() > 0)
                                    <span class="badge bg-light text-dark border">
                                        {{ $products->total() }} product{{ $products->total() == 1 ? '' : 's' }} found
                                    </span>
                                @endif
                            </div>
                        </div>
                    </form>

                    {{-- Products Grid --}}
                    <div class="prd-grid mt-3">
                        @forelse ($products as $product)
                            @php
                                $maxSold = $products->max('order_items_count') ?: 1;
                                $soldWidth = $maxSold > 0 ? ($product->order_items_count / $maxSold) * 100 : 0;
                                $imgPath = $product->principalImage
                                    ? asset('storage/products_images/' . $product->id . '/' . $product->principalImage)
                                    : asset('frontend/images/No_Image.png');
                            @endphp
                            <div class="prd-card">
                                {{-- Stock Badge --}}
                                @if ($product->actual_quantity <= 0)
                                    <span class="prd-badge-stock out">Out of stock</span>
                                @elseif ($product->actual_quantity < 5)
                                    <span class="prd-badge-stock low">Low: {{ $product->actual_quantity }}</span>
                                @else
                                    <span class="prd-badge-stock">{{ $product->actual_quantity }} in stock</span>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="prd-actions">
                                    <a href="{{ route('frontend.product_details', $product->id) }}" target="_blank" class="prd-action-btn" title="View">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.delete_product', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="prd-action-btn danger" title="Delete">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Product Image --}}
                                <div class="prd-img-wrap">
                                    <img src="{{ $imgPath }}" alt="{{ $product->name }}" class="prd-img">
                                </div>

                                {{-- Product Info --}}
                                <div class="prd-body">
                                    <div class="prd-name">{{ $product->name }}</div>

                                    <div class="prd-store">
                                        <i class="mdi mdi-store-outline"></i>
                                        <span>{{ $product->magasin->name ?? '—' }}</span>
                                    </div>

                                    {{-- Rating --}}
                                    <div class="prd-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="mdi {{ $i <= floor($product->rate_average) ? 'mdi-star' : 'mdi-star-outline' }} {{ $i <= floor($product->rate_average) ? 'star' : 'empty' }}"></i>
                                        @endfor
                                        <span class="count">({{ number_format($product->rate_average, 1) }})</span>
                                    </div>

                                    {{-- Sold Progress --}}
                                    <div class="prd-sold-wrap">
                                        <span>Sold: <strong>{{ $product->order_items_count }}</strong></span>
                                        <div class="prd-sold-bar">
                                            <div class="prd-sold-fill" style="width:{{ $soldWidth }}%;"></div>
                                        </div>
                                    </div>

                                    {{-- Price --}}
                                    <div class="prd-bottom">
                                        <div>
                                            <div class="prd-price">{{ number_format($product->price) }} DZD</div>
                                            <div class="prd-price-label">Price</div>
                                        </div>
                                        @if($product->category)
                                            <span class="prd-category">
                                                <i class="mdi mdi-tag-outline"></i>
                                                {{ $product->category->name ?? '' }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="prd-empty">
                                <i class="mdi mdi-package-variant-closed"></i>
                                <p class="mb-0 mt-3">No products found matching your filters.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if ($products->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                            <div class="text-muted" style="font-size:.85rem;">
                                Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                            </div>
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle sort direction button
    document.getElementById('sortDirToggle')?.addEventListener('click', function () {
        const input = document.getElementById('sortDirInput');
        const icon  = this.querySelector('i');
        const current = input.value;
        const next = current === 'asc' ? 'desc' : 'asc';
        input.value = next;
        icon.className = next === 'asc' ? 'mdi mdi-sort-ascending' : 'mdi mdi-sort-descending';
    });
</script>
@endpush
