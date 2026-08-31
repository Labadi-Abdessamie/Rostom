@extends('admin.master')

@section('styles')
<style>
.prd-toolbar {
    display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
    background: #fff; border-radius: 14px; padding: 14px 18px;
    box-shadow: 0 4px 16px rgba(30,27,75,.06);
    margin-bottom: 18px;
}
.prd-search { flex: 1; min-width: 220px; max-width: 420px; }
.prd-toolbar .input-group-text { background: #f8fafc; border-right: 0; }
.prd-toolbar .form-control { border-left: 0; box-shadow: none !important; }
.prd-toolbar .form-control:focus { border-color: #4f46e5; }

.prd-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 16px;
}
.prd-card {
    background: #fff; border-radius: 14px; overflow: hidden;
    box-shadow: 0 4px 16px rgba(30,27,75,.07);
    display: flex; flex-direction: column; position: relative;
    transition: transform .2s ease, box-shadow .2s ease;
}
.prd-card:hover { transform: translateY(-3px); box-shadow: 0 12px 28px rgba(30,27,75,.12); }

.prd-img {
    width: 100%; aspect-ratio: 1/1; object-fit: cover;
    background: #f4f5fb;
}
.prd-body { padding: 12px 14px 14px; display: flex; flex-direction: column; gap: 6px; }
.prd-name {
    font-weight: 700; color: #1e1b4b; font-size: .95rem;
    line-height: 1.25; min-height: 2.5em; max-height: 2.5em;
    overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
}
.prd-meta { font-size: .78rem; color: #64748b; display: flex; align-items: center; gap: 6px; }
.prd-meta i { color: #f59e0b; }
.prd-bottom {
    margin-top: auto; display: flex; align-items: center; justify-content: space-between;
    padding-top: 8px; border-top: 1px solid #f1f5f9;
}
.prd-price { font-weight: 800; color: #4f46e5; font-size: 1rem; }
.prd-old { font-size: .8rem; color: #94a3b8; margin-left: 4px; }
.prd-badge-stock {
    position: absolute; top: 10px; left: 10px;
    background: rgba(255,255,255,.95); color: #1e1b4b;
    padding: 3px 10px; border-radius: 999px; font-size: .7rem; font-weight: 700;
    box-shadow: 0 2px 6px rgba(0,0,0,.1);
}
.prd-badge-stock.low { color: #b45309; background: #fef3c7; }
.prd-badge-stock.out { color: #991b1b; background: #fee2e2; }
.prd-actions {
    position: absolute; top: 10px; right: 10px;
    display: flex; gap: 6px; opacity: 0; transition: opacity .2s;
}
.prd-card:hover .prd-actions { opacity: 1; }
.prd-action-btn {
    width: 32px; height: 32px; border-radius: 8px; border: none;
    display: inline-flex; align-items: center; justify-content: center;
    background: #fff; color: #1e1b4b; cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,.12); font-size: .9rem;
}
.prd-action-btn:hover { background: #4f46e5; color: #fff; }
.prd-action-btn.danger:hover { background: #e11d48; }

.prd-sold-bar {
    height: 4px; background: #f1f5f9; border-radius: 999px; overflow: hidden;
    margin-top: 4px;
}
.prd-sold-fill {
    height: 100%; background: linear-gradient(90deg, #4f46e5, #7c3aed);
    border-radius: 999px;
}
.prd-empty {
    grid-column: 1 / -1; text-align: center; padding: 60px 20px;
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

            <!-- Toolbar -->
            <form method="GET" action="{{ url()->current() }}" class="prd-toolbar">
                <div class="input-group prd-search">
                    <span class="input-group-text"><i class="mdi mdi-magnify"></i></span>
                    <input type="text" name="search" class="form-control"
                        placeholder="Search by product name or magasin..."
                        value="{{ request('search') }}">
                </div>

                <select name="per_page" class="form-select" style="width:auto;" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 / page</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 / page</option>
                    <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>All</option>
                </select>

                <button type="submit" class="btn btn-primary"><i class="mdi mdi-filter-variant me-1"></i>Apply</button>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>

                <div class="ms-auto text-muted" style="font-size:.85rem;">
                    <strong>{{ $totalProducts }}</strong> total products
                </div>
            </form>

            <!-- Products grid -->
            <div class="prd-grid">
                @forelse ($products as $product)
                    @php
                        $maxSold = $products->max('order_items_count') ?: 1;
                        $soldWidth = $maxSold > 0 ? ($product->order_items_count / $maxSold) * 100 : 0;
                        $imgPath = $product->principalImage
                            ? asset('storage/products_images/' . $product->id . '/' . $product->principalImage)
                            : asset('frontend/images/No_Image.png');
                    @endphp
                    <div class="prd-card">
                        @if ($product->actual_quantity <= 0)
                            <span class="prd-badge-stock out">Out of stock</span>
                        @elseif ($product->actual_quantity < 5)
                            <span class="prd-badge-stock low">Low: {{ $product->actual_quantity }}</span>
                        @else
                            <span class="prd-badge-stock">In stock: {{ $product->actual_quantity }}</span>
                        @endif

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

                        <img src="{{ $imgPath }}" alt="{{ $product->name }}" class="prd-img">

                        <div class="prd-body">
                            <div class="prd-name">{{ $product->name }}</div>

                            <div class="prd-meta">
                                <i class="mdi mdi-store-outline"></i>
                                <span>{{ $product->magasin->name ?? '—' }}</span>
                            </div>

                            <div class="prd-meta">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fa{{ $i < floor($product->rate_average) ? ' fa-star' : ' fa-star-o' }}"></i>
                                @endfor
                                <span style="color:#94a3b8;">({{ number_format($product->rate_average, 1) }})</span>
                            </div>

                            <div class="prd-meta" style="color:#64748b;">
                                <span>Sold: <strong style="color:#1e1b4b;">{{ $product->order_items_count }}</strong></span>
                            </div>
                            <div class="prd-sold-bar">
                                <div class="prd-sold-fill" style="width:{{ $soldWidth }}%;"></div>
                            </div>

                            <div class="prd-bottom">
                                <div>
                                    <span class="prd-price">{{ number_format($product->price) }} DZD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="prd-empty">
                        <i class="mdi mdi-package-variant-closed" style="font-size:3rem;opacity:.4;"></i>
                        <p class="mb-0 mt-2">No products found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted" style="font-size:.85rem;">
                        Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }}
                    </div>
                    {{ $products->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
