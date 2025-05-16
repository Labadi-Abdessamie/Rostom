@extends('frontend.master')

@section('title')
    {{ $website->name }} || Login
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
                        <h4>login / register</h4>
                        <ul>
                            <li><a href="{{ route('frontend.index') }}">home</a></li>
                            <li><a href="">login / register</a></li>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           LOGIN/REGISTER PAGE START
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ==============================-->
    <section id="wsus__login_register">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 m-auto">
                    <div class="wsus__login_reg_area">
                        <ul class="nav nav-pills mb-3" id="pills-tab2" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-home-tab2" data-bs-toggle="pill"
                                    data-bs-target="#pills-homes" type="button" role="tab" aria-controls="pills-homes"
                                    aria-selected="true">login</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab2" data-bs-toggle="pill"
                                    data-bs-target="#pills-profiles" type="button" role="tab"
                                    aria-controls="pills-profiles" aria-selected="true">signup</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent2">
                            <div class="tab-pane fade show active" id="pills-homes" role="tabpanel"
                                aria-labelledby="pills-home-tab2">
                                <div class="wsus__login">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="wsus__login_input">
                                            <i class="fas fa-user-tie"></i>
                                            <input type="email" name="email" id="email" placeholder="Email">
                                        </div>
                                        @error('email')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                        @enderror
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input name="password" type="password" id="password" placeholder="Password">
                                        </div>
                                        @error('password')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                        @enderror

                                        <div class="wsus__login_save">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="remember_me"
                                                    name="remember">
                                                <label class="form-check-label" for="remember_me">Remember me</label>
                                            </div>
                                            <a class="forget_p" href="{{ route('forget_password') }}">forget
                                                password ?</a>
                                        </div>
                                        <button class="common_btn" type="submit">login</button>
                                        @if (false)
                                            <p class="social_text">Sign in with social account</p>
                                            <ul class="wsus__login_link">
                                                <li><a href="#"><i class="fab fa-google"></i></a></li>
                                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                            </ul>
                                        @endif
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade " id="pills-profiles" role="tabpanel"
                                aria-labelledby="pills-profile-tab2">
                                <div class="wsus__login">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="wsus__login_input">
                                            <i class="fas fa-user-tie"></i>
                                            <input type="text" id="name" name="name" placeholder="Name"
                                                value="{{ old('name') }}">
                                        </div>
                                        @error('name')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                        @enderror
                                        <div class="wsus__login_input">
                                            <i class="far fa-envelope"></i>
                                            <input type="email" placeholder="Email" id="signupemail" name="email"
                                                value="{{ old('email') }}">
                                        </div>
                                        @error('email')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                        @enderror
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" placeholder="Password" name="password"
                                                id="signuppassword">
                                        </div>
                                        @error('password')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                        @enderror
                                        <div class="wsus__login_input">
                                            <i class="fas fa-key"></i>
                                            <input type="password" placeholder="Confirm Password"
                                                id="password_confirmation" name="password_confirmation">
                                        </div>
                                        @error('password_confirmation')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                        @enderror
                                        <div class="wsus__login_save">
                                            SignUp as :
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="radio" id="role_client"
                                                    name="role" value="client" checked>
                                                <label class="form-check-label" for="role_client">Client</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="radio" id="role_vendor"
                                                    name="role" value="vendor">
                                                <label class="form-check-label" for="role_vendor">Vendor</label>
                                            </div>
                                        </div>
                                        @error('role')
                                            <div class="text-danger m-2">{{ $message }}</div>
                                        @enderror
                                        <div class="wsus__login_save">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="agreedCheck"
                                                    name="agreedCheck">
                                                <label class="form-check-label" for="agreedCheck">I consent to the
                                                    <a href="youtube.com">privacy policy</a></label>
                                            </div>
                                        </div>
                                        @error('agreedCheck')
                                            <div class="text-danger mb-2">{{ $message }}</div>
                                        @enderror
                                        <button class="common_btn" type="submit">signup</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           LOGIN/REGISTER PAGE END
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ==============================-->
@endsection
