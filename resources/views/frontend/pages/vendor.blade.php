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
                <div class="col-xl-3 col-lg-4">

                    {{-- Mobile toggle --}}
                    <button class="wsus__sidebar_filter d-lg-none w-100 mb-3"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#vendorFilters"
                            aria-expanded="false"
                            aria-controls="vendorFilters">
                        <i class="fas fa-sliders-h me-2"></i> Filters
                    </button>

                    {{-- Filter card --}}
                    <div class="collapse d-lg-block" id="vendorFilters">
                        <form method="GET" action="{{ route('frontend.vendor') }}" id="filterForm">

                            {{-- Search --}}
                            <div class="wsus__product_sidebar wsus__vendor_sidebar" id="sticky_sidebar">
                                <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                    <i class="fas fa-search me-1"></i> Search
                                </h5>
                                <div class="input-group mb-3">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Vendor name..."
                                        value="{{ $name ?? '' }}">
                                </div>

                                {{-- Category Filter --}}
                                <div class="wsus__vendor_sidebar_select">
                                    <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                        <i class="fas fa-tags me-1"></i> Category
                                    </h5>
                                    <select name="category" class="form-select select_2 mb-3" id="categorySelect">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ ($categoryId ?? '') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Rating Filter --}}
                                <div class="wsus__vendor_sidebar_select">
                                    <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                        <i class="fas fa-star me-1"></i> Min Rating
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach([0, 3, 4, 4.5] as $r)
                                            <button type="button"
                                                    class="btn btn-sm rating-filter-btn {{ ($minRating ?? 0) == $r ? 'btn-primary' : 'btn-outline-secondary' }}"
                                                    data-rating="{{ $r }}">
                                                @if($r == 0)
                                                    All
                                                @else
                                                    <i class="fas fa-star text-warning me-1"></i>{{ $r }}+
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="min_rating" id="minRatingInput" value="{{ $minRating ?? 0 }}">
                                </div>

                                {{-- Sort (moved here on mobile) --}}
                                <div class="wsus__vendor_sidebar_select mt-3">
                                    <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                        <i class="fas fa-sort me-1"></i> Sort By
                                    </h5>
                                    <select name="sort_by" class="form-select select_2 mb-3">
                                        <option value="default"         {{ ($sortBy ?? 'default') === 'default'       ? 'selected' : '' }}>Featured</option>
                                        <option value="rating_high"     {{ ($sortBy ?? '') === 'rating_high'         ? 'selected' : '' }}>Highest Rated</option>
                                        <option value="rating_low"      {{ ($sortBy ?? '') === 'rating_low'           ? 'selected' : '' }}>Lowest Rated</option>
                                        <option value="latest"           {{ ($sortBy ?? '') === 'latest'              ? 'selected' : '' }}>Newest First</option>
                                        <option value="oldest"           {{ ($sortBy ?? '') === 'oldest'              ? 'selected' : '' }}>Oldest First</option>
                                        <option value="name_asc"         {{ ($sortBy ?? '') === 'name_asc'           ? 'selected' : '' }}>Name (A–Z)</option>
                                        <option value="name_desc"        {{ ($sortBy ?? '') === 'name_desc'          ? 'selected' : '' }}>Name (Z–A)</option>
                                    </select>
                                </div>

                                {{-- Per Page --}}
                                <div class="wsus__vendor_sidebar_select">
                                    <h5 class="mb-3 fw-bold text-uppercase" style="font-size:.75rem; letter-spacing:.08em; color:#64748b;">
                                        <i class="fas fa-th me-1"></i> Show
                                    </h5>
                                    <select name="per_page" class="form-select select_2">
                                        <option value="12" {{ ($perPage ?? 12) == 12 ? 'selected' : '' }}>12 per page</option>
                                        <option value="18" {{ ($perPage ?? 12) == 18 ? 'selected' : '' }}>18 per page</option>
                                        <option value="24" {{ ($perPage ?? 12) == 24 ? 'selected' : '' }}>24 per page</option>
                                        <option value="48" {{ ($perPage ?? 12) == 48 ? 'selected' : '' }}>48 per page</option>
                                    </select>
                                </div>

                                {{-- Action buttons --}}
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
                <div class="col-xl-9 col-lg-8">

                    {{-- Top bar (desktop) --}}
                    <div class="wsus__product_topbar d-none d-lg-flex justify-content-between align-items-center mb-4">
                        <p class="mb-0 text-muted" style="font-size:.875rem;">
                            Showing <strong>{{ $vendors->firstItem() ?? 0 }}–{{ $vendors->lastItem() ?? 0 }}</strong>
                            of <strong>{{ $totalVendors }}</strong> vendor{{ $totalVendors == 1 ? '' : 's' }}
                        </p>
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-muted mb-0" style="font-size:.8rem;">Sort:</label>
                            <form method="GET" id="topbarSortForm" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="name"      value="{{ $name ?? '' }}">
                                <input type="hidden" name="category"  value="{{ $categoryId ?? '' }}">
                                <input type="hidden" name="min_rating" value="{{ $minRating ?? 0 }}">
                                <input type="hidden" name="per_page"  value="{{ $perPage ?? 12 }}">
                                <select name="sort_by" class="form-select form-select-sm" style="width:auto;"
                                        onchange="document.getElementById('topbarSortForm').submit()">
                                    <option value="default"     {{ ($sortBy ?? 'default') === 'default'    ? 'selected' : '' }}>Featured</option>
                                    <option value="rating_high" {{ ($sortBy ?? '') === 'rating_high'     ? 'selected' : '' }}>Highest Rated</option>
                                    <option value="rating_low"  {{ ($sortBy ?? '') === 'rating_low'       ? 'selected' : '' }}>Lowest Rated</option>
                                    <option value="latest"      {{ ($sortBy ?? '') === 'latest'          ? 'selected' : '' }}>Newest First</option>
                                    <option value="oldest"      {{ ($sortBy ?? '') === 'oldest'          ? 'selected' : '' }}>Oldest First</option>
                                    <option value="name_asc"    {{ ($sortBy ?? '') === 'name_asc'        ? 'selected' : '' }}>Name (A–Z)</option>
                                    <option value="name_desc"   {{ ($sortBy ?? '') === 'name_desc'       ? 'selected' : '' }}>Name (Z–A)</option>
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
                                    ])) }}"
                                       class="text-white text-decoration-none ms-1 fw-bold">&times;</a>
                                </span>
                            @endif
                            @if($categoryId)
                                @php $catName = $categories->firstWhere('id', $categoryId)?->name ?? 'Category'; @endphp
                                <span class="badge bg-info d-flex align-items-center gap-1 px-3 py-2">
                                    <i class="fas fa-tag"></i> {{ $catName }}
                                    <a href="{{ route('frontend.vendor', array_filter([
                                        'name'      => $name ?? null,
                                        'sort_by'   => $sortBy ?? null,
                                        'min_rating'=> $minRating ?? null,
                                        'per_page'  => $perPage ?? null,
                                    ])) }}"
                                       class="text-white text-decoration-none ms-1 fw-bold">&times;</a>
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
                                    ])) }}"
                                       class="text-dark text-decoration-none ms-1 fw-bold">&times;</a>
                                </span>
                            @endif
                        </div>
                    @endif

                    {{-- Vendors Grid --}}
                    <div class="row" id="vendorGrid">
                        @forelse($vendors as $vendor)
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="wsus__vendor_single">
                                    <div class="wsus__vendor_img_wrapper">
                                        <img src="{{ $vendor->magasinPicture
                                            ? asset('storage/magasins_images/' . $vendor->id . '/' . $vendor->magasinPicture)
                                            : asset('frontend/images/vendor_details_banner.jpg') }}"
                                             alt="{{ $vendor->name }}"
                                             class="img-fluid w-100"
                                             onerror="this.onerror=null;this.src='{{ asset('frontend/images/vendor_details_banner.jpg') }}';">

                                        {{-- Rating overlay --}}
                                        @if($vendor->rate > 0)
                                            <div class="wsus__vendor_rating_overlay">
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-star"></i> {{ number_format($vendor->rate, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="wsus__vendor_text">
                                        <div class="wsus__vendor_text_center">
                                            <h4 class="mb-1">{{ $vendor->name }}</h4>

                                            @if($vendor->location || $vendor->address)
                                                <p class="mb-2 text-muted" style="font-size:.8rem;">
                                                    <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                                                    {{ $vendor->location ?? $vendor->address ?? '' }}
                                                </p>
                                            @endif

                                            <p class="wsus__vendor_rating mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= floor($vendor->rate))
                                                        <i class="fas fa-star"></i>
                                                    @elseif($i - 0.5 <= $vendor->rate)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                                <span class="text-muted ms-1">({{ number_format($vendor->rate, 1) }})</span>
                                            </p>

                                            <div class="wsus__vendor_contact">
                                                @if($vendor->phoneNumber)
                                                    <a href="tel:{{ $vendor->phoneNumber }}" class="d-block mb-1">
                                                        <i class="far fa-phone-alt me-1"></i> {{ $vendor->phoneNumber }}
                                                    </a>
                                                @endif
                                                @if($vendor->email)
                                                    <a href="mailto:{{ $vendor->email }}" class="d-block mb-3">
                                                        <i class="fal fa-envelope me-1"></i> {{ strlen($vendor->email) > 25 ? substr($vendor->email, 0, 25) . '...' : $vendor->email }}
                                                    </a>
                                                @endif
                                            </div>

                                            <a href="{{ route('frontend.vendor_details', ['id' => $vendor->id]) }}"
                                               class="common_btn">
                                                <i class="fas fa-store me-1"></i> Visit Store
                                            </a>
                                        </div>
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

