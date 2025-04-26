<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorInterfaceController;
use App\Http\Middleware\RoleMiddleware;
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
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('product-details/{id}', [ProductController::class, 'show'])->name('product_details');
    Route::get('vendors', [VendorController::class, 'index'])->name('vendor');
    Route::get('vendor-details/{id}', [VendorController::class, 'show'])->name('vendor_details');

    Route::get('cart', [MainController::class, 'cart'])->name('cart')->middleware(['auth', RoleMiddleware::class . ':client']);
    Route::get('wishlist', [MainController::class, 'wishlist'])->name('wishlist')->middleware(['auth', RoleMiddleware::class . ':client']);
    Route::get('compare', [MainController::class, 'compare'])->name('compare');

    Route::get('contact', [MainController::class, 'contact'])->name('contact');

    //Route::get('flash-Sale', [MainController::class, 'flashSale'])->name('flash_sale');
    //Route::get('daily-deals', [MainController::class, 'dailyDeals'])->name('daily_deals');
    //Route::get('track-order', [MainController::class, 'trackOrder'])->name('track_order');
    //Route::get('brands', [MainController::class, 'brands'])->name('brands');
    //Route::get('blog', [MainController::class, 'blog'])->name('blog');
    //Route::get('blog-details', [MainController::class, 'blogDetails'])->name('blog_details');


    //Route::get('user-login', [MainController::class, 'login'])->name('login');
    //Route::get('forget-password', [MainController::class, 'forgetPassword'])->name('forget_password');
});

route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

//Client route
route::middleware(['auth', RoleMiddleware::class . ':client'])->group(function () {
    Route::get('check-out', [MainController::class, 'checkOut'])->name('frontend.check_out');
    Route::post('create_order', [OrderController::class, 'store'])->name('create_order');

    Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
        Route::get('dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
        Route::get('orders', [ClientController::class, 'orders'])->name('orders');
        Route::get('orders/{id}', [ClientController::class, 'orderDetails'])->name('order_details');
        Route::get('wishlist', [ClientController::class, 'wishlist'])->name('wishlist');
        Route::get('reviews', [ClientController::class, 'reviews'])->name('reviews');
        Route::put('reviews/{id}', [ReviewController::class, 'update'])->name('review.update');
        Route::delete('reviews/{id}', [ReviewController::class, 'destroy'])->name('review.delete'); //! is gonna be available to admin
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
route::middleware(['auth',  RoleMiddleware::class . ':vendor'])->group(function () {
    Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function () {
        Route::get('dashboard', [VendorInterfaceController::class, 'dashboard'])->name('dashboard');
        Route::get('products', [VendorInterfaceController::class, 'products'])->name('products');
        Route::get('profile', [VendorInterfaceController::class, 'profile'])->name('profile');
        Route::get('orders', [VendorInterfaceController::class, 'orders'])->name('orders');
        Route::get('reviews', [VendorInterfaceController::class, 'reviews'])->name('reviews');
        Route::get('purchase-orders', [VendorInterfaceController::class, 'purchaseOrders'])->name('purchase_orders');


        Route::get('magasin', [VendorInterfaceController::class, 'magasin'])->name('magasin');
        Route::get('magasin/create', [MagasinController::class, 'create'])->name('magasin_create');
        Route::post('magasin/store', [MagasinController::class, 'store'])->name('magasin_store');

        Route::get('contact', [VendorInterfaceController::class, 'contact'])->name('contact');
        Route::get('profile', [VendorInterfaceController::class, 'profile'])->name('profile');
        Route::post('profile/update', [VendorInterfaceController::class, 'updateProfile'])->name('update_profile');
        Route::post('profile/update/password', [VendorInterfaceController::class, 'updatePassword'])->name('update_password');
    });
});

//Admin route

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');

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
        Route::post('store-banner', [AdminController::class, 'storeBanner'])->name('store_banner');
        Route::delete('delete-banner/{id}', [AdminController::class, 'deleteBanner'])->name('delete_banner');
        Route::get('banner/edit/{id}', [AdminController::class, 'showEditBanner'])->name('edit_banner');
        Route::put('banner/update/{id}', [AdminController::class, 'updateBanner'])->name('update_banner');

        Route::get('orders', [AdminController::class, 'orders'])->name('orders');
        Route::delete('delete-order/{id}', [AdminController::class, 'deleteOrder'])->name('delete_order');
        Route::get('order-details/{id}', [AdminController::class, 'orderDetails'])->name('order_details');
        Route::get('admins', [AdminController::class, 'admins'])->name('admins');
        Route::get('reviews', [AdminController::class, 'reviews'])->name('reviews');
        Route::delete('delete-review/{id}', [AdminController::class, 'deleteReview'])->name('delete_review');
    });
});


/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/
/*
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/


require __DIR__ . '/auth.php';
