<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Banner Preview — {{ $banner->title ?: 'Untitled' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #111; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; font-family: sans-serif; }
        .preview-wrap { position: relative; width: 100%; max-width: 1920px; }
        .preview-canvas {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: {{ $design['background']['value'] ?? '#1e1b4b' }};
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 20px 60px rgba(0,0,0,.5);
        }
        .preview-element {
            position: absolute;
            user-select: none;
            pointer-events: none;
        }
        .preview-element.button-wrap {
            pointer-events: all;
        }
        .preview-text {
            word-break: break-word;
        }
        .preview-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }
        .preview-info {
            color: #888;
            text-align: center;
            padding: 14px;
            font-size: 13px;
        }
        .preview-info a { color: #6c5ce7; }
        .preview-label {
            position: absolute;
            top: 10px; left: 10px;
            background: rgba(0,0,0,.6);
            color: #fff;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
            z-index: 10;
        }
    </style>
</head>
<body>
    <div class="preview-wrap">
        <div class="preview-canvas" id="previewCanvas">
            <span class="preview-label">Preview Mode</span>

            @php
                $bg = $design['background'] ?? ['type' => 'color', 'value' => '#1e1b4b', 'overlay' => ['color' => '#000000', 'opacity' => 0]];
                $overlayColor = $bg['overlay']['color'] ?? '#000000';
                $overlayOpacity = $bg['overlay']['opacity'] ?? 0;
            @endphp

            @if($bg['type'] === 'image' && !empty($bg['value']))
                <img src="{{ asset($bg['value']) }}"
                     style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;"
                     alt="">
            @endif

            <div class="preview-overlay"
                 style="background:{{ $overlayColor }};opacity:{{ $overlayOpacity }};"></div>

            @foreach($design['elements'] ?? [] as $el)
                @if(($el['visible'] ?? true) === false)
                    @continue
                @endif

                @php
                    $style = sprintf(
                        'left:%.2f%%;top:%.2f%%;width:%.2f%%;height:%.2f%%;opacity:%d;transform:rotate(%ddeg);',
                        ($el['x'] ?? 0) / 1920 * 100,
                        ($el['y'] ?? 0) / 1080 * 100,
                        ($el['width'] ?? 100) / 1920 * 100,
                        ($el['height'] ?? 50) / 1080 * 100,
                        $el['opacity'] ?? 100,
                        $el['rotation'] ?? 0
                    );
                @endphp

                @if($el['type'] === 'text')
                    <div class="preview-element preview-text" style="{{ $style }}
                        font-family:'{{ $el['fontFamily'] ?? 'Poppins' }}', sans-serif;
                        font-size:{{ $el['fontSize'] ?? 40 }}px;
                        font-weight:{{ $el['fontWeight'] ?? 400 }};
                        color:{{ $el['color'] ?? '#ffffff' }};
                        text-align:{{ $el['align'] ?? 'left' }};
                        line-height:{{ $el['lineHeight'] ?? 1.2 }};
                        letter-spacing:{{ $el['letterSpacing'] ?? 0 }}px;
                    ">{{ $el['content'] ?? '' }}</div>
                @elseif($el['type'] === 'button')
                    @php
                        $btnColor = $el['color'] ?? '#ffffff';
                        $btnBg = $el['background'] ?? '#1677FF';
                        $btnRadius = $el['borderRadius'] ?? 12;
                        $btnFs = $el['fontSize'] ?? 22;
                    @endphp
                    <div class="preview-element" style="{{ $style }}">
                        @if(!empty($el['link']))
                            <a href="{{ $el['link'] }}" target="_blank" style="
                                display:inline-flex;align-items:center;justify-content:center;
                                padding:{{ ($el['height'] ?? 64) * 0.4 }}px {{ ($el['width'] ?? 240) * 0.2 }}px;
                                background:{{ $btnBg }};color:{{ $btnColor }};
                                font-family:'{{ $el['fontFamily'] ?? 'Poppins' }}', sans-serif;
                                font-size:{{ $btnFs }}px;font-weight:{{ $el['fontWeight'] ?? 600 }};
                                border-radius:{{ $btnRadius }}px;text-decoration:none;pointer-events:all;
                                box-shadow:0 4px 14px rgba(0,0,0,.25);
                            ">{{ $el['content'] ?? 'Button' }}</a>
                        @else
                            <div style="
                                display:inline-flex;align-items:center;justify-content:center;
                                padding:{{ ($el['height'] ?? 64) * 0.4 }}px {{ ($el['width'] ?? 240) * 0.2 }}px;
                                background:{{ $btnBg }};color:{{ $btnColor }};
                                font-family:'{{ $el['fontFamily'] ?? 'Poppins' }}', sans-serif;
                                font-size:{{ $btnFs }}px;font-weight:{{ $el['fontWeight'] ?? 600 }};
                                border-radius:{{ $btnRadius }}px;
                            ">{{ $el['content'] ?? 'Button' }}</div>
                        @endif
                    </div>
                @elseif($el['type'] === 'image' && !empty($el['src']))
                    <img class="preview-element" src="{{ asset($el['src']) }}" style="{{ $style }} object-fit:contain;" alt="">
                @endif
            @endforeach
        </div>
        <div class="preview-info">
            Banner: <strong>{{ $banner->title ?: 'Untitled' }}</strong> &nbsp;·&nbsp;
            Size: <strong>1920 × 1080</strong> &nbsp;·&nbsp;
            <a href="{{ route('admin.edit_banner', $banner->id) }}">← Back to editor</a>
        </div>
    </div>
</body>
</html>
