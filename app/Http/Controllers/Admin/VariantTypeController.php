<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantType;
use Illuminate\Http\Request;

class VariantTypeController extends Controller
{
    public function index()
    {
        $variantTypes = VariantType::orderBy('position')->get();
        return view('admin.pages.variant_types', compact('variantTypes'));
    }

    public function create()
    {
        return view('admin.pages.create_variant_type');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:variant_types,name',
            'display_name' => 'required|string|max:50',
            'type' => 'required|in:color_swatch,text,image',
            'options' => 'nullable|string',
            'required' => 'boolean',
            'position' => 'integer|min:0',
        ]);

        // Parse comma-separated options into array
        if (!empty($validated['options'])) {
            $validated['options'] = array_map('trim', explode(',', $validated['options']));
        } else {
            $validated['options'] = null;
        }

        VariantType::create($validated);

        return redirect()->route('admin.variant_types')->with('success', 'Variant type created successfully.');
    }

    public function edit(VariantType $variantType)
    {
        return view('admin.pages.edit_variant_type', compact('variantType'));
    }

    public function update(Request $request, VariantType $variantType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:variant_types,name,' . $variantType->id,
            'display_name' => 'required|string|max:50',
            'type' => 'required|in:color_swatch,text,image',
            'options' => 'nullable|string',
            'required' => 'boolean',
            'position' => 'integer|min:0',
        ]);

        // Parse comma-separated options into array
        if (!empty($validated['options'])) {
            $validated['options'] = array_map('trim', explode(',', $validated['options']));
        } else {
            $validated['options'] = null;
        }

        $variantType->update($validated);

        return redirect()->route('admin.variant_types')->with('success', 'Variant type updated successfully.');
    }

    public function destroy(VariantType $variantType)
    {
        if ($variantType->variants()->exists()) {
            return redirect()->route('admin.variant_types')->with('error', 'Cannot delete variant type that is in use.');
        }

        $variantType->delete();

        return redirect()->route('admin.variant_types')->with('success', 'Variant type deleted successfully.');
    }
}