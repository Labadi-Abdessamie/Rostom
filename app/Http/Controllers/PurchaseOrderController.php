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
        
        $purchaseOrders = PurchaseOrder::where('magasin_id', auth()->user()->magasin_id)->get();

        
        $payedOrders = PurchaseOrder::where('magasin_id', auth()->user()->magasin_id)
                                    ->where('paymentStatus', 'full')
                                    ->get();

        
        $notFullyPayedOrders = PurchaseOrder::where('magasin_id', auth()->user()->magasin_id)
                                            ->where('paymentStatus', 'partial')
                                            ->get();

        
        $debtOrders = PurchaseOrder::where('magasin_id', auth()->user()->magasin_id)
                                   ->where('paymentStatus', 'debt')
                                   ->get();

        
        return view('vendor.pages.purchase_orders', compact('purchaseOrders', 'payedOrders', 'notFullyPayedOrders', 'debtOrders'));
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
    
        // Updating automatically the total amount of the purchase order
        $purchaseOrder->update(['totalAmount' => $totalAmount]);
    
        return redirect()->route('vendor.purchase_orders')->with('success', 'Purchase order created successfully.');
    }
    public function show($id)
{
    
    $order = PurchaseOrder::findOrFail($id);
    $magasin = $order->magasin;
    if ($magasin->id !== auth()->user()->magasin_id) {
        return redirect()->back()->with('error', 'Unauthorized access to this purchase order.');
    }

    
    $orderItems = PurchaseOrderItem::where('purchaseOrder_id', $id)->get();

    
    return view('vendor.pages.purchase_order_details', compact('order', 'orderItems','magasin'));
}

public function confirm($id)
{
    
    $order = PurchaseOrder::findOrFail($id);

    
    $order->type = 'order'; 
    $order->save();

    
    return redirect()->route('vendor.purchase_orders.show', $id)->with('success', 'Order has been confirmed.');
}
public function pay($id)
{
    $order = PurchaseOrder::findOrFail($id);

    
    foreach ($order->purchaseOrderItems as $item) {
        $product = $item->product;

        
        $product->actual_quantity += $item->quantity;
        $product->save();
    }


    return redirect()->route('vendor.purchase_orders.show', $id)->with('success', 'Order paid and product quantities updated.');
}


    public function destroy($id)
    {
        
        $order = PurchaseOrder::findOrFail($id);

        
        $order->delete();

        
        return redirect()->route('vendor.purchase_orders')->with('success', 'Purchase order deleted successfully.');
    }

}
