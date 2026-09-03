<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Existing index code - no changes needed
        $categoryId = $request->query('category', null);
        $sort = $request->query('sort', null);
        $perPage = $request->query('number', 12);
        if ($perPage === 'all') $perPage = 9999;

        $queryFilter = $request->query('query', null);
        $min = $request->query('min', null);
        $max = $request->query('max', null);
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        if ($queryFilter) {
            $products = Product::where('is_listed', true)->where('name', 'like', '%'. $queryFilter .'%')
                ->with('category')
                ->paginate($perPage)->appends($request->except('page'));
        } else {
            $query = Product::where('is_listed', true)->with(['category', 'magasin'])->withCount('orderItems');

            if ($categoryId) {
                $category = Category::find($categoryId);
                if (!$category || $category->status !== 'active') {
                    return redirect()->route('frontend.products')
                        ->with('message', 'This category is not active');
                }
                $subCategoryIds = Category::where('parentId', $categoryId)->where('status', 'active')->pluck('id')->toArray();
                $subSubCategoryIds = Category::whereIn('parentId', $subCategoryIds)->where('status', 'active')->pluck('id')->toArray();
                $allCategoryIds = array_merge([$categoryId], $subCategoryIds, $subSubCategoryIds);
                $query->whereIn('category_id', $allCategoryIds);
            }

            if ($min !== null && $min !== '') {
                $query->where('price', '>=', (float)$min);
            }
            if ($max !== null && $max !== '') {
                $query->where('price', '<=', (float)$max);
            }

            switch ($sort) {
                case 'rating':
                    $query->orderByDesc('rate_average');
                    break;
                case 'latest':
                    $query->orderByDesc('created_at');
                    break;
                case 'low_high':
                    $query->orderBy('price');
                    break;
                case 'high_low':
                    $query->orderByDesc('price');
                    break;
                default:
                    $query->latest();
                    break;
            }
            $products = $query->paginate($perPage)->appends($request->except('page'));
        }

        return view('frontend.pages.product_view', compact('products', 'queryFilter', 'categories', 'min', 'max'));


        //! Precedent code works without filters
        /*
        $categoryId = $request->query('category');

        $category = null;
        if (is_null($categoryId)) {
            $products = Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->where('actual_quantity', '>', '0')->latest()->paginate(12);
        } else {
            $category = Category::find($categoryId);
            if (!$category || $category->status !== 'active') {
                return redirect()->route('frontend.products')
                    ->with('message', 'This category is not active');
            }
            $products = Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->where('actual_quantity', '>', '0')->where('category_id', $categoryId)->latest()->paginate(12);
        }

        return view('frontend.pages.product_view', compact('products', 'category'));
        */
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $magasin = Auth::user()->magasin;
        $magasinCategoryId = $magasin->category_id;

        $subcategories = Category::where('parentId', $magasinCategoryId)
            ->where('status', 'active')->get();

        $finalCategories = [];
        foreach ($subcategories as $subcategory) {
            $finalCategories[$subcategory->id] = Category::where('parentId', $subcategory->id)
                ->where('status', 'active')->get();
        }

        return view('vendor.pages.add_product', [
            'subcategories' => $subcategories,
            'finalCategories' => $finalCategories
        ]);
    }

    /**
     * Download a CSV template for bulk product import.
     */
    public function downloadProductTemplate()
    {
        $headers = [
            'name',
            'short_description',
            'long_description',
            'actual_quantity',
            'price',
        ];

        $filename = 'products_template.csv';

        $callback = function () use ($headers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            fclose($handle);
        };

        return Response::stream($callback, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Show bulk-import form.
     */
    public function showImportForm()
    {
        $magasin = Auth::user()->magasin;
        $magasinCategoryId = $magasin->category_id;

        $subcategories = Category::where('parentId', $magasinCategoryId)
            ->where('status', 'active')->get();

        $finalCategories = [];
        foreach ($subcategories as $subcategory) {
            $finalCategories[$subcategory->id] = Category::where('parentId', $subcategory->id)
                ->where('status', 'active')->get();
        }

        return view('vendor.pages.import_products', [
            'subcategories'   => $subcategories,
            'finalCategories' => $finalCategories,
        ]);
    }

    /**
     * Process the uploaded CSV/Excel and create products.
     */
    public function importProducts(Request $request)
    {
        $request->validate([
            'file'           => 'required|file|mimes:csv,txt|max:5120',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:categories,id',
        ]);

        $vendor = Auth::user();
        $magasin = $vendor->magasin;
        $magasinCategoryId = $magasin->category_id;

        // Resolve the chosen category, validate it belongs to vendor's tree
        $chosenCategoryId = (int) $request->input('subcategory_id') ?: (int) $request->input('category_id');

        $validCategory = Category::where('id', $chosenCategoryId)
            ->where('status', 'active')
            ->where(function ($q) use ($magasinCategoryId) {
                $q->where('id', $magasinCategoryId)
                  ->orWhere('parentId', $magasinCategoryId)
                  ->orWhereIn('parentId', function ($sub) use ($magasinCategoryId) {
                      $sub->select('id')->from('categories')->where('parentId', $magasinCategoryId);
                  });
            })
            ->exists();

        if (!$validCategory) {
            return redirect()->back()->with('error', 'Selected category is not in your magasin category tree.');
        }

        $file = $request->file('file');
        $path = $file->getRealPath();
        $rows = $this->readCsvRows($path);

        if (count($rows) < 2) {
            return redirect()->back()->with('error', 'The file is empty or missing data rows.');
        }

        $headers = array_map(fn($h) => strtolower(trim($h)), array_shift($rows));

        $expected = ['name', 'price'];
        foreach ($expected as $col) {
            if (!in_array($col, $headers)) {
                return redirect()->back()->with('error', "Missing column: {$col}. Please use the template.");
            }
        }

        $created = 0;
        $failed  = [];
        $rowNum  = 1; // header was row 1

        foreach ($rows as $row) {
            $rowNum++;

            // Skip empty rows
            if (count(array_filter($row, fn($v) => trim((string)$v) !== '')) === 0) {
                continue;
            }

            $data = array_combine($headers, array_pad($row, count($headers), ''));

            $name             = trim($data['name'] ?? '');
            $shortDescription = trim($data['short_description'] ?? '');
            $longDescription  = trim($data['long_description'] ?? '');
            $quantity         = (int) trim($data['actual_quantity'] ?? '0');
            $price            = (float) trim($data['price'] ?? '0');

            if ($name === '' || $price <= 0) {
                $failed[] = "Row {$rowNum}: name and price are required.";
                continue;
            }

            $product = new Product();
            $product->name              = $name;
            $product->short_description = $shortDescription;
            $product->long_description  = $longDescription;
            $product->actual_quantity   = $quantity;
            $product->price             = $price;
            $product->magasin_id        = $magasin->id;
            $product->category_id       = $chosenCategoryId;
            $product->rate_average      = 0;
            $product->rate_count        = 0;
            $product->is_listed         = false; // hidden until vendor publishes
            $product->save();

            $created++;
        }

        $message = "{$created} product(s) imported successfully.";
        if (count($failed) > 0) {
            $message .= ' ' . count($failed) . ' row(s) failed: ' . implode(' | ', array_slice($failed, 0, 5));
        }

        return redirect()->route('vendor.products')->with($created > 0 ? 'success' : 'error', $message);
    }

    private function readCsvRows(string $path): array
    {
        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            // Strip UTF-8 BOM if present
            $bom = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($handle);
            }
            while (($row = fgetcsv($handle)) !== false) {
                $rows[] = $row;
            }
            fclose($handle);
        }
        return $rows;
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'long_description' => 'nullable|string',
            'actual_quantity' => 'required|integer|min:0|max:999999',
            'price' => 'required|numeric|min:0',
            'principalImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'nullable|exists:categories,id',
        ]);


        $product = new Product();
        $product->name = $request->name;
        $product->short_description = $request->short_description ?? '';
        $product->long_description = $request->long_description;
        $product->actual_quantity = $request->actual_quantity;
        $product->price = $request->price;
        $product->magasin_id = Auth::user()->magasin->id;

        $product->category_id = $request->subcategory ? $request->subcategory : $request->category;

        $product->rate_average = 0;
        $product->rate_count = 0;
        $product->is_listed = false; // new product is hidden until vendor publishes

        $product->save();

        if ($request->hasFile('principalImage')) {
            $imagePath = $request->file('principalImage')->store('products_images/' . $product->id, 'public');
            $product->principalImage = basename($imagePath);
            $product->save();
        }


        return redirect()->route('vendor.products')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Existing show code - no changes needed
        $product = Product::where('is_listed', true)->whereHas('magasin', function ($query) {
            $query->where('status', 'active');
        })->whereHas('category', function ($q) {
            $q->where('status', 'active');
        })->with('magasin')->with('productImages')->findorFail($id);

        $reviews = Review::where('product_id', $id)->whereHas('user', function ($query) {
            $query->where('status', '!=', 'blocked');
        })->with(['user:id,name,profilePicture', 'images:id,review_id,path'])->latest()->paginate(3);

        return view('frontend.pages.product_details', compact('product', 'reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);

        $vendor = Auth::user();
        $magasin = $vendor->magasin;

        $mainCategoryId = $magasin->category_id;

        $subcategories = Category::where('parentId', $mainCategoryId)
            ->where('status', 'active')->get();

        $finalCategories = [];
        foreach ($subcategories as $subcategory) {
            $finalCategories[$subcategory->id] = Category::where('parentId', $subcategory->id)
                ->where('status', 'active')->get();
        }


        $productCategory = $product->category;

        $currentSubcategoryId = null;
        $currentSubSubcategoryId = null;

        if ($productCategory->parentId) {
            $parentCategory = Category::find($productCategory->parentId);
            if ($parentCategory && $parentCategory->parentId) {
                $currentSubcategoryId = $parentCategory->id;
                $currentSubSubcategoryId = $productCategory->id;
            } else {
                $currentSubcategoryId = $productCategory->id;
            }
        }


        return view('vendor.pages.edit_product', compact(
            'product',
            'subcategories',
            'finalCategories',
            'currentSubcategoryId',
            'currentSubSubcategoryId'
        ));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
            'long_description' => 'nullable|string',
            'actual_quantity' => 'required|integer|min:0|max:999999',
            'price' => 'required|numeric|min:0',
            'principalImage' => 'nullable|image|mimes:png|max:2048',
            'category' => 'required|exists:categories,id',
            'subcategory' => 'nullable|exists:categories,id',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->short_description = $request->short_description ?? '';
        $product->long_description = $request->long_description;
        $product->actual_quantity = $request->actual_quantity;
        $product->price = $request->price;

        if ($request->hasFile('principalImage')) {
            if ($product->principalImage && Storage::disk('public')->exists('products_images/' . $product->id . '/' . $product->principalImage)) {
                Storage::disk('public')->delete('products_images/' . $product->id . '/' . $product->principalImage);
            }

            $imagePath = $request->file('principalImage')->store('products_images/' . $product->id, 'public');
            $product->principalImage = basename($imagePath);
        }

        $product->category_id = $request->subcategory ? $request->subcategory : $request->category;



        $product->save();

        return redirect()->route('vendor.products')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        if ($product->orderItems()->count() > 0) {
            return redirect()->back()->with('error', "You can't delete this product.");
        }
        if (!empty($product->principalImage)) {
            $path = 'products_images/' . $product->id . '/' . $product->principalImage;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}
