<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\MagasinController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorInterfaceController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\StatusMiddleware;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
/*
Route::get('/cleareverything', function () {
    $clearcache = Artisan::call('cache:clear');
    echo 'Cache cleared<br>';
    $clearview = Artisan::call('view:clear');
    echo 'View cleared<br>';
    $clearconfig = Artisan::call('config:clear');
    echo 'Config cleared<br>';
    return redirect()->back();
});*/

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
    Route::post('send-mail', [MainController::class, 'sendMail'])->name('send_mail');

    Route::get('search', [MainController::class, 'search'])->name('search');
    Route::get('search-vendor', [MainController::class, 'searchVendor'])->name('search_vendor');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    Route::patch('/profile-update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile-update/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
});

//Client route
Route::middleware(['auth', RoleMiddleware::class . ':client'])->group(function () {
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
        Route::get('address', [AddressController::class, 'index'])->name('address');
        Route::get('address/add', [AddressController::class, 'create'])->name('address.add');
        Route::post('address/store', [AddressController::class, 'store'])->name('address.store');
        Route::get('address/{id}/edit', [AddressController::class, 'edit'])->name('address.edit');
        Route::put('address/{id}', [AddressController::class, 'update'])->name('address.update');
        Route::delete('address/{id}', [AddressController::class, 'destroy'])->name('address.delete');
        //-----------------------------------------//

        Route::post('order/{id}/confirm', [OrderController::class, 'confirmOrder'])->name('confirm_order');
        Route::post('order/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('cancel_order');

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

Route::middleware(['auth',  RoleMiddleware::class . ':vendor'])->group(function () {

    Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function () {
        Route::get('magasin/create', [MagasinController::class, 'create'])->name('magasin_create');
        Route::post('magasin/store', [MagasinController::class, 'store'])->name('magasin_store');
    });


    Route::middleware([StatusMiddleware::class])->group(function () {
        Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function () {
            Route::get('profile', [VendorInterfaceController::class, 'profile'])->name('profile');

            Route::get('dashboard', [VendorInterfaceController::class, 'dashboard'])->name('dashboard');

            Route::get('products', [VendorInterfaceController::class, 'products'])->name('products');
            Route::post('product/{id}/toggle-listing', [VendorInterfaceController::class, 'toggleProductListing'])->name('toggle_product_listing');
            Route::get('add-product', [ProductController::class, 'create'])->name('add_product');
            Route::post('store-product', [ProductController::class, 'store'])->name('store_product');
            Route::get('edit-product/{id}', [ProductController::class, 'edit'])->name('edit_product');
            Route::put('update-product/{id}', [ProductController::class, 'update'])->name('update_product');
            Route::delete('delete-product/{id}', [ProductController::class, 'destroy'])->name('delete_product');

            Route::get('orders', [VendorInterfaceController::class, 'orders'])->name('orders');
            Route::get('orders/export', [VendorInterfaceController::class, 'exportOrders'])->name('orders.export');
            Route::get('order-details/{id}', [VendorInterfaceController::class, 'orderDetails'])->name('order_details');
            Route::post('order/{id}/update', [OrderController::class, 'update'])->name('order.update');
            Route::post('order/{id}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('order.confirm_payment');


            Route::get('reviews', [VendorInterfaceController::class, 'reviews'])->name('reviews');

            Route::get('purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase_orders');
            Route::get('purchase-orders/create', [PurchaseOrderController::class, 'create'])->name('purchase_order_add');
            Route::post('purchase-orders', [PurchaseOrderController::class, 'store'])->name('purchase_orders.store');
            Route::delete('purchase-orders/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchase_orders.delete');
            Route::get('purchase-orders/{id}', [PurchaseOrderController::class, 'show'])->name('purchase_orders.show');
            Route::post('purchase-orders/{id}/confirm', [PurchaseOrderController::class, 'confirm'])->name('purchase_orders.confirm');
            Route::post('purchase-orders/{id}/pay', [PurchaseOrderController::class, 'pay'])->name('purchase_orders.pay');
            //Route::get('purchase-orders/{id}', [PurchaseOrderController::class, 'show'])->name('purchase_order_details');

            Route::get('pending-payments', [VendorInterfaceController::class, 'pendingPayments'])->name('pending_payments');

            Route::get('magasin', [VendorInterfaceController::class, 'magasin'])->name('magasin');
            Route::get('magasin/edit/{id}', [MagasinController::class, 'edit'])->name('edit_magasin');


            Route::post('magasin/update/{id}', [MagasinController::class, 'update'])->name('update_magasin');


            Route::get('contact', [VendorInterfaceController::class, 'contact'])->name('contact');
        });
    });
});

//Admin route

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');

        Route::get('customers/{type?}', [AdminController::class, 'customers'])->name('customers');
        Route::get('vendors/{type?}', [AdminController::class, 'vendors'])->name('vendors');
        Route::get('admins', [AdminController::class, 'admins'])->name('admins');


        Route::get('user/{id}/edit', [ProfileController::class, 'editUser'])->name('edit_user');
        Route::put('user/{id}/update', [ProfileController::class, 'updateUser'])->name('update_user');
        Route::delete('user/{id}/delete', [ProfileController::class, 'deleteUser'])->name('delete_user');
        Route::post('admin/store', [ProfileController::class, 'store'])->name('store_admin');


        Route::get('magasin/{filtre?}', [MagasinController::class, 'magasins'])->name('magasins');

        Route::get('register/{id}', [MagasinController::class, 'showRegister'])->name('show.register');
        Route::post('magasin/{id}/approve', [MagasinController::class, 'approveMagasin'])->name('approve.magasin');
        Route::delete('magasin/{id}/reject', [MagasinController::class, 'rejectMagasin'])->name('reject.magasin');

        Route::get('magasin/{id}/edit', [MagasinController::class, 'edit'])->name('edit.magasin');
        Route::put('magasin/{id}/update', [MagasinController::class, 'update'])->name('update.magasin');
        Route::delete('magasin/{id}/delete', [MagasinController::class, 'destroy'])->name('delete.magasin');


        Route::get('categories', [CategoryController::class, 'index'])->name('categories');
        Route::get('category/create', [CategoryController::class, 'create'])->name('add_category');
        Route::post('category/store', [CategoryController::class, 'store'])->name('store_category');
        Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('edit_category');
        Route::put('category/{id}/update', [CategoryController::class, 'update'])->name('update_category');
        Route::delete('category/{id}/delete', [CategoryController::class, 'destroy'])->name('delete_category');


        Route::get('products', [AdminController::class, 'products'])->name('products');
        Route::delete('delete-product/{id}', [ProductController::class, 'destroy'])->name('delete_product');


        Route::get('banners', [BannerController::class, 'index'])->name('banners');
        Route::get('banner/create', [BannerController::class, 'create'])->name('add_banner');
        Route::post('banner/store', [BannerController::class, 'store'])->name('store_banner');
        Route::delete('banner/{id}/delete', [BannerController::class, 'destroy'])->name('delete_banner');
        Route::get('banner/{id}/edit', [BannerController::class, 'edit'])->name('edit_banner');
        Route::put('banner/{id}/update', [BannerController::class, 'update'])->name('update_banner');

        Route::get('orders', [AdminController::class, 'orders'])->name('orders');
        Route::get('order-details/{id}', [AdminController::class, 'orderDetails'])->name('order_details');
        Route::delete('delete-order/{id}', [OrderController::class, 'destroy'])->name('delete_order');


        Route::get('reviews', [AdminController::class, 'reviews'])->name('reviews');
        Route::delete('review/{id}/delete', [ReviewController::class, 'destroy'])->name('delete_review');

        Route::get('reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('reports/export/{type}', [AdminController::class, 'exportCsv'])->name('export_csv');
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




//! fronted route
    //Route::get('flash-Sale', [MainController::class, 'flashSale'])->name('flash_sale');
    //Route::get('daily-deals', [MainController::class, 'dailyDeals'])->name('daily_deals');
    //Route::get('track-order', [MainController::class, 'trackOrder'])->name('track_order');
    //Route::get('brands', [MainController::class, 'brands'])->name('brands');
    //Route::get('blog', [MainController::class, 'blog'])->name('blog');
    //Route::get('blog-details', [MainController::class, 'blogDetails'])->name('blog_details');
