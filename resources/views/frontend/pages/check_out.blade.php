@extends('frontend.master')

@section('title')
    ATLAS MALL || Check Out
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
                        <h4>check out</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="{{ route('frontend.cart') }}">Cart</a></li>
                            <li><a href>check out</a></li>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                CHECK OUT PAGE START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <form class="wsus__checkout_form" action="{{ route('create_order') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="wsus__check_form">
                            <h5>Billing Details
                                @if (false)
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">add new
                                        address</a>
                                @endif
                            </h5>
                            <div class="row">
                                @if ($principalAddress)
                                    <input type="hidden" name="id" value="{{ $principalAddress->id }}">
                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="name" placeholder="Name"
                                                value="{{ $principalAddress->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="address" placeholder="Address"
                                                value="{{ $principalAddress->address }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="phoneNumber" placeholder="Phone"
                                                value="{{ $principalAddress->phoneNumber }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="email" name="email" placeholder="Email"
                                                value="{{ $principalAddress->email }}">
                                        </div>
                                    </div>

                                    <div class="wsus__check_single_form">
                                        <div class="form-check">
                                            <input id="principalShippingAddress" class="form-check-input cursor-pointer"
                                                type="checkbox" name="principalShippingAddress" checked>
                                            <label class="form-check-label" for="principalShippingAddress">
                                                Select it as your principal shippping address
                                            </label>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="id" value="null">

                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="name" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-12 col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="address" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="phoneNumber" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="email" name="email" placeholder="Email">
                                        </div>
                                    </div>

                                    <div class="wsus__check_single_form">
                                        <div class="form-check">
                                            <input id="principalShippingAddress" class="form-check-input cursor-pointer"
                                                type="checkbox" name="principalShippingAddress">
                                            <label class="form-check-label" for="principalShippingAddress">
                                                Select it as your principal shippping address
                                            </label>
                                        </div>
                                    </div>
                                @endif


                                @if (false)
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <select class="select_2" name="state">
                                                <option value="AL">Country / Region *</option>
                                                <option value="">dhaka</option>
                                                <option value="">barisal</option>
                                                <option value="">khulna</option>
                                                <option value="">rajshahi</option>
                                                <option value="">bogura</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Street Address *">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Apartment, suite, unit, etc. (optional)">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Town / City *">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="State *">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" placeholder="Zip *">
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-12
                                    col-lg-12 col-xl-12">
                                    <div class="accordion checkout_accordian" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <div class="wsus__check_single_form accordion-button collapsed">
                                                    <div class="form-check">
                                                        <input class="form-check-input cursor-pointer" type="checkbox"
                                                            name="sameAsShippingAd" id="flexCheckDefault"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree" checked>
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Same as shipping address
                                                        </label>
                                                    </div>
                                                </div>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                <div class="accordion-body p-0">
                                                    <div class="wsus__check_form p-0" style="box-shadow: none;">
                                                        <div class="row">
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" name="billingName"
                                                                        placeholder="Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-lg-12 col-xl-12">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" name="billingAddress"
                                                                        placeholder="Address">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="text" name="billingPhoneNumber"
                                                                        placeholder="Phone *">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-12 col-xl-6">
                                                                <div class="wsus__check_single_form">
                                                                    <input type="email" name="billingEmail"
                                                                        placeholder="Email *">
                                                                </div>
                                                            </div>
                                                            <div class="wsus__check_single_form">
                                                                <div class="form-check">
                                                                    <input id="principalBillingAddress"
                                                                        class="form-check-input cursor-pointer"
                                                                        type="checkbox" name="princpalBillingAddress"
                                                                        value="">
                                                                    <label class="form-check-label"
                                                                        for="principalBillingAddress">
                                                                        Select it as your principal billing address
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-xl-12">
                                    <div class="wsus__check_single_form">
                                        <h5>Additional Information</h5>
                                        <textarea cols="3" rows="4" name="details"
                                            placeholder="Notes about your order, e.g. special notes for delivery"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @if ($addresses)
                                    @foreach ($addresses as $key => $address)
                                        <div class="col-xl-6">
                                            <div class="wsus__checkout_single_address">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="radioAddress"
                                                        id="radioAddress{{ $key }}">
                                                    <label class="form-check-label" for="radioAddress{{ $key }}">
                                                        Select Address
                                                    </label>
                                                </div>
                                                <ul>
                                                    <li><span>Id :</span> {{ $address->id }}</li>
                                                    <li><span>Name :</span> {{ $address->name }}</li>
                                                    <li><span>Phone :</span> {{ $address->phoneNumber }}</li>
                                                    <li><span>Email :</span> {{ $address->email }}</li>
                                                    <li><span>Address :</span> {{ $address->address }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="wsus__order_details" id="sticky_sidebar">
                            @if (false)
                                <p class="wsus__product">shipping Methods</p>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                        id="exampleRadios1" value="option1" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        free shipping
                                        <span>(10 - 12 days)</span>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                        id="exampleRadios2" value="option2">
                                    <label class="form-check-label" for="exampleRadios2">
                                        express shipping
                                        <span>(5 - 10 days)</span>
                                    </label>
                                </div>
                            @endif
                            <div class="wsus__order_details_summery">

                                @php
                                    $total = 0;
                                    $shipping_fee = 100;
                                @endphp
                                @foreach (session()->get('cart', []) as $key => $item)
                                    @php $total += $item['product']['price'] * $item['quantity']   @endphp
                                @endforeach
                                <p>subtotal: <span>DZ {{ $total }}</span></p>
                                <p>shipping fee: <span>DZ {{ $shipping_fee }}.00</span></p>
                                @if (false)
                                    <p>tax: <span>$00.00</span></p>
                                @endif
                                <p><b>total:</b> <span><b>DZ {{ $total + $shipping_fee }}</b></span></p>
                            </div>
                            <div class="terms_area">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckChecked3"
                                        name="TermsConditions" checked>
                                    <label class="form-check-label" for="flexCheckChecked3">
                                        I have read and agree to the website <a href="#">terms and conditions *</a>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="common_btn">Place Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>


    {{--
        ============================
            CHECK OUT PAGE END
        ==============================
    --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            let IdInput = $('input[name="id"]');
            let NameInput = $('input[name="name"]');
            let PhoneInput = $('input[name="phoneNumber"]');
            let EmailInput = $('input[name="email"]');
            let AddressInput = $('input[name="address"]');


            $('input[name="radioAddress"]').on('change', function() {
                let container = $(this).closest('.wsus__checkout_single_address');
                let addressList = container.find('ul');
                let id = addressList.find('li:contains("Id")').text().replace('Id :', '').trim();
                let name = addressList.find('li:contains("Name")').text().replace('Name :', '').trim();
                let phone = addressList.find('li:contains("Phone")').text().replace('Phone :', '').trim();
                let email = addressList.find('li:contains("Email")').text().replace('Email :', '').trim();
                let address = addressList.find('li:contains("Address")').text().replace('Address :', '')
                    .trim();

                IdInput.val(id);
                NameInput.val(name);
                PhoneInput.val(phone);
                EmailInput.val(email);
                AddressInput.val(address);
            });
        });
    </script>
@endpush


@if (false)
    <!-- after the section -->
    <div class="wsus__popup_address">
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="wsus__check_form p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <input type="text" placeholder="Phone *">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="wsus__check_single_form">
                                        <input type="email" placeholder="Email *">
                                    </div>
                                </div>
                                <input type="hidden" value="billing">
                                <div class="col-xl-12">
                                    <div class="wsus__check_single_form">
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
