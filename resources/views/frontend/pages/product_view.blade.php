@extends('frontend.master')

@section('title')
    {{ $website->name }} || Product List
@endsection

@section('content')
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>products</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href>products</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->

    <!--============================
        PRODUCT PAGE START
    ==============================-->
    <section id="wsus__product_page" class="wsus__vendors">
        <div class="container">
            <div class="row">

                {{-- ═══ SIDEBAR FILTER ═══ --}}
                <div class="col-xl-3 col-lg-4 d-none d-lg-block" style="max-width:280px; flex:0 0 280px;">
                    <div class="collapse d-lg-block" id="productFilters" style="position:sticky;top:20px;">
                        <form method="GET" action="{{ route('frontend.products') }}" id="filterForm">
                            <div class="wsus__product_sidebar wsus__vendor_sidebar" style="border:1px solid #e8eaf0; border-radius:14px; padding:18px; background:#fff; box-shadow:0 2px 12px rgba(0,0,0,.04);">

                                <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                    <i class="fas fa-search me-1"></i> Search
                                </h5>
                                <div class="input-group mb-3">
                                    <input type="text" name="query" class="form-control" placeholder="Product name..."
                                        value="{{ $queryFilter ?? '' }}">
                                </div>

                                <h5 class="mb-2 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                    <i class="fas fa-tags me-1"></i> Category
                                </h5>
                                <select name="category" class="form-control mb-3" style="border-radius:8px; border:1px solid #e2e8f0; font-size:.85rem;">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ (request('category') ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <h5 class="mb-2 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                    <i class="fas fa-dollar-sign me-1"></i> Price Range
                                </h5>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <input type="number" name="min" class="form-control" placeholder="Min DZD" min="0" value="{{ $min ?? '' }}" style="font-size:.85rem; border-radius:8px;">
                                </div>
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <input type="number" name="max" class="form-control" placeholder="Max DZD" min="0" value="{{ $max ?? '' }}" style="font-size:.85rem; border-radius:8px;">
                                </div>

                                <h5 class="mb-2 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                    <i class="fas fa-sort me-1"></i> Sort By
                                </h5>
                                <select name="sort" class="form-control mb-3" style="border-radius:8px; border:1px solid #e2e8f0; font-size:.85rem;">
                                    <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Default sorting</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Sort by Rating</option>
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Price Low to High</option>
                                    <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>Price High to Low</option>
                                </select>

                                <h5 class="mb-2 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                    <i class="fas fa-th me-1"></i> Show
                                </h5>
                                <select name="number" class="form-control mb-3" style="border-radius:8px; border:1px solid #e2e8f0; font-size:.85rem;">
                                    <option value="12" {{ (request('number') ?? 12) == 12 ? 'selected' : '' }}>12 per page</option>
                                    <option value="18" {{ (request('number') ?? 12) == 18 ? 'selected' : '' }}>18 per page</option>
                                    <option value="24" {{ (request('number') ?? 12) == 24 ? 'selected' : '' }}>24 per page</option>
                                </select>

                                <div class="d-flex gap-2 mt-2">
                                    <button type="submit" class="btn btn-primary flex-grow-1" style="border-radius:8px; font-weight:600; font-size:.85rem; padding:8px 12px;">
                                        <i class="fas fa-filter me-1"></i> Apply
                                    </button>
                                    <a href="{{ route('frontend.products') }}" class="btn btn-outline-secondary" style="border-radius:8px; padding:8px 12px;">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ═══ PRODUCTS GRID ═══ --}}
                <div class="col-xl-9 col-lg-8" style="padding-left:10px; max-width:100%; flex:1;">

                    {{-- Mobile filter button above cards --}}
                    <button class="wsus__sidebar_filter d-lg-none w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#productFiltersMobile" aria-expanded="false" aria-controls="productFiltersMobile" style="background: linear-gradient(135deg,#4f46e5,#7c3aed); color:#fff; font-weight:700; border:none; padding:10px 16px; border-radius:10px; font-size:.9rem;">
                        <i class="fas fa-sliders-h me-2"></i> Filters
                    </button>

                    {{-- Mobile dropdown --}}
                    <div class="collapse d-lg-none mb-3" id="productFiltersMobile" style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px; box-shadow:0 4px 12px rgba(0,0,0,.05);">
                        <form method="GET" action="{{ route('frontend.products') }}">
                            <div class="input-group mb-2"><input type="text" name="query" class="form-control form-control-sm" placeholder="Search..." value="{{ $queryFilter ?? '' }}"></div>
                            <select name="category" class="form-select form-select-sm mb-2"><option value="">All Categories</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ (request('category') ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select>
                            <div class="row mb-2">
                                <div class="col-6"><input type="number" name="min" class="form-control form-control-sm" placeholder="Min DZD" value="{{ $min ?? '' }}"></div>
                                <div class="col-6"><input type="number" name="max" class="form-control form-control-sm" placeholder="Max DZD" value="{{ $max ?? '' }}"></div>
                            </div>
                            <select name="sort" class="form-select form-select-sm mb-2">
                                <option value="">Default</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Low to High</option>
                                <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>High to Low</option>
                            </select>
                            <div class="d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="fas fa-filter me-1"></i>Apply</button><a href="{{ route('frontend.products') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a></div>
                        </form>
                    </div>

                    {{-- Top bar --}}
                    <div class="wsus__product_topbar d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                        <p class="mb-0 text-muted" style="font-size:.875rem;">
                            Showing <strong>{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong>
                            of <strong>{{ $products->total() }}</strong> product{{ $products->total() == 1 ? '' : 's' }}
                        </p>
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted mb-0" style="font-size:.8rem;">Sort:</label>
                            <form method="GET" id="topbarSortForm" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="query" value="{{ $queryFilter ?? '' }}">
                                <input type="hidden" name="category" value="{{ request('category') ?? '' }}">
                                <input type="hidden" name="min" value="{{ $min ?? '' }}">
                                <input type="hidden" name="max" value="{{ $max ?? '' }}">
                                <input type="hidden" name="number" value="{{ request('number') ?? 12 }}">
                                <select name="sort" class="form-select form-select-sm" style="width:auto;"
                                        onchange="document.getElementById('topbarSortForm').submit()">
                                    <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Default</option>
                                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Low → High</option>
                                    <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>High → Low</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    {{-- Active filter chips --}}
                    @if($queryFilter || request('category') || $min || $max)
                        <div class="mb-3 d-flex flex-wrap gap-2">
                            @if($queryFilter)
                                <span class="badge bg-primary d-flex align-items-center gap-1 px-3 py-2">
                                    <i class="fas fa-search"></i> "{{ $queryFilter }}"
                                    <a href="{{ route('frontend.products', array_filter([
                                        'category' => request('category') ?? null,
                                        'sort' => request('sort') ?? null,
                                        'min' => $min ?? null,
                                        'max' => $max ?? null,
                                        'number' => request('number') ?? null,
                                    ])) }}" class="text-white text-decoration-none ms-1 fw-bold">&times;</a>
                                </span>
                            @endif
                            @if(request('category'))
                                <span class="badge bg-info d-flex align-items-center gap-1 px-3 py-2">
                                    <i class="fas fa-tag"></i> {{ $categories->firstWhere('id', request('category'))?->name ?? 'Category' }}
                                    <a href="{{ route('frontend.products', array_filter([
                                        'query' => $queryFilter ?? null,
                                        'sort' => request('sort') ?? null,
                                        'min' => $min ?? null,
                                        'max' => $max ?? null,
                                        'number' => request('number') ?? null,
                                    ])) }}" class="text-white text-decoration-none ms-1 fw-bold">&times;</a>
                                </span>
                            @endif
                            @if($min || $max)
                                <span class="badge bg-warning text-dark d-flex align-items-center gap-1 px-3 py-2">
                                    <i class="fas fa-dollar-sign"></i> {{ $min ? $min.' DZD' : '0' }} – {{ $max ? $max.' DZD' : '∞' }}
                                    <a href="{{ route('frontend.products', array_filter([
                                        'query' => $queryFilter ?? null,
                                        'category' => request('category') ?? null,
                                        'sort' => request('sort') ?? null,
                                        'number' => request('number') ?? null,
                                    ])) }}" class="text-dark text-decoration-none ms-1 fw-bold">&times;</a>
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- Products Grid --}}
                    <div class="row" id="productsGrid">
                        @forelse($products as $product)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                <div class="wsus__product_item product-card"
                                     data-product-url="{{ route('frontend.product_details', ['id' => $product->id]) }}">
                                    {{-- Image --}}
                                    <div class="product-card__img-wrap">
                                        @if($product->principalImage)
                                            <img src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                                 alt="{{ $product->name }}"
                                                 class="img-fluid w-100 product-card__img">
                                        @else
                                            <img src="{{ asset('frontend/images/No_Image.png') }}"
                                                 alt="No image"
                                                 class="img-fluid w-100 product-card__img">
                                        @endif
                                        <div class="product-card__overlay">
                                            <div class="product-card__icon-row">
                                                <span class="cursor-pointer" title="Quick View" onclick="event.stopPropagation()">
                                                    <i class="far fa-eye"></i>
                                                </span>
                                                <span class="cursor-pointer" onclick="event.stopPropagation()">
                                                    @livewire('add-to-wishlist', ['product' => $product], key('wish-'.$product->id))
                                                </span>
                                                <span class="cursor-pointer" onclick="event.stopPropagation()">
                                                    @livewire('add-to-compare', ['productId' => $product->id])
                                                </span>
                                            </div>
                                        </div>
                                        @if($product->actual_quantity <= 0)
                                            <span class="product-card__badge product-card__badge--out">Out of stock</span>
                                        @elseif($product->actual_quantity < 5)
                                            <span class="product-card__badge product-card__badge--low">Low stock</span>
                                        @endif
                                    </div>

                                    {{-- Body --}}
                                    <div class="product-card__body">
                                        <span class="product-card__category">
                                            {{ $product->category->name ?? 'Uncategorized' }}
                                        </span>

                                        <div class="product-card__rating">
                                            @if($product->rate_average > 0)
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= floor($product->rate_average) ? 'star-filled' : 'star-empty' }}"></i>
                                                @endfor
                                                <span class="product-card__rating-count">({{ $product->rate_count ?? 0 }})</span>
                                            @else
                                                <i class="far fa-star star-empty"></i>
                                                <i class="far fa-star star-empty"></i>
                                                <i class="far fa-star star-empty"></i>
                                                <i class="far fa-star star-empty"></i>
                                                <i class="far fa-star star-empty"></i>
                                                <span class="product-card__rating-count">(0)</span>
                                            @endif
                                        </div>

                                        <span class="product-card__name">{{ $product->name }}</span>

                                        <div class="product-card__price-row">
                                            <span class="product-card__price">{{ number_format($product->price) }} DZD</span>
                                        </div>

                                        @if($product->actual_quantity > 0)
                                            <div onclick="event.stopPropagation()">
                                                @livewire('add-to-cart', ['product' => $product->id], key('cart-'.$product->id))
                                            </div>
                                        @else
                                            <button class="product-card__oos-btn" onclick="event.stopPropagation()">Out of Stock</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No products found</h5>
                                    <p class="text-muted">Try adjusting your filters or
                                        <a href="{{ route('frontend.products') }}">browse all products</a>.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($products->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!--============================
        PRODUCT PAGE END
    ==============================-->
@endsection

@push('styles')
<style>
    /* ── Product Card ── */
    a.product-card-link { text-decoration: none; display: block; }
    a.product-card-link:hover .product-card {
        box-shadow: 0 10px 28px rgba(0,0,0,.10);
        transform: translateY(-3px);
    }
    .product-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e8eaf0;
        transition: box-shadow .25s ease, transform .25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card__img-wrap {
        position: relative;
        aspect-ratio: 1/1;
        overflow: hidden;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }
    .product-card__img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s ease;
    }
    .product-card:hover .product-card__img {
        transform: scale(1.07);
    }

    .product-card__overlay {
        position: absolute;
        inset: 0;
        background: rgba(30,27,75,.35);
        opacity: 0;
        transition: opacity .25s;
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    .product-card:hover .product-card__overlay { opacity: 1; pointer-events: auto; }
    .product-card__overlay .product-card__icon-row { pointer-events: auto; }

    .product-card__icon-row {
        display: flex;
        gap: 8px;
    }
    .product-card__icon-row a,
    .product-card__icon-row > span {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255,255,255,.95);
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .9rem;
        text-decoration: none;
        transition: background .2s, color .2s, transform .2s;
        backdrop-filter: blur(4px);
        cursor: pointer;
    }
    .product-card__icon-row a:hover,
    .product-card__icon-row > span:hover,
    .product-card__icon-row > span:hover a,
    .product-card__icon-row > span a:hover {
        background: #4f46e5;
        color: #fff;
        transform: translateY(-2px);
    }
    .product-card__icon-row > span a {
        display: inline-flex; align-items: center; justify-content: center;
        width: 38px; height: 38px; border-radius: 50%;
        background: rgba(255,255,255,.95); color: #1e293b;
        font-size: .9rem; text-decoration: none;
        transition: background .2s, color .2s, transform .2s;
        backdrop-filter: blur(4px); cursor: pointer;
    }

    .product-card__badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: .7rem;
        font-weight: 700;
        backdrop-filter: blur(4px);
    }
    .product-card__badge--out {
        background: rgba(254,226,226,.95);
        color: #991b1b;
    }
    .product-card__badge--low {
        background: rgba(254,243,199,.95);
        color: #92400e;
    }

    .product-card__body {
        padding: 14px;
        display: flex;
        flex-direction: column;
        flex: 1;
        gap: 6px;
    }

    .product-card__category {
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .05em;
        color: #64748b;
        text-decoration: none;
        transition: color .2s;
    }
    .product-card__category:hover { color: #4f46e5; }

    .product-card__rating {
        display: flex;
        align-items: center;
        gap: 2px;
    }
    .product-card__rating .star-filled { color: #f59e0b; font-size: .7rem; }
    .product-card__rating .star-empty { color: #e2e8f0; font-size: .7rem; }
    .product-card__rating-count {
        font-size: .7rem;
        color: #94a3b8;
        margin-left: 4px;
    }

    .product-card__name {
        font-size: .9rem;
        font-weight: 700;
        color: #1e293b;
        text-decoration: none;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        transition: color .2s;
    }
    .product-card__name:hover { color: #4f46e5; }

    .product-card__price-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: auto;
    }
    .product-card__price {
        font-size: 1rem;
        font-weight: 800;
        color: #4f46e5;
    }

    .product-card__oos-btn {
        width: 100%;
        padding: 8px 12px;
        border-radius: 8px;
        border: none;
        background: #f1f5f9;
        color: #64748b;
        font-weight: 600;
        font-size: .85rem;
        cursor: not-allowed;
        margin-top: 4px;
    }

    /* ── Sidebar filter styles ── */
    .wsus__sidebar_filter {
        cursor: pointer;
        padding: 10px 16px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-weight: 600;
        color: #475569;
        font-size: .9rem;
    }
    .wsus__sidebar_filter:hover { background: #f1f5f9; }
    .wsus__product_sidebar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
    }
    .wsus__vendor_sidebar_select h5 { margin-bottom: 12px !important; }
    .wsus__product_topbar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 16px;
    }

    /* ── Mobile adjustments ── */
    @media (max-width: 991px) {
        #productFilters {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }
    }
    @media (max-width: 575px) {
        .product-card__img-wrap { aspect-ratio: 1/1; }
    }
    .product-card { cursor: pointer; position: relative; }
    .product-card .product-card__overlay { pointer-events: none; }
    .product-card:hover .product-card__overlay { pointer-events: auto; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.product-card[data-product-url]').forEach(function(card) {
            card.style.cursor = 'pointer';
            card.addEventListener('click', function(e) {
                // Don't navigate if clicking buttons (Add to Cart, OOS, wishlist, compare)
                if (e.target.closest('button, [wire\\:click], .cursor-pointer')) {
                    return;
                }
                window.location.href = card.getAttribute('data-product-url');
            });
        });
    });
</script>
@endpush
