<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function get()
    {
        return session()->get('cart', []);
        /*
        $categories = Category::WhereNull('parentId')->where('status', 'active')->with([
            'childrens' => function ($query) {
                $query->where('status', 'active')
                    ->with([
                        'childrens' => function ($query) {
                            $query->where('status', 'active');
                        }
                    ]);
            }
        ])->get();
        return $categories;
        return view('frontend.body.main_menu', compact('categories'));
        */
    }
}
