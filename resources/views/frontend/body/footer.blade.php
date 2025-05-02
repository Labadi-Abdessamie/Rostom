    <!--============================
        FOOTER PART START
    ==============================-->
    <footer class="footer_2">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-3 col-sm-7 col-md-6 col-lg-3">
                    <div class="wsus__footer_content">
                        <a class="wsus__footer_2_logo" href="{{ route('frontend.index') }}">
                            <img src="{{ asset('' . $website->logo . '') }}" alt="logo">
                        </a>
                        <a class="action" href="callto:+213{{ $website->contact_phone }}"><i
                                class="fas fa-phone-alt"></i>
                            +213{{ $website->contact_phone }}</a>
                        <a class="action" href="mailto:{{ $website->contact_email }}"><i class="far fa-envelope"></i>
                            {{ $website->contact_email }}</a>
                        @if (false)
                            <p><i class="fal fa-map-marker-alt"></i> 36 Liberty City, Tiaret, DZ</p>
                        @endif
                        <ul class="wsus__footer_social">
                            @php
                                $socials = json_decode($website->social_media_links);
                            @endphp
                            @foreach ($socials as $platform => $url)
                                @if ($url)
                                    <li>
                                        <a class="{{ $platform }}" href="{{ $url }}">
                                            <i
                                                class="fab fa-{{ $platform == 'facebook' ? $platform . '-f' : $platform }}"></i>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                    <div class="wsus__footer_content">
                        <h5>About Us</h5>
                        <ul class="wsus__footer_menu">
                            <li><a href="#"><i class="fas fa-caret-right"></i> About Us</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i> Team Member</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i> Team Details</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-5 col-md-4 col-lg-2">
                    <div class="wsus__footer_content">
                        <h5>More Links</h5>
                        <ul class="wsus__footer_menu">
                            <li><a href="#"><i class="fas fa-caret-right"></i> FAQS</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i> Privacy Policy</a></li>
                            <li><a href="#"><i class="fas fa-caret-right"></i> Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-sm-7 col-md-8 col-lg-5">
                    <div class="wsus__footer_content wsus__footer_content_2">
                        <h3>{{ $website->name }}</h3>
                        <p>{{ $website->description }}</p>
                        <br>
                        @if (false)
                            <form>
                                <input type="text" placeholder="Search...">
                                <button type="submit" class="common_btn">subscribe</button>
                            </form>
                        @endif
                        <div class="footer_payment">
                            <p>We're using safe payment :</p>
                            <p>CashOnDelivery
                                @if (false)
                                    <img class="w-25" src="{{ asset('frontend/images/cashOnDelivery.png') }}"
                                        alt="card">
                                @endif
                            </p>
                            @if (false)
                                <p>Edahabia</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wsus__footer_bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__copyright d-flex justify-content-center">
                            <p>Copyright © 2023 -
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ $website->name }}. All Rights Reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--============================
        FOOTER PART END
    ==============================-->

    <!--============================
        SCROLL BUTTON START
    ==============================-->
    <div class="wsus__scroll_btn">
        <i class="fas fa-chevron-up"></i>
    </div>
    <!--============================
        SCROLL BUTTON  END
    ==============================-->
