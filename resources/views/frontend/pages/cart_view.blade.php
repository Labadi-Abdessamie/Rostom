@extends('frontend.master')

@section('title')
    ATLAS MALL || Cart View
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
                        <h4>cart View</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="">cart view</a></li>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        CART VIEW PAGE START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                @if ($cart == [])
                    <div class="col-xl-12">
                        <div class="wsus__cart_list cart_empty p-3 p-sm-5 text-center">
                            <p class="mb-4">your shopping cart is empty</p>
                            <a href="{{ route('frontend.products') }}" class="common_btn"><i
                                    class="fal fa-store me-2"></i>view our
                                product</a>
                        </div>
                    </div>
                @else
                    <div class="col-xl-9">
                        <div class="wsus__cart_list">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                        <tr class="d-flex">
                                            <th class="wsus__pro_img">
                                                product item
                                            </th>

                                            <th class="wsus__pro_name">
                                                product details
                                            </th>

                                            <th class="wsus__pro_status">
                                                status
                                            </th>

                                            <th class="wsus__pro_select">
                                                quantity
                                            </th>

                                            <th class="wsus__pro_tk">
                                                price
                                            </th>

                                            <th class="wsus__pro_icon">
                                                <form action="{{ route('frontend.cart.clear') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="common_btn">clear cart</button>
                                                </form>
                                            </th>
                                        </tr>
                                        @php $total = 0 @endphp
                                        @foreach ($cart as $key => $item)
                                            <tr class="d-flex">
                                                <td class="wsus__pro_img">
                                                    <a href="{{ route('frontend.product_details', ['id' => $key]) }}">
                                                        <img src="{{ asset('frontend/images/pro9_9.jpg') }}" alt="product"
                                                            class="img-fluid w-100"></a>
                                                </td>

                                                <td class="wsus__pro_name">
                                                    <p>
                                                        <a href="{{ route('frontend.product_details', ['id' => $key]) }}">
                                                            {{ $item['product']['name'] }}
                                                        </a>
                                                    </p>
                                                    @if (false)
                                                        <span>color: red</span>
                                                        <span>size: XL</span>
                                                    @endif
                                                </td>

                                                <td class="wsus__pro_status">
                                                    <p>
                                                        @if ($item['product']['actual_quantity'] > 0)
                                                            in stock
                                                        @else
                                                            out of stock
                                                        @endif
                                                    </p>
                                                </td>

                                                <td class="wsus__pro_select">
                                                    <form class="select_number d-flex">{{--
                                                        <button class="btn" type="button">-</button>
                                                        <input class="form-control" type="number" min="1"
                                                            max="100" value="{{ $item['quantity'] }}" disabled />
                                                        <button class="btn" type="button">+</button> --}}
                                                        <input class="number_area" type="number" min="1"
                                                            max="100" value="{{ $item['quantity'] }}" />

                                                    </form>
                                                </td>

                                                <td class="wsus__pro_tk">
                                                    <h6>DZ {{ $item['product']['price'] * $item['quantity'] }}</h6>
                                                </td>

                                                <td class="wsus__pro_icon">
                                                    @livewire('delete-from-cart', ['productId' => $key], key($key))
                                                    {{--
                                                    <form action="{{ route('frontend.cart.remove_item', ['id' => $key]) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="btn" type="submit">
                                                            <i class="far fa-times"></i></button>
                                                    </form>
                                                --}}
                                                </td>
                                            </tr>
                                            @php $total += $item['product']['price'] * $item['quantity']; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                            <h6>total cart</h6>
                            <p>subtotal: <span>DZ {{ $total }}</span></p>
                            <p>delivery: <span>DZ 250.00</span></p>
                            <p class="total"><span>total:</span> <span>DZ {{ $total }}</span></p>

                            @if (false)
                                <p>discount: <span>$10.00</span></p>
                                <form>
                                    <input type="text" placeholder="Coupon Code">
                                    <button type="submit" class="common_btn">apply</button>
                                </form>
                            @endif

                            <a class="common_btn mt-4 w-100 text-center"
                                href="{{ route('frontend.check_out') }}">checkout</a>
                            <a class="common_btn mt-1 w-100 text-center" href="{{ route('frontend.products') }}"><i
                                    class="fab fa-shopify"></i> go shop</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content">
                        <div class="wsus__single_banner_img">
                            <img src="{{ asset('frontend/images/single_banner_2.jpg') }}" alt="banner"
                                class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>sell on <span>35% off</span></h6>
                            <h3>smart watch</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="wsus__single_banner_content single_banner_2">
                        <div class="wsus__single_banner_img">
                            <img src="{{ asset('frontend/images/single_banner_3.jpg') }}" alt="banner"
                                class="img-fluid w-100">
                        </div>
                        <div class="wsus__single_banner_text">
                            <h6>New Collection</h6>
                            <h3>Cosmetics</h3>
                            <a class="shop_btn" href="#">shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          CART VIEW PAGE END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ==============================-->
@endsection
