<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('admin.pages.banners', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $banner = new Banner();
        $banner->title = 'New Banner';
        $banner->description = '';
        $banner->link = '#';
        $banner->page = 'home';
        $banner->position = 'hero';
        $banner->priority = 1;
        $banner->type = 'normal';
        $banner->status = 'active';
        $banner->show_title = true;
        $banner->show_description = true;
        $banner->design_data = null;

        return view('admin.pages.add-banner', compact('banner'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'page' => 'required|string',
            'position' => 'required|string',
            'priority' => 'required|integer|min:1',
            'show_title' => 'boolean',
            'show_description' => 'boolean',
            'type' => 'required|string',
            'status' => 'required|string',
            'link' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'design_data' => 'nullable|json',
            'rendered_image' => 'nullable|string',
        ]);

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->description = $request->description ?? '';
        $banner->link = $request->link;
        $banner->page = $request->page;
        $banner->position = $request->position;
        $banner->priority = $request->priority;
        $banner->show_title = $request->boolean('show_title');
        $banner->show_description = $request->boolean('show_description');
        $banner->type = $request->type;
        $banner->status = $request->status;
        $banner->design_data = $this->sanitizeDesignData($request->input('design_data'));

        // Handle rendered image from canvas (base64 data URL)
        if ($request->filled('rendered_image')) {
            $banner->image = $this->saveBase64Image($request->input('rendered_image'));
        } elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        // Deactivate any other active banner with the same page + position + priority
        Banner::where('page', $banner->page)
            ->where('position', $banner->position)
            ->where('priority', $banner->priority)
            ->where('id', '!=', $banner->id)
            ->update(['status' => 'inactive']);

        return redirect()->route('admin.banners')->with('success', 'Banner created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.pages.edit_banner', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'page' => 'required|string',
            'position' => 'required|string',
            'priority' => 'required|integer|min:1',
            'show_title' => 'boolean',
            'show_description' => 'boolean',
            'type' => 'required|string',
            'status' => 'required|string',
            'link' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'design_data' => 'nullable|json',
            'rendered_image' => 'nullable|string',
        ]);

        $banner = Banner::findOrFail($id);

        $banner->title = $request->title;
        $banner->description = $request->description ?? '';
        $banner->link = $request->link ?? '#';
        $banner->page = $request->page;
        $banner->position = $request->position;
        $banner->priority = $request->priority;
        $banner->show_title = $request->boolean('show_title');
        $banner->show_description = $request->boolean('show_description');
        $banner->type = $request->type;
        $banner->status = $request->status;

        $designData = $this->sanitizeDesignData($request->input('design_data'));
        if ($designData !== null) {
            $banner->design_data = $designData;
        }

        // Handle rendered image from canvas (base64 data URL)
        if ($request->filled('rendered_image')) {
            $banner->image = $this->saveBase64Image($request->input('rendered_image'));
        } elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        return redirect()->route('admin.banners')->with('success', 'Banner updated successfully.');
    }

    /**
     * Upload an image asset (used by the visual editor).
     * Returns the storage path so Fabric.js can reference it.
     */
    public function uploadAsset(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,webp|max:8192',
        ]);

        $path = $request->file('file')->store('banners/editor', 'public');

        return response()->json([
            'path' => $path,
            'url' => asset('storage/' . $path),
        ]);
    }

    /**
     * Server-side preview of a banner. Renders the editor JSON
     * in a standalone iframe-friendly template, no admin chrome.
     */
    public function preview(string $id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.pages.banner_preview', [
            'banner' => $banner,
            'design' => $banner->design_data ?? $this->legacyDesign($banner),
        ]);
    }

    /**
     * Build a design_data structure from legacy (title/description/image)
     * so existing banners keep rendering on the new system.
     */
    public static function legacyDesign(Banner $banner): array
    {
        $elements = [];
        $y = 360;

        if ($banner->show_title && $banner->title) {
            $elements[] = [
                'id' => 'legacy-title-' . $banner->id,
                'name' => 'Title',
                'type' => 'text',
                'content' => $banner->title,
                'x' => 120, 'y' => $y, 'width' => 800, 'height' => 120,
                'fontSize' => 84, 'fontFamily' => 'Poppins', 'fontWeight' => 800,
                'color' => '#ffffff', 'align' => 'left', 'lineHeight' => 1.1,
                'letterSpacing' => 0, 'opacity' => 100, 'zIndex' => 5, 'visible' => true, 'locked' => false,
            ];
            $y += 140;
        }

        if ($banner->show_description && $banner->description) {
            $elements[] = [
                'id' => 'legacy-desc-' . $banner->id,
                'name' => 'Description',
                'type' => 'text',
                'content' => $banner->description,
                'x' => 120, 'y' => $y, 'width' => 800, 'height' => 100,
                'fontSize' => 40, 'fontFamily' => 'Poppins', 'fontWeight' => 400,
                'color' => '#ffffff', 'align' => 'left', 'lineHeight' => 1.2,
                'letterSpacing' => 0, 'opacity' => 100, 'zIndex' => 4, 'visible' => true, 'locked' => false,
            ];
            $y += 130;
        }

        if (! empty($banner->link) && $banner->link !== '#') {
            $elements[] = [
                'id' => 'legacy-btn-' . $banner->id,
                'name' => 'Shop Now',
                'type' => 'button',
                'content' => 'Shop Now',
                'link' => $banner->link,
                'x' => 120, 'y' => $y, 'width' => 240, 'height' => 64,
                'fontSize' => 22, 'fontFamily' => 'Poppins', 'fontWeight' => 600,
                'color' => '#ffffff', 'background' => '#1677FF',
                'borderRadius' => 12, 'align' => 'center', 'zIndex' => 6, 'visible' => true, 'locked' => false,
            ];
        }

        return [
            'version' => 1,
            'width' => 1920,
            'height' => 1080,
            'background' => [
                'type' => $banner->image ? 'image' : 'color',
                'value' => $banner->image ? ('storage/' . $banner->image) : '#1e1b4b',
                'overlay' => ['color' => '#000000', 'opacity' => 0],
            ],
            'elements' => $elements,
        ];
    }

    /**
     * Decode and lightly validate a design_data JSON payload coming from
     * the visual editor. Returns null when the payload is empty/invalid so
     * we never blow up on a malformed request.
     */
    private function sanitizeDesignData(?string $raw): ?array
    {
        if ($raw === null || $raw === '') {
            return null;
        }

        $decoded = json_decode($raw, true);

        if (! is_array($decoded)) {
            return null;
        }

        return $decoded;
    }

    /**
     * Save a base64-encoded PNG (from canvas.toDataURL) to storage.
     * Returns the storage path (e.g. banners/filename.png).
     */
    private function saveBase64Image(string $base64DataUrl): ?string
    {
        if (!str_contains($base64DataUrl, 'base64,')) {
            return null;
        }
        $parts = explode(',', $base64DataUrl, 2);
        $imgData = base64_decode($parts[1]);
        if ($imgData === false) {
            return null;
        }
        $filename = 'banner_' . uniqid() . '.png';
        $path = 'banners/' . $filename;
        Storage::disk('public')->put($path, $imgData);
        return $path;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->route('admin.banners')->with('success', 'Banner deleted successfully.');
    }
}
