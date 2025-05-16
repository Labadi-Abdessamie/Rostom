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
    <section id="wsus__product_page">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_page_bammer">
                        <img src="{{ asset('frontend/images/pro_banner_1.jpg') }}" alt="banner" class="img-fluid w-100">
                        <div class="wsus__pro_page_bammer_text">
                            <div class="wsus__pro_page_bammer_text_center">
                                <p>up to <span>70% off</span></p>
                                <h5>wemen's jeans Collection</h5>
                                <h3>fashion for wemen's</h3>
                                <a href="#" class="add_cart">Discover Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="wsus__sidebar_filter ">
                        <p>filter</p>
                        <span class="wsus__filter_icon">
                            <i class="far fa-minus" id="minus"></i>
                            <i class="far fa-plus" id="plus"></i>
                        </span>
                    </div>
                    <div class="wsus__product_sidebar " id="sticky_sidebar">
                        <form action="{{ route('frontend.search') }}">
                            @csrf
                            <input name="query" type="text" placeholder="Search..."
                                value="{{ $queryFilter ? $queryFilter : '' }}">
                            <button class="common_btn" type="submit"><i class="far fa-search"></i></button>
                        </form>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        All Categories
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach ($categories as $category)
                                                <li><a
                                                        href="{{ route('frontend.products', ['category' => $category->id, 'name' => $queryFilter ? $queryFilter : '']) }}">{{ $category->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Price
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <label class="form-label mb-0" for="min">Min:</label>
                                            <input class="form-control" type="number" name="min" id="min"
                                                min="0" style="max-width: 120px;">
                                        </div>
                                        <div class="d-flex align-items-center gap-2 mb-3">
                                            <label class="form-label mb-0" for="max">Max:</label>
                                            <input class="form-control" type="number" name="max" id="max"
                                                max="0" style="max-width: 120px;">
                                        </div>
                                        @if (false)
                                            <div class="price_ranger">
                                                <input type="hidden" id="slider_range" class="flat-slider">
                                            </div>
                                        @endif
                                        <button type="submit" class="common_btn">filter</button>
                                    </div>
                                </div>
                            </div>
                            @if (false)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree2">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree2" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            size
                                        </button>
                                    </h2>
                                    <div id="collapseThree2" class="accordion-collapse collapse show"
                                        aria-labelledby="headingThree2" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    small
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckChecked">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    medium
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckChecked2">
                                                <label class="form-check-label" for="flexCheckChecked2">
                                                    large
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree3">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree3" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            brand
                                        </button>
                                    </h2>
                                    <div id="collapseThree3" class="accordion-collapse collapse show"
                                        aria-labelledby="headingThree3" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefault11">
                                                <label class="form-check-label" for="flexCheckDefault11">
                                                    gentle park
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckChecked22">
                                                <label class="form-check-label" for="flexCheckChecked22">
                                                    colors
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckChecked222">
                                                <label class="form-check-label" for="flexCheckChecked222">
                                                    yellow
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckChecked33">
                                                <label class="form-check-label" for="flexCheckChecked33">
                                                    enice man
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckChecked333">
                                                <label class="form-check-label" for="flexCheckChecked333">
                                                    plus point
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="true"
                                            aria-controls="collapseThree">
                                            color
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse show"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckDefaultc1">
                                                <label class="form-check-label" for="flexCheckDefaultc1">
                                                    black
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckCheckedc2">
                                                <label class="form-check-label" for="flexCheckCheckedc2">
                                                    white
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckCheckedc3">
                                                <label class="form-check-label" for="flexCheckCheckedc3">
                                                    green
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckCheckedc4">
                                                <label class="form-check-label" for="flexCheckCheckedc4">
                                                    pink
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="flexCheckCheckedc5">
                                                <label class="form-check-label" for="flexCheckCheckedc5">
                                                    red
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="row">
                        <div class="col-xl-12 d-none d-md-block mt-md-4 mt-lg-0">
                            <div class="wsus__product_topbar">
                                <div class="wsus__product_topbar_left">
                                    <div class="nav nav-pills" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <button class="nav-link active " id="v-pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-home" type="button" role="tab"
                                            aria-controls="v-pills-home" aria-selected="true">
                                            <i class="fas fa-th"></i>
                                        </button></a>
                                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-profile" type="button" role="tab"
                                            aria-controls="v-pills-profile" aria-selected="false">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                    </div>
                                    <form method="GET" id="sortForm">
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                        <input type="hidden" name="number" value="{{ request('number') }}">
                                        <select class="select_2" name="sort"
                                            onchange="document.getElementById('sortForm').submit();">
                                            <option value="">Default sorting</option>
                                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Sort
                                                by Rating</option>
                                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                Sort
                                                by Latest</option>
                                            <option value="low_high"
                                                {{ request('sort') == 'low_high' ? 'selected' : '' }}>
                                                Low to High</option>
                                            <option value="high_low"
                                                {{ request('sort') == 'high_low' ? 'selected' : '' }}>High to Low</option>
                                        </select>
                                    </form>
                                </div>
                                <div class="wsus__topbar_select">
                                    <form method="GET" id="stateForm">
                                        <input type="hidden" name="category" value="{{ request('category') }}">
                                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                                        <select class="select_2" name="number"
                                            onchange="document.getElementById('stateForm').submit();">
                                            <option value="12" {{ request('number') == '12' ? 'selected' : '' }}>Show
                                                12</option>
                                            <option value="15" {{ request('number') == '15' ? 'selected' : '' }}>Show
                                                15</option>
                                            <option value="18" {{ request('number') == '18' ? 'selected' : '' }}>Show
                                                18</option>
                                            <option value="21" {{ request('number') == '21' ? 'selected' : '' }}>Show
                                                21</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                aria-labelledby="v-pills-home-tab">
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="wsus__product_item">
                                                @if (true)
                                                    <span class="wsus__new">New</span>
                                                @endif
                                                @if (false)
                                                    <span class="wsus__minus">-20%</span>
                                                @endif

                                                <a class="wsus__pro_link"
                                                    href="{{ route('frontend.product_details', ['id' => $product->id]) }}">
                                                    <img src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                                        alt="product" class="img-fluid w-100 img_1" />
                                                    <img src="
                                                            @if (@empty($product->productImages)) {{ asset('storage/products_images/' . $product->id . '/' . $product->productImages[0]) }}
                                                            @else {{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }} @endif
                                                            "
                                                        alt="product" class="img-fluid w-100 img_2" />
                                                </a>
                                                <ul class="wsus__single_pro_icon">
                                                    @if (false)
                                                        <li><a href="#" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal"><i
                                                                    class="far fa-eye"></i></a>
                                                        </li>
                                                    @endif
                                                    <li class="cursor-pointer">
                                                        @livewire('add-to-wishlist', ['product' => $product], key($product->id))
                                                    </li>
                                                    <li class="cursor-pointer">
                                                        @livewire('add-to-compare', ['productId' => $product->id])
                                                    </li>
                                                </ul>
                                                <div class="wsus__product_details">
                                                    <a class="wsus__category"
                                                        href="{{ route('frontend.products', ['category' => $product->category->id]) }}">{{ $product->category->name }}
                                                    </a>
                                                    <p class="wsus__pro_rating">
                                                        @if ($product->rate_average != 0)
                                                            @for ($i = 1; $i <= $product->rate_average; $i++)
                                                                <i class="fas fa-star"></i>
                                                            @endfor
                                                            @if ($product->rate_average != floor($product->rate_average))
                                                                <i class="fas fa-star-half-alt"></i>
                                                            @endif
                                                        @else
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                        <span>({{ $product->rate_count }} review)</span>
                                                    </p>
                                                    <a class="wsus__pro_name" href="#">{{ $product->name }}</a>
                                                    <p class="wsus__price">DZ {{ $product->price }}
                                                        @if (false)
                                                            <del>$200</del>
                                                        @endif
                                                    </p>
                                                    @if ($product->actual_quantity > 0)
                                                        @livewire('add-to-cart', ['product' => $product->id])
                                                    @else
                                                        <button class="btn btn--danger bg-danger add_cart">
                                                            Out of stock
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                aria-labelledby="v-pills-profile-tab">
                                <div class="row">
                                    @foreach ($products as $product)
                                        <div class="col-xl-12">
                                            <div class="wsus__product_item wsus__list_view">
                                                @if (true)
                                                    <span class="wsus__new">New</span>
                                                @endif
                                                @if (false)
                                                    <span class="wsus__minus">-20%</span>
                                                @endif
                                                <a class="wsus__pro_link"
                                                    href="{{ route('frontend.product_details', ['id' => $product->id]) }}">
                                                    <img src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                                        alt="product" class="img-fluid w-100 img_1" />
                                                    <img src="
                                                            @if (@empty($product->productImages)) {{ asset('storage/products_images/' . $product->id . '/' . $product->productImages[0]) }}
                                                            @else {{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }} @endif
                                                            "
                                                        alt="product" class="img-fluid w-100 img_2" />
                                                </a>
                                                <div class="wsus__product_details">
                                                    <a class="wsus__category"
                                                        href="{{ route('frontend.products', ['category' => $product->category->id]) }}">{{ $product->category->name }}
                                                    </a>
                                                    <p class="wsus__pro_rating">
                                                        @if ($product->rate_average != 0)
                                                            @for ($i = 1; $i <= $product->rate_average; $i++)
                                                                <i class="fas fa-star"></i>
                                                            @endfor
                                                            @if ($product->rate_average != floor($product->rate_average))
                                                                <i class="fas fa-star-half-alt"></i>
                                                            @endif
                                                        @else
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                        <span>({{ $product->rate_count }} review)</span>
                                                    </p>
                                                    <a class="wsus__pro_name" href="#">{{ $product->name }}</a>
                                                    <p class="wsus__price">DZ {{ $product->price }}
                                                        @if (false)
                                                            <del>$200</del>
                                                        @endif
                                                    </p>
                                                    <p class="list_description">{{ $product->short_description }}</p>
                                                    <ul class="wsus__single_pro_icon">
                                                        @livewire('add-to-cart', ['product' => $product], key($product->id))
                                                        <li class="cursor-pointer ms-2">
                                                            @livewire('add-to-wishlist', ['product' => $product], key($product->id))
                                                        </li>
                                                        <li class="cursor-pointer">
                                                            @livewire('add-to-compare', ['productId' => $product->id])
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <section id="pagination">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                {{ $products->links() }}

                                {{--
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link page_active" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                                --}}
                            </ul>
                        </nav>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                PRODUCT PAGE END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================--
@endsection
