    <!--============================
        BANNER PART 2 START
    ==============================-->
    <section id="wsus__banner">

        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__banner_content">
                        <div class="row banner_slider">
                            @foreach ($banners as $banner)
                                <div class="col-xl-12">
                                    <div class="wsus__single_slider"
                                        style="background: url({{ asset('storage/banners/' . $banner->image) }});">
                                        <div class="wsus__single_slider_text">
                                            <h3>{{ $banner->title }}</h3>
                                            <h1>{{ $banner->description }}</h1>
                                            <!-- <h6>start at $99.00</h6> -->
                                            <a class="common_btn" href="{{ route($banner->link) }}">shop now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BANNER PART 2 END
    ==============================-->
