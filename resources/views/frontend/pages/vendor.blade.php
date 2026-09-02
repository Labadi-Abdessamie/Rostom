@extends('frontend.master')

@section('title', "$website->name || Vendors")

@section('content')

    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>Vendors</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">Home</a></li>
                            <li><a href="#">Vendors</a></li>
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
        VENDORS START
    ==============================-->
    <section id="wsus__product_page" class="wsus__vendors">
        <div class="container">
            <div class="row">

                {{-- ═══ SIDEBAR FILTER ═══ --}}
                <div class="col-xl-3 col-lg-4 d-none d-lg-block" style="max-width:280px; flex:0 0 280px;">

                    <div class="collapse d-lg-block" id="vendorFilters" style="position:sticky;top:20px;">
                        <form method="GET" action="{{ route('frontend.vendor') }}" id="filterForm">

                            <div class="wsus__product_sidebar wsus__vendor_sidebar" id="sticky_sidebar">
                                <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                    <i class="fas fa-search me-1"></i> Search
                                </h5>
                                <div class="input-group mb-3">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Vendor name or location..." value="{{ $name ?? '' }}">
                                </div>

                                <div class="wsus__vendor_sidebar_select">
                                    <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                        <i class="fas fa-tags me-1"></i> Category
                                    </h5>
                                    <select name="category" class="form-control mb-3">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ ($categoryId ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="wsus__vendor_sidebar_select">
                                    <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                        <i class="fas fa-star me-1"></i> Min Rating
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach([0, 1, 2, 3, 4, 5] as $r)
                                            <a href="{{ route('frontend.vendor', array_filter(array_merge(request()->query(), ['min_rating' => $r]))) }}"
                                               class="btn btn-sm rating-filter-btn {{ ($minRating ?? 0) == $r ? 'btn-primary' : 'btn-outline-secondary' }}"
                                               style="text-decoration:none; font-weight:600; font-size:.8rem; padding:5px 12px; border-radius:20px;">
                                                @if($r == 0) All
                                                @else <i class="fas fa-star text-warning me-1"></i>{{ $r }}+
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="wsus__vendor_sidebar_select mt-3">
                                    <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                        <i class="fas fa-sort me-1"></i> Sort By
                                    </h5>
                                    <select name="sort_by" class="form-control mb-3">
                                        <option value="default"     {{ ($sortBy ?? 'default') === 'default'    ? 'selected' : '' }}>Featured</option>
                                        <option value="rating_high" {{ ($sortBy ?? '') === 'rating_high'     ? 'selected' : '' }}>Highest Rated</option>
                                        <option value="rating_low"  {{ ($sortBy ?? '') === 'rating_low'       ? 'selected' : '' }}>Lowest Rated</option>
                                        <option value="latest"     {{ ($sortBy ?? '') === 'latest'          ? 'selected' : '' }}>Newest First</option>
                                        <option value="oldest"     {{ ($sortBy ?? '') === 'oldest'          ? 'selected' : '' }}>Oldest First</option>
                                        <option value="name_asc"   {{ ($sortBy ?? '') === 'name_asc'        ? 'selected' : '' }}>Name (A–Z)</option>
                                        <option value="name_desc"  {{ ($sortBy ?? '') === 'name_desc'       ? 'selected' : '' }}>Name (Z–A)</option>
                                    </select>
                                </div>

                                <div class="wsus__vendor_sidebar_select">
                                    <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                        <i class="fas fa-th me-1"></i> Show
                                    </h5>
                                    <select name="per_page" class="form-control">
                                        <option value="12" {{ ($perPage ?? 12) == 12 ? 'selected' : '' }}>12 per page</option>
                                        <option value="18" {{ ($perPage ?? 12) == 18 ? 'selected' : '' }}>18 per page</option>
                                        <option value="24" {{ ($perPage ?? 12) == 24 ? 'selected' : '' }}>24 per page</option>
                                        <option value="48" {{ ($perPage ?? 12) == 48 ? 'selected' : '' }}>48 per page</option>
                                    </select>
                                </div>

                                <div class="d-flex gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary flex-grow-1">
                                        <i class="fas fa-filter me-1"></i> Apply
                                    </button>
                                    <a href="{{ route('frontend.vendor') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ═══ VENDOR GRID ═══ --}}
                <div class="col-xl-9 col-lg-8" style="padding-left:10px; max-width:100%; flex:1;">

                    {{-- Mobile filter button above cards --}}
                    <button class="wsus__sidebar_filter d-lg-none w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#vendorFiltersMobile" aria-expanded="false" aria-controls="vendorFiltersMobile" style="background: linear-gradient(135deg,#f59e0b,#ef4444); color:#fff; font-weight:700; border:none; padding:8px 12px; border-radius:8px; font-size:.9rem;">
                        <i class="fas fa-sliders-h me-2"></i> Filters
                    </button>

                    <!-- Mobile dropdown -->
                    <div class="collapse d-lg-none mb-3" id="vendorFiltersMobile" style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px; box-shadow:0 4px 12px rgba(0,0,0,.05);">
                        <form method="GET" action="{{ route('frontend.vendor') }}">
                            <div class="input-group mb-2"><input type="text" name="name" class="form-control form-control-sm" placeholder="Search..." value="{{ $name ?? '' }}"></div>
                            <select name="category" class="form-select form-select-sm mb-2"><option value="">All Categories</option>@foreach($categories as $c)<option value="{{ $c->id }}" {{ ($categoryId ?? '') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>@endforeach</select>
                            <select name="sort_by" class="form-select form-select-sm mb-2"><option value="default" {{ ($sortBy ?? 'default')=='default'?'selected':'' }}>Featured</option><option value="rating_high" {{ ($sortBy ?? '')=='rating_high'?'selected':'' }}>Highest Rated</option></select>
                            <div class="d-flex gap-2"><button type="submit" class="btn btn-primary btn-sm flex-grow-1"><i class="fas fa-filter me-1"></i>Apply</button><a href="{{ route('frontend.vendor') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-times"></i></a></div>
                        </form>
                    </div>

                    {{-- Top bar (desktop) --}}
                    <div class="wsus__product_topbar d-none d-lg-flex justify-content-between align-items-center mb-4">
                        <p class="mb-0 text-muted" style="font-size:.875rem;">
                            Showing <strong>{{ $vendors->firstItem() ?? 0 }}–{{ $vendors->lastItem() ?? 0 }}</strong>
                            of <strong>{{ $totalVendors }}</strong> vendor{{ $totalVendors == 1 ? '' : 's' }}
                        </p>
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted mb-0" style="font-size:.8rem;">Sort:</label>
                            <form method="GET" id="topbarSortForm" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="name"       value="{{ $name ?? '' }}">
                                <input type="hidden" name="category"   value="{{ $categoryId ?? '' }}">
                                <input type="hidden" name="min_rating" value="{{ $minRating ?? 0 }}">
                                <input type="hidden" name="per_page"   value="{{ $perPage ?? 12 }}">
                                <select name="sort_by" class="form-select form-select-sm" style="width:auto;"
                                        onchange="document.getElementById('topbarSortForm').submit()">
                                    <option value="default"     {{ ($sortBy ?? 'default') === 'default'    ? 'selected' : '' }}>Featured</option>
                                    <option value="rating_high" {{ ($sortBy ?? '') === 'rating_high'     ? 'selected' : '' }}>Highest Rated</option>
                                    <option value="rating_low"  {{ ($sortBy ?? '') === 'rating_low'       ? 'selected' : '' }}>Lowest Rated</option>
                                    <option value="latest"     {{ ($sortBy ?? '') === 'latest'          ? 'selected' : '' }}>Newest First</option>
                                    <option value="oldest"     {{ ($sortBy ?? '') === 'oldest'          ? 'selected' : '' }}>Oldest First</option>
                                    <option value="name_asc"   {{ ($sortBy ?? '') === 'name_asc'        ? 'selected' : '' }}>Name (A–Z)</option>
                                    <option value="name_desc"  {{ ($sortBy ?? '') === 'name_desc'       ? 'selected' : '' }}>Name (Z–A)</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    {{-- Active filter chips --}}
                    @if($name || $categoryId || ($minRating ?? 0) > 0)
                        <div class="mb-3 d-flex flex-wrap gap-2">
                            @if($name)
                                <span class="badge bg-primary d-flex align-items-center gap-1 px-3 py-2">
                                    <i class="fas fa-search"></i> "{{ $name }}"
                                    <a href="{{ route('frontend.vendor', array_filter([
                                        'category'   => $categoryId ?? null,
                                        'sort_by'    => $sortBy ?? null,
                                        'min_rating' => $minRating ?? null,
                                        'per_page'   => $perPage ?? null,
                                    ])) }}" class="text-white text-decoration-none ms-1 fw-bold">&times;</a>
                                </span>
                            @endif
                            @if($categoryId)
                                <span class="badge bg-info d-flex align-items-center gap-1 px-3 py-2">
                                    <i class="fas fa-tag"></i> {{ $categories->firstWhere('id', $categoryId)?->name ?? 'Category' }}
                                    <a href="{{ route('frontend.vendor', array_filter([
                                        'name'       => $name ?? null,
                                        'sort_by'    => $sortBy ?? null,
                                        'min_rating' => $minRating ?? null,
                                        'per_page'   => $perPage ?? null,
                                    ])) }}" class="text-white text-decoration-none ms-1 fw-bold">&times;</a>
                                </span>
                            @endif
                            @if(($minRating ?? 0) > 0)
                                <span class="badge bg-warning text-dark d-flex align-items-center gap-1 px-3 py-2">
                                    <i class="fas fa-star"></i> {{ $minRating }}+ stars
                                    <a href="{{ route('frontend.vendor', array_filter([
                                        'name'     => $name ?? null,
                                        'category' => $categoryId ?? null,
                                        'sort_by'  => $sortBy ?? null,
                                        'per_page' => $perPage ?? null,
                                    ])) }}" class="text-dark text-decoration-none ms-1 fw-bold">&times;</a>
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- Vendors Grid --}}
                    <div class="row">
                        @forelse($vendors as $vendor)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 mb-4">
                                <div class="vendor-card">
                                    {{-- Cover image --}}
                                    <div class="vendor-card__cover">
                                        <a href="{{ route('frontend.vendor_details', ['id' => $vendor->id]) }}">
                                            <img src="{{ $vendor->magasinPicture
                                                ? asset('storage/magasins_images/' . $vendor->id . '/' . $vendor->magasinPicture)
                                                : asset('frontend/images/vendor_details_banner.jpg') }}"
                                                 alt="{{ $vendor->name }}"
                                                 onerror="this.onerror=null;this.src='{{ asset('frontend/images/vendor_details_banner.jpg') }}';">
                                            <div class="vendor-card__overlay"></div>
                                        </a>
                                        @if($vendor->rate > 0)
                                            <div class="vendor-card__rating">
                                                <i class="fas fa-star"></i> {{ number_format($vendor->rate, 1) }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Body --}}
                                    <div class="vendor-card__body">
                                        <div class="vendor-card__avatar">{{ strtoupper(mb_substr($vendor->name, 0, 1)) }}</div>
                                        <h5 class="vendor-card__title">
                                            <a href="{{ route('frontend.vendor_details', ['id' => $vendor->id]) }}">
                                                {{ $vendor->name }}
                                            </a>
                                        </h5>

                                        @if($vendor->location)
                                            <p class="vendor-card__location">
                                                <i class="fas fa-map-marker-alt"></i> {{ $vendor->location }}
                                            </p>
                                        @endif

                                        <div class="vendor-card__meta">
                                            <div class="vendor-card__meta-item">
                                                <i class="fas fa-star"></i> {{ number_format($vendor->rate, 1) }} / 5
                                            </div>
                                            <div class="vendor-card__divider"></div>
                                            <div class="vendor-card__meta-item">
                                                <i class="fas fa-comments"></i> {{ $vendor->rate_count ?? 0 }} reviews
                                            </div>
                                        </div>

                                        <div class="vendor-card__contact-row">
                                            @if($vendor->phoneNumber)
                                                <span><i class="fas fa-phone-alt me-1 text-primary"></i> {{ $vendor->phoneNumber }}</span>
                                            @endif
                                            @if($vendor->email)
                                                <span class="vendor-card__email" title="{{ $vendor->email }}"><i class="fas fa-envelope me-1 text-primary"></i> {{ $vendor->email }}</span>
                                            @endif
                                        </div>

                                        <a href="{{ route('frontend.vendor_details', ['id' => $vendor->id]) }}"
                                           class="vendor-card__btn">
                                            <span style="color:#fff;font-weight:900;">Visit Store</span>
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-store-slash fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No vendors found</h5>
                                    <p class="text-muted">Try adjusting your filters or
                                        <a href="{{ route('frontend.vendor') }}">browse all vendors</a>.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    @if($vendors->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $vendors->appends(request()->query())->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!--============================
        VENDORS END
    ==============================-->
@endsection

<style>
    .vendor-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e8eaf0;
        transition: box-shadow .25s ease, transform .25s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .vendor-card:hover {
        box-shadow: 0 10px 28px rgba(0,0,0,.10);
        transform: translateY(-3px);
    }
    .vendor-card__cover {
        position: relative;
        height: 200px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .vendor-card__cover a {
        display: block;
        height: 100%;
    }
    .vendor-card__cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .35s ease;
    }
    .vendor-card:hover .vendor-card__cover img {
        transform: scale(1.07);
    }
    .vendor-card__overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,.5) 0%, rgba(0,0,0,.05) 60%, transparent 100%);
        pointer-events: none;
    }
    .vendor-card__rating {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255,255,255,.92);
        color: #f59e0b;
        border-radius: 20px;
        padding: 3px 9px;
        font-size: .75rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 3px;
        backdrop-filter: blur(4px);
    }
    .vendor-card__avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: #fff;
        font-size: 1.6rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 4px solid #fff;
        box-shadow: 0 3px 12px rgba(0,0,0,.22);
        margin: -50px auto 12px;
        position: relative;
        z-index: 10;
    }
    .vendor-card__body {
        padding: 0 14px 14px;
        display: flex;
        flex-direction: column;
        flex: 1;
        text-align: center;
    }
    .vendor-card__title {
        font-size: .95rem;
        font-weight: 700;
        margin: 0 0 4px;
        line-height: 1.3;
        text-align: center;
    }
    .vendor-card__title a {
        color: #1e293b;
        text-decoration: none;
        transition: color .2s;
    }
    .vendor-card__title a:hover { color: #6366f1; }
    .vendor-card__location {
        font-size: .9rem;
        color: #94a3b8;
        margin: 0 0 10px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .vendor-card__location i { color: #ef4444; font-size: .8rem; }
    .vendor-card__meta {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
        justify-content: center;
    }
    .vendor-card__meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .75rem;
        color: #64748b;
    }
    .vendor-card__meta-item i { color: #f59e0b; font-size: .7rem; }
    .vendor-card__divider {
        width: 1px;
        height: 12px;
        background: #e2e8f0;
    }
    .vendor-card__contact-row {
        font-size: .78rem;
        color: #64748b;
        margin-bottom: 12px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .vendor-card__contact-row span { display: flex; align-items: center; gap: 6px; justify-content: center; word-break: break-word; font-size: .78rem; }
    .vendor-card__email { white-space: normal !important; word-break: break-word; font-size: .75rem; }
    .vendor-card__contact a {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .75rem;
        text-decoration: none;
        transition: background .2s, color .2s;
    }
    .vendor-card__contact a:hover { background: #6366f1; color: #fff; }
    .vendor-card__btn {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: linear-gradient(90deg, #08C 0%, #0077cc 100%);
        color: #fff;
        border-radius: 8px;
        padding: 14px 22px;
        font-size: 1rem;
        font-weight: 800;
        letter-spacing: .03em;
        text-decoration: none;
        transition: background .2s, transform .2s, box-shadow .2s;
        border: none;
    }
    .vendor-card__btn:hover {
        background: #0070bb;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,136,204,.3);
    }
    .vendor-card__btn i { font-size: .72rem; transition: transform .2s; }
    .vendor-card__btn:hover i { transform: translateX(3px); }
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
    .rating-filter-btn { font-size: .8rem; padding: 4px 10px; border-radius: 20px; }
    @media (max-width: 575px) {
        .vendor-card__cover { height: 160px; }
        .vendor-card__avatar { width: 56px; height: 56px; font-size: 1.2rem; margin-top: -30px; }
        .vendor-card__body { padding: 0 10px 10px; }
    }
    @media (max-width: 991px) {
        #vendorFilters {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }
    }
</style>

