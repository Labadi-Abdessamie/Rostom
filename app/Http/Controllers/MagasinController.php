<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magasin;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MagasinController extends Controller
{
    public function create()
    {
        $categories = Category::whereNull('parentId')->get();
        return view('vendor.pages.create_magasin', ['categories' => $categories]);
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'magasinPicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'vitrineVideo' => 'nullable|mimetypes:video/mp4,video/quicktime|max:10000',
            'bio' => 'required|string',
            'location' => 'required|string|max:255',
            'facebookLink' => 'nullable|url',
            'instagramLink' => 'nullable|url',
            'tiktokLink' => 'nullable|url',
            'whatsupLink' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'registreCommerce' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $magasin = new Magasin();
        $magasin->name = $validated['name'];
        $magasin->phoneNumber = $validated['phoneNumber'];
        $magasin->email = $validated['email'];
        $magasin->bio = $validated['bio'];
        $magasin->location = $validated['location'];
        $magasin->facebookLink = $validated['facebookLink'] ?? null;
        $magasin->instagramLink = $validated['instagramLink'] ?? null;
        $magasin->tiktokLink = $validated['tiktokLink'] ?? null;
        $magasin->whatsupLink = $validated['whatsupLink'] ?? null;
        $magasin->category_id = $validated['category_id'];
        $magasin->user_id = Auth::id();

        //$magasin->status = 'firstOpening'; //! by ddefault

        if ($request->hasFile('magasinPicture')) {
            $magasin->magasinPicture = $request->file('magasinPicture')->store('magasin_pictures', 'public');
        }

        // Handle vitrineVideo upload
        if ($request->hasFile('vitrineVideo')) {
            $magasin->vitrineVideo = $request->file('vitrineVideo')->store('vitrine_videos', 'public');
        }

        $magasin->save();

        $user = Auth::user();
        $user->magasin_id = $magasin->id;
        $user->save();

        if ($request->hasFile('registreCommerce')) {
            $vendor = auth()->user();
            $customPath = 'demands/' . $vendor->id . '/' . $magasin->id;

            $file = $request->file('registreCommerce');
            $filename = time() . '_' . $file->getClientOriginalName();

            $file->storeAs($customPath, $filename, 'local');
        }

        return redirect()->back()->with('success', 'Magasin created successfully! It will be active after admin approval.');
    }
}
