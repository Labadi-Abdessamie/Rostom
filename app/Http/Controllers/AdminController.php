<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Magasin;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalClients        = User::where('role', 'client')->where('status', 'active')->count();
        $totalVendors        = User::where('role', 'vendor')->where('status', 'active')->count();
        $totalMagasins       = Magasin::count();
        $totalActiveMagasins = Magasin::where('status', 'active')->count();
        $totalAdmins         = User::where('role', 'admin')->count();
        $totalProducts       = Product::count();
        $avgRating           = Review::avg('rate') ?? 0;
        $totalReviews        = Review::count();
        $totalOrders         = Order::count();
        $pendingOrders       = Order::where('status', 'pending')->count();
        $newVendorRequests    = Magasin::where('status', 'firstOpening')->count();

        $latestOrders        = Order::with('user')->orderBy('created_at', 'desc')->take(8)->get();
        $topMagasinsRating   = Magasin::orderBy('rate', 'desc')->take(5)->get();
        $bestSellingProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        // --- Chart: last 6 months revenue ---
        $chartLabels   = [];
        $revenueByMonth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartLabels[] = $month->format('M Y');
            $revenueByMonth[] = (float) Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'delivered')
                ->sum('totalAmount');
        }

        // --- Chart: order status breakdown ---
        $orderStatusBreakdown = [
            'Pending'    => Order::where('status', 'pending')->count(),
            'Processing' => Order::where('status', 'processing')->count(),
            'Delivered'  => Order::where('status', 'delivered')->count(),
            'Cancelled'  => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.index', compact(
            'totalClients', 'totalVendors', 'totalProducts', 'latestOrders',
            'totalActiveMagasins', 'totalMagasins', 'totalAdmins',
            'avgRating', 'totalReviews', 'topMagasinsRating', 'bestSellingProducts',
            'totalOrders', 'pendingOrders', 'newVendorRequests',
            'chartLabels', 'revenueByMonth', 'orderStatusBreakdown'
        ));
    }

    public function reports()
    {
        $totalRevenue        = Order::where('status', 'delivered')->sum('totalAmount');
        $totalOrders         = Order::count();
        $deliveredOrders     = Order::where('status', 'delivered')->count();
        $cancelledOrders     = Order::where('status', 'cancelled')->count();
        $pendingOrders       = Order::where('status', 'pending')->count();
        $totalProducts       = Product::count();
        $totalClients        = User::where('role', 'client')->count();
        $totalVendors        = User::where('role', 'vendor')->count();
        $totalMagasins       = Magasin::count();
        $totalActiveMagasins = Magasin::where('status', 'active')->count();
        $avgRating           = Review::avg('rate') ?? 0;
        $totalReviews        = Review::count();

        // Monthly revenue - last 12 months
        $monthlyLabels  = [];
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyLabels[]  = $month->format('M Y');
            $monthlyRevenue[] = (float) Order::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->where('status', 'delivered')
                ->sum('totalAmount');
        }

        $topProducts = Product::withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(10)
            ->get();

        $topMagasins = Magasin::orderBy('rate', 'desc')->take(10)->get();

        $orderStatusBreakdown = [
            'Pending'    => $pendingOrders,
            'Processing' => Order::where('status', 'processing')->count(),
            'Delivered'  => $deliveredOrders,
            'Cancelled'  => $cancelledOrders,
        ];

        return view('admin.pages.reports', compact(
            'totalRevenue', 'totalOrders', 'deliveredOrders', 'cancelledOrders',
            'pendingOrders', 'totalProducts', 'totalClients', 'totalVendors',
            'totalMagasins', 'totalActiveMagasins', 'avgRating', 'totalReviews',
            'monthlyLabels', 'monthlyRevenue', 'topProducts', 'topMagasins',
            'orderStatusBreakdown'
        ));
    }

    public function exportCsv(string $type)
    {
        switch ($type) {
            case 'orders':
                $headers = ['ID', 'Customer', 'Total (DZD)', 'Status', 'Payment Method', 'Payment Status', 'Date'];
                $rows = Order::with('user')->get()->map(fn($o) => [
                    $o->id,
                    $o->user->name ?? 'N/A',
                    $o->totalAmount,
                    $o->status,
                    $o->paymentMethod ?? '-',
                    $o->paymentStatus ?? '-',
                    $o->created_at->format('Y-m-d H:i'),
                ]);
                $filename = 'orders_' . now()->format('Ymd') . '.csv';
                break;

            case 'products':
                $headers = ['ID', 'Name', 'Price (DZD)', 'Quantity', 'Times Ordered', 'Magasin', 'Category'];
                $rows = Product::with(['magasin', 'category'])->withCount('orderItems')->get()->map(fn($p) => [
                    $p->id,
                    $p->name,
                    $p->price,
                    $p->actual_quantity,
                    $p->order_items_count,
                    $p->magasin->name ?? 'N/A',
                    $p->category->name ?? 'N/A',
                ]);
                $filename = 'products_' . now()->format('Ymd') . '.csv';
                break;

            case 'customers':
                $headers = ['ID', 'Name', 'Email', 'Role', 'Status', 'Registered'];
                $rows = User::whereIn('role', ['client', 'vendor'])->get()->map(fn($u) => [
                    $u->id,
                    $u->name,
                    $u->email,
                    $u->role,
                    $u->status,
                    $u->created_at->format('Y-m-d'),
                ]);
                $filename = 'customers_' . now()->format('Ymd') . '.csv';
                break;

            case 'revenue':
                $headers = ['Month', 'Revenue (DZD)', 'Orders Delivered'];
                $rows = collect();
                for ($i = 11; $i >= 0; $i--) {
                    $month = Carbon::now()->subMonths($i);
                    $rows->push([
                        $month->format('F Y'),
                        Order::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->where('status','delivered')->sum('totalAmount'),
                        Order::whereYear('created_at', $month->year)->whereMonth('created_at', $month->month)->where('status','delivered')->count(),
                    ]);
                }
                $filename = 'revenue_' . now()->format('Ymd') . '.csv';
                break;

            default:
                abort(404);
        }

        $callback = function() use ($headers, $rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    public function customers($type = null)
    {
        $search = request('search');
        $perPage = request('per_page', 10);
        if ($perPage === 'all') $perPage = 9999;

        $query = User::where('role', 'client');
        if ($type === 'blocked') {
            $query->where('status', 'blocked');
            $title = "Blocked Clients";
        } elseif ($type === 'inactive') {
            $query->where('status', 'inactive');
            $title = "Inactive Clients";
        } else {
            $title = "Clients";
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phoneNumber', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate($perPage)->appends(request()->all());
        return view('admin.pages.customers', compact('users', 'title'));
    }

    public function vendors(Request $request, $type = null)
    {
        $search      = $request->input('search');
        $status      = $request->input('status');
        $magasinStatus = $request->input('magasin_status');
        $dateFrom    = $request->input('date_from');
        $dateTo      = $request->input('date_to');
        $sortBy      = $request->input('sort_by', 'created_at');
        $sortDir     = $request->input('sort_dir', 'desc');
        $perPage     = $request->input('per_page', 10);
        if ($perPage === 'all') $perPage = 9999;

        $query = User::with('magasin')->where('role', 'vendor');

        if ($type === 'blocked') {
            $query->where('status', 'blocked');
            $title = "Blocked Vendors";
        } elseif ($type === 'firstOpening') {
            $query->whereHas('magasin', fn($q) => $q->where('status', 'firstOpening'));
            $title = "Pending Approval";
        } else {
            $title = "Vendors";
        }

        // Text search: name, email, phone
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name',        'like', "%{$search}%")
                  ->orWhere('email',     'like', "%{$search}%")
                  ->orWhere('phoneNumber','like', "%{$search}%");
            });
        }

        // Vendor user-level status filter
        if ($status && in_array($status, ['active', 'inactive', 'blocked'])) {
            $query->where('status', $status);
        }

        // Magasin status filter
        if ($magasinStatus && in_array($magasinStatus, ['active', 'inactive', 'blocked', 'firstOpening'])) {
            $query->whereHas('magasin', fn($q) => $q->where('status', $magasinStatus));
        }

        // Date range filter
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Sorting
        $allowedSorts = ['created_at', 'name', 'email', 'phoneNumber'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $vendors = $query->paginate($perPage)->appends($request->query());
        return view('admin.pages.vendors', compact(
            'vendors', 'title', 'search', 'status', 'magasinStatus',
            'dateFrom', 'dateTo', 'sortBy', 'sortDir', 'perPage', 'type'
        ));
    }

    public function admins()
    {
        $admins = User::where('role', 'admin')->paginate(10);

        $totalAdmins = User::where('role', 'admin')->count();
        return view('admin.pages.admins', compact('admins', 'totalAdmins'));
    }

    //! PROFILE
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.pages.profile', compact('admin'));
    }

    //! Products
    public function products()
    {
        $search = request('search');
        $perPage = request('per_page', 10);
        if ($perPage === 'all') $perPage = 9999;

        $query = Product::with('magasin')->withCount('orderItems');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('price', 'like', '%' . $search . '%')
                  ->orWhereHas('magasin', fn($mq) => $mq->where('name', 'like', '%' . $search . '%'));
            });
        }

        $products = $query->paginate($perPage)->appends(request()->all());
        $totalProducts = Product::count();
        return view('admin.pages.products', compact('products', 'totalProducts'));
    }

    //! REVIEWS
    public function reviews()
    {
        $reviews = Review::with('user', 'product')->paginate(10);
        return view('admin.pages.reviews', compact('reviews'));
    }

    //! ORDERS
    public function orders()
    {
        $orders = Order::with(['user', 'shippingAddress', 'billingAddress'])->get();

        return view('admin.pages.orders', compact('orders'));
    }

    public function orderDetails($id)
    {
        $order = Order::with(['user', 'shippingAddress', 'billingAddress', 'orderItems.product'])->findOrFail($id);
        return view('admin.pages.orderDetails', compact('order'));
    }
}
