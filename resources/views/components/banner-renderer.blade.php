{{-- Shared banner renderer — renders design_data JSON if present, falls back to legacy layout --}}
@props(['banner'])

@php
    $design = $banner->design_data;
@endphp

@if($design && isset($design['version']))
    {{-- New JSON-based design --}}
    @php
        $bg = $design['background'] ?? ['type' => 'color', 'value' => '#1e1b4b', 'overlay' => ['color' => '#000000', 'opacity' => 0]];
        $overlayColor = $bg['overlay']['color'] ?? '#000000';
        $overlayOpacity = $bg['overlay']['opacity'] ?? 0;
    @endphp

    <div class="wsus__design_banner" style="
        position:relative;
        width:100%;
        aspect-ratio:16/9;
        overflow:hidden;
        pointer-events:none;
        background:{{ $bg['type'] === 'color' ? ($bg['value'] ?? '#1e1b4b') : 'transparent' }};
    ">
        @if($bg['type'] === 'image' && !empty($bg['value']))
            <img src="{{ asset($bg['value']) }}"
                 style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"
                 alt="">
        @endif

        {{-- Gradient background via pseudo-element --}}
        @if($bg['type'] === 'gradient' || (isset($bg['gradient']) && $bg['gradient']))
            <div style="
                position:absolute;inset:0;width:100%;height:100%;
                background:{{ $bg['value'] ?? 'linear-gradient(135deg,#4f46e5,#7c3aed)' }};
            "></div>
        @endif

        {{-- Overlay --}}
        @if($overlayOpacity > 0)
            <div style="
                position:absolute;inset:0;
                background:{{ $overlayColor }};
                opacity:{{ $overlayOpacity }};
                pointer-events:none;
            "></div>
        @endif

        {{-- Elements --}}
        @foreach($design['elements'] ?? [] as $el)
            @if(($el['visible'] ?? true) === false)
                @continue
            @endif

            @php
                $scaleX = $el['width'] / 1920;
                $scaleY = $el['height'] / 1080;
            @endphp

            @if($el['type'] === 'text')
                <div style="
                    position:absolute;
                    left:{{ $el['x'] / 1920 * 100 }}%;
                    top:{{ $el['y'] / 1080 * 100 }}%;
                    width:{{ $el['width'] / 1920 * 100 }}%;
                    pointer-events:none;
                    user-select:none;
                    font-family:'{{ $el['fontFamily'] ?? 'Poppins' }}', sans-serif;
                    font-size:calc({{ $el['fontSize'] ?? 40 }}px * {{ $scaleX }});
                    font-weight:{{ $el['fontWeight'] ?? 400 }};
                    color:{{ $el['color'] ?? '#ffffff' }};
                    text-align:{{ $el['align'] ?? 'left' }};
                    line-height:{{ $el['lineHeight'] ?? 1.2 }};
                    letter-spacing:{{ $el['letterSpacing'] ?? 0 }}px;
                    opacity:{{ ($el['opacity'] ?? 100) / 100 }};
                    transform:rotate({{ $el['rotation'] ?? 0 }}deg);
                    word-break:break-word;
                ">{{ $el['content'] ?? '' }}</div>
            @elseif($el['type'] === 'button')
                @php
                    $btnBg = $el['background'] ?? '#1677FF';
                    $btnColor = $el['color'] ?? '#ffffff';
                    $btnRadius = $el['borderRadius'] ?? 12;
                    $btnFs = $el['fontSize'] ?? 22;
                    $btnW = $el['width'] / 1920 * 100;
                    $btnH = $el['height'] / 1080 * 100;
                    $link = $el['link'] ?? $banner->link_url;
                @endphp
                <div style="
                    position:absolute;
                    left:{{ $el['x'] / 1920 * 100 }}%;
                    top:{{ $el['y'] / 1080 * 100 }}%;
                    width:{{ $btnW }}%;
                    aspect-ratio:{{ $el['width'] / ($el['height'] ?: 64) }};
                    pointer-events:all;
                    opacity:{{ ($el['opacity'] ?? 100) / 100 }};
                ">
                    @if(!empty($link) && $link !== '#')
                        <a href="{{ $link }}"
                           style="
                               display:inline-flex;align-items:center;justify-content:center;
                               width:100%;height:100%;
                               background:{{ $btnBg }};color:{{ $btnColor }};
                               font-family:'{{ $el['fontFamily'] ?? 'Poppins' }}', sans-serif;
                               font-size:calc({{ $btnFs }}px * {{ $scaleX }});
                               font-weight:{{ $el['fontWeight'] ?? 600 }};
                               border-radius:{{ $btnRadius }}px;
                               text-decoration:none;
                               box-shadow:0 4px 14px rgba(0,0,0,.25);
                           ">{{ $el['content'] ?? 'Shop Now' }}</a>
                    @else
                        <div style="
                            display:inline-flex;align-items:center;justify-content:center;
                            width:100%;height:100%;
                            background:{{ $btnBg }};color:{{ $btnColor }};
                            font-family:'{{ $el['fontFamily'] ?? 'Poppins' }}', sans-serif;
                            font-size:calc({{ $btnFs }}px * {{ $scaleX }});
                            font-weight:{{ $el['fontWeight'] ?? 600 }};
                            border-radius:{{ $btnRadius }}px;
                        ">{{ $el['content'] ?? 'Shop Now' }}</div>
                    @endif
                </div>
            @elseif($el['type'] === 'image' && !empty($el['src']))
                <img src="{{ asset($el['src']) }}"
                     style="
                        position:absolute;
                        left:{{ $el['x'] / 1920 * 100 }}%;
                        top:{{ $el['y'] / 1080 * 100 }}%;
                        width:{{ $el['width'] / 1920 * 100 }}%;
                        aspect-ratio:{{ $el['width'] / ($el['height'] ?: $el['width']) }};
                        object-fit:contain;
                        pointer-events:none;
                        opacity:{{ ($el['opacity'] ?? 100) / 100 }};
                        transform:rotate({{ $el['rotation'] ?? 0 }}deg);
                     "
                     alt="">
            @endif
        @endforeach
    </div>
@else
    {{-- Legacy banner: use slot content --}}
    {{ $slot }}
@endif
