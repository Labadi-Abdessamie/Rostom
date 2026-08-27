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
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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
        $magasin->latitude = $validated['latitude'] ?? null;
        $magasin->longitude = $validated['longitude'] ?? null;
        $magasin->facebookLink = $validated['facebookLink'] ?? null;
        $magasin->instagramLink = $validated['instagramLink'] ?? null;
        $magasin->tiktokLink = $validated['tiktokLink'] ?? null;
        $magasin->whatsupLink = $validated['whatsupLink'] ?? null;
        $magasin->category_id = $validated['category_id'];
        $magasin->user_id = Auth::id();

        //$magasin->status = 'firstOpening'; //! by ddefault
        $magasin->save();

        if ($request->hasFile('magasinPicture')) {
            $file = $request->file('magasinPicture');
            $path = $file->store('magasins_images' . $magasin->id, 'public');
            $magasin->magasinPicture = basename($path);
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
            return view('vendor.pages.edit_magasin', compact('magasin',));
        }
    }


    public function destroy($id)
    {
        $magasin = Magasin::findOrFail($id);
        $magasin->user->magasin_id = null;
        $magasin->user->save();
        $magasin->status = 'inactive';
        $magasin->save();

        return redirect()->back()->with('success', 'Magasin disabled successfully.');
    }

    public function update(Request $request, $id)
    {
        $magasin = Magasin::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:magasins,email,' . $magasin->id,
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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
            'status' => 'nullable|in:active,inactive,blocked',
            'rate' => 'nullable|numeric|min:0|max:5',
        ]);

        $magasin->name = $request->name;
        $magasin->email = $request->email;
        $magasin->latitude = $request->latitude;
        $magasin->longitude = $request->longitude;
        $magasin->phoneNumber = $request->phoneNumber;
        $magasin->location = $request->location;
        $magasin->magasinOpen = $request->magasinOpen;

        // Bio and social links only exist on the vendor edit form. Guard them so
        // the admin edit form (which omits them) doesn't wipe them to null.
        if ($request->has('bio')) {
            $magasin->bio = $request->bio;
        }
        if ($request->has('facebookLink')) {
            $magasin->facebookLink = $request->facebookLink;
        }
        if ($request->has('instagramLink')) {
            $magasin->instagramLink = $request->instagramLink;
        }
        if ($request->has('tiktokLink')) {
            $magasin->tiktokLink = $request->tiktokLink;
        }
        if ($request->has('whatsupLink')) {
            $magasin->whatsupLink = $request->whatsupLink;
        }

        // Status and rate only exist on the admin edit form.
        if ($request->filled('status')) {
            $magasin->status = $request->status;
        }
        if ($request->filled('rate')) {
            $magasin->rate = $request->rate;
        }

        if ($request->hasFile('magasinPicture')) {
            if ($magasin->magasinPicture && Storage::exists('public/' . $magasin->magasinPicture)) {
                Storage::delete('public/' . $magasin->magasinPicture);
            }

            $magasin->magasinPicture = $request->file('magasinPicture')->store('magasinPictures', 'public');
        }

        if ($request->hasFile('vitrineVideo')) {
            if ($magasin->vitrineVideo && Storage::exists('public/' . $magasin->vitrineVideo)) {
                Storage::delete('public/' . $magasin->vitrineVideo);
            }

            $magasin->vitrineVideo = $request->file('vitrineVideo')->store('vitrineVideos', 'public');
        }

        $magasin->save();

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.magasins')->with('success', 'Magasin updated successfully!');
        }

        return redirect()->route('vendor.magasin', $magasin->id)->with('success', 'Magasin updated successfully!');
    }
}
