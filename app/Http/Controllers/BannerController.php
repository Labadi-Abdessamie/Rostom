<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

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
        return view('admin.pages.add-banner');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'page' => 'required|string',
            'position' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $banner = new Banner();
        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->link = $request->link;
        $banner->page = $request->page;
        $banner->position = $request->position;
        $banner->type = $request->type;
        $banner->status = $request->status;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        $oldBanner = Banner::where('page', $banner->page)->where('position', $banner->position)->first();
        if ($oldBanner) {
            $oldBanner->status = 'inactive';
            $oldBanner->save();
        }
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
            'description' => 'required|string',
            'page' => 'required|string',
            'position' => 'required|string',
            'type' => 'required|string',
            'status' => 'required|string',
            'link' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $banner = Banner::findOrFail($id);

        $banner->title = $request->title;
        $banner->description = $request->description;
        $banner->link = $request->link ?? '#';
        $banner->page = $request->page;
        $banner->position = $request->position;
        $banner->type = $request->type;
        $banner->status = $request->status;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        return redirect()->route('admin.banners')->with('success', 'Banner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return redirect()->back()->with('success', 'Banner deleted successfully.');
    }
}
