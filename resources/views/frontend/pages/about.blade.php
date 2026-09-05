@extends('frontend.master')

@section('title')
    {{ $website->name ?? 'Store' }} || About Us
@endsection

@php
    use App\Models\AboutSection;
    $stats        = \App\Models\SiteInfo::visibleStats();
    $teamPreview  = \App\Models\TeamMember::visible()->take(4)->get();
    $heroTitle    = AboutSection::section('hero_title');
    $heroText     = AboutSection::section('hero_text');
    $capTitle     = AboutSection::section('hero_caption_title');
    $capText      = AboutSection::section('hero_caption_text');
    $missionCards = AboutSection::ofType('mission_card');
    $teamIntroT   = AboutSection::section('team_intro_title');
    $teamIntroB   = AboutSection::section('team_intro_text');
@endphp

@section('content')

<!-- BREADCRUMB -->
<section id="wsus__breadcrumb">
    <div class="wsus_breadcrumb_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h4>About Us</h4>
                    <ul>
                        <li><a href="{{ route('frontend.index') }}">Home</a></li>
                        <li><a href="#">About Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ABOUT HERO -->
<section id="wsus__about" class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-xl-6">
                <span class="d-inline-block px-3 py-1 mb-3 rounded-pill" style="background:#ede9fe; color:#7c3aed; font-weight:700; font-size:.75rem; letter-spacing:.08em;">WHO WE ARE</span>
                <h2 class="fw-extrabold mb-4" style="font-size:2.6rem; line-height:1.15; color:#1e293b;">{{ $heroTitle->title ?? 'About Us' }}</h2>
                <p class="mb-4" style="font-size:1.05rem; color:#475569; line-height:1.75;">{{ $heroText->text ?? '' }}</p>
                @if($stats->count() > 0)
                <div class="row g-3 mt-2">
                    @foreach($stats as $stat)
                        <div class="col-6 col-sm-3">
                            <div class="p-3 rounded-3 text-center" style="background:#fff; border:1px solid #e2e8f0; box-shadow:0 4px 20px rgba(0,0,0,.04);">
                                @if($stat->icon)<i class="{{ $stat->icon }} d-block mb-2" style="font-size:1.2rem; color:#4338ca;"></i>@endif
                                <h4 class="fw-extrabold mb-1" style="font-size:1.4rem; color:#4338ca;">{{ $stat->value }}</h4>
                                <small class="text-muted">{{ $stat->label }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="row g-3 mt-2">
                    <div class="col-6 col-sm-3">
                        <div class="p-3 rounded-3 text-center" style="background:#fff; border:1px solid #e2e8f0; box-shadow:0 4px 20px rgba(0,0,0,.04);">
                            <h4 class="fw-extrabold mb-1" style="font-size:1.4rem; color:#4338ca;">—</h4>
                            <small class="text-muted text-danger">No stats set</small>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-xl-6">
                <div class="position-relative">
                    <img src="{{ asset('frontend/images/hero-shop.jpg') }}" onerror="this.src='{{ asset('frontend/images/logo.png') }}'" alt="Team" class="img-fluid rounded-4 shadow-lg" style="object-fit:cover; height:420px; width:100%;">
                    <div class="position-absolute bottom-0 start-0 end-0 p-4 rounded-bottom-4" style="background: linear-gradient(transparent, rgba(30,41,59,.85));">
                        <h5 class="text-white fw-bold mb-1">{{ $capTitle->title ?? '' }}</h5>
                        <p class="text-white-50 mb-0" style="font-size:.9rem;">{{ $capText->text ?? '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MISSION & VALUES -->
@php
    $missionPalette = [
        'purple' => ['bg' => '#ede9fe', 'color' => '#7c3aed'],
        'green'  => ['bg' => '#dcfce7', 'color' => '#15803d'],
        'red'    => ['bg' => '#fee2e2', 'color' => '#b91c1c'],
        'blue'   => ['bg' => '#dbeafe', 'color' => '#1d4ed8'],
        'amber'  => ['bg' => '#fef3c7', 'color' => '#b45309'],
    ];
@endphp
<section class="py-5" style="background:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-extrabold" style="font-size:2rem; color:#1e293b;">Our Mission & Values</h2>
            <p class="text-muted" style="max-width:600px; margin:0 auto;">Principles that guide every decision, product update, and partnership we make.</p>
        </div>
        @if($missionCards->count() > 0)
        <div class="row g-4">
            @foreach($missionCards as $card)
                @php $palette = $missionPalette[$card->color] ?? $missionPalette['purple']; @endphp
                <div class="col-md-4">
                    <div class="p-4 rounded-4 h-100" style="background:#f8fafc; border:1px solid #e2e8f0; transition:transform .2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                        <div class="d-flex align-items-center justify-content-center rounded-3 mb-3" style="width:56px; height:56px; background:{{ $palette['bg'] }}; color:{{ $palette['color'] }}; font-size:1.25rem;">
                            <i class="{{ $card->icon ?? 'fas fa-circle' }}"></i>
                        </div>
                        <h5 class="fw-bold mb-2">{{ $card->title }}</h5>
                        <p class="mb-0 text-muted" style="font-size:.92rem; line-height:1.65;">{{ $card->text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-muted">Mission & Values content is not configured yet.</p>
        @endif
    </div>
</section>

<!-- TEAM PREVIEW + LINK -->
<section class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-xl-7">
                <h2 class="fw-extrabold mb-3" style="font-size:2rem; color:#1e293b;">{{ $teamIntroT->title ?? 'Meet the people behind the platform.' }}</h2>
                <p class="mb-4" style="font-size:1.05rem; color:#475569; line-height:1.75;">{{ $teamIntroB->text ?? '' }}</p>
                <a href="{{ route('frontend.team') }}" class="dash-btn dash-btn-primary" style="text-decoration:none;">View Full Team <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="col-xl-5">
                @if($teamPreview->count() > 0)
                <div class="d-flex gap-3 overflow-auto pb-2">
                    @foreach($teamPreview as $m)
                        <a href="{{ route('frontend.team_details', $m->id) }}" class="text-decoration-none flex-shrink-0 text-center" style="width:120px;">
                            @if($m->image)
                                <img src="{{ asset('storage/' . $m->image) }}" alt="{{ $m->name }}" class="rounded-circle mb-2 shadow-sm" style="width:100px; height:100px; object-fit:cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($m->name) }}&background=4338ca&color=fff&size=100" alt="{{ $m->name }}" class="rounded-circle mb-2 shadow-sm" style="width:100px; height:100px; object-fit:cover;">
                            @endif
                            <h6 class="mb-0 fw-bold" style="font-size:.85rem; color:#1e293b;">{{ $m->name }}</h6>
                            <small style="font-size:.75rem; color:#64748b;">{{ $m->role }}</small>
                        </a>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-users" style="font-size:2rem; opacity:.4;"></i>
                    <p class="mb-0 mt-2" style="font-size:.9rem;">No team members yet.<br><a href="{{ route('frontend.team') }}">View team</a></p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
