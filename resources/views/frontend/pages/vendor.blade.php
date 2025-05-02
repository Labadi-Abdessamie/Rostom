@extends('frontend.master')

@section('title')
    ATLAS MALL || Vendors
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
                        <h4>vendors</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href>vendors</a></li>
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
                <div class="col-xl-3 col-lg-4">
                    <div class="wsus__sidebar_filter">
                        <p>filter</p>
                        <span class="wsus__filter_icon">
                            <i class="far fa-minus" id="minus"></i>
                            <i class="far fa-plus" id="plus"></i>
                        </span>
                    </div>
                    <div class="wsus__product_sidebar wsus__vendor_sidebar" id="sticky_sidebar">
                        <form action="{{ route('frontend.search_vendor') }}">
                            @csrf
                            <input name="query" type="text" placeholder="Search..."
                                value="{{ $queryFilter ? $queryFilter : '' }}">
                            <button class="common_btn" type="submit"><i class="far fa-search"></i></button>
                        </form>
                        <div class="wsus__vendor_sidebar_select">
                            <h4>filter by category</h4>
                            <select class="select_2" name="state">
                                <option>choose category</option>
                                <option>men's</option>
                                <option>wemen's</option>
                                <option>kid's</option>
                                <option>electronics</option>
                                <option>electrick</option>
                            </select>
                        </div>
                        @if (false)
                            <div class="wsus__vendor_sidebar_select">
                                <h4>filter by location</h4>
                                <select class="select_2" name="state">
                                    <option>choose location</option>
                                    <option>short by rating</option>
                                    <option>short by latest</option>
                                    <option>low to high </option>
                                    <option>high to low</option>
                                </select>
                            </div>
                            <div class="wsus__vendor_sidebar_select">
                                <select class="select_2" name="state">
                                    <option>choose state</option>
                                    <option>korea</option>
                                    <option>japan</option>
                                    <option>china</option>
                                    <option>singapore</option>
                                    <option>thailand</option>
                                </select>
                            </div>
                            <div class="wsus__vendor_sidebar_select">
                                <select class="select_2" name="state">
                                    <option>search by city</option>
                                    <option>korea</option>
                                    <option>japan</option>
                                    <option>china</option>
                                    <option>singapore</option>
                                    <option>thailand</option>
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="row">
                        <div class="col-xl-12 d-none d-lg-block">
                            <div class="wsus__product_topbar">
                                <div class="wsus__topbar_select">
                                    <select class="select_2" name="state">
                                        <option>default shorting</option>
                                        <option>short by rating</option>
                                        <option>short by latest</option>
                                        <option>low to high </option>
                                        <option>high to low</option>
                                    </select>
                                </div>
                                <div class="wsus__topbar_select wsus__topbar_select2">
                                    <select class="select_2" name="state">
                                        <option>show 12</option>
                                        <option>show 15</option>
                                        <option>show 18</option>
                                        <option>show 21</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @foreach ($vendors as $vendor)
                            <div class="col-xl-6 col-md-6">
                                <div class="wsus__vendor_single">
                                    <img src="{{ asset('frontend/images/vendor_1.jpg') }}" alt="vendor"
                                        class="img-fluid w-100">
                                    <div class="wsus__vendor_text">
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
                                            <a href="callto:{{ $vendor->phoneNumber }}" target="_blank"><i
                                                    class="far fa-phone-alt"></i>
                                                {{ $vendor->phoneNumber }}</a>
                                            <a href="mailto:{{ $vendor->email }}" target="_blank"><i
                                                    class="fal fa-envelope"></i>
                                                {{ $vendor->email }}</a>
                                            <a href="{{ route('frontend.vendor_details', ['id' => $vendor->id]) }}"
                                                class="common_btn">visit
                                                store</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-12">
                    <section id="pagination">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                {{ $vendors->links() }}
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
                                                                            VENDORS END
                                                                            ==============================-->
@endsection
