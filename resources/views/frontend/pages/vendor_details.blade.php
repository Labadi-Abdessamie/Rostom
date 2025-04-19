@extends('frontend.master')

@section('title')
    ATLAS MALL || Vendor Details
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
                        <h4>vendor details</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="{{ route('frontend.vendor') }}">vendors</a></li>
                            <li><a href>vendor details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                            BREADCRUMB END
                                                                                                                                                                                                                                                                                        ==============================-->

    {{--
    <!--==========================
                                        VENDOR REVIEW MODAL START
                                        ===========================-->
    <section class="product_popup_modal report_modal vendor_review_modal">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">write a Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="#">
                            <p class="rating">
                                <span>select your rating : </span>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </p>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__single_com">
                                        <input type="text" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__single_com">
                                        <input type="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="col-xl-12">
                                        <div class="wsus__single_com">
                                            <textarea cols="3" rows="3" placeholder="Write your review"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="common_btn" type="submit">submit review</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==========================
                                        VENDOR REVIEW MODAL END
                                        ===========================-->
--}}

    <!--============================
                                                                                                                                                                                                                                                                                          VENDORS DETAILA START
                                                                                                                                                                                                                                                                                        ==============================-->
    <section id="wsus__product_page" class="wsus__vendor_details_page">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_page_bammer vendor_det_banner">
                        <img src="{{ asset('frontend/images/vendor_details_banner.jpg') }}" alt="banner"
                            class="img-fluid w-100">
                        <div class="wsus__pro_page_bammer_text wsus__vendor_det_banner_text">
                            <div class="wsus__vendor_text_center">
                                <h4>{{ $vendor->name }}</h4>
                                <p class="wsus__vendor_rating">
                                    @for ($i = 1; $i <= $vendor->rate; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                    @if ($vendor->rate != floor($vendor->rate))
                                        <i class="fas fa-star-half-alt"></i>
                                    @endif
                                </p>
                                <a href="callto:{{ $vendor->phoneNumber }}"><i class="far fa-phone-alt"></i>
                                    {{ $vendor->phoneNumber }}</a>
                                <a href="mailto:{{ $vendor->email }}"><i
                                        class="far fa-envelope"></i>{{ $vendor->email }}</a>
                                <p class="wsus__vendor_location"><i class="fal fa-map-marker-alt"></i>
                                    {{ $vendor->location }} </p>
                                <p class="wsus__open_store"><i class="fab fa-shopify"></i>
                                    @if ($vendor->magasinOpen)
                                        store open
                                    @else
                                        store closed
                                    @endif
                                </p>
                                <ul class="d-flex">
                                    <li><a class="facebook" href="{{ $vendor->facebookLink }}"><i
                                                class="fab fa-facebook-f"></i></a></li>
                                    <li><a class="tiktok" href="{{ $vendor->tiktokLink }}"><i
                                                class="fab fa-tiktok"></i></a></li>
                                    <li><a class="whatsapp" href="{{ $vendor->whatsupLink }}"><i
                                                class="fab fa-whatsapp"></i></a></li>
                                    <li><a class="instagram" href="{{ $vendor->instagramLink }}"><i
                                                class="fab fa-instagram"></i></a></li>
                                </ul>
                                @if (false)
                                    <a class="common_btn" href="#" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal"><i class="fas fa-star"></i>add review</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="wsus__sidebar_filter">
                        <p>filter</p>
                        <span class="wsus__filter_icon">
                            <i class="far fa-minus" id="minus"></i>
                            <i class="far fa-plus" id="plus"></i>
                        </span>
                    </div>
                    <div class="wsus__product_sidebar" id="sticky_sidebar">
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
                                            <li><a href="#">Accessories</a></li>
                                            <li><a href="#">Babies</a></li>
                                            <li><a href="#">Babies</a></li>
                                            <li><a href="#">Beauty</a></li>
                                            <li><a href="#">Decoration</a></li>
                                            <li><a href="#">Electronics</a></li>
                                            <li><a href="#">Fashion</a></li>
                                            <li><a href="#">Food</a></li>
                                            <li><a href="#">Furniture</a></li>
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
                                        <div class="price_ranger">
                                            <input type="hidden" id="slider_range" class="flat-slider" />
                                            <button type="submit" class="common_btn">filter</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="row">
                        <div class="col-xl-12 d-none d-md-block mt-4 mt-lg-0">
                            <div class="wsus__product_topbar">
                                <div class="wsus__product_topbar_left">
                                    <div class="nav nav-pills" id="v-pills-tab" role="tablist"
                                        aria-orientation="vertical">
                                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-home" type="button" role="tab"
                                            aria-controls="v-pills-home" aria-selected="true">
                                            <i class="fas fa-th"></i>
                                        </button>
                                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#v-pills-profile" type="button" role="tab"
                                            aria-controls="v-pills-profile" aria-selected="false">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                    </div>
                                    <div class="wsus__topbar_select">
                                        <select class="select_2" name="state">
                                            <option>default shorting</option>
                                            <option>short by rating</option>
                                            <option>short by latest</option>
                                            <option>low to high </option>
                                            <option>high to low</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="wsus__topbar_select">
                                    <select class="select_2" name="state">
                                        <option>show 12</option>
                                        <option>show 15</option>
                                        <option>show 18</option>
                                        <option>show 21</option>
                                    </select>
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
                                                    <img src="{{ asset('frontend/images/pro4.jpg') }}" alt="product"
                                                        class="img-fluid w-100 img_1" />
                                                    <img src="{{ asset('frontend/images/pro4_4.jpg') }}" alt="product"
                                                        class="img-fluid w-100 img_2" />
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
                                                        href="#">{{ $product->category->name }}
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
                                                        <span>({{ $product->rate_count }} Review)</span>
                                                    </p>
                                                    <a class="wsus__pro_name"
                                                        href="{{ route('frontend.product_details', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                                    <p class="wsus__price">DZ {{ $product->price }}
                                                        @if (false)
                                                            <del>$200</del>
                                                        @endif
                                                    </p>
                                                    @livewire('add-to-cart', ['product' => $product->id])
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
                                                    <img src="{{ asset('frontend/images/pro4.jpg') }}" alt="product"
                                                        class="img-fluid w-100 img_1" />
                                                    <img src="{{ asset('frontend/images/pro4_4.jpg') }}" alt="product"
                                                        class="img-fluid w-100 img_2" />
                                                </a>
                                                <div class="wsus__product_details">
                                                    <a class="wsus__category"
                                                        href="#">{{ $product->category->name }} </a>
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
                                                        <span>({{ $product->rate_count }} Review)</span>
                                                    </p>
                                                    <a class="wsus__pro_name"
                                                        href="{{ route('frontend.product_details', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                                    <p class="wsus__price">DZ {{ $product->price }}
                                                        @if (false)
                                                            <del>$200</del>
                                                        @endif
                                                    </p>
                                                    <p class="list_description">{{ $product->short_description }}</p>
                                                    <ul class="wsus__single_pro_icon">
                                                        <li>
                                                            @livewire('add-to-cart', ['product' => $product->id])
                                                        </li>
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
                                {{ $links = $products->links() }}
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
                                                                                                                                                                                    VENDORS DETAILA END
                                                                                                                                                                                ==============================-->
@endsection
