@extends('admin.master')

@section('styles')
    <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        :root {
            --ed-bg: #0f0e1a;
            --ed-panel: #1a1929;
            --ed-panel-2: #232235;
            --ed-border: #2d2c45;
            --ed-text: #e2e1f4;
            --ed-muted: #8a89a8;
            --ed-primary: #6c5ce7;
            --ed-primary-2: #a29bfe;
            --ed-accent: #00d4ff;
            --ed-success: #10b981;
            --ed-danger: #ef4444;
            --ed-warning: #f59e0b;
        }

        .ed-shell {
            display: flex;
            flex-direction: column;
            background: var(--ed-bg);
            color: var(--ed-text);
            border-radius: 14px;
            overflow: hidden;
            min-height: 760px;
            margin: -28px;
            box-shadow: 0 20px 50px rgba(0,0,0,.4);
        }

        /* ===== TOP BAR ===== */
        .ed-topbar {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            background: var(--ed-panel);
            border-bottom: 1px solid var(--ed-border);
            gap: 14px;
            flex-wrap: wrap;
        }
        .ed-brand {
            display: flex; align-items: center; gap: 10px;
            font-weight: 700; color: var(--ed-text); font-size: 15px;
        }
        .ed-brand i { color: var(--ed-primary-2); }
        .ed-divider { width: 1px; height: 26px; background: var(--ed-border); }
        .ed-name-input {
            background: transparent; border: 1px solid transparent; color: var(--ed-text);
            padding: 6px 10px; border-radius: 6px; font-size: 13px; min-width: 220px;
        }
        .ed-name-input:hover, .ed-name-input:focus { border-color: var(--ed-border); outline: none; background: var(--ed-panel-2); }

        .ed-topbar-actions { margin-left: auto; display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .ed-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 12px; border-radius: 8px; font-size: 13px; font-weight: 600;
            border: 1px solid var(--ed-border); background: var(--ed-panel-2); color: var(--ed-text);
            cursor: pointer; transition: all .15s ease;
        }
        .ed-btn:hover { background: var(--ed-border); transform: translateY(-1px); }
        .ed-btn.primary { background: var(--ed-primary); border-color: var(--ed-primary); color: #fff; }
        .ed-btn.primary:hover { background: var(--ed-primary-2); color: #1a1929; }
        .ed-btn.success { background: var(--ed-success); border-color: var(--ed-success); color: #fff; }
        .ed-btn.success:hover { filter: brightness(1.1); }
        .ed-btn.danger { background: var(--ed-danger); border-color: var(--ed-danger); color: #fff; }
        .ed-btn.outline { background: transparent; }
        .ed-btn.icon { padding: 7px 9px; }

        /* ===== MAIN LAYOUT ===== */
        .ed-main {
            display: grid;
            grid-template-columns: 240px 1fr 280px;
            flex: 1;
            min-height: 700px;
        }

        /* ===== LEFT PANEL (TOOLBAR) ===== */
        .ed-left {
            background: var(--ed-panel);
            border-right: 1px solid var(--ed-border);
            padding: 12px;
            display: flex; flex-direction: column; gap: 10px;
            overflow-y: auto;
        }
        .ed-section-title {
            font-size: 10px; text-transform: uppercase; letter-spacing: .14em;
            color: var(--ed-muted); font-weight: 700; margin: 8px 4px 4px;
        }
        .ed-tool {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px; cursor: pointer;
            color: var(--ed-text); font-size: 13px; font-weight: 500;
            border: 1px solid transparent;
            transition: all .15s ease;
        }
        .ed-tool:hover { background: var(--ed-panel-2); border-color: var(--ed-border); }
        .ed-tool i { width: 18px; text-align: center; color: var(--ed-primary-2); }
        .ed-tool .ed-kbd { margin-left: auto; font-size: 10px; color: var(--ed-muted); }
        .ed-tool-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 8px;
        }
        .ed-tool-grid .ed-tool { flex-direction: column; align-items: center; gap: 6px; padding: 12px 6px; text-align: center; }
        .ed-tool-grid .ed-tool .ed-kbd { display: none; }

        /* ===== CANVAS AREA ===== */
        .ed-stage {
            background:
                linear-gradient(45deg, #16151f 25%, transparent 25%),
                linear-gradient(-45deg, #16151f 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #16151f 75%),
                linear-gradient(-45deg, transparent 75%, #16151f 75%);
            background-size: 24px 24px;
            background-position: 0 0, 0 12px, 12px -12px, 12px 0;
            background-color: #0a0913;
            position: relative;
            display: flex; flex-direction: column;
            overflow: hidden;
        }
        .ed-canvas-wrap {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            overflow: auto;
            padding: 28px;
        }
        .ed-canvas-frame {
            box-shadow: 0 25px 80px rgba(0,0,0,.6), 0 0 0 1px rgba(255,255,255,.05);
            border-radius: 6px;
            background: white;
            transform-origin: center center;
            flex-shrink: 0;
        }
        .ed-canvas-frame canvas { display: block; }

        .ed-stage-bar {
            display: flex; align-items: center; justify-content: space-between;
            padding: 8px 16px;
            background: var(--ed-panel);
            border-top: 1px solid var(--ed-border);
            font-size: 12px; color: var(--ed-muted);
        }
        .ed-zoom-group { display: flex; align-items: center; gap: 6px; }
        .ed-zoom-group .ed-btn { padding: 4px 8px; }

        /* ===== RIGHT PANEL ===== */
        .ed-right {
            background: var(--ed-panel);
            border-left: 1px solid var(--ed-border);
            display: flex; flex-direction: column;
            overflow: hidden;
        }
        .ed-tabs {
            display: flex;
            background: var(--ed-panel-2);
            border-bottom: 1px solid var(--ed-border);
        }
        .ed-tab {
            flex: 1; padding: 12px 8px; text-align: center;
            font-size: 12px; font-weight: 600; color: var(--ed-muted);
            cursor: pointer; border-bottom: 2px solid transparent;
            text-transform: uppercase; letter-spacing: .08em;
            transition: all .15s ease;
        }
        .ed-tab.active { color: var(--ed-primary-2); border-bottom-color: var(--ed-primary); }
        .ed-tab:hover { color: var(--ed-text); }

        .ed-panels { flex: 1; overflow-y: auto; padding: 14px; }
        .ed-pane { display: none; }
        .ed-pane.active { display: block; }

        /* Property rows */
        .ed-prop { margin-bottom: 12px; }
        .ed-prop-label {
            display: block; font-size: 11px; font-weight: 700; color: var(--ed-muted);
            text-transform: uppercase; letter-spacing: .08em; margin-bottom: 4px;
        }
        .ed-input, .ed-select, .ed-textarea {
            width: 100%; padding: 7px 10px; font-size: 13px;
            background: var(--ed-panel-2); color: var(--ed-text);
            border: 1px solid var(--ed-border); border-radius: 6px;
            transition: all .15s ease;
        }
        .ed-input:focus, .ed-select:focus, .ed-textarea:focus {
            outline: none; border-color: var(--ed-primary);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, .18);
        }
        .ed-textarea { resize: vertical; min-height: 60px; font-family: inherit; }
        .ed-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .ed-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 8px; }
        .ed-color-wrap {
            display: flex; align-items: center; gap: 8px;
            padding: 4px 8px; background: var(--ed-panel-2);
            border: 1px solid var(--ed-border); border-radius: 6px;
        }
        .ed-color-swatch {
            width: 22px; height: 22px; border-radius: 4px;
            border: 1px solid var(--ed-border); cursor: pointer; flex-shrink: 0;
        }
        .ed-color-text {
            flex: 1; background: transparent; border: none; color: var(--ed-text);
            font-family: 'SF Mono', Menlo, monospace; font-size: 12px; outline: none;
            width: 100%;
        }
        .ed-align-group { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 4px; }
        .ed-align-group .ed-btn { justify-content: center; padding: 6px 8px; }
        .ed-align-group .ed-btn.active { background: var(--ed-primary); color: #fff; }

        .ed-empty {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-align: center; padding: 40px 20px; color: var(--ed-muted);
        }
        .ed-empty i { font-size: 36px; margin-bottom: 12px; opacity: .4; }

        /* Layers list */
        .ed-layers { display: flex; flex-direction: column; gap: 4px; }
        .ed-layer {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 10px; border-radius: 6px;
            background: var(--ed-panel-2); border: 1px solid var(--ed-border);
            font-size: 12px; cursor: grab;
        }
        .ed-layer:hover { border-color: var(--ed-primary); }
        .ed-layer.selected { background: rgba(108, 92, 231, .18); border-color: var(--ed-primary); }
        .ed-layer-icon { width: 16px; text-align: center; color: var(--ed-primary-2); }
        .ed-layer-name { flex: 1; font-weight: 500; color: var(--ed-text); overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .ed-layer-name[contenteditable="true"]:focus { outline: 1px solid var(--ed-primary); border-radius: 3px; padding: 1px 3px; }
        .ed-layer-actions { display: flex; gap: 2px; }
        .ed-layer-action {
            width: 22px; height: 22px; display: inline-flex; align-items: center; justify-content: center;
            border-radius: 4px; color: var(--ed-muted); cursor: pointer;
            background: transparent; border: none; font-size: 11px;
        }
        .ed-layer-action:hover { background: var(--ed-border); color: var(--ed-text); }
        .ed-layer-action.danger:hover { color: var(--ed-danger); }
        .ed-layer-action.muted { opacity: .35; }

        /* Templates grid */
        .ed-templates { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .ed-template {
            border: 1px solid var(--ed-border); border-radius: 8px; padding: 8px;
            cursor: pointer; background: var(--ed-panel-2);
            transition: all .15s ease;
        }
        .ed-template:hover { border-color: var(--ed-primary); transform: translateY(-1px); }
        .ed-template-thumb {
            aspect-ratio: 16/9; border-radius: 5px; margin-bottom: 6px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; color: white;
        }
        .ed-template-name { font-size: 11px; font-weight: 600; color: var(--ed-text); text-align: center; }

        /* Status indicators */
        .ed-coord {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 2px 8px; background: var(--ed-panel-2);
            border-radius: 4px; font-size: 11px; color: var(--ed-muted);
        }

        .ed-divider-line { height: 1px; background: var(--ed-border); margin: 12px 0; }

        .ed-fullscreen {
            position: fixed; inset: 0; z-index: 9999;
            background: var(--ed-bg);
            display: flex; flex-direction: column;
        }
        .ed-fullscreen .ed-shell { border-radius: 0; margin: 0; min-height: 100vh; }
        .ed-fullscreen .ed-canvas-wrap { height: calc(100vh - 110px); }
    </style>
@endsection

@section('content')
    <div class="ed-shell" id="editorShell">

        {{-- ===== TOP BAR ===== --}}
        <div class="ed-topbar">
            <div class="ed-brand">
                <i class="fas fa-palette"></i>
                Banner Editor
            </div>
            <div class="ed-divider"></div>
            <a href="{{ route('admin.banners') }}" class="ed-btn icon outline" title="Back to banners">
                <i class="fas fa-arrow-left"></i>
            </a>
            <input type="text" class="ed-name-input" id="bannerName"
                   value="{{ $banner->title ?: 'Untitled Banner' }}"
                   placeholder="Banner name">

            <div class="ed-topbar-actions">
                <button type="button" class="ed-btn icon" id="undoBtn" title="Undo (Ctrl+Z)">
                    <i class="fas fa-undo"></i>
                </button>
                <button type="button" class="ed-btn icon" id="redoBtn" title="Redo (Ctrl+Y)">
                    <i class="fas fa-redo"></i>
                </button>
                <div class="ed-divider"></div>
                <button type="button" class="ed-btn outline" id="previewToggle" title="Preview">
                    <i class="fas fa-eye"></i> Preview
                </button>
                <button type="button" class="ed-btn outline" id="fullscreenBtn" title="Fullscreen">
                    <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="ed-btn primary" id="saveBtn">
                    <i class="fas fa-save"></i> Save
                </button>
                <a href="{{ route('admin.banners') }}" class="ed-btn outline">
                    <i class="fas fa-times"></i> Exit
                </a>
            </div>
        </div>

        {{-- ===== MAIN ===== --}}
        <div class="ed-main">

            {{-- LEFT TOOLS --}}
            <div class="ed-left">
                <div class="ed-section-title">Add Element</div>
                <div class="ed-tool-grid">
                    <div class="ed-tool" data-add="text">
                        <i class="fas fa-font"></i> Text
                    </div>
                    <div class="ed-tool" data-add="heading">
                        <i class="fas fa-heading"></i> Heading
                    </div>
                    <div class="ed-tool" data-add="button">
                        <i class="fas fa-square"></i> Button
                    </div>
                    <div class="ed-tool" data-add="image">
                        <i class="fas fa-image"></i> Image
                    </div>
                </div>

                <div class="ed-section-title">Background</div>
                <div class="ed-prop">
                    <select class="ed-select" id="bgType">
                        <option value="color">Solid color</option>
                        <option value="gradient">Gradient</option>
                        <option value="image">Image</option>
                    </select>
                </div>
                <div class="ed-prop" id="bgColorWrap">
                    <div class="ed-color-wrap">
                        <input type="color" class="ed-color-swatch" id="bgColorSwatch" value="#1e1b4b">
                        <input type="text" class="ed-color-text" id="bgColorText" value="#1e1b4b">
                    </div>
                </div>
                <div class="ed-prop" id="bgImageWrap" style="display:none;">
                    <input type="file" id="bgImageInput" accept="image/*" class="ed-input" style="padding: 4px;">
                </div>
                <div class="ed-prop" id="bgGradientWrap" style="display:none;">
                    <div class="ed-row" style="margin-bottom:6px;">
                        <div>
                            <div class="ed-prop-label">From</div>
                            <input type="color" class="ed-color-swatch" id="bgGradFrom" value="#4f46e5" style="width:100%; height:32px;">
                        </div>
                        <div>
                            <div class="ed-prop-label">To</div>
                            <input type="color" class="ed-color-swatch" id="bgGradTo" value="#7c3aed" style="width:100%; height:32px;">
                        </div>
                    </div>
                    <select class="ed-select" id="bgGradAngle">
                        <option value="135">Diagonal ↘</option>
                        <option value="90">Top to bottom</option>
                        <option value="45">Diagonal ↗</option>
                        <option value="180">Bottom to top</option>
                        <option value="0">Left to right</option>
                    </select>
                </div>
                <div class="ed-prop">
                    <label class="ed-prop-label">Overlay</label>
                    <div class="ed-row">
                        <input type="color" class="ed-color-swatch" id="bgOverlayColor" value="#000000" style="width:100%; height:32px; padding:0;">
                        <input type="number" class="ed-input" id="bgOverlayOpacity" value="0" min="0" max="100" placeholder="Opacity %">
                    </div>
                </div>

                <div class="ed-section-title">Layout</div>
                <div class="ed-tool" id="duplicateBtn">
                    <i class="fas fa-copy"></i> Duplicate
                    <span class="ed-kbd">⌘D</span>
                </div>
                <div class="ed-tool" id="deleteBtn">
                    <i class="fas fa-trash"></i> Delete
                    <span class="ed-kbd">Del</span>
                </div>
                <div class="ed-tool" id="bringForwardBtn">
                    <i class="fas fa-layer-group"></i> Bring forward
                </div>
                <div class="ed-tool" id="sendBackwardBtn">
                    <i class="fas fa-layer-group fa-rotate-180"></i> Send backward
                </div>
                <div class="ed-tool" id="centerHBtn">
                    <i class="fas fa-arrows-alt-h"></i> Center H
                </div>
                <div class="ed-tool" id="centerVBtn">
                    <i class="fas fa-arrows-alt-v"></i> Center V
                </div>
            </div>

            {{-- CANVAS --}}
            <div class="ed-stage">
                <div class="ed-canvas-wrap" id="canvasWrap">
                    <div class="ed-canvas-frame" id="canvasFrame">
                        <canvas id="bannerCanvas" width="1920" height="1080"></canvas>
                    </div>
                </div>
                <div class="ed-stage-bar">
                    <div>
                        <span class="ed-coord" id="zoomLabel">100%</span>
                        <span class="ed-coord" id="sizeLabel">1920 × 1080</span>
                        <span class="ed-coord" id="selectionLabel" style="display:none;"></span>
                    </div>
                    <div class="ed-zoom-group">
                        <button class="ed-btn icon" id="zoomOutBtn" title="Zoom out">−</button>
                        <button class="ed-btn outline" id="zoomFitBtn">Fit</button>
                        <button class="ed-btn icon" id="zoomInBtn" title="Zoom in">+</button>
                        <button class="ed-btn icon" id="zoomResetBtn" title="Reset to 100%">1:1</button>
                    </div>
                </div>
            </div>

            {{-- RIGHT PANEL --}}
            <div class="ed-right">
                <div class="ed-tabs">
                    <div class="ed-tab active" data-tab="properties">Properties</div>
                    <div class="ed-tab" data-tab="layers">Layers</div>
                    <div class="ed-tab" data-tab="templates">Templates</div>
                </div>
                <div class="ed-panels">

                    {{-- PROPERTIES TAB --}}
                    <div class="ed-pane active" id="pane-properties">
                        <div id="propMeta" style="margin-bottom:14px; padding-bottom:14px; border-bottom:1px solid var(--ed-border);">
                            <div class="ed-section-title">Banner Settings</div>
                            <div class="ed-prop">
                                <label class="ed-prop-label">Page</label>
                                <select class="ed-select" id="metaPage" onchange="document.getElementById('formPage').value=this.value">
                                    <option value="home" selected>Homepage</option>
                                    <option value="about">About</option>
                                    <option value="products">Products</option>
                                </select>
                            </div>
                            <div class="ed-row">
                                <div>
                                    <label class="ed-prop-label">Position</label>
                                    <select class="ed-select" id="metaPosition" onchange="document.getElementById('formPosition').value=this.value">
                                        <option value="hero" selected>Hero</option>
                                        <option value="below">Below Hero</option>
                                        <option value="footer">Footer</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="ed-prop-label">Priority</label>
                                    <input type="number" class="ed-input" id="metaPriority" value="1" min="1" onchange="document.getElementById('formPriority').value=this.value">
                                </div>
                            </div>
                            <div class="ed-prop">
                                <label class="ed-prop-label">Link (optional)</label>
                                <input type="text" class="ed-input" id="metaLink" placeholder="/products or https://..." oninput="document.getElementById('formLink').value=this.value || '#'">
                            </div>
                        </div>

                        <div id="propEmpty" class="ed-empty">
                            <i class="fas fa-mouse-pointer"></i>
                            <div>Select an element to edit its properties</div>
                        </div>

                        <div id="propForm" style="display:none;">
                            {{-- Position & Size --}}
                            <div class="ed-section-title">Position &amp; Size</div>
                            <div class="ed-row-3" style="margin-bottom:8px;">
                                <div>
                                    <label class="ed-prop-label">X</label>
                                    <input type="number" class="ed-input" id="propX">
                                </div>
                                <div>
                                    <label class="ed-prop-label">Y</label>
                                    <input type="number" class="ed-input" id="propY">
                                </div>
                            </div>
                            <div class="ed-row-3" style="margin-bottom:8px;">
                                <div>
                                    <label class="ed-prop-label">W</label>
                                    <input type="number" class="ed-input" id="propW" min="1">
                                </div>
                                <div>
                                    <label class="ed-prop-label">H</label>
                                    <input type="number" class="ed-input" id="propH" min="1">
                                </div>
                                <div>
                                    <label class="ed-prop-label">Rotation</label>
                                    <input type="number" class="ed-input" id="propRot" min="0" max="360" step="1">
                                </div>
                            </div>
                            <div class="ed-row-3">
                                <div>
                                    <label class="ed-prop-label">Opacity</label>
                                    <input type="number" class="ed-input" id="propOpacity" min="0" max="100" value="100">
                                </div>
                            </div>

                            {{-- TEXT PROPS --}}
                            <div id="propTextBlock">
                                <div class="ed-divider-line"></div>
                                <div class="ed-section-title">Text</div>
                                <div class="ed-prop">
                                    <label class="ed-prop-label">Content</label>
                                    <textarea class="ed-textarea" id="propText" rows="2"></textarea>
                                </div>
                                <div class="ed-row">
                                    <div>
                                        <label class="ed-prop-label">Font</label>
                                        <select class="ed-select" id="propFont">
                                            <option value="Poppins">Poppins</option>
                                            <option value="Inter">Inter</option>
                                            <option value="Roboto">Roboto</option>
                                            <option value="Montserrat">Montserrat</option>
                                            <option value="Playfair Display">Playfair Display</option>
                                            <option value="Bebas Neue">Bebas Neue</option>
                                            <option value="Oswald">Oswald</option>
                                            <option value="Lato">Lato</option>
                                            <option value="Arial">Arial</option>
                                            <option value="Georgia">Georgia</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="ed-prop-label">Size</label>
                                        <input type="number" class="ed-input" id="propFontSize" min="6" max="500">
                                    </div>
                                </div>
                                <div class="ed-row">
                                    <div>
                                        <label class="ed-prop-label">Weight</label>
                                        <select class="ed-select" id="propFontWeight">
                                            <option value="300">Light</option>
                                            <option value="400">Regular</option>
                                            <option value="500">Medium</option>
                                            <option value="600">Semibold</option>
                                            <option value="700">Bold</option>
                                            <option value="800">Extra Bold</option>
                                            <option value="900">Black</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="ed-prop-label">Color</label>
                                        <div class="ed-color-wrap">
                                            <input type="color" class="ed-color-swatch" id="propColorSwatch">
                                            <input type="text" class="ed-color-text" id="propColor">
                                        </div>
                                    </div>
                                </div>
                                <div class="ed-prop">
                                    <label class="ed-prop-label">Alignment</label>
                                    <div class="ed-align-group">
                                        <button type="button" class="ed-btn" data-align="left"><i class="fas fa-align-left"></i></button>
                                        <button type="button" class="ed-btn" data-align="center"><i class="fas fa-align-center"></i></button>
                                        <button type="button" class="ed-btn" data-align="right"><i class="fas fa-align-right"></i></button>
                                    </div>
                                </div>
                                <div class="ed-row">
                                    <div>
                                        <label class="ed-prop-label">Line Height</label>
                                        <input type="number" class="ed-input" id="propLineHeight" min="0.5" max="4" step="0.1">
                                    </div>
                                    <div>
                                        <label class="ed-prop-label">Letter Spacing</label>
                                        <input type="number" class="ed-input" id="propLetterSpacing" min="-20" max="50" step="0.5">
                                    </div>
                                </div>
                            </div>

                            {{-- BUTTON PROPS --}}
                            <div id="propButtonBlock" style="display:none;">
                                <div class="ed-divider-line"></div>
                                <div class="ed-section-title">Button</div>
                                <div class="ed-prop">
                                    <label class="ed-prop-label">Button Text</label>
                                    <input type="text" class="ed-input" id="propBtnText">
                                </div>
                                <div class="ed-prop">
                                    <label class="ed-prop-label">Link</label>
                                    <input type="text" class="ed-input" id="propBtnLink" placeholder="/products or https://...">
                                </div>
                                <div class="ed-row">
                                    <div>
                                        <label class="ed-prop-label">Background</label>
                                        <div class="ed-color-wrap">
                                            <input type="color" class="ed-color-swatch" id="propBtnBgSwatch">
                                            <input type="text" class="ed-color-text" id="propBtnBg">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="ed-prop-label">Text Color</label>
                                        <div class="ed-color-wrap">
                                            <input type="color" class="ed-color-swatch" id="propBtnColorSwatch">
                                            <input type="text" class="ed-color-text" id="propBtnColor">
                                        </div>
                                    </div>
                                </div>
                                <div class="ed-row-3">
                                    <div>
                                        <label class="ed-prop-label">Font Size</label>
                                        <input type="number" class="ed-input" id="propBtnFontSize" min="6" max="120">
                                    </div>
                                    <div>
                                        <label class="ed-prop-label">Radius</label>
                                        <input type="number" class="ed-input" id="propBtnRadius" min="0" max="200">
                                    </div>
                                    <div>
                                        <label class="ed-prop-label">Weight</label>
                                        <select class="ed-select" id="propBtnWeight">
                                            <option value="400">Regular</option>
                                            <option value="500">Medium</option>
                                            <option value="600">Semibold</option>
                                            <option value="700">Bold</option>
                                            <option value="800">Extra Bold</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- IMAGE PROPS --}}
                            <div id="propImageBlock" style="display:none;">
                                <div class="ed-divider-line"></div>
                                <div class="ed-section-title">Image</div>
                                <div class="ed-prop">
                                    <input type="file" id="propImageReplace" accept="image/*" class="ed-input" style="padding: 4px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- LAYERS TAB --}}
                    <div class="ed-pane" id="pane-layers">
                        <div class="ed-section-title" style="margin-top:0;">Layers (top to bottom)</div>
                        <div class="ed-layers" id="layersList">
                            <div class="ed-empty" style="padding:20px;">
                                <i class="fas fa-layer-group"></i>
                                <div>No layers yet</div>
                            </div>
                        </div>
                    </div>

                    {{-- TEMPLATES TAB --}}
                    <div class="ed-pane" id="pane-templates">
                        <div class="ed-section-title" style="margin-top:0;">Start from a template</div>
                        <div class="ed-templates" id="templatesList">
                            <div class="ed-template" data-template="blank">
                                <div class="ed-template-thumb" style="background: linear-gradient(135deg, #1e1b4b, #312e81);">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="ed-template-name">Blank</div>
                            </div>
                            <div class="ed-template" data-template="welcome">
                                <div class="ed-template-thumb" style="background: linear-gradient(135deg, #4f46e5, #7c3aed);">
                                    Welcome
                                </div>
                                <div class="ed-template-name">Welcome</div>
                            </div>
                            <div class="ed-template" data-template="sale">
                                <div class="ed-template-thumb" style="background: linear-gradient(135deg, #ef4444, #f97316);">
                                    SALE 50%
                                </div>
                                <div class="ed-template-name">Big Sale</div>
                            </div>
                            <div class="ed-template" data-template="arrivals">
                                <div class="ed-template-thumb" style="background: linear-gradient(135deg, #0ea5e9, #06b6d4);">
                                    NEW
                                </div>
                                <div class="ed-template-name">New Arrivals</div>
                            </div>
                            <div class="ed-template" data-template="electronics">
                                <div class="ed-template-thumb" style="background: linear-gradient(135deg, #0f172a, #334155);">
                                    Tech
                                </div>
                                <div class="ed-template-name">Electronics</div>
                            </div>
                            <div class="ed-template" data-template="fashion">
                                <div class="ed-template-thumb" style="background: linear-gradient(135deg, #f43f5e, #ec4899);">
                                    Fashion
                                </div>
                                <div class="ed-template-name">Fashion</div>
                            </div>
                            <div class="ed-template" data-template="offer">
                                <div class="ed-template-thumb" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                                    OFFER
                                </div>
                                <div class="ed-template-name">Special Offer</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden form to actually submit the saved design_data --}}
    <form id="bannerForm" action="{{ route('admin.update_banner', $banner->id) }}" method="POST" enctype="multipart/form-data" style="display:none;">
        @csrf
        @method('PUT')
        <input type="hidden" name="title" id="formTitle" value="{{ $banner->title }}">
        <input type="hidden" name="description" id="formDescription" value="{{ $banner->description }}">
        <input type="hidden" name="link" id="formLink" value="{{ $banner->link ?? '#' }}">
        <input type="hidden" name="page" value="{{ $banner->page ?: 'home' }}">
        <input type="hidden" name="position" value="{{ $banner->position ?: 'hero' }}">
        <input type="hidden" name="priority" value="{{ $banner->priority ?: 1 }}">
        <input type="hidden" name="type" value="{{ $banner->type ?: 'normal' }}">
        <input type="hidden" name="status" value="{{ $banner->status ?: 'active' }}">
        <input type="hidden" name="show_title" value="1">
        <input type="hidden" name="show_description" value="1">
        <input type="hidden" name="rendered_image" id="formImageData">
        <input type="hidden" name="design_data" id="formDesignData">
    </form>
@endsection

@section('scripts')
    {{-- Fabric.js --}}
    <script src="{{ asset('assets/libs/fabric.min.js') }}"></script>
    <script>
    (function() {
        'use strict';

        // ===========================================================
        //  STATE
        // ===========================================================
        const canvas = new fabric.Canvas('bannerCanvas', {
            backgroundColor: '#1e1b4b',
            preserveObjectStacking: true,
            selection: true,
        });

        const state = {
            zoom: 0.5,
            undoStack: [],
            redoStack: [],
            isApplyingState: false,
            currentDesign: null,
        };

        // Initial design (from server) or blank
        @php
            $initialDesign = $banner->design_data;
            $initialJson = json_encode($initialDesign);
        @endphp
        const INITIAL_DESIGN = {!! $initialJson !!};

        // ===========================================================
        //  UTILITIES
        // ===========================================================
        const $ = (s) => document.querySelector(s);
        const $$ = (s) => document.querySelectorAll(s);
        const uid = () => 'el_' + Math.random().toString(36).slice(2, 10);
        const clamp = (n, a, b) => Math.max(a, Math.min(b, n));

        function pushHistory() {
            if (state.isApplyingState) return;
            state.undoStack.push(JSON.stringify(canvas.toJSON(['_elementMeta'])));
            if (state.undoStack.length > 60) state.undoStack.shift();
            state.redoStack = [];
        }

        function undo() {
            if (state.undoStack.length < 2) return;
            state.redoStack.push(state.undoStack.pop());
            const snap = state.undoStack[state.undoStack.length - 1];
            state.isApplyingState = true;
            canvas.loadFromJSON(snap, () => {
                state.isApplyingState = false;
                applyZoom(); renderLayers(); renderProperties();
            });
        }

        function redo() {
            if (state.redoStack.length === 0) return;
            const snap = state.redoStack.pop();
            state.undoStack.push(snap);
            state.isApplyingState = true;
            canvas.loadFromJSON(snap, () => {
                state.isApplyingState = false;
                applyZoom(); renderLayers(); renderProperties();
            });
        }

        function applyZoom() {
            canvas.setZoom(state.zoom);
            canvas.setWidth(1920 * state.zoom);
            canvas.setHeight(1080 * state.zoom);
            $('#canvasFrame').style.width = (1920 * state.zoom) + 'px';
            $('#canvasFrame').style.height = (1080 * state.zoom) + 'px';
            $('#zoomLabel').textContent = Math.round(state.zoom * 100) + '%';
        }

        function fitZoom() {
            const wrap = $('#canvasWrap');
            const availW = wrap.clientWidth - 56;
            const availH = wrap.clientHeight - 56;
            const ratio = Math.min(availW / 1920, availH / 1080);
            state.zoom = clamp(Math.floor(ratio * 100) / 100, 0.05, 1);
            applyZoom();
        }

        function getMeta(obj) {
            if (!obj._elementMeta) obj._elementMeta = { id: uid(), name: obj.type, visible: true, locked: false };
            return obj._elementMeta;
        }

        function setMeta(obj, key, val) {
            const m = getMeta(obj);
            m[key] = val;
        }

        // ===========================================================
        //  RENDER: PROPERTIES PANEL
        // ===========================================================
        function renderProperties() {
            const active = canvas.getActiveObject();
            if (!active) {
                $('#propEmpty').style.display = 'flex';
                $('#propForm').style.display = 'none';
                $('#selectionLabel').style.display = 'none';
                return;
            }
            $('#propEmpty').style.display = 'none';
            $('#propForm').style.display = 'block';

            const left = Math.round(active.left);
            const top  = Math.round(active.top);
            const w    = Math.round((active.width  || 0) * (active.scaleX || 1));
            const h    = Math.round((active.height || 0) * (active.scaleY || 1));
            const rot  = Math.round(active.angle || 0);
            const op   = Math.round((active.opacity || 1) * 100);

            $('#propX').value = left;
            $('#propY').value = top;
            $('#propW').value = w;
            $('#propH').value = h;
            $('#propRot').value = rot;
            $('#propOpacity').value = op;

            $('#selectionLabel').style.display = 'inline-flex';
            $('#selectionLabel').textContent = `${left}, ${top}  ·  ${w}×${h}  ·  ${rot}°`;

            // Text vs button vs image
            const isText = active.type === 'i-text' || active.type === 'text' || active.type === 'textbox';
            const isBtn  = active.type === 'button-shape';
            const isImg  = active.type === 'image';

            $('#propTextBlock').style.display   = isText ? 'block' : 'none';
            $('#propButtonBlock').style.display = isBtn  ? 'block' : 'none';
            $('#propImageBlock').style.display  = isImg  ? 'block' : 'none';

            if (isText) {
                $('#propText').value = active.text || '';
                $('#propFont').value = active.fontFamily || 'Poppins';
                $('#propFontSize').value = active.fontSize || 40;
                $('#propFontWeight').value = String(active.fontWeight || 400);
                const c = active.fill || '#000000';
                $('#propColor').value = c;
                $('#propColorSwatch').value = toHex(c);
                $('#propLineHeight').value = active.lineHeight || 1.2;
                $('#propLetterSpacing').value = (active.charSpacing || 0) / 10;
                $$('.ed-align-group .ed-btn').forEach(b => b.classList.toggle('active', b.dataset.align === active.textAlign));
            }
            if (isBtn) {
                $('#propBtnText').value = active._btnText || 'Shop Now';
                $('#propBtnLink').value = active._btnLink || '';
                const bg = active.fill || '#1677FF';
                const fg = active._btnTextColor || '#ffffff';
                $('#propBtnBg').value = bg;
                $('#propBtnBgSwatch').value = toHex(bg);
                $('#propBtnColor').value = fg;
                $('#propBtnColorSwatch').value = toHex(fg);
                $('#propBtnFontSize').value = active.fontSize || 22;
                $('#propBtnRadius').value = active._btnRadius || 12;
                $('#propBtnWeight').value = String(active.fontWeight || 600);
            }
        }

        function toHex(c) {
            if (!c) return '#000000';
            if (c[0] === '#') return c;
            const m = c.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
            if (!m) return '#000000';
            return '#' + [m[1], m[2], m[3]].map(n => Number(n).toString(16).padStart(2, '0')).join('');
        }

        // ===========================================================
        //  RENDER: LAYERS
        // ===========================================================
        function renderLayers() {
            const list = $('#layersList');
            const objs = canvas.getObjects().slice().reverse(); // top of canvas = top of list
            if (objs.length === 0) {
                list.innerHTML = '<div class="ed-empty" style="padding:20px;"><i class="fas fa-layer-group"></i><div>No layers yet</div></div>';
                return;
            }
            const active = canvas.getActiveObject();
            list.innerHTML = '';
            objs.forEach(obj => {
                const meta = getMeta(obj);
                const row = document.createElement('div');
                row.className = 'ed-layer' + (obj === active ? ' selected' : '');
                row.draggable = true;
                row.dataset.objId = meta.id;
                const iconMap = {
                    'i-text': 'fa-font',
                    'text': 'fa-font',
                    'textbox': 'fa-font',
                    'image': 'fa-image',
                    'button-shape': 'fa-square',
                };
                row.innerHTML = `
                    <button class="ed-layer-action" data-action="visible" title="Show/hide">
                        <i class="fas fa-${meta.visible === false ? 'eye-slash' : 'eye'}"></i>
                    </button>
                    <div class="ed-layer-icon"><i class="fas ${iconMap[obj.type] || 'fa-cube'}"></i></div>
                    <div class="ed-layer-name" contenteditable="false">${escapeHtml(meta.name || obj.type)}</div>
                    <div class="ed-layer-actions">
                        <button class="ed-layer-action" data-action="lock" title="Lock"><i class="fas fa-${meta.locked ? 'lock' : 'lock-open'}"></i></button>
                        <button class="ed-layer-action danger" data-action="delete" title="Delete"><i class="fas fa-trash"></i></button>
                    </div>
                `;
                list.appendChild(row);
            });
        }

        function escapeHtml(s) {
            return String(s || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
        }

        // ===========================================================
        //  ADD ELEMENTS
        // ===========================================================
        function addText(opts = {}) {
            const o = new fabric.IText(opts.content || 'Edit me', {
                left: opts.x ?? 200,
                top:  opts.y ?? 200,
                fontFamily: opts.fontFamily || 'Poppins',
                fontSize:   opts.fontSize || 64,
                fontWeight: opts.fontWeight || 700,
                fill:       opts.color || '#ffffff',
                textAlign:  opts.align || 'left',
                lineHeight: opts.lineHeight || 1.2,
                charSpacing:(opts.letterSpacing || 0) * 10,
                opacity:    (opts.opacity ?? 100) / 100,
                originX: 'left', originY: 'top',
            });
            setMeta(o, 'name', opts.name || 'Text');
            if (opts.id) setMeta(o, 'id', opts.id);
            canvas.add(o); canvas.setActiveObject(o); canvas.requestRenderAll();
            pushHistory(); renderLayers();
        }

        function addHeading() {
            addText({ content: 'HEADING', fontSize: 96, fontWeight: 800, name: 'Heading' });
        }

        function addButton(opts = {}) {
            const text = opts.content || 'Shop Now';
            const bg   = opts.background || '#1677FF';
            const fg   = opts.color || '#ffffff';
            const fs   = opts.fontSize || 22;
            const r    = opts.borderRadius ?? 12;
            const w    = opts.width  ?? 240;
            const h    = opts.height ?? 64;
            const lbl  = new fabric.IText(text, {
                fontFamily: opts.fontFamily || 'Poppins',
                fontSize: fs,
                fontWeight: opts.fontWeight || 600,
                fill: fg,
                originX: 'center', originY: 'center',
            });
            const bgRect = new fabric.Rect({
                width: w, height: h,
                fill: bg,
                rx: r, ry: r,
                originX: 'center', originY: 'center',
                shadow: new fabric.Shadow({ color: 'rgba(0,0,0,0.25)', blur: 14, offsetY: 4 }),
            });
            const grp = new fabric.Group([bgRect, lbl], {
                left: opts.x ?? 200, top: opts.y ?? 200,
                originX: 'left', originY: 'top',
                opacity: (opts.opacity ?? 100) / 100,
            });
            grp.type = 'button-shape';
            grp._btnText = text;
            grp._btnLink = opts.link || '';
            grp._btnTextColor = fg;
            grp._btnRadius = r;
            grp._btnFontSize = fs;
            grp._btnFontWeight = opts.fontWeight || 600;
            grp._btnFontFamily = opts.fontFamily || 'Poppins';
            grp._btnBackground = bg;
            setMeta(grp, 'name', opts.name || 'Button');
            if (opts.id) setMeta(grp, 'id', opts.id);
            canvas.add(grp); canvas.setActiveObject(grp); canvas.requestRenderAll();
            pushHistory(); renderLayers();
        }

        function addImageFromUrl(url, opts = {}) {
            fabric.Image.fromURL(url, (img) => {
                const targetW = opts.width || Math.min(800, img.width);
                const scale = targetW / img.width;
                img.set({
                    left: opts.x ?? 300,
                    top:  opts.y ?? 200,
                    scaleX: opts.scaleX ?? scale,
                    scaleY: opts.scaleY ?? scale,
                    originX: 'left', originY: 'top',
                    opacity: (opts.opacity ?? 100) / 100,
                });
                if (opts.angle) img.rotate(opts.angle);
                setMeta(img, 'name', opts.name || 'Image');
                if (opts.id) setMeta(img, 'id', opts.id);
                canvas.add(img); canvas.setActiveObject(img); canvas.requestRenderAll();
                pushHistory(); renderLayers();
            }, { crossOrigin: 'anonymous' });
        }

        function uploadAndAddImage(file) {
            const fd = new FormData();
            fd.append('file', file);
            fetch('{{ route('admin.banner_upload_asset') }}', {
                method: 'POST',
                body: fd,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            })
            .then(r => r.json())
            .then(data => {
                if (data.url) addImageFromUrl(data.url, { name: file.name.replace(/\.[^.]+$/, '') });
            })
            .catch(err => { console.error('Upload error:', err); alert('Upload failed. See console for details: ' + err.message); });
        }

        // ===========================================================
        //  BACKGROUND
        // ===========================================================
        function applyBackground() {
            const type = $('#bgType').value;
            const overlay = { color: $('#bgOverlayColor').value, opacity: Number($('#bgOverlayOpacity').value) / 100 };
            if (type === 'color') {
                canvas.setBackgroundColor($('#bgColorText').value, () => canvas.requestRenderAll());
            } else if (type === 'image') {
                // Image set via input — store on the canvas instance
                if (window._bgImageUrl) {
                    fabric.Image.fromURL(window._bgImageUrl, (img) => {
                        const scale = Math.max(1920 / img.width, 1080 / img.height);
                        img.set({ originX: 'left', originY: 'top', scaleX: scale, scaleY: scale });
                        canvas.setBackgroundImage(img, () => canvas.requestRenderAll());
                    }, { crossOrigin: 'anonymous' });
                }
            } else if (type === 'gradient') {
                const from = $('#bgGradFrom').value;
                const to   = $('#bgGradTo').value;
                const ang  = Number($('#bgGradAngle').value);
                const ctx = fabric.util.createCanvasElement(1920, 1080);
                const c = ctx.getContext('2d');
                let g;
                if (ang === 90) g = c.createLinearGradient(0, 0, 0, 1080);
                else if (ang === 180) g = c.createLinearGradient(0, 1080, 0, 0);
                else if (ang === 0) g = c.createLinearGradient(0, 0, 1920, 0);
                else if (ang === 45) g = c.createLinearGradient(0, 0, 1920, 1080);
                else g = c.createLinearGradient(0, 0, 1920, 1080);
                g.addColorStop(0, from); g.addColorStop(1, to);
                c.fillStyle = g; c.fillRect(0, 0, 1920, 1080);
                fabric.Image.fromURL(ctx.toDataURL(), (img) => {
                    canvas.setBackgroundImage(img, () => canvas.requestRenderAll());
                });
            }
            state._bgOverlay = overlay;
        }

        // ===========================================================
        //  SERIALIZE / RESTORE
        // ===========================================================
        function serializeDesign() {
            const objects = canvas.getObjects().map(o => {
                const meta = getMeta(o);
                const base = {
                    id: meta.id,
                    name: meta.name,
                    visible: meta.visible !== false,
                    locked: !!meta.locked,
                    x: Math.round(o.left),
                    y: Math.round(o.top),
                    width: Math.round((o.width || 0) * (o.scaleX || 1)),
                    height: Math.round((o.height || 0) * (o.scaleY || 1)),
                    rotation: Math.round(o.angle || 0),
                    opacity: Math.round((o.opacity || 1) * 100),
                    zIndex: canvas.getObjects().indexOf(o),
                };
                if (o.type === 'i-text' || o.type === 'text' || o.type === 'textbox') {
                    return {
                        ...base,
                        type: 'text',
                        content: o.text,
                        fontFamily: o.fontFamily,
                        fontSize: o.fontSize,
                        fontWeight: o.fontWeight,
                        color: o.fill,
                        align: o.textAlign || 'left',
                        lineHeight: o.lineHeight || 1.2,
                        letterSpacing: (o.charSpacing || 0) / 10,
                    };
                }
                if (o.type === 'image') {
                    return { ...base, type: 'image', src: o._element?.src || o.toDataURL(), name: meta.name || 'Image' };
                }
                if (o.type === 'button-shape') {
                    return {
                        ...base,
                        type: 'button',
                        content: o._btnText,
                        link: o._btnLink || '',
                        fontFamily: o._btnFontFamily || 'Poppins',
                        fontSize: o._btnFontSize,
                        fontWeight: o._btnFontWeight || 600,
                        color: o._btnTextColor,
                        background: o._btnBackground,
                        borderRadius: o._btnRadius || 0,
                    };
                }
                return base;
            });

            // Background
            const bg = {};
            const bgImg = canvas.backgroundImage;
            if (bgImg && bgImg._element) {
                bg.type = 'image';
                bg.value = bgImg._element.src;
            } else {
                bg.type = 'color';
                bg.value = canvas.backgroundColor || '#1e1b4b';
            }
            bg.overlay = state._bgOverlay || { color: '#000000', opacity: 0 };

            return {
                version: 1,
                width: 1920,
                height: 1080,
                background: bg,
                elements: objects,
            };
        }

        function restoreDesign(design) {
            if (!design) return;
            canvas.clear();
            // Background
            if (design.background) {
                const bg = design.background;
                if (bg.type === 'image' && bg.value) {
                    const url = bg.value.startsWith('http') || bg.value.startsWith('data:') ? bg.value : '/storage/' + bg.value.replace(/^storage\//, '');
                    fabric.Image.fromURL(url, (img) => {
                        const scale = Math.max(1920 / img.width, 1080 / img.height);
                        img.set({ originX: 'left', originY: 'top', scaleX: scale, scaleY: scale });
                        canvas.setBackgroundImage(img, () => canvas.requestRenderAll());
                    }, { crossOrigin: 'anonymous' });
                } else {
                    canvas.setBackgroundColor(bg.value || '#1e1b4b', () => canvas.requestRenderAll());
                }
                state._bgOverlay = bg.overlay || { color: '#000000', opacity: 0 };
                if (bg.overlay) {
                    $('#bgOverlayColor').value = bg.overlay.color || '#000000';
                    $('#bgOverlayOpacity').value = Math.round((bg.overlay.opacity || 0) * 100);
                }
            }
            // Elements
            (design.elements || []).forEach(el => {
                if (el.type === 'text') {
                    addText(el);
                } else if (el.type === 'button') {
                    addButton(el);
                } else if (el.type === 'image') {
                    if (el.src) {
                        const url = el.src.startsWith('http') || el.src.startsWith('data:') ? el.src : '/storage/' + el.src.replace(/^storage\//, '');
                        addImageFromUrl(url, el);
                    }
                }
            });
        }

        // ===========================================================
        //  TEMPLATES
        // ===========================================================
        const TEMPLATES = {
            blank: () => ({
                version: 1, width: 1920, height: 1080,
                background: { type: 'color', value: '#1e1b4b', overlay: { color: '#000000', opacity: 0 } },
                elements: []
            }),
            welcome: () => ({
                version: 1, width: 1920, height: 1080,
                background: { type: 'gradient', value: 'linear-gradient(135deg,#4f46e5,#7c3aed)', overlay: { color: '#000000', opacity: 0.1 } },
                elements: [
                    { type: 'text', content: 'Welcome to TiarShop', x: 120, y: 380, width: 1200, height: 140, fontSize: 96, fontFamily: 'Poppins', fontWeight: 800, color: '#ffffff', align: 'left', lineHeight: 1.1, letterSpacing: 0, opacity: 100, name: 'Heading' },
                    { type: 'text', content: 'Discover amazing products curated just for you.', x: 120, y: 540, width: 900, height: 80, fontSize: 32, fontFamily: 'Inter', fontWeight: 400, color: '#e0e7ff', align: 'left', lineHeight: 1.4, letterSpacing: 0, opacity: 100, name: 'Subtitle' },
                    { type: 'button', content: 'Shop Now', link: '/products', x: 120, y: 680, width: 240, height: 64, fontSize: 22, fontFamily: 'Poppins', fontWeight: 600, color: '#ffffff', background: '#f43f5e', borderRadius: 32, opacity: 100, name: 'CTA Button' }
                ]
            }),
            sale: () => ({
                version: 1, width: 1920, height: 1080,
                background: { type: 'gradient', value: 'linear-gradient(135deg,#ef4444,#f97316)', overlay: { color: '#000000', opacity: 0.1 } },
                elements: [
                    { type: 'text', content: 'MEGA SALE', x: 120, y: 280, width: 1000, height: 140, fontSize: 128, fontFamily: 'Bebas Neue', fontWeight: 700, color: '#ffffff', align: 'left', lineHeight: 1, letterSpacing: 4, opacity: 100, name: 'Title' },
                    { type: 'text', content: 'Up to 50% OFF', x: 120, y: 440, width: 900, height: 80, fontSize: 56, fontFamily: 'Poppins', fontWeight: 700, color: '#fef3c7', align: 'left', lineHeight: 1.2, opacity: 100, name: 'Subtitle' },
                    { type: 'text', content: 'Limited time only. Don\'t miss out on the best deals of the season.', x: 120, y: 560, width: 900, height: 100, fontSize: 24, fontFamily: 'Inter', fontWeight: 400, color: '#ffffff', align: 'left', lineHeight: 1.4, opacity: 100, name: 'Description' },
                    { type: 'button', content: 'Shop the Sale', link: '/products', x: 120, y: 720, width: 280, height: 72, fontSize: 24, fontFamily: 'Poppins', fontWeight: 700, color: '#ef4444', background: '#ffffff', borderRadius: 36, opacity: 100, name: 'CTA' }
                ]
            }),
            arrivals: () => ({
                version: 1, width: 1920, height: 1080,
                background: { type: 'gradient', value: 'linear-gradient(135deg,#0ea5e9,#06b6d4)', overlay: { color: '#000000', opacity: 0.1 } },
                elements: [
                    { type: 'text', content: 'NEW', x: 120, y: 300, width: 400, height: 140, fontSize: 140, fontFamily: 'Bebas Neue', fontWeight: 700, color: '#fef3c7', align: 'left', lineHeight: 1, letterSpacing: 8, opacity: 100, name: 'New Badge' },
                    { type: 'text', content: 'Arrivals', x: 120, y: 440, width: 900, height: 120, fontSize: 110, fontFamily: 'Poppins', fontWeight: 800, color: '#ffffff', align: 'left', lineHeight: 1, opacity: 100, name: 'Title' },
                    { type: 'text', content: 'Be the first to discover our latest collection', x: 120, y: 590, width: 900, height: 80, fontSize: 28, fontFamily: 'Inter', fontWeight: 400, color: '#e0f2fe', align: 'left', lineHeight: 1.4, opacity: 100, name: 'Subtitle' },
                    { type: 'button', content: 'Explore Now', link: '/products', x: 120, y: 720, width: 240, height: 64, fontSize: 22, fontFamily: 'Poppins', fontWeight: 600, color: '#0c4a6e', background: '#ffffff', borderRadius: 12, opacity: 100, name: 'CTA' }
                ]
            }),
            electronics: () => ({
                version: 1, width: 1920, height: 1080,
                background: { type: 'gradient', value: 'linear-gradient(135deg,#0f172a,#334155)', overlay: { color: '#000000', opacity: 0.2 } },
                elements: [
                    { type: 'text', content: 'TECH', x: 120, y: 280, width: 600, height: 100, fontSize: 96, fontFamily: 'Oswald', fontWeight: 700, color: '#00d4ff', align: 'left', lineHeight: 1, letterSpacing: 6, opacity: 100, name: 'Tag' },
                    { type: 'text', content: 'Next-Gen Electronics', x: 120, y: 400, width: 1100, height: 140, fontSize: 84, fontFamily: 'Poppins', fontWeight: 800, color: '#ffffff', align: 'left', lineHeight: 1.1, opacity: 100, name: 'Title' },
                    { type: 'text', content: 'Powerful devices for work, play and everything in between', x: 120, y: 560, width: 900, height: 80, fontSize: 26, fontFamily: 'Inter', fontWeight: 400, color: '#cbd5e1', align: 'left', lineHeight: 1.4, opacity: 100, name: 'Subtitle' },
                    { type: 'button', content: 'Shop Electronics', link: '/products', x: 120, y: 700, width: 280, height: 64, fontSize: 22, fontFamily: 'Poppins', fontWeight: 600, color: '#0f172a', background: '#00d4ff', borderRadius: 12, opacity: 100, name: 'CTA' }
                ]
            }),
            fashion: () => ({
                version: 1, width: 1920, height: 1080,
                background: { type: 'gradient', value: 'linear-gradient(135deg,#f43f5e,#ec4899)', overlay: { color: '#000000', opacity: 0.1 } },
                elements: [
                    { type: 'text', content: 'FASHION', x: 120, y: 280, width: 700, height: 100, fontSize: 96, fontFamily: 'Playfair Display', fontWeight: 700, color: '#fef3c7', align: 'left', lineHeight: 1, letterSpacing: 4, opacity: 100, name: 'Tag' },
                    { type: 'text', content: 'Style Your Story', x: 120, y: 400, width: 1000, height: 140, fontSize: 88, fontFamily: 'Playfair Display', fontWeight: 700, color: '#ffffff', align: 'left', lineHeight: 1.1, opacity: 100, name: 'Title' },
                    { type: 'text', content: 'Curated collections for the modern wardrobe', x: 120, y: 560, width: 900, height: 80, fontSize: 26, fontFamily: 'Inter', fontWeight: 400, color: '#fce7f3', align: 'left', lineHeight: 1.4, opacity: 100, name: 'Subtitle' },
                    { type: 'button', content: 'Shop Collection', link: '/products', x: 120, y: 700, width: 260, height: 64, fontSize: 22, fontFamily: 'Poppins', fontWeight: 600, color: '#f43f5e', background: '#ffffff', borderRadius: 32, opacity: 100, name: 'CTA' }
                ]
            }),
            offer: () => ({
                version: 1, width: 1920, height: 1080,
                background: { type: 'gradient', value: 'linear-gradient(135deg,#f59e0b,#fbbf24)', overlay: { color: '#000000', opacity: 0.05 } },
                elements: [
                    { type: 'text', content: 'SPECIAL', x: 120, y: 280, width: 800, height: 100, fontSize: 88, fontFamily: 'Poppins', fontWeight: 600, color: '#7c2d12', align: 'left', lineHeight: 1, letterSpacing: 4, opacity: 100, name: 'Tag' },
                    { type: 'text', content: 'OFFER', x: 120, y: 380, width: 900, height: 200, fontSize: 200, fontFamily: 'Bebas Neue', fontWeight: 700, color: '#ffffff', align: 'left', lineHeight: 1, letterSpacing: 8, opacity: 100, name: 'Title' },
                    { type: 'text', content: 'Exclusive deals for our valued customers', x: 120, y: 600, width: 900, height: 60, fontSize: 26, fontFamily: 'Inter', fontWeight: 400, color: '#78350f', align: 'left', lineHeight: 1.4, opacity: 100, name: 'Subtitle' },
                    { type: 'button', content: 'Claim Offer', link: '/products', x: 120, y: 700, width: 240, height: 64, fontSize: 22, fontFamily: 'Poppins', fontWeight: 700, color: '#ffffff', background: '#7c2d12', borderRadius: 12, opacity: 100, name: 'CTA' }
                ]
            }),
        };

        function applyTemplate(key) {
            const tpl = TEMPLATES[key];
            if (!tpl) return;
            if (canvas.getObjects().length > 0 && !confirm('Replace current design with this template?')) return;
            const design = tpl();
            restoreDesign(design);
            pushHistory(); renderLayers(); renderProperties();
        }

        // ===========================================================
        //  EVENTS
        // ===========================================================
        canvas.on('selection:created', () => { renderProperties(); renderLayers(); });
        canvas.on('selection:updated', () => { renderProperties(); renderLayers(); });
        canvas.on('selection:cleared', () => { renderProperties(); renderLayers(); });
        canvas.on('object:modified', () => { pushHistory(); renderProperties(); renderLayers(); });
        canvas.on('object:moving',  () => { renderProperties(); });
        canvas.on('object:scaling', () => { renderProperties(); });
        canvas.on('object:rotating', () => { renderProperties(); });

        // Double-click to edit text
        canvas.on('mouse:dblclick', (e) => {
            const t = canvas.getActiveObject();
            if (t && (t.type === 'i-text' || t.type === 'textbox')) {
                t.enterEditing(); t.selectAll();
            }
        });

        // Sync text edits back to panel
        canvas.on('text:changed', () => renderProperties());
        canvas.on('text:editing:exited', () => { pushHistory(); renderProperties(); });

        // Right panel property inputs
        function bindProp(input, fn) {
            input.addEventListener('input', () => { fn(); pushHistory(); });
        }
        bindProp($('#propX'), () => { const o = canvas.getActiveObject(); if (o) { o.set('left', Number($('#propX').value)); canvas.requestRenderAll(); } });
        bindProp($('#propY'), () => { const o = canvas.getActiveObject(); if (o) { o.set('top', Number($('#propY').value)); canvas.requestRenderAll(); } });
        bindProp($('#propW'), () => { const o = canvas.getActiveObject(); if (o) { const s = Number($('#propW').value) / (o.width || 1); o.set('scaleX', s); canvas.requestRenderAll(); } });
        bindProp($('#propH'), () => { const o = canvas.getActiveObject(); if (o) { const s = Number($('#propH').value) / (o.height || 1); o.set('scaleY', s); canvas.requestRenderAll(); } });
        bindProp($('#propRot'), () => { const o = canvas.getActiveObject(); if (o) { o.rotate(Number($('#propRot').value)); canvas.requestRenderAll(); } });
        bindProp($('#propOpacity'), () => { const o = canvas.getActiveObject(); if (o) { o.set('opacity', Number($('#propOpacity').value) / 100); canvas.requestRenderAll(); } });

        bindProp($('#propText'), () => { const o = canvas.getActiveObject(); if (o && (o.type === 'i-text' || o.type === 'textbox')) { o.set('text', $('#propText').value); canvas.requestRenderAll(); } });
        bindProp($('#propFont'), () => { const o = canvas.getActiveObject(); if (o) { o.set('fontFamily', $('#propFont').value); canvas.requestRenderAll(); } });
        bindProp($('#propFontSize'), () => { const o = canvas.getActiveObject(); if (o) { o.set('fontSize', Number($('#propFontSize').value)); canvas.requestRenderAll(); } });
        bindProp($('#propFontWeight'), () => { const o = canvas.getActiveObject(); if (o) { o.set('fontWeight', Number($('#propFontWeight').value)); canvas.requestRenderAll(); } });
        function syncColor(textInput, swatchInput, prop) {
            bindProp(textInput, () => { swatchInput.value = toHex(textInput.value); const o = canvas.getActiveObject(); if (o) { o.set(prop, textInput.value); canvas.requestRenderAll(); } });
            swatchInput.addEventListener('input', () => { textInput.value = swatchInput.value; const o = canvas.getActiveObject(); if (o) { o.set(prop, swatchInput.value); canvas.requestRenderAll(); } });
        }
        syncColor($('#propColor'), $('#propColorSwatch'), 'fill');
        bindProp($('#propLineHeight'), () => { const o = canvas.getActiveObject(); if (o) { o.set('lineHeight', Number($('#propLineHeight').value)); canvas.requestRenderAll(); } });
        bindProp($('#propLetterSpacing'), () => { const o = canvas.getActiveObject(); if (o) { o.set('charSpacing', Number($('#propLetterSpacing').value) * 10); canvas.requestRenderAll(); } });
        $$('.ed-align-group .ed-btn').forEach(b => b.addEventListener('click', () => { const o = canvas.getActiveObject(); if (o) { o.set('textAlign', b.dataset.align); canvas.requestRenderAll(); pushHistory(); renderProperties(); } }));

        bindProp($('#propBtnText'), () => { const o = canvas.getActiveObject(); if (o && o.type === 'button-shape') {
            const lbl = o._objects[1]; lbl.set('text', $('#propBtnText').value); o._btnText = $('#propBtnText').value; o.dirty = true; canvas.requestRenderAll();
        }});
        bindProp($('#propBtnLink'), () => { const o = canvas.getActiveObject(); if (o && o.type === 'button-shape') o._btnLink = $('#propBtnLink').value; });
        bindProp($('#propBtnFontSize'), () => { const o = canvas.getActiveObject(); if (o && o.type === 'button-shape') { const lbl = o._objects[1]; lbl.set('fontSize', Number($('#propBtnFontSize').value)); o._btnFontSize = Number($('#propBtnFontSize').value); o.dirty = true; canvas.requestRenderAll(); } });
        bindProp($('#propBtnRadius'), () => { const o = canvas.getActiveObject(); if (o && o.type === 'button-shape') { const bg = o._objects[0]; bg.set({ rx: Number($('#propBtnRadius').value), ry: Number($('#propBtnRadius').value) }); o._btnRadius = Number($('#propBtnRadius').value); o.dirty = true; canvas.requestRenderAll(); } });
        bindProp($('#propBtnWeight'), () => { const o = canvas.getActiveObject(); if (o && o.type === 'button-shape') { const lbl = o._objects[1]; lbl.set('fontWeight', Number($('#propBtnWeight').value)); o._btnFontWeight = Number($('#propBtnWeight').value); o.dirty = true; canvas.requestRenderAll(); } });
        syncColor($('#propBtnBg'),     $('#propBtnBgSwatch'),     'fill');
        syncColor($('#propBtnColor'),  $('#propBtnColorSwatch'),  (v) => { const o = canvas.getActiveObject(); if (o && o.type === 'button-shape') { const lbl = o._objects[1]; lbl.set('fill', v); o._btnTextColor = v; o.dirty = true; canvas.requestRenderAll(); } });
        // syncColor uses a function for fill, so handle manually
        $('#propBtnColor').addEventListener('input', () => { const v = $('#propBtnColor').value; $('#propBtnColorSwatch').value = toHex(v); const o = canvas.getActiveObject(); if (o && o.type === 'button-shape') { const lbl = o._objects[1]; lbl.set('fill', v); o._btnTextColor = v; o.dirty = true; canvas.requestRenderAll(); } });
        $('#propBtnColorSwatch').addEventListener('input', () => { const v = $('#propBtnColorSwatch').value; $('#propBtnColor').value = v; const o = canvas.getActiveObject(); if (o && o.type === 'button-shape') { const lbl = o._objects[1]; lbl.set('fill', v); o._btnTextColor = v; o.dirty = true; canvas.requestRenderAll(); } });

        // Image replace
        $('#propImageReplace').addEventListener('change', (e) => {
            if (e.target.files[0]) uploadAndAddImage(e.target.files[0]);
        });

        // ===== Background controls =====
        $('#bgType').addEventListener('change', () => {
            const v = $('#bgType').value;
            $('#bgColorWrap').style.display    = v === 'color' ? 'block' : 'none';
            $('#bgImageWrap').style.display    = v === 'image' ? 'block' : 'none';
            $('#bgGradientWrap').style.display = v === 'gradient' ? 'block' : 'none';
            applyBackground();
        });
        ['bgColorText', 'bgColorSwatch'].forEach(id => $('#' + id).addEventListener('input', applyBackground));
        ['bgGradFrom', 'bgGradTo', 'bgGradAngle'].forEach(id => $('#' + id).addEventListener('input', applyBackground));
        ['bgOverlayColor', 'bgOverlayOpacity'].forEach(id => $('#' + id).addEventListener('input', applyBackground));
        $('#bgImageInput').addEventListener('change', (e) => {
            if (!e.target.files[0]) return;
            const fd = new FormData();
            fd.append('file', e.target.files[0]);
            fetch('{{ route('admin.banner_upload_asset') }}', {
                method: 'POST', body: fd,
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            }).then(r => r.json()).then(data => { window._bgImageUrl = data.url; applyBackground(); });
        });

        // ===== Tabs =====
        $$('.ed-tab').forEach(t => t.addEventListener('click', () => {
            $$('.ed-tab').forEach(x => x.classList.remove('active'));
            t.classList.add('active');
            $$('.ed-pane').forEach(p => p.classList.remove('active'));
            $('#pane-' + t.dataset.tab).classList.add('active');
        }));

        // ===== Toolbar actions =====
        $$('.ed-tool[data-add]').forEach(t => t.addEventListener('click', () => {
            const k = t.dataset.add;
            if (k === 'text') addText();
            else if (k === 'heading') addHeading();
            else if (k === 'button') addButton();
            else if (k === 'image') {
                const inp = document.createElement('input');
                inp.type = 'file'; inp.accept = 'image/*';
                inp.onchange = (e) => { if (e.target.files[0]) uploadAndAddImage(e.target.files[0]); };
                inp.click();
            }
        }));
        $$('.ed-template').forEach(t => t.addEventListener('click', () => applyTemplate(t.dataset.template)));

        $('#duplicateBtn').addEventListener('click', () => {
            const o = canvas.getActiveObject();
            if (!o) return;
            o.clone((cl) => {
                cl.set({ left: (o.left || 0) + 20, top: (o.top || 0) + 20 });
                setMeta(cl, 'id', uid());
                canvas.add(cl); canvas.setActiveObject(cl); canvas.requestRenderAll();
                pushHistory(); renderLayers();
            }, ['_elementMeta']);
        });
        $('#deleteBtn').addEventListener('click', deleteSelected);
        $('#bringForwardBtn').addEventListener('click', () => { const o = canvas.getActiveObject(); if (o) { canvas.bringForward(o); pushHistory(); renderLayers(); } });
        $('#sendBackwardBtn').addEventListener('click', () => { const o = canvas.getActiveObject(); if (o) { canvas.sendBackwards(o); pushHistory(); renderLayers(); } });
        $('#centerHBtn').addEventListener('click', () => { const o = canvas.getActiveObject(); if (o) { o.set('left', (1920 - (o.width * (o.scaleX || 1))) / 2); canvas.requestRenderAll(); pushHistory(); renderProperties(); } });
        $('#centerVBtn').addEventListener('click', () => { const o = canvas.getActiveObject(); if (o) { o.set('top', (1080 - (o.height * (o.scaleY || 1))) / 2); canvas.requestRenderAll(); pushHistory(); renderProperties(); } });

        $('#undoBtn').addEventListener('click', undo);
        $('#redoBtn').addEventListener('click', redo);
        $('#zoomInBtn').addEventListener('click', () => { state.zoom = clamp(state.zoom + 0.1, 0.05, 2); applyZoom(); });
        $('#zoomOutBtn').addEventListener('click', () => { state.zoom = clamp(state.zoom - 0.1, 0.05, 2); applyZoom(); });
        $('#zoomResetBtn').addEventListener('click', () => { state.zoom = 1; applyZoom(); });
        $('#zoomFitBtn').addEventListener('click', fitZoom);

        $('#fullscreenBtn').addEventListener('click', () => {
            const shell = $('#editorShell');
            if (!document.fullscreenElement) {
                (shell.requestFullscreen || shell.webkitRequestFullscreen || shell.msRequestFullscreen).call(shell);
            } else {
                document.exitFullscreen();
            }
        });

        $('#previewToggle').addEventListener('click', () => {
            // Save first
            saveDesign().then(() => {
                window.open('{{ route('admin.banner_preview', $banner->id) }}', '_blank');
            });
        });

        // ===== Layer actions =====
        $('#layersList').addEventListener('click', (e) => {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;
            const row = btn.closest('.ed-layer');
            const obj = canvas.getObjects().find(o => getMeta(o).id === row.dataset.objId);
            if (!obj) return;
            const action = btn.dataset.action;
            const meta = getMeta(obj);
            if (action === 'visible') { meta.visible = meta.visible === false; obj.visible = meta.visible !== false; obj.evented = obj.visible; canvas.requestRenderAll(); pushHistory(); renderLayers(); }
            if (action === 'lock')    { meta.locked = !meta.locked; obj.lockMovementX = obj.lockMovementY = obj.lockScalingX = obj.lockScalingY = obj.lockRotation = meta.locked; obj.selectable = !meta.locked; canvas.requestRenderAll(); renderLayers(); }
            if (action === 'delete')  { canvas.remove(obj); pushHistory(); renderLayers(); renderProperties(); }
        });
        $('#layersList').addEventListener('dblclick', (e) => {
            const nameEl = e.target.closest('.ed-layer-name');
            if (!nameEl) return;
            const row = nameEl.closest('.ed-layer');
            const obj = canvas.getObjects().find(o => getMeta(o).id === row.dataset.objId);
            nameEl.contentEditable = 'true';
            nameEl.focus();
            const sel = window.getSelection(); sel.removeAllRanges(); const r = document.createRange(); r.selectNodeContents(nameEl); sel.addRange(r);
            nameEl.addEventListener('blur', () => {
                nameEl.contentEditable = 'false';
                if (obj) setMeta(obj, 'name', nameEl.textContent.trim() || 'Layer');
            }, { once: true });
            nameEl.addEventListener('keydown', (ev) => {
                if (ev.key === 'Enter') { ev.preventDefault(); nameEl.blur(); }
            });
        });
        // Drag to reorder
        let dragSrc = null;
        $('#layersList').addEventListener('dragstart', (e) => {
            const row = e.target.closest('.ed-layer');
            if (row) { dragSrc = row.dataset.objId; e.dataTransfer.effectAllowed = 'move'; }
        });
        $('#layersList').addEventListener('dragover', (e) => e.preventDefault());
        $('#layersList').addEventListener('drop', (e) => {
            e.preventDefault();
            const tgt = e.target.closest('.ed-layer');
            if (!tgt || !dragSrc || tgt.dataset.objId === dragSrc) return;
            const src = canvas.getObjects().find(o => getMeta(o).id === dragSrc);
            const dst = canvas.getObjects().find(o => getMeta(o).id === tgt.dataset.objId);
            if (!src || !dst) return;
            const srcIdx = canvas.getObjects().indexOf(src);
            const dstIdx = canvas.getObjects().indexOf(dst);
            canvas.moveTo(src, dstIdx);
            pushHistory(); renderLayers();
        });

        // ===== Keyboard =====
        document.addEventListener('keydown', (e) => {
            // Skip when editing text
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.isContentEditable) return;
            if (e.ctrlKey || e.metaKey) {
                if (e.key === 'z' || e.key === 'Z') { e.preventDefault(); e.shiftKey ? redo() : undo(); return; }
                if (e.key === 'y' || e.key === 'Y') { e.preventDefault(); redo(); return; }
                if (e.key === 'c') { e.preventDefault(); /* copy via duplicate shortcut */ $('#duplicateBtn').click(); return; }
                if (e.key === 'd') { e.preventDefault(); $('#duplicateBtn').click(); return; }
                if (e.key === 's') { e.preventDefault(); saveDesign().then(submitForm); return; }
            }
            if (e.key === 'Delete' || e.key === 'Backspace') { e.preventDefault(); deleteSelected(); return; }
            // Arrow keys
            if (['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown'].includes(e.key)) {
                const o = canvas.getActiveObject();
                if (!o) return;
                e.preventDefault();
                const step = e.shiftKey ? 10 : 1;
                if (e.key === 'ArrowLeft')  o.set('left', (o.left || 0) - step);
                if (e.key === 'ArrowRight') o.set('left', (o.left || 0) + step);
                if (e.key === 'ArrowUp')    o.set('top',  (o.top  || 0) - step);
                if (e.key === 'ArrowDown')  o.set('top',  (o.top  || 0) + step);
                canvas.requestRenderAll(); renderProperties();
            }
        });

        function deleteSelected() {
            const objs = canvas.getActiveObjects();
            if (objs.length === 0) return;
            objs.forEach(o => canvas.remove(o));
            canvas.discardActiveObject();
            canvas.requestRenderAll();
            pushHistory(); renderLayers(); renderProperties();
        }

        // ===== Save =====
        function saveDesign() {
            return new Promise((resolve) => {
                const design = serializeDesign();
                // Sync simple banner fields from a primary heading/text
                const firstText = design.elements.find(e => e.type === 'text');
                const firstBtn  = design.elements.find(e => e.type === 'button');
                $('#formTitle').value       = firstText ? firstText.content : $('#bannerName').value;
                $('#formDescription').value = firstText ? '' : ''; // we keep description optional
                $('#formLink').value        = firstBtn ? firstBtn.link : '#';
                $('#formDesignData').value  = JSON.stringify(design);

                // Generate PNG of the canvas so the banner shows as a real image
                // (text, buttons, images — exactly as designed) on the frontend.
                try {
                    const prevZoom = state.zoom;
                    if (prevZoom !== 1) { canvas.setZoom(1); }
                    const dataUrl = canvas.toDataURL({ format: 'png', multiplier: 1 });
                    if (prevZoom !== 1) { canvas.setZoom(prevZoom); applyZoom(); }
                    $('#formImageData').value = dataUrl;
                } catch (e) {
                    console.error('Failed to render canvas to image:', e);
                }

                resolve(design);
            });
        }
        function submitForm() { $('#bannerForm').submit(); }

        $('#saveBtn').addEventListener('click', () => saveDesign().then(submitForm));

        // ===========================================================
        //  INIT — load existing design, or empty canvas
        // ===========================================================
        if (INITIAL_DESIGN && INITIAL_DESIGN.elements && INITIAL_DESIGN.elements.length > 0) {
            restoreDesign(INITIAL_DESIGN);
        } else {
            canvas.setBackgroundColor('#1e1b4b', () => canvas.requestRenderAll());
        }
        applyBackground();
        // Reflect initial background
        if (INITIAL_DESIGN && INITIAL_DESIGN.background && INITIAL_DESIGN.background.type === 'color') {
            const c = INITIAL_DESIGN.background.value || '#1e1b4b';
            $('#bgColorText').value = c;
            $('#bgColorSwatch').value = c;
        }
        // Restore Banner Settings (Page, Position, Priority, Link) from server data
        document.getElementById('metaPage').value = '{{ $banner->page ?: 'home' }}';
        document.getElementById('formPage').value = '{{ $banner->page ?: 'home' }}';
        document.getElementById('metaPosition').value = '{{ $banner->position ?: 'hero' }}';
        document.getElementById('formPosition').value = '{{ $banner->position ?: 'hero' }}';
        document.getElementById('metaPriority').value = {{ $banner->priority ?: 1 }};
        document.getElementById('formPriority').value = {{ $banner->priority ?: 1 }};
        document.getElementById('metaLink').value = '{{ $banner->link ?? '' }}';
        document.getElementById('formLink').value = '{{ $banner->link ?? '#' }}';
        setTimeout(() => { fitZoom(); if (canvas.getObjects().length > 0) { pushHistory(); renderLayers(); renderProperties(); } else { renderLayers(); renderProperties(); } }, 100);
        window.addEventListener('resize', fitZoom);

    })();
    </script>
@endsection
