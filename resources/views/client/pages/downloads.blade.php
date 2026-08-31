@extends('client.master')


@section('title')
    Dashboard || Downloads
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="dashboard_content">
                <div class="dash-page-header">
                    <h1><i class="far fa-cloud-download-alt"></i>Downloads</h1>
                    <p>Your purchased digital files will appear here</p>
                </div>
                <div class="dash-empty dash-card">
                    <i class="far fa-cloud-download-alt"></i>
                    <h5>No downloads available yet</h5>
                    <a href="{{ route('frontend.index') }}" class="dash-btn dash-btn-primary">Go Shop <i class="fal fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection
