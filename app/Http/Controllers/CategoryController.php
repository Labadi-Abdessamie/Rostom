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
        $categories = Category::where('parentId', null)->with('childrens')->get();
        return view('admin.pages.add-category', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:255',
            'status' => 'required|string|in:active,inactive',
            'parent' => 'nullable|integer'
        ]);


        $categories = Category::where('parentId', $request->parent)->get();
        $nameExists = $categories->contains(function ($category) use ($request) {
            return strtolower($category->name) === strtolower($request->name);
        });

        if ($nameExists) {
            return redirect()->back()->with("error", "Category name already exists.");
        }

        $category = new Category();
        $category->name = $request->name;
        $category->status = $request->status;
        $category->parentId = $request->parent;
        $category->save();

        return redirect()->route('admin.categories')->with('success', 'Category created successfully.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.pages.edit-category', compact('category'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|in:active,inactive'
        ]);

        $category = Category::findOrFail($id);

        $categories = Category::where('parentId', $category->parentId)->get();

        $nameExists = $categories->contains(function ($item) use ($request) {
            return strtolower($item->name) === strtolower($request->name);
        });

        if ($nameExists) {
            return redirect()->back()->with("error", "Category name already exists.");
        }
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
                $grandChild->status = 'inactive';
                $grandChild->save();
            }
            $child->status = 'inactive';
            $child->save();
        }
        $category->status = 'inactive';
        $category->save();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
