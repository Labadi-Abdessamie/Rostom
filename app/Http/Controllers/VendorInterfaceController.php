<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Magasin;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;

class VendorInterfaceController extends Controller
{
    public function dashboard()
    {
        $vendor = Auth::user();
        //! 1
        $totalProducts = Product::where('magasin_id', $vendor->magasin->id)->count();
        //! 2
        $totalOrderItems = $vendor->magasin->orderItems()->with('order')->get()
            ->filter(function ($item) { return $item->order !== null; });
        $totalOrders = $totalOrderItems->groupBy('order_id')->map(function ($items, $orderId) {
            return [
                'id' => $orderId,
                'status' => $items[0]->order->status,
                'items' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                    ];
                })->values(),
            ];
        })->values();
        //! 3
        $completedOrders = $totalOrders->where('status', 'delivered');
        $totalCompletedOrders = $completedOrders->count();

        //! 4
        $orderItemIds = collect($completedOrders)
            ->pluck('items')
            ->flatten(1)
            ->pluck('id');
        $orderItems = OrderItem::whereIn('id', $orderItemIds)->where('status', 'available')->get();

        $topProductData = $orderItems
            ->groupBy('product_id')
            ->map(function ($items) {
                return $items->sum('quantity');
            })
            ->sortDesc()
            ->take(5);

        $topProducts = Product::whereIn('id', $topProductData->keys())->get()
            ->sortByDesc(function ($product) use ($topProductData) {
                return $topProductData[$product->id];
            });



        //$totalOrders = $vendor->orders()->count();
        //$topProducts = Product::where('magasin_id', $vendor->magasin->id)->withCount('orderItems')->orderBy('order_items_count', 'desc')->take(5)->get();
        //$totalEarnings = $vendor->magasin->orderItems()->where('status', 'available')->get();

        //! 5 — Confirmed Balance (stored in magasin)
        $totalEarnings = $vendor->magasin->balance;

        //! 6
        $pendingOrders = $totalOrders->where('status', 'pending')->count();
        $newOrderCount = $totalOrders->where('status', 'pending')->count();

        //! 7 — Pending Balance: delivered orders with unconfirmed payment
        $pendingBalance = 0;
        $pendingPaymentOrders = collect();
        if ($vendor->magasin) {
            $deliveredOrderIds = $totalOrders->where('status', 'delivered')->pluck('id');
            $pendingPaymentOrderItems = OrderItem::with(['product', 'order'])
                ->whereIn('order_id', $deliveredOrderIds)
                ->where('status', 'available')
                ->whereHas('order', function ($q) { return $q->where('paymentStatus', 'pending'); })
                ->whereHas('product', function ($q) use ($vendor) { return $q->where('magasin_id', $vendor->magasin->id); })
                ->get();

            $pendingBalance = $pendingPaymentOrderItems->sum(function ($item) { return $item->product->price * $item->quantity; });

            $pendingPaymentOrders = Order::with(['user', 'orderItems.product'])
                ->whereIn('id', $deliveredOrderIds)
                ->where('paymentStatus', 'pending')
                ->whereHas('orderItems.product', function ($q) use ($vendor) { return $q->where('magasin_id', $vendor->magasin->id); })
                ->get()
                ->filter(function ($order) use ($vendor) { return $order->orderItems
                    ->where('product.magasin_id', $vendor->magasin->id)
                    ->where('status', 'available')
                    ->count() > 0;
                })
                ->values()
                ->sortByDesc('id')
                ->values();
        }

        // ===== Monthly Revenue (last 6 months) =====
        $chartLabels    = [];
        $revenueByMonth = [];

        $completedItemIds = collect($completedOrders)
            ->pluck('items')->flatten(1)->pluck('id');

        $completedItemsFlat = OrderItem::with('product:id,price')
            ->whereIn('id', $completedItemIds)
            ->where('status', 'available')
            ->get();

        for ($m = 5; $m >= 0; $m--) {
            $date           = Carbon::now()->subMonths($m);
            $chartLabels[]  = $date->format('M Y');

            $revenueByMonth[] = (float) $completedItemsFlat
                ->filter(function ($item) use ($date) {
                    return Carbon::parse($item->created_at)->year  === $date->year &&
                    Carbon::parse($item->created_at)->month === $date->month;
                })
                ->sum(function ($item) { return $item->product->price * $item->quantity; });
        }

        // ===== Order Status Breakdown =====
        $statusBreakdown = [
            'pending'    => $totalOrders->where('status', 'pending')->count(),
            'delivered'  => $totalOrders->where('status', 'delivered')->count(),
            'processing' => $totalOrders->where('status', 'processing')->count(),
            'cancelled'  => $totalOrders->where('status', 'cancelled')->count(),
        ];

        return view('vendor.index', compact(
            'totalProducts', 'totalCompletedOrders', 'totalEarnings',
            'pendingOrders', 'topProducts',
            'chartLabels', 'revenueByMonth', 'statusBreakdown',
            'pendingBalance', 'pendingPaymentOrders', 'newOrderCount'
        ));
    }
    public function profile()
    {
        $vendor = Auth::user();
        return view('vendor.pages.profile', compact('vendor'));
    }
    public function products()
    {
        $user = Auth::user();
        $magasin = Magasin::where('user_id', $user->id)->first();

        if (!$magasin) {
            $products = collect();
        } else {
            $products = Product::where('magasin_id', $magasin->id)->withSum('orderItems', 'quantity')->get();
        }
        return view('vendor.pages.products', compact('products'));
    }

    public function orders()
    {
        $vendor = Auth::user();
        //$magasinId = $vendor->magasin->id;
        $orderItems = $vendor->magasin->orderItems()->with(['product', 'order'])->get()
            ->filter(function ($item) { return $item->order !== null; });

        $orders = $orderItems->groupBy('order_id')->map(function ($items, $orderId) {
            return [
                'id' => $orderId,
                'status' => $items[0]->order->status,
                'totalAmount' => $items->sum(function ($item) {
                    return $item->quantity * $item->product->price;
                }),
                'items' => $items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'quantity' => $item->quantity,
                        'status' => $item->status,
                        'description' => $item->description ?? '',
                        'product' => [
                            'id' => $item->product->id ?? null,
                            'name' => $item->product->name ?? null,
                            'price' => $item->product->price ?? null,
                        ],
                    ];
                })->values(),
            ];
        })->values();

        $totalOrders = $orders->count();

        return view('vendor.pages.orders', [
            'orders' => $orders,
            'totalOrders' => $totalOrders
        ]);

        /*
        $magasinId = $vendor->magasin->id;

        $orders = Order::whereHas('orderItems.product', function ($query) use ($magasinId) {
            $query->where('magasin_id', $magasinId);
        })->with(['orderItems.product' => function ($query) use ($magasinId) {
            $query->where('magasin_id', $magasinId);
        }])->get();

        $totalOrders = $orders->count();

        return view('vendor.pages.orders', compact('orders', 'totalOrders'));*/
    }

    public function orderDetails($id)
    {
        $order = Order::with('shippingAddress')->with('billingAddress')->findOrFail($id);
        $vendor = Auth::user();

        $orderItems = $order->orderItems()->where('order_id', $id)->whereHas('product', function ($query) use ($vendor) {
            $query->where('magasin_id', $vendor->magasin->id);
        })->with('product')->get();

        if ($orderItems->count() == 0) {
            return redirect()->back();
        }
        return view('vendor.pages.order_details', compact('order', 'orderItems'));
    }

    public function pendingPayments()
    {
        $vendor = Auth::user();
        $magasin = $vendor->magasin;

        if (!$magasin) {
            $orders = collect();
            $totalPending = 0;
        } else {
            $orders = Order::with(['user', 'orderItems.product'])
                ->where('status', 'delivered')
                ->whereIn('paymentStatus', ['pending'])
                ->whereHas('orderItems.product', function ($q) use ($magasin) {
                    return $q->where('magasin_id', $magasin->id);
                })
                ->get()
                ->filter(function ($order) use ($magasin) {
                    // Hide orders that this vendor has already confirmed (no remaining available items for this vendor)
                    $vendorAvailableCount = $order->orderItems
                        ->where('product.magasin_id', $magasin->id)
                        ->where('status', 'available')
                        ->count();
                    return $vendorAvailableCount > 0;
                })
                ->values();

            $totalPending = $orders->sum(function ($order) use ($magasin) {
                return $order->orderItems
                    ->where('product.magasin_id', $magasin->id)
                    ->where('status', 'available')
                    ->sum(function ($item) {
                        return $item->product->price * $item->quantity;
                    });
            });
        }

        return view('vendor.pages.pending_payments', [
            'orders' => $orders,
            'totalPending' => $totalPending,
        ]);
    }

    public function purchaseOrders()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.purchase_orders');
    }
    public function reviews()
    {
        $vendor = Auth::user();
        $magasin = Magasin::where('user_id', $vendor->id)->first();

        $reviews = $magasin->reviews()->with(['user', 'product'])->get();
        $totalReviews = $reviews->count();
        $averageRating = $reviews->avg('rate');

        return view('vendor.pages.reviews', compact('reviews', 'totalReviews', 'averageRating'));
    }
    public function contact()
    {
        //$vendor = Auth::user();
        return view('vendor.pages.contact');
    }
    public function magasin()
    {
        $magasin = Auth::user()->magasin;
        $vendorName = Auth::user()->name;
        return view('vendor.pages.magasin_info', compact('vendorName', 'magasin'));
    }
}


















/*
    public function addProduct()
    {
        return view('vendor.pages.add_product');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:2048'
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            'vendor_id' => Auth::id(),
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $imagePath
        ]);

        return redirect()->route('vendor.dashboard')->with('success', 'Product added successfully!');
    }

    public function editProduct($id)
    {
        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);
        return view('vendor.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('vendor.dashboard')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::where('vendor_id', Auth::id())->findOrFail($id);
        $product->delete();

        return redirect()->route('vendor.dashboard')->with('success', 'Product deleted successfully!');
    }
    */
