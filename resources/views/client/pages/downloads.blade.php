@extends('client.master')


@section('title')
    Dashboard || Downloads
@endsection


@section('content')
    <div class="row">
        <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
            <div class="dashboard_content">
                <h3><i class="far fa-cloud-download-alt"></i> download</h3>
                <div class="wsus__dashboard_download">
                    <p>No downloads available yet.</p>
                    <a href="index.html" class="common_btn">go shop <i class="fal fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
