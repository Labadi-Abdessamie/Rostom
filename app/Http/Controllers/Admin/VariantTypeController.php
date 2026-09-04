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
        // Keep full list for admin list (so hidden ones can be toggled back),
        // but forms/views that show them to vendors should filter by is_visible.
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

        VariantType::create(array_merge($validated, ['is_visible' => true]));

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

    public function toggleVisibility(VariantType $variantType)
    {
        $variantType->is_visible = !$variantType->is_visible;
        $variantType->save();
        return redirect()->route('admin.variant_types')->with('success', 'Variant type ' . ($variantType->is_visible ? 'shown' : 'hidden') . '.');
    }
}