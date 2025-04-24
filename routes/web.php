<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorInterfaceController;
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

    //Route::get('user-login', [MainController::class, 'login'])->name('login');
    Route::get('forget-password', [MainController::class, 'forgetPassword'])->name('forget_password');
});



//Client route
route::middleware(['auth', /*'role:client'*/])->group(function () {
    Route::get('check-out', [MainController::class, 'checkOut'])->name('frontend.check_out');
    Route::post('create_order', [OrderController::class, 'store'])->name('create_order');

    Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
        Route::get('dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
        Route::get('orders', [ClientController::class, 'orders'])->name('orders');
        Route::get('orders/{id}', [ClientController::class, 'orderDetails'])->name('order_details');
        Route::get('wishlist', [ClientController::class, 'wishlist'])->name('wishlist');
        Route::get('reviews', [ClientController::class, 'reviews'])->name('reviews');
        Route::put('reviews/{id}', [ClientController::class, 'updateReview'])->name('review.update');
        Route::delete('reviews/{id}', [ClientController::class, 'deleteReview'])->name('review.delete');
        Route::get('profile', [ClientController::class, 'profile'])->name('profile');
        Route::put(('profile/update'), [ClientController::class, 'update'])->name('profile.update');
        //-----------------------------------------//
        Route::get('address', [ClientController::class, 'address'])->name('address');
        Route::get('address/{id}/edit', [ClientController::class, 'editAddress'])->name('address.edit');
        Route::put('address/{id}', [ClientController::class, 'updateAddress'])->name('address.update');
        Route::delete('address/{id}', [ClientController::class, 'deleteAddress'])->name('address.delete');
        Route::post('address/store', [ClientController::class, 'storeAddress'])->name('address.store');
        Route::get('address/add', [ClientController::class, 'addAddress'])->name('address.add');
        //-----------------------------------------//

        Route::post('profile/update/password', [ClientController::class, 'updatePassword'])->name('update_password');

        //Route::get('invoice', [ClientController::class, 'invoice'])->name('order_invoice');
        //Route::get('chat', [ClientController::class, 'chat'])->name('chat');
        //Route::get('downloads', [ClientController::class, 'download'])->name('downloads');
    });
    Route::group(['prefix' => 'review', 'as' => 'frontend.review.'], function () {
        Route::post('add', [ReviewController::class, 'store'])->name('add');
    });
});

//Vendor route
route::middleware(['auth' /*,'role:vendor'*/])->group(function () {
    Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function () {
        Route::get('dashboard', [VendorInterfaceController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [VendorInterfaceController::class, 'profile'])->name('profile');
        Route::post('profile/update', [VendorInterfaceController::class, 'updateProfile'])->name('update_profile');
        Route::post('profile/update/password', [VendorInterfaceController::class, 'updatePassword'])->name('update_password');
    });
});

//Admin route
//! Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::middleware(['auth',/*'role:admin'*/])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        /*
        Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('update_profile');
        Route::post('profile/update/password', [AdminController::class, 'updatePassword'])->name('update_password');
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        */

        Route::get('customers/{type?}', [AdminController::class, 'customers'])->name('customers');
        Route::delete('delete-customer/{id}', [AdminController::class, 'deleteCustomer'])->name('delete.customer');

        Route::get('users/{id}/edit', [AdminController::class, 'editUser'])->name('edit_user');
        Route::post('users/{id}/update', [AdminController::class, 'updateUser'])->name('update_user');
        Route::delete('delete-user/{id}', [AdminController::class, 'deleteUser'])->name('delete_user');


        Route::get('magasins/{filtre?}', [AdminController::class, 'magasins'])->name('magasins');
        Route::post('magasins/{id}/approve', [AdminController::class, 'approveMagasin'])->name('approve.magasin');
        Route::delete('magasins/{id}/reject', [AdminController::class, 'rejectMagasin'])->name('reject.magasin');
        Route::delete('delete-magasin/{id}', [AdminController::class, 'deleteMagasin'])->name('delete.magasin');
        Route::get('magasins/edit/{id}', [AdminController::class, 'showEditMagasin'])->name('edit.magasin');
        Route::put('magasins/update/{id}', [AdminController::class, 'updateMagasin'])->name('update.magasin');

        Route::get('vendors/{type?}', [AdminController::class, 'vendors'])->name('vendors');
        Route::delete('delete-vendor/{id}', [AdminController::class, 'deleteVendor'])->name('delete.vendor');
        Route::get('vendors/edit/{id}', [AdminController::class, 'showEditVendor'])->name('vendors.edit');
        Route::put('vendors/update/{id}', [AdminController::class, 'updateVendor'])->name('vendors.update');



        Route::get('products', [AdminController::class, 'products'])->name('products');
        Route::delete('delete-product/{id}', [AdminController::class, 'deleteProduct'])->name('delete_product');


        Route::get('banners', [AdminController::class, 'banners'])->name('banners');
        Route::get('add-banner/{id?}', [AdminController::class, 'addBanner'])->name('add_banner');

        Route::get('orders', [AdminController::class, 'orders'])->name('orders');
        Route::get('order-details/{id}', [AdminController::class, 'orderDetails'])->name('order_details');
        Route::get('admins', [AdminController::class, 'admins'])->name('admins');
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

Route::get('/test', [AdminController::class, 'dashboard'])->name('test');
require __DIR__ . '/auth.php';
