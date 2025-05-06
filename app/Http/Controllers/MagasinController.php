<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magasin;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class MagasinController extends Controller
{
    public function magasins($filtre = null)
    {
        if (is_null($filtre)) {
            $magasins = Magasin::with('user')->paginate(10);
        } else if ($filtre === "demands") {
            $magasins = Magasin::with('user')->where('status', 'firstOpening')->paginate(10); // Maybe me(Mus) changes it
        } else {
            return redirect()->route('admin.magasins');
        }
        return view('admin.pages.magasins', compact('magasins', 'filtre'));
    }

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

    public function showRegister($id)
    {
        $magasin = Magasin::findOrFail($id);
        $directory = 'demands/' . $magasin->user->id . '/' . $magasin->id . '/';
        $files = Storage::disk('local')->files($directory);
        if (empty($files)) {
            abort(404);
        }
        $path = $files[0];
        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }
        $file = Storage::disk('local')->get($path);
        $type = Storage::disk('local')->mimeType($path);

        return Response::make($file, 200)->header("Content-Type", $type);
    }

    public function approveMagasin($id)
    {
        $magasin = Magasin::findOrFail($id);
        $magasin->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Magasin approved successfully.');
    }
    public function rejectMagasin($id)
    {
        $magasin = Magasin::findOrFail($id);
        $magasin->user->magasin_id = null;
        $magasin->user->save();
        $magasin->delete();
        return redirect()->route('admin.magasins', ['filtre' => 'demands'])->with('success', 'Magasin rejected and deleted successfully.');
    }

    public function edit($id)
    {
        $magasin = Magasin::findOrFail($id);
        if (Auth::user()->role == "admin") {
            return view('admin.pages.edit_magasin', compact('magasin'));
        } else if (Auth::user()->role == "vendor" && $magasin->user_id == Auth::user()->id) {
            return view('vendor.pages.edit_magasin', compact('magasin', ));
        }
    }
    

    public function destroy($id)
    {
        $magasin = Magasin::findOrFail($id);
        $magasin->user->magasin_id = null;
        $magasin->user->save();
        $magasin->delete();

        return redirect()->back()->with('success', 'Magasin deleted successfully.');
    }

    public function update(Request $request, $id)
{
    // Find the magasin by ID
    $magasin = Magasin::findOrFail($id);

    // Validate incoming data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:magasins,email,' . $magasin->id,
        'phoneNumber' => 'required|string|max:20',
        'location' => 'required|string|max:255',
        'bio' => 'nullable|string',
        'magasinPicture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'vitrineVideo' => 'nullable|mimes:mp4,mov,avi,mkv|max:10240',
        'facebookLink' => 'nullable|url',
        'instagramLink' => 'nullable|url',
        'tiktokLink' => 'nullable|url',
        'whatsupLink' => 'nullable|url',
        'magasinOpen' => 'required|boolean',
    ]);

    // Update the magasin details
    $magasin->name = $request->name;
    $magasin->email = $request->email;
    $magasin->phoneNumber = $request->phoneNumber;
    $magasin->location = $request->location;
    $magasin->bio = $request->bio;
    $magasin->facebookLink = $request->facebookLink;
    $magasin->instagramLink = $request->instagramLink;
    $magasin->tiktokLink = $request->tiktokLink;
    $magasin->whatsupLink = $request->whatsupLink;
    $magasin->magasinOpen = $request->magasinOpen;

    // Handle the magasinPicture upload
    if ($request->hasFile('magasinPicture')) {
        // Delete the old picture if it exists
        if ($magasin->magasinPicture && Storage::exists('public/' . $magasin->magasinPicture)) {
            Storage::delete('public/' . $magasin->magasinPicture);
        }

        // Store the new picture
        $magasin->magasinPicture = $request->file('magasinPicture')->store('magasinPictures', 'public');
    }

    // Handle the vitrineVideo upload
    if ($request->hasFile('vitrineVideo')) {
        // Delete the old video if it exists
        if ($magasin->vitrineVideo && Storage::exists('public/' . $magasin->vitrineVideo)) {
            Storage::delete('public/' . $magasin->vitrineVideo);
        }

        // Store the new video
        $magasin->vitrineVideo = $request->file('vitrineVideo')->store('vitrineVideos', 'public');
    }

    // Save the updated magasin data
    $magasin->save();

    // Redirect back with success message
    return redirect()->route('vendor.magasin', $magasin->id)->with('success', 'Magasin updated successfully!');
}
}
