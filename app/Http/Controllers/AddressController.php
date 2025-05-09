<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = $user->addresses()->latest()->get();
        return view('client.pages.address', compact('addresses'));
    }
    public function create()
    {
        $user = Auth::user();
        $hasPrincipal = $user->addresses()->where('principalAddress', true)->exists();

        return view('client.pages.add_address', [
            'hasPrincipal' => $hasPrincipal
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'type' => 'required|in:billing,shipping', // Only accept allowed enum values
            'address' => 'required|string|max:255',
            'principalAddress' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        if ($request->boolean('principalAddress') && $user->addresses()->where('principalAddress', true)->exists()) {
            return redirect()->back()->with('error', 'You can only have one principal address.');
        }
        $user->addresses()->create([
            'name' => $request->input('name'),
            'phoneNumber' => $request->input('phoneNumber'),
            'email' => $request->input('email'),
            'type' => $request->input('type'),
            'address' => $request->input('address'),
            'principalAddress' => $request->boolean('principalAddress'),
        ]);

        return redirect()->route('client.address')->with('success', 'Address added successfully.');
    }
    public function edit($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        return view('client.pages.edit', compact('address'));
    }

    // Handle the address update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'type' => 'required|string',
            'address' => 'required|string|max:255',
            'principalAddress' => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $address = $user->addresses()->findOrFail($id);

        if ($request->has('principalAddress')) {
            $user->addresses()->where('type', $address->type)->where('id', '!=', $id)->update([
                'principalAddress' => false
            ]);
        }

        $address->update([
            'name' => $request->name,
            'phoneNumber' => $request->phoneNumber,
            'email' => $request->email,
            'type' => $request->type,
            'address' => $request->address,
            'principalAddress' => $request->has('principalAddress'),
        ]);

        return redirect()->route('client.address')->with('success', 'Address updated successfully.');
    }
    public function destroy($id)
    {
        $address = Auth::user()->addresses()->findOrFail($id);
        $address->delete();

        return back()->with('success', 'Address deleted successfully.');
    }
}
