@extends('frontend.master')

@section('title')
    {{ $website->name ?? 'Store' }} || Team Details
@endsection

@php
    $member = \App\Models\TeamMember::find($memberId);
    $otherMembers = \App\Models\TeamMember::visible()
        ->where('id', '!=', $memberId)
        ->orderBy('sort_order')
        ->limit(4)
        ->get();
@endphp

@if(!$member)
    @section('content')
    <div class="container py-5 text-center">
        <h2 class="text-muted">Member not found.</h2>
        <a href="{{ route('frontend.team') }}" class="btn btn-primary mt-3">Back to Team</a>
    </div>
    @endsection
@else
@section('content')

<!-- BREADCRUMB -->
<section id="wsus__breadcrumb">
    <div class="wsus_breadcrumb_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>{{ $member->name }}</h4>
                    <ul>
                        <li><a href="{{ route('frontend.index') }}">Home</a></li>
                        <li><a href="{{ route('frontend.about') }}">About</a></li>
                        <li><a href="{{ route('frontend.team') }}">Team</a></li>
                        <li><a href="#">{{ $member->name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .profile-hero { background: linear-gradient(135deg, #f8fafc 0%, #ede9fe 100%); padding: 60px 0; }
    .profile-img-wrap { position:relative; }
    .profile-img-wrap img { width:240px; height:240px; object-fit:cover; border-radius:24px; border:6px solid #fff; box-shadow:0 20px 60px rgba(67,56,202,.15); }
    .profile-badge { position:absolute; bottom:-12px; left:50%; transform:translateX(-50%); background: linear-gradient(135deg,#4338ca,#7c3aed); color:#fff; padding:6px 18px; border-radius:999px; font-size:.8rem; font-weight:700; white-space:nowrap; }
    .skill-tag { display:inline-block; padding:6px 14px; background:#f1f5f9; color:#475569; border-radius:8px; font-size:.82rem; font-weight:600; margin:3px; border:1px solid #e2e8f0; }
    .social-btn { width:44px; height:44px; border-radius:12px; border:2px solid #e2e8f0; display:inline-flex; align-items:center; justify-content:center; color:#475569; text-decoration:none; transition:all .2s ease; font-size:1.1rem; }
    .social-btn:hover { background:#4338ca; border-color:#4338ca; color:#fff; transform:translateY(-3px); }
    .stat-card { background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:24px; text-align:center; transition:transform .2s; }
    .stat-card:hover { transform:translateY(-4px); box-shadow:0 10px 30px rgba(0,0,0,.06); }
</style>

<!-- PROFILE HERO -->
<section class="profile-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 text-center">
                <div class="profile-img-wrap">
                    @if($member->image)
                        <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=4338ca&color=fff&size=240" alt="{{ $member->name }}">
                    @endif
                    <span class="profile-badge">{{ $member->allDepartments[0] ?? $member->department }}</span>
                </div>
            </div>
            <div class="col-lg-7">
                <h1 class="fw-extrabold mb-1" style="font-size:2.2rem; color:#1e293b;">{{ $member->name }}</h1>
                <h4 class="mb-3" style="font-size:1.1rem; color:#7c3aed; font-weight:600;">{{ $member->role }}</h4>
                @if($member->bio)
                    <p class="text-muted mb-4" style="font-size:1rem; line-height:1.75; max-width:600px;">{{ $member->bio }}</p>
                @endif

                @if($member->skills && is_array($member->skills) && count($member->skills) > 0)
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @foreach($member->skills as $skill)
                        <span class="skill-tag"><i class="fas fa-check text-success me-1"></i>{{ $skill }}</span>
                    @endforeach
                </div>
                @endif

                <div class="d-flex gap-3 align-items-center flex-wrap">
                    @if($member->twitter)<a href="{{ $member->twitter }}" class="social-btn" title="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                    @if($member->linkedin)<a href="{{ $member->linkedin }}" class="social-btn" title="LinkedIn" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                    @if($member->github)<a href="{{ $member->github }}" class="social-btn" title="GitHub" target="_blank"><i class="fab fa-github"></i></a>@endif
                    @if($member->email)<a href="mailto:{{ $member->email }}" class="social-btn" title="Email"><i class="fas fa-envelope"></i></a>@endif
                    <a href="{{ route('frontend.team') }}" class="btn" style="background:#f1f5f9; color:#475569; font-weight:600; border-radius:10px; padding:10px 22px;">
                        <i class="fas fa-arrow-left me-1"></i> Back to Team
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- OTHER TEAM MEMBERS -->
@if($otherMembers->count() > 0)
<section class="py-5" style="background:#f8fafc;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0" style="color:#1e293b;">More Team Members</h4>
            <a href="{{ route('frontend.team') }}" class="btn btn-sm" style="background:#f1f5f9; color:#4338ca; font-weight:600; border-radius:8px;">View All</a>
        </div>
        <div class="row g-3">
            @foreach($otherMembers as $m)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <a href="{{ route('frontend.team_details', $m->id) }}" class="text-decoration-none">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:#fff; border:1px solid #e2e8f0; transition:all .2s;" onmouseover="this.style.borderColor='#4338ca';this.style.boxShadow='0 4px 20px rgba(67,56,202,.12)'" onmouseout="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                        @if($m->image)
                            <img src="{{ asset('storage/' . $m->image) }}" alt="{{ $m->name }}" class="rounded-circle" style="width:56px; height:56px; object-fit:cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($m->name) }}&background=4338ca&color=fff&size=56" alt="{{ $m->name }}" class="rounded-circle" style="width:56px; height:56px; object-fit:cover;">
                        @endif
                        <div>
                            <h6 class="mb-0 fw-bold" style="font-size:.9rem; color:#1e293b;">{{ $m->name }}</h6>
                            <small style="font-size:.78rem; color:#7c3aed; font-weight:600;">{{ $m->role }}</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
@endif
