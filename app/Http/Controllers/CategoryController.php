<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('parentId', null)->with('childrens')->get();
        return view('admin.pages.categories', compact('categories'));
    }
    public function create()
    {
        return view('admin.pages.add-category');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive',
            'parentId' => 'nullable|integer'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->parentId = $request->parentId;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.pages.edit_category', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive'
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category Edited successfully.');
    }
    public function destroy($id)
    {
        $category = Category::with('childrens.childrens')->findOrFail($id);
        foreach ($category->childrens as $child) {
            foreach ($child->childrens as $grandChild) {
                $grandChild->delete();
            }
            $child->delete();
        }
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
