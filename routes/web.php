<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VendorController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/cleareverything', function () {
    $clearcache = Artisan::call('cache:clear');
    echo 'Cache cleared<br>';

    $clearview = Artisan::call('view:clear');
    echo 'View cleared<br>';

    $clearconfig = Artisan::call('config:clear');
    echo 'Config cleared<br>';
});


Route::group(['prefix' => '/'], function () {
    Route::get('cat', [CategoryController::class, 'get']);
});


//Frontend route
Route::group(['prefix' => '', 'as' => 'frontend.'], function () {
    Route::get('/', [MainController::class, 'index'])->name('index');

    Route::get('vendors', [VendorController::class, 'index'])->name('vendor');
    Route::get('vendor-details/{id}', [VendorController::class, 'show'])->name('vendor_details');

    Route::get('products/{category?}', [ProductController::class, 'index'])->name('products');
    Route::get('product-details/{id}', [ProductController::class, 'show'])->name('product_details');


    Route::get('cart', [MainController::class, 'cart'])->name('cart');
    Route::get('wishlist', [MainController::class, 'wishlist'])->name('wishlist');
    Route::get('compare', [MainController::class, 'compare'])->name('compare');


    //Route::get('flash-Sale', [MainController::class, 'flashSale'])->name('flash_sale');
    //Route::get('daily-deals', [MainController::class, 'dailyDeals'])->name('daily_deals');
    //Route::get('track-order', [MainController::class, 'trackOrder'])->name('track_order');
    //Route::get('brands', [MainController::class, 'brands'])->name('brands');
    //Route::get('blog', [MainController::class, 'blog'])->name('blog');
    //Route::get('blog-details', [MainController::class, 'blogDetails'])->name('blog_details');

    Route::get('contact', [MainController::class, 'contact'])->name('contact');

    Route::get('check-out', [MainController::class, 'checkOut'])->name('check_out');
    //Route::get('user-login', [MainController::class, 'login'])->name('login');
    Route::get('forget-password', [MainController::class, 'forgetPassword'])->name('forget_password');
});



route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'review', 'as' => 'frontend.review.'], function () {
        Route::post('add', [ReviewController::class, 'store'])->name('add');
        //Route::post('remove-item/{id}', [CartController::class, 'removeItem'])->name('cart.remove_item');
        //Route::post('add-item/{id}', [CartController::class, 'addItem'])->name('cart.add_item');
    });
});

//Client route
route::middleware(['auth', 'role:client'])->group(function () {
    Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
        Route::get('dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
        //Route::get('chat', [ClientController::class, 'chat'])->name('chat');
        Route::get('orders', [ClientController::class, 'orders'])->name('orders');
        Route::get('download', [ClientController::class, 'download'])->name('download');
        //Route::get('invoice', [ClientController::class, 'invoice'])->name('order_invoice');
        Route::get('reviews', [ClientController::class, 'reviews'])->name('reviews');
        Route::get('wishlist', [ClientController::class, 'wishlist'])->name('wishlist');
        Route::get('profile', [ClientController::class, 'profile'])->name('profile');
        Route::get('address', [ClientController::class, 'address'])->name('address');
        Route::get('add-address', [ClientController::class, 'addAddress'])->name('add_address');
        Route::post('profile/update', [ClientController::class, 'updateProfile'])->name('update_profile');
        Route::post('profile/update/password', [ClientController::class, 'updatePassword'])->name('update_password');
    });
});

//Vendor route
route::middleware(['auth', 'role:vender'])->group(function () {
    Route::group(['prefix' => 'vender', 'as' => 'vender.'], function () {
        Route::get('dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [VendorController::class, 'profile'])->name('profile');
        Route::post('profile/update', [VendorController::class, 'updateProfile'])->name('update_profile');
        Route::post('profile/update/password', [VendorController::class, 'updatePassword'])->name('update_password');
    });
});

//Admin route
//! Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');
route::middleware(['auth', 'role:admin'])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('update_profile');
        Route::post('profile/update/password', [AdminController::class, 'updatePassword'])->name('update_password');
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//!
/*
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/vendors', [AdminController::class, 'manageVendors'])->name('admin.vendors');
    Route::get('/admin/products', [AdminController::class, 'manageProducts'])->name('admin.products');
    Route::delete('/admin/user/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
    Route::delete('/admin/product/{id}', [AdminController::class, 'deleteProduct'])->name('admin.product.delete');
});
*/
/*
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
*/
require __DIR__ . '/auth.php';
