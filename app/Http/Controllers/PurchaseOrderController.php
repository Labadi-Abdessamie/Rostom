<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Product;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        // Resolve the vendor's magasin the same way create()/store() do (via the
        // ownership relationship), so orders created here are also listed here.
        $magasin = auth()->user()->magasin;

        if (!$magasin) {
            return redirect()->back()->with('error', 'You do not have a magasin assigned.');
        }

        // Pending orders still await confirmation; confirmed orders have already
        // had their quantities added to stock.
        $pendingOrders = PurchaseOrder::where('magasin_id', $magasin->id)
            ->where('type', 'quote')
            ->get();

        $confirmedOrders = PurchaseOrder::where('magasin_id', $magasin->id)
            ->where('type', '!=', 'quote')
            ->get();

        return view('vendor.pages.purchase_orders', compact('pendingOrders', 'confirmedOrders'));
    }

    public function create()
    {
        $vendor = auth()->user();


        $magasin = $vendor->magasin;

        if (!$magasin) {
            return redirect()->back()->with('error', 'You do not have a magasin assigned.');
        }


        $products = $magasin->products;

        return view('vendor.pages.create_purchaseOrder', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'products_data' => 'required|json',
            'supplierName' => 'required|string',
            'paymentStatus' => 'required|in:full,partial,debt',
        ]);

        $vendor = auth()->user();
        $magasin = $vendor->magasin;

        if (!$magasin) {
            return redirect()->back()->with('error', 'No magasin found.');
        }

        $productsData = json_decode($request->products_data, true);
        $totalAmount = 0;

        $purchaseOrder = PurchaseOrder::create([
            'supplierName' => $request->supplierName,
            'totalAmount' => 0,
            'doneDate' => now(),
            'type' => 'quote', // Quote is the first type normalment
            'paymentStatus' => $request->paymentStatus,
            'magasin_id' => $magasin->id,
        ]);

        foreach ($productsData as $item) {
            $product = Product::find($item['id']);
            $quantity = (int) $item['quantity'];
            $unitPrice = (float) $item['unit_price'];
            $totalAmount += $quantity * $unitPrice;

            PurchaseOrderItem::create([
                'purchaseOrder_id' => $purchaseOrder->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
            ]);
        }

        $purchaseOrder->update(['totalAmount' => $totalAmount]);

        return redirect()->route('vendor.purchase_orders')->with('success', 'Purchase order created successfully.');
    }
    public function show($id)
    {

        $order = PurchaseOrder::findOrFail($id);
        $magasin = $order->magasin;
        // Compare against the vendor's owned magasin (same source create()/store()
        // use) rather than the users.magasin_id column, which can drift out of sync.
        $vendorMagasin = auth()->user()->magasin;
        if (!$vendorMagasin || $magasin->id !== $vendorMagasin->id) {
            return redirect()->back()->with('error', 'Unauthorized access to this purchase order.');
        }


        $orderItems = PurchaseOrderItem::where('purchaseOrder_id', $id)->get();


        return view('vendor.pages.purchase_order_details', compact('order', 'orderItems', 'magasin'));
    }

    public function confirm($id)
    {
        $order = PurchaseOrder::findOrFail($id);

        // Only the owning vendor may confirm (and thereby add stock).
        $vendorMagasin = auth()->user()->magasin;
        if (!$vendorMagasin || $order->magasin_id !== $vendorMagasin->id) {
            return redirect()->route('vendor.purchase_orders')->with('error', 'Unauthorized action.');
        }

        // Confirming receives the goods: add each ordered quantity to stock.
        // Guarded by type === 'quote' so a re-submit can never double-count.
        if ($order->type === 'quote') {
            foreach ($order->purchaseOrderItems as $item) {
                $product = $item->product;
                if ($product) {
                    $product->actual_quantity += $item->quantity;
                    $product->save();
                }
            }

            $order->type = 'order';
            $order->save();
        }

        return redirect()->route('vendor.purchase_orders.show', $id)->with('success', 'Order confirmed and product quantities added to stock.');
    }
    public function pay($id)
    {
        $order = PurchaseOrder::findOrFail($id);

        foreach ($order->purchaseOrderItems as $item) {
            $product = $item->product;

            $product->actual_quantity += $item->quantity;
            $product->save();
        }

        $order->type = 'delivery';
        $order->save();

        return redirect()->route('vendor.purchase_orders.show', $id)->with('success', 'Order paid and product quantities updated.');
    }


    public function destroy($id)
    {

        $order = PurchaseOrder::findOrFail($id);
        $order->delete();
        return redirect()->route('vendor.purchase_orders')->with('success', 'Purchase order deleted successfully.');
    }
}
