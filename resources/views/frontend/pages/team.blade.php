@extends('frontend.master')

@section('title')
    {{ $website->name ?? 'Store' }} || Team Members
@endsection

@php
    $team = \App\Models\TeamMember::visible()->get();
    $allDepts = [];
    foreach ($team as $m) {
        foreach ($m->allDepartments as $d) {
            $allDepts[$d] = $d;
        }
    }
    $depts = collect($allDepts)->sort()->values();
@endphp

@section('content')

<!-- BREADCRUMB -->
<section id="wsus__breadcrumb">
    <div class="wsus_breadcrumb_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>Team Members</h4>
                    <ul>
                        <li><a href="{{ route('frontend.index') }}">Home</a></li>
                        <li><a href="{{ route('frontend.about') }}">About</a></li>
                        <li><a href="#">Team Members</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .team-card {
        background:#fff; border:1px solid #e2e8f0; border-radius:18px; overflow:hidden;
        transition:transform .25s ease, box-shadow .25s ease;
    }
    .team-card:hover { transform: translateY(-6px); box-shadow:0 18px 40px rgba(15,23,42,.10); }
    .team-card-img { position:relative; overflow:hidden; aspect-ratio: 1/1; }
    .team-card-img img { width:100%; height:100%; object-fit:cover; transition:transform .5s ease; }
    .team-card:hover .team-card-img img { transform: scale(1.05); }
    .team-socials {
        position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
        background:linear-gradient(transparent 40%, rgba(67,56,202,.85));
        opacity:0; transition:opacity .25s ease;
    }
    .team-card:hover .team-socials { opacity:1; }
    .team-socials a {
        width:38px; height:38px; border-radius:50%; background:#fff; color:#4338ca;
        display:inline-flex; align-items:center; justify-content:center; margin:0 4px;
        transform:translateY(8px); opacity:0; transition:all .3s ease; text-decoration:none;
    }
    .team-card:hover .team-socials a { transform:translateY(0); opacity:1; }
    .team-socials a:hover { background:#4338ca; color:#fff; }
    .dept-filter .nav-pills .nav-link {
        border:1px solid #e2e8f0; color:#475569; font-weight:600; border-radius:999px;
        padding:8px 18px; font-size:.85rem; margin:0 4px;
    }
    .dept-filter .nav-pills .nav-link.active {
        background: linear-gradient(135deg, #4338ca, #7c3aed);
        color:#fff; border-color:transparent;
    }
</style>

<!-- TEAM HEADER -->
<section class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #ede9fe 100%);">
    <div class="container">
        <div class="text-center mx-auto" style="max-width:700px;">
            <span class="d-inline-block px-3 py-1 mb-3 rounded-pill" style="background:#fff; color:#7c3aed; font-weight:700; font-size:.75rem; letter-spacing:.08em;">OUR PEOPLE</span>
            <h1 class="fw-extrabold mb-3" style="font-size:2.4rem; color:#1e293b;">The people powering our platform.</h1>
            <p class="text-muted" style="font-size:1.05rem;">Designers, engineers, operators, and dreamers — get to know the humans behind every product release.</p>
        </div>
    </div>
</section>

<!-- DEPARTMENT FILTER -->
<section class="py-4" style="background:#fff;">
    <div class="container">
        <div class="dept-filter d-flex justify-content-center flex-wrap">
            <ul class="nav nav-pills" id="deptTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#all" type="button">All</button></li>
                @foreach($depts as $dept)
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#{{ strtolower($dept) }}" type="button">{{ $dept }}</button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</section>

<!-- TEAM GRID -->
<section class="pb-5" style="background:#fff;">
    <div class="container">
        <div class="tab-content" id="deptTabsContent">

            {{-- ALL --}}
            <div class="tab-pane fade show active" id="all">
                <div class="row g-4">
                    @forelse($team as $m)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="team-card h-100">
                                <div class="team-card-img">
                                    @if($m->image)
                                        <img src="{{ asset('storage/' . $m->image) }}" alt="{{ $m->name }}">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($m->name) }}&background=4338ca&color=fff&size=400" alt="{{ $m->name }}">
                                    @endif
                                    <div class="team-socials">
                                        @if($m->twitter)<a href="{{ $m->twitter }}" title="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                                        @if($m->linkedin)<a href="{{ $m->linkedin }}" title="LinkedIn" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                                        @if($m->github)<a href="{{ $m->github }}" title="GitHub" target="_blank"><i class="fab fa-github"></i></a>@endif
                                        <a href="{{ route('frontend.team_details', $m->id) }}" title="Profile"><i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                                <div class="p-3 text-center">
                                    <h5 class="fw-bold mb-1" style="font-size:1rem; color:#1e293b;">{{ $m->name }}</h5>
                                    <small style="font-size:.85rem; color:#7c3aed; font-weight:600;">{{ $m->role }}</small>
                                    <div class="mt-3">
                                        <a href="{{ route('frontend.team_details', $m->id) }}" class="btn btn-sm" style="background:#f1f5f9; color:#4338ca; font-weight:600; border-radius:8px; font-size:.8rem;">View Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">
                            <i class="fas fa-users" style="font-size:3rem; opacity:.3;"></i>
                            <p class="mt-3">No team members yet. Check back soon!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- DEPARTMENT VIEWS (re-use same data) --}}
            @foreach($depts as $dept)
                <div class="tab-pane fade" id="{{ strtolower($dept) }}">
                    <div class="row g-4">
                        @foreach($team->filter(fn($m) => in_array($dept, $m->allDepartments)) as $m)
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="team-card h-100">
                                    <div class="team-card-img">
                                        @if($m->image)
                                            <img src="{{ asset('storage/' . $m->image) }}" alt="{{ $m->name }}">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($m->name) }}&background=4338ca&color=fff&size=400" alt="{{ $m->name }}">
                                        @endif
                                        <div class="team-socials">
                                            @if($m->twitter)<a href="{{ $m->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>@endif
                                            @if($m->linkedin)<a href="{{ $m->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>@endif
                                            @if($m->github)<a href="{{ $m->github }}" target="_blank"><i class="fab fa-github"></i></a>@endif
                                            <a href="{{ route('frontend.team_details', $m->id) }}"><i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="p-3 text-center">
                                        <h5 class="fw-bold mb-1" style="font-size:1rem; color:#1e293b;">{{ $m->name }}</h5>
                                        <small style="font-size:.85rem; color:#7c3aed; font-weight:600;">{{ $m->role }}</small>
                                        <div class="mt-3">
                                            <a href="{{ route('frontend.team_details', $m->id) }}" class="btn btn-sm" style="background:#f1f5f9; color:#4338ca; font-weight:600; border-radius:8px; font-size:.8rem;">View Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

<!-- JOIN US CTA -->
<section class="py-5" style="background: linear-gradient(135deg, #4338ca 0%, #7c3aed 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 text-white">
                <h3 class="fw-extrabold mb-2" style="font-size:1.8rem;">Want to join the team?</h3>
                <p class="mb-0 text-white-50" style="font-size:1rem;">We're hiring across engineering, design, support, and operations.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('frontend.contact') }}" class="btn btn-light btn-lg fw-bold px-4" style="border-radius:12px;">Get in touch</a>
            </div>
        </div>
    </div>
</section>

@endsection
