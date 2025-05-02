@extends('vendor.master')
@section('title', 'Vendor | Contact')

@section('scripts')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyB55Np3_WsZwUQ9NS7DP-HnneleZLYZDNw&amp;sensor=true"></script>
    <script src="{{ asset('vendor/modules/gmaps.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('vendor/js/page/utilities-contact.js') }}"></script>
@endsection

@section('content')

    <section class="section">
        <div class="section-header">
            <h1>Contact</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('vendor.dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Contact</div>
            </div>
        </div>
        <div class="section-body mt-5">
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1 col-lg-10 offset-lg-1">
                    <div class="login-brasnd">
                        {{ $website->name }}
                    </div>
                    <div class="card card-primary">
                        <div class="row m-0">
                            <div class="col-12 col-md-12 col-lg-5 p-0">
                                <div class="card-header text-center">
                                    <h4>Contact Us</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group floating-addon">
                                            <label>Name</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="far fa-user"></i>
                                                    </div>
                                                </div>
                                                <input id="name" type="text" class="form-control" name="name"
                                                    autofocus placeholder="Name">
                                            </div>
                                        </div>

                                        <div class="form-group floating-addon">
                                            <label>Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <input id="email" type="email" class="form-control" name="email"
                                                    placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Message</label>
                                            <textarea class="form-control" placeholder="Type your message" data-height="150"></textarea>
                                        </div>

                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-round btn-lg btn-primary">
                                                Send Message
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-7 p-0">
                                <div id="map" class="contact-map"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