@push('styles')
<style>
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
    .wsus__sidebar_filter:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }
    .wsus__product_sidebar {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
    }
    .wsus__vendor_sidebar_select h5 {
        margin-bottom: 12px !important;
    }
    .rating-filter-btn {
        font-size: .8rem;
        padding: 4px 10px;
        border-radius: 20px;
    }
    .wsus__vendor_single {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        transition: all .25s ease;
        background: #fff;
        height: 100%;
    }
    .wsus__vendor_single:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,.12);
        transform: translateY(-3px);
        border-color: #cbd5e1;
    }
    .wsus__vendor_img_wrapper {
        position: relative;
        height: 200px;
        overflow: hidden;
    }
    .wsus__vendor_img_wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .3s ease;
    }
    .wsus__vendor_single:hover .wsus__vendor_img_wrapper img {
        transform: scale(1.05);
    }
    .wsus__vendor_rating_overlay {
        position: absolute;
        top: 10px;
        right: 10px;
    }
    .wsus__vendor_text {
        padding: 16px;
    }
    .wsus__vendor_text_center h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
    }
    .wsus__vendor_text_center .common_btn {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border: none;
        color: #fff;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: .85rem;
        text-decoration: none;
        display: inline-block;
        transition: all .2s ease;
    }
    .wsus__vendor_text_center .common_btn:hover {
        opacity: .9;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(99, 102, 241, .4);
    }
    .wsus__vendor_contact a {
        color: #64748b;
        font-size: .82rem;
        text-decoration: none;
        transition: color .2s;
    }
    .wsus__vendor_contact a:hover {
        color: #6366f1;
    }
    .wsus__vendor_rating {
        color: #f59e0b;
        font-size: .85rem;
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
@endpush

@push('scripts')
<script>
    // Rating filter buttons
    document.querySelectorAll('.rating-filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var rating = this.dataset.rating;
            document.getElementById('minRatingInput').value = rating;
            document.querySelectorAll('.rating-filter-btn').forEach(function(b) {
                b.classList.remove('btn-primary');
                b.classList.add('btn-outline-secondary');
            });
            this.classList.remove('btn-outline-secondary');
            this.classList.add('btn-primary');
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush
