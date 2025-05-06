@extends('frontend.master')

@section('title')
    ATLAS MALL || Product Details
@endsection

@section('content')
    {{-- ! Report modal popup
    <!--==========================
                    PRODUCT  REPORT MODAL VIEW
                    ===========================-->
    <section class="product_popup_modal report_modal">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Report Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <form>
                                    <div class="wsus__single_input">
                                        <label>Subject</label>
                                        <input type="text" placeholder="Type Subject">
                                    </div>
                                    <div class="wsus__single_input">
                                        <label>email</label>
                                        <input type="email" placeholder="Type Email">
                                    </div>
                                    <div class="wsus__single_input">
                                        <label>Description</label>
                                        <textarea cols="3" rows="3" placeholder="Brief description of your issue"></textarea>
                                    </div>
                                    <div class="wsus__report_img">
                                        <div class="img_upload">
                                            <div class="gallery">
                                                <a class="cam" href="javascript:void(0)"><span><i
                                                            class="fas fa-image"></i></span></a>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="common_btn">submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--==========================
                    PRODUCT REPORT MODAL VIEW
                    ===========================-->
--}}


    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                BREADCRUMB START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>products details</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="{{ route('frontend.products') }}">product</a></li>
                            <li><a href="">product details</a></li>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                PRODUCT DETAILS START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->
    <section id="wsus__product_details">
        <div class="container">
            <div class="wsus__details_bg">
                <div class="row">
                    <div class="col-xl-4 col-md-5 col-lg-5">
                        <div id="sticky_pro_zoom">
                            <div class="exzoom hidden" id="exzoom">
                                <div class="exzoom_img_box">
                                    @if (false)
                                        <a class="venobox wsus__pro_det_video" data-autoplay="true" data-vbtype="video"
                                            href="https://youtu.be/7m16dFI1AF8">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    <ul class='exzoom_img_ul'>
                                        <li><img class="zoom ing-fluid w-100"
                                                src="{{ asset('storage/products_images/' . $product->id . '/' . $product->principalImage) }}"
                                                alt="product"></li>
                                        @if ($product->productImages)
                                            @foreach ($product->productImages as $image)
                                                <li><img class="zoom ing-fluid w-100"
                                                        src="{{ asset('storage/products_images/' . $product->id . '/' . $image) }}"
                                                        alt="product"></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                <div class="exzoom_nav"></div>
                                <p class="exzoom_btn">
                                    <a href="javascript:void(0);" class="exzoom_prev_btn"> <i
                                            class="far fa-chevron-left"></i> </a>
                                    <a href="javascript:void(0);" class="exzoom_next_btn"> <i
                                            class="far fa-chevron-right"></i> </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-md-7 col-lg-7">
                        <div class="wsus__pro_details_text">
                            <a class="title">{{ $product->name }}</a>
                            <p class="wsus__stock_area">
                                @if ($product->actual_quantity > 0)
                                    <span class="in_stock">in stock</span>
                                @else
                                    <span class="out_stock">out of stock</span>
                                @endif
                                ({{ $product->actual_quantity }} item)
                            </p>
                            <h4>DZ
                                <span id="product_price">{{ $product->price }}</span>
                                @if (false)
                                    <del>DZ 60.00</del>
                                @endif
                            </h4>
                            <p class="review">
                                @if ($product->rate_average != 0)
                                    @for ($i = 1; $i <= $product->rate_average; $i++)
                                        <i class="fas fa-star "></i>
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
                            <!-- <p class="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Officia
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        neque
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        sint obcaecati asperiores dolor cumque. ad voluptate dolores reprehenderit hic adipisci
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        Similique eaque illum.</p> -->
                            @if (false)
                                <div class="wsus_pro_hot_deals">
                                    <h5>offer ending time : </h5>
                                    <div class="simply-countdown simply-countdown-one"></div>
                                </div>
                            @endif
                            <div class="wsus_pro_det_color">
                                @php
                                    $product->colorVar = json_decode($product->colorVar);
                                @endphp
                                <ul>
                                    @if ($product->colorVar)
                                        <h5>color :</h5>
                                        @foreach ($product->colorVar as $color)
                                            <input type="checkbox">
                                            <li>
                                                <a class="{{ $color }}"><i class="far fa-check"></i></a>
                                            </li>
                                            </input>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="wsus_pro__det_size">
                                @php
                                    $product->sizeVar = json_decode($product->sizeVar);
                                @endphp
                                <ul>
                                    @if ($product->sizeVar)
                                        <h5>size :</h5>
                                        @foreach ($product->sizeVar as $size)
                                            <li><a href="">{{ $size }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            @if (false)
                                <div class="wsus__quentity">
                                    <h5>quantity :</h5>
                                    <form class="select_number">
                                        <!-- Maybe we change the css here to make it work -->
                                        <input class="number_area" id="number_input" type="number" min="1"
                                            max="100" value="1" />
                                    </form>
                                    @push('scripts')
                                        <script>
                                            let numberInput = document.getElementById('number_input');
                                            numberInput.addEventListener('input', function() {
                                                let totalPrice = document.getElementById('product_total_price');
                                                let quantity = numberInput = document.getElementById('number_input').value;
                                                let price = document.getElementById('product_price').innerText;
                                                let priceValue = parseFloat(price);
                                                let quantityValue;
                                                if (numberInput >= 0) {
                                                    quantityValue = parseInt(numberInput) || 1;
                                                } else {
                                                    quantityValue = 1;
                                                }
                                                totalPrice.innerText = (priceValue * quantityValue).toFixed(2);
                                            });
                                        </script>
                                    @endpush

                                    <h3>DZ
                                        <span id="product_total_price">
                                            {{ $product->price }}
                                        </span>
                                    </h3>
                                </div>
                            @endif

                            @if (false)
                                <div class="wsus__selectbox">
                                    <div class="row">
                                        <div class="col-xl-6 col-sm-6">
                                            <h5 class="mb-2">select:</h5>
                                            <select class="select_2" name="state">
                                                <option>default select</option>
                                                <option>select 1</option>
                                                <option>select 2</option>
                                                <option>select 3</option>
                                                <option>select 4</option>
                                            </select>
                                        </div>
                                        <div class="col-xl-6 col-sm-6">
                                            <h5 class="mb-2">select:</h5>
                                            <select class="select_2" name="state">
                                                <option>default select</option>
                                                <option>select 1</option>
                                                <option>select 2</option>
                                                <option>select 3</option>
                                                <option>select 4</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <ul class="wsus__button_area">
                                @if ($product->actual_quantity > 0)
                                    <li>
                                        @livewire('add-to-cart', ['product' => $product], key($product->id))
                                        {{-- <a class="add_cart" href="#">add to cart</a> --}}
                                    </li>
                                    <li class="cursor-pointer">
                                        @livewire('buy-now', ['product' => $product], key($product->id))
                                    </li>
                                @else
                                    <li>
                                        <button class="btn btn--danger bg-danger add_cart">
                                            Out of stock
                                        </button>
                                    </li>
                                @endif
                                <li class="cursor-pointer">
                                    @livewire('add-to-wishlist', ['product' => $product], key($product->id))
                                </li>
                                <li class="cursor-pointer">
                                    @livewire('add-to-compare', ['productId' => $product->id])
                                </li>
                            </ul>
                            @if (false)
                                <p class="brand_model"><span>model :</span> 12345670</p>
                                <p class="brand_model"><span>brand :</span> The Northland</p>
                            @endif
                            <div class="wsus__pro_det_share">
                                <h5>share :</h5>
                                <ul class="d-flex">
                                    <li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a class="whatsapp" href="#"><i class="fab fa-whatsapp"></i></a></li>
                                    <li><a class="instagram" href="#"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div>
                            @if (false)
                                <a class="wsus__pro_report" href="#" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class="fal fa-comment-alt-smile"></i> Report
                                    incorrect
                                    product information.</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-12 mt-md-5 mt-lg-0">
                        <div class="wsus_pro_det_sidebar" id="sticky_sidebar">
                            @if (false)
                                <ul>
                                    <li>
                                        <span><i class="fal fa-truck"></i></span>
                                        <div class="text">
                                            <h4>Return Available</h4>
                                            <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                        </div>
                                    </li>
                                    <li>
                                        <span><i class="far fa-shield-check"></i></span>
                                        <div class="text">
                                            <h4>Secure Payment</h4>
                                            <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                        </div>
                                    </li>
                                    <li>
                                        <span><i class="fal fa-envelope-open-dollar"></i></span>
                                        <div class="text">
                                            <h4>Warranty Available</h4>
                                            <!-- <p>Lorem Ipsum is simply dummy text of the printing</p> -->
                                        </div>
                                    </li>
                                </ul>
                            @endif
                            <div class="wsus__det_sidebar_banner">
                                <img src="{{ asset('frontend/images/blog_1.jpg') }}" alt="banner"
                                    class="img-fluid w-100">
                                <div class="wsus__det_sidebar_banner_text_overlay">
                                    <div class="wsus__det_sidebar_banner_text">
                                        <p>Black Friday Sale</p>
                                        <h4>Up To 70% Off</h4>
                                        <a href="#" class="common_btn">shope now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_det_description">
                        <div class="wsus__details_bg">
                            <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-home-tab7" data-bs-toggle="pill"
                                        data-bs-target="#pills-home22" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true">Description</button>
                                </li>
                                @if (false)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab7" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile22" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">Information</button>
                                    </li>
                                @endif
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false">Vendor Info</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab2" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact2" type="button" role="tab"
                                        aria-controls="pills-contact2" aria-selected="false">Reviews</button>
                                </li>
                                @if (false)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-contact-tab23" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact23" type="button" role="tab"
                                            aria-controls="pills-contact23" aria-selected="false">comment</button>
                                    </li>
                                @endif
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-contact-tab239" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact239" type="button" role="tab"
                                        aria-controls="pills-contact239" aria-selected="false">faqs</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent4">
                                {{-- ! Description area --}}
                                <div class="tab-pane fade  show active " id="pills-home22" role="tabpanel"
                                    aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">
                                                <h1>Heading</h1>
                                                <p>{{ $product->long_description }}</p>
                                            </div>
                                        </div>
                                        @if (false)
                                            <div class="row">
                                                <div class="col-xl-4 col-md-4">
                                                    <div class="description_single">
                                                        <h6><span>1</span> Free Shipping & Return</h6>
                                                        <p>We offer free shipping for products on orders above 50$ and
                                                            offer
                                                            free delivery for all orders in US.</p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-md-4">
                                                    <div class="description_single">
                                                        <h6><span>2</span> Free and Easy Returns</h6>
                                                        <p>We guarantee our products and you could get back all of your
                                                            money anytime you want in 30 days.</p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-md-4">
                                                    <div class="description_single">
                                                        <h6><span>3</span> Special Financing </h6>
                                                        <p>Get 20%-50% off items over 50$ for a month or over 250$ for a
                                                            year with our special credit card.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if (false)
                                    {{-- ! information area --}}
                                    <div class="tab-pane fade" id="pills-profile22" role="tabpanel"
                                        aria-labelledby="pills-profile-tab7">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 mb-4 mb-lg-0">
                                                <div class="wsus__pro_det_info">
                                                    <h4>Additional Information</h4>
                                                    <p><span>Fabric</span> 100% Cotton</p>
                                                    <p><span>Materials</span> Yearn</p>
                                                    <p><span>Packaging</span> 1 pice poly</p>
                                                    <p><span>Cleaning</span> Washable</p>
                                                    <p><span>Cash on Delivery</span> yes</p>
                                                    <p><span>Payment Method</span> Cash / Credit Card</p>
                                                    <p><span>Other Paymen Method</span> Wire Transfer</p>
                                                    <p><span>Order Tracking</span> Yes </p>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6">
                                                <div class="wsus__pro_det_info">
                                                    <h4>Additional Information</h4>
                                                    <p><span>Fabric</span> 100% Cotton</p>
                                                    <p><span>Materials</span> Yearn</p>
                                                    <p><span>Packaging</span> 1 pice poly</p>
                                                    <p><span>Cleaning</span> Washable</p>
                                                    <p><span>Cash on Delivery</span> yes</p>
                                                    <p><span>Payment Method</span> Cash / Credit Card</p>
                                                    <p><span>Other Paymen Method</span> Wire Transfer</p>
                                                    <p><span>Order Tracking</span> Yes </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                {{-- ! Vendor info area --}}
                                <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                    aria-labelledby="pills-contact-tab">
                                    <div class="wsus__pro_det_vendor">
                                        <div class="row">
                                            <div class="col-xl-6 col-xxl-5 col-md-6">
                                                <div class="wsus__vebdor_img">
                                                    <img src="{{ asset('storage/magasins_images/' . $product->magasin->id . '/' . $product->magasin->magasinPicture) }}"
                                                        alt="vensor" class="img-fluid w-100">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-xxl-7 col-md-6 mt-4 mt-md-0">
                                                <div class="wsus__pro_det_vendor_text">
                                                    <h4>{{ $product->magasin->user->name }}</h4>
                                                    <p class="rating">
                                                        @for ($i = 1; $i <= $product->magasin->rate; $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                        @if ($product->magasin->rate != floor($product->magasin->rate))
                                                            <i class="fas fa-star-half-alt"></i>
                                                        @endif
                                                        @if (false)
                                                            <span>
                                                                {{-- ! calculate the whole reviews of the all products of magasin --}}
                                                                (0 review)
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <p><span>Store Name:</span> {{ $product->magasin->name }}</p>
                                                    <p><span>Address:</span> {{ $product->magasin->location }}</p>
                                                    <p><span>Phone:</span> {{ $product->magasin->phoneNumber }}</p>
                                                    <p><span>mail:</span> {{ $product->magasin->email }}</p>
                                                    <a href="{{ route('frontend.vendor_details', ['id' => $product->magasin->id]) }}"
                                                        class="see_btn">visit store</a>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="wsus__vendor_details">
                                                    <p>{{ $product->magasin->bio }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- ! Reviews area --}}
                                <div class="tab-pane fade" id="pills-contact2" role="tabpanel"
                                    aria-labelledby="pills-contact-tab2">
                                    <div class="wsus__pro_det_review">
                                        <div class="wsus__pro_det_review_single">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7">
                                                    <div class="wsus__comment_area">
                                                        <h4>Reviews <span>
                                                                @if ($reviews)
                                                                    {{ $reviews->count() }}
                                                                @else
                                                                    0
                                                                @endif
                                                            </span></h4>
                                                        @foreach ($reviews as $review)
                                                            <div class="wsus__main_comment">
                                                                <div class="wsus__comment_img">
                                                                    <img src="{{ asset('frontend/images/' . $review->user->profilePicture) }}"
                                                                        alt="user" class="img-fluid w-100">
                                                                </div>
                                                                <div class="wsus__comment_text reply">
                                                                    <h6>{{ $review->user->name }}
                                                                        <span>{{ $review->rate }}<i
                                                                                class="fas fa-star"></i></span>
                                                                    </h6>
                                                                    <span>{{ $review->created_at }}</span>
                                                                    <p>{{ $review->content }}
                                                                    </p>
                                                                    @if ($review->images->count() > 0)
                                                                        <ul class="">
                                                                            @foreach ($review->images as $image)
                                                                                <li><img src="{{ asset('frontend/images/' . $image->path) }}"
                                                                                        alt="product"
                                                                                        class="img-fluid w-100">
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                    @if (false)
                                                                        <a href="#" data-bs-toggle="collapse"
                                                                            data-bs-target="#flush-collapsetwo">reply</a>
                                                                        <div class="accordion accordion-flush"
                                                                            id="accordionFlushExample2">
                                                                            <div class="accordion-item">
                                                                                <div id="flush-collapsetwo"
                                                                                    class="accordion-collapse collapse"
                                                                                    aria-labelledby="flush-collapsetwo"
                                                                                    data-bs-parent="#accordionFlushExample">
                                                                                    <div class="accordion-body">
                                                                                        <form>
                                                                                            <div
                                                                                                class="wsus__riv_edit_single text_area">
                                                                                                <i class="far fa-edit"></i>
                                                                                                <textarea cols="3" rows="1" placeholder="Your Text"></textarea>
                                                                                            </div>
                                                                                            <button type="submit"
                                                                                                class="common_btn">submit</button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div id="pagination">
                                                            {{ $reviews->links() }}
                                                            @if (false)
                                                                <nav aria-label="Page navigation example">
                                                                    <ul class="pagination">
                                                                        <li class="page-item">
                                                                            <a class="page-link" href="#"
                                                                                aria-label="Previous">
                                                                                <i class="fas fa-chevron-left"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li class="page-item"><a
                                                                                class="page-link page_active"
                                                                                href="#">1</a>
                                                                        </li>
                                                                        <li class="page-item"><a class="page-link"
                                                                                href="#">2</a></li>
                                                                        <li class="page-item"><a class="page-link"
                                                                                href="#">3</a></li>
                                                                        <li class="page-item"><a class="page-link"
                                                                                href="#">4</a></li>
                                                                        <li class="page-item">
                                                                            <a class="page-link" href="#"
                                                                                aria-label="Next">
                                                                                <i class="fas fa-chevron-right"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </nav>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (Auth::user()->role == 'client')
                                                    <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">
                                                        <div class="wsus__post_comment rev_mar" id="sticky_sidebar3">
                                                            <h4>write a Review</h4>
                                                            <form action="{{ route('frontend.review.add') }} "
                                                                method="POST">
                                                                @csrf
                                                                <input name="product_id" type="hidden"
                                                                    value="{{ $product->id }}">
                                                                <p class="star-rating">
                                                                    <span>select your rating : </span>
                                                                    <i class="fas fa-star selected" data-value="1"></i>
                                                                    <i class="fas fa-star" data-value="2"></i>
                                                                    <i class="fas fa-star" data-value="3"></i>
                                                                    <i class="fas fa-star" data-value="4"></i>
                                                                    <i class="fas fa-star" data-value="5"></i>
                                                                </p>
                                                                <input name="rating" id="rating-value" type="hidden"
                                                                    value="1">
                                                                @push('scripts')
                                                                    <script>
                                                                        const stars = document.querySelectorAll('.star-rating .fa-star');
                                                                        const ratingInput = document.getElementById('rating-value');

                                                                        stars.forEach(star => {
                                                                            star.addEventListener('click', function() {
                                                                                const rating = this.getAttribute('data-value');
                                                                                ratingInput.value = rating;

                                                                                // Met à jour l’affichage visuel des étoiles sélectionnées
                                                                                stars.forEach(s => {
                                                                                    s.classList.remove('selected');
                                                                                    if (s.getAttribute('data-value') <= rating) {
                                                                                        s.classList.add('selected');
                                                                                    }
                                                                                });
                                                                            });
                                                                        });
                                                                    </script>
                                                                @endpush
                                                                <div class="row">
                                                                    <div class="col-xl-12">
                                                                        <div class="col-xl-12">
                                                                            <div class="wsus__single_com">
                                                                                <textarea name="content" cols="3" rows="3" placeholder="Write your review"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="img_upload cursor-pointer">
                                                                    <div class="gallery">
                                                                        <a class="cam">
                                                                            <span>
                                                                                <i class="fas fa-image">
                                                                                    <input name="image" class="d-none"
                                                                                        type="file"
                                                                                        accept=".jpg,.jpeg,.png">
                                                                                </i>
                                                                            </span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <button class="common_btn" type="submit">submit
                                                                    review</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (false)
                                    <div class="tab-pane fade" id="pills-contact23" role="tabpanel"
                                        aria-labelledby="pills-contact-tab23">
                                        <div class="wsus__pro_det_comment">
                                            <div class="row">
                                                <div class="col-xl-7 col-lg-6">
                                                    <div class="wsus__comment_area">
                                                        <h4>comment <span>03</span></h4>
                                                        <div class="wsus__main_comment">
                                                            <div class="wsus__comment_img">
                                                                <img src="{{ asset('frontend/images/dashboard_user.jpg') }}"
                                                                    alt="user" class="img-fluid w-100">
                                                            </div>
                                                            <div class="wsus__comment_text reply">
                                                                <h6>Shopnil mahadi <span>09 Jul 2021</span></h6>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Cupiditate sint molestiae eos? Officia, fuga eaque.</p>
                                                                <a href="#" data-bs-toggle="collapse"
                                                                    data-bs-target="#flush-collapsetwo2">reply</a>
                                                                <div class="accordion accordion-flush"
                                                                    id="accordionFlushExample2">
                                                                    <div class="accordion-item">
                                                                        <div id="flush-collapsetwo2"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="flush-collapsetwo"
                                                                            data-bs-parent="#accordionFlushExample">
                                                                            <div class="accordion-body">
                                                                                <form>
                                                                                    <div
                                                                                        class="wsus__riv_edit_single text_area">
                                                                                        <i class="far fa-edit"></i>
                                                                                        <textarea cols="3" rows="1" placeholder="Your Text"></textarea>
                                                                                    </div>
                                                                                    <button type="submit"
                                                                                        class="common_btn">submit</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="wsus__main_comment wsus__com_reply">
                                                            <div class="wsus__comment_img">
                                                                <img src="{{ asset('frontend/images/ts-3.jpg') }}"
                                                                    alt="user" class="img-fluid w-100">
                                                            </div>
                                                            <div class="wsus__comment_text reply">
                                                                <h6>Smith jhon <span>09 Jul 2021</span></h6>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Cupiditate sint molestiae eos? Officia, fuga eaque.</p>
                                                                <a href="#" data-bs-toggle="collapse"
                                                                    data-bs-target="#flush-collapsetwo">reply</a>
                                                                <div class="accordion accordion-flush"
                                                                    id="accordionFlushExample">
                                                                    <div class="accordion-item">
                                                                        <div id="flush-collapsetwo"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="flush-collapsetwo"
                                                                            data-bs-parent="#accordionFlushExample">
                                                                            <div class="accordion-body">
                                                                                <form>
                                                                                    <div
                                                                                        class="wsus__riv_edit_single text_area">
                                                                                        <i class="far fa-edit"></i>
                                                                                        <textarea cols="3" rows="1" placeholder="Your Text"></textarea>
                                                                                    </div>
                                                                                    <button type="submit"
                                                                                        class="common_btn">submit</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="wsus__main_comment">
                                                            <div class="wsus__comment_img">
                                                                <img src="{{ asset('frontend/images/team_1.jpg') }}"
                                                                    alt="user" class="img-fluid w-100">
                                                            </div>
                                                            <div class="wsus__comment_text reply">
                                                                <h6>Smith jhon <span>09 Jul 2021</span></h6>
                                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                                    Cupiditate sint molestiae eos? Officia, fuga eaque.</p>
                                                                <a href="#" data-bs-toggle="collapse"
                                                                    data-bs-target="#flush-collapsetwo3">reply</a>
                                                                <div class="accordion accordion-flush"
                                                                    id="accordionFlushExample3">
                                                                    <div class="accordion-item">
                                                                        <div id="flush-collapsetwo3"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="flush-collapsetwo"
                                                                            data-bs-parent="#accordionFlushExample">
                                                                            <div class="accordion-body">
                                                                                <form>
                                                                                    <div
                                                                                        class="wsus__riv_edit_single text_area">
                                                                                        <i class="far fa-edit"></i>
                                                                                        <textarea cols="3" rows="1" placeholder="Your Text"></textarea>
                                                                                    </div>
                                                                                    <button type="submit"
                                                                                        class="common_btn">submit</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="pagination">
                                                            <nav aria-label="Page navigation example">
                                                                <ul class="pagination">
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"
                                                                            aria-label="Previous">
                                                                            <i class="fas fa-chevron-left"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li class="page-item"><a class="page-link page_active"
                                                                            href="#">1</a></li>
                                                                    <li class="page-item"><a class="page-link"
                                                                            href="#">2</a>
                                                                    </li>
                                                                    <li class="page-item"><a class="page-link"
                                                                            href="#">3</a>
                                                                    </li>
                                                                    <li class="page-item"><a class="page-link"
                                                                            href="#">4</a>
                                                                    </li>
                                                                    <li class="page-item">
                                                                        <a class="page-link" href="#"
                                                                            aria-label="Next">
                                                                            <i class="fas fa-chevron-right"></i>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </nav>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-5 col-lg-6 mt-4 mt-lg-0">
                                                    <div class="wsus__post_comment" id="sticky_sidebar2">
                                                        <h4>post a comment</h4>
                                                        <form action="#">
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="wsus__single_com">
                                                                        <input type="text" placeholder="Name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="wsus__single_com">
                                                                        <input type="email" placeholder="Email">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <div class="wsus__single_com">
                                                                        <textarea cols="3" rows="3" placeholder="Your Comment"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button class="common_btn" type="submit">post
                                                                comment</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="tab-pane fade" id="pills-contact239" role="tabpanel"
                                    aria-labelledby="pills-contact-tab239">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="wsus__contact_question">
                                                <h5>People usually ask these</h5>
                                                <div class="accordion" id="accordionExample">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne">
                                                            <button class="accordion-button" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                                aria-expanded="true" aria-controls="collapseOne">
                                                                How can I cancel my order?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseOne" class="accordion-collapse collapse show"
                                                            aria-labelledby="headingOne"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingTwo">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                                aria-expanded="false" aria-controls="collapseTwo">
                                                                Why is my registration delayed?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                                            aria-labelledby="headingTwo"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThree">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                                aria-expanded="false" aria-controls="collapseThree">
                                                                What do I need to buy products?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThree" class="accordion-collapse collapse"
                                                            aria-labelledby="headingThree"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThreet1">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseThreet1" aria-expanded="false"
                                                                aria-controls="collapseThreet1">
                                                                How can I track an order?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThreet1" class="accordion-collapse collapse"
                                                            aria-labelledby="headingThreet1"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingThreet2">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseThreet2" aria-expanded="false"
                                                                aria-controls="collapseThreet2">
                                                                How can I get money back?
                                                            </button>
                                                        </h2>
                                                        <div id="collapseThreet2" class="accordion-collapse collapse"
                                                            aria-labelledby="headingThreet2"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    elit.
                                                                    Voluptatum voluptas ea hic excepturi sit, sapiente
                                                                    optio
                                                                    deleniti pariatur. Dolorum in quos magni?
                                                                    Necessitatibus
                                                                    recusandae cupiditate iste expedita amet voluptatem
                                                                    laudantium.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                PRODUCT DETAILS END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->


    {{--
    <!--============================
                                                    RELATED PRODUCT START
                                            ==============================-->
    <section id="wsus__flash_sell">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header">
                        <h3>Related Products</h3>
                        <a class="see_btn" href="#">see more <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row flash_sell_slider">
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__new">New</span>
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                            <img src="{{ asset('frontend/images/pro3.jpg') }}" alt="product"
                                class="img-fluid w-100 img_1" />
                            <img src="{{ asset('frontend/images/pro3_3.jpg') }}" alt="product"
                                class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            <li><a href="#"><i class="far fa-random"></i></a>
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">Electronics </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(133 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">hp 24" FHD monitore</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__new">New</span>
                        <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                            <img src="{{ asset('frontend/images/pro4.jpg') }}" alt="product"
                                class="img-fluid w-100 img_1" />
                            <img src="{{ asset('frontend/images/pro4_4.jpg') }}" alt="product"
                                class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            <li><a href="#"><i class="far fa-random"></i></a>
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">fashion </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(17 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">men's casual fashion watch</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                            <img src="{{ asset('frontend/images/pro9.jpg') }}" alt="product"
                                class="img-fluid w-100 img_1" />
                            <img src="{{ asset('frontend/images/pro9_9.jpg') }}" alt="product"
                                class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            <li><a href="#"><i class="far fa-random"></i></a>
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">fashion </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(120 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">men's fashion sholder bag</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__new">New</span>
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                            <img src="{{ asset('frontend/images/pro2.jpg') }}" alt="product"
                                class="img-fluid w-100 img_1" />
                            <img src="{{ asset('frontend/images/pro2_2.jpg') }}" alt="product"
                                class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            <li><a href="#"><i class="far fa-random"></i></a>
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">fashion </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(72 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">men's casual shoes</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-lg-4">
                    <div class="wsus__product_item">
                        <span class="wsus__minus">-20%</span>
                        <a class="wsus__pro_link" href="{{ route('frontend.product_details') }}">
                            <img src="{{ asset('frontend/images/pro4.jpg') }}" alt="product"
                                class="img-fluid w-100 img_1" />
                            <img src="{{ asset('frontend/images/pro4_4.jpg') }}" alt="product"
                                class="img-fluid w-100 img_2" />
                        </a>
                        <ul class="wsus__single_pro_icon">
                            <li><a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i
                                        class="far fa-eye"></i></a></li>
                            <li><a href="#"><i class="far fa-heart"></i></a></li>
                            <li><a href="#"><i class="far fa-random"></i></a>
                        </ul>
                        <div class="wsus__product_details">
                            <a class="wsus__category" href="#">fashion </a>
                            <p class="wsus__pro_rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>(17 review)</span>
                            </p>
                            <a class="wsus__pro_name" href="#">men's casual fashion watch</a>
                            <p class="wsus__price">$159 <del>$200</del></p>
                            <a class="add_cart" href="#">add to cart</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--============================
                                                RELATED PRODUCT END
                                            ==============================-->
--}}
@endsection
