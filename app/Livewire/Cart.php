<?php

namespace App\Livewire;

use App\Models\BagItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $message;
    public $actionType;
    public $item_Id;

    public function mount($item_Id, $actionType)
    {
        $this->actionType = $actionType;
        $this->item_Id = $item_Id;
    }
    public function render()
    {
        return view('livewire.cart');
    }
    public function addItem($item_Id)
    {

        return view('frontend.pages.cart_view');

        $user = Auth::user();
        if ($user) {
            $product = Product::findOrFail($item_Id);
            if ($product->magasin->status == 'active') {
                $cart = session()->get('cart', []);
                if (isset($cart[$item_Id])) {
                    $cart[$item_Id]['quantity']++;
                } else {
                    $cart[$item_Id] = [
                        'id' => null,
                        'quantity' => 1,
                        'product' => [
                            'image' => $product->principalImage,
                            'name' => $product->name,
                            'actual_quantity' => $product->actual_quantity,
                            'price' => $product->price,
                        ]
                    ];
                }
                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Added');
            } else {
                return redirect()->back()->with('error', 'This product is unavailable.');
            }
            /*
                $user = Auth::user();
                if ($user) {
                    $cart = $user->bags->where('type', 'cart')->first();
                    if ($cart) {
                        if ($cart->bagItems->contains('Item_Id', $product_id)) {
                            $existItem = $cart->bagItems->where('product_id', $product_id)->first();
                            $existItem->quantity += 1;
                            $existItem->save();
                        } else {
                            BagItem::create([
                                'bag_id' => $cart->id,
                                'product_id' => $product_id,
                            ]);
                        }
                        return redirect()->back()->with('alert', 'Product Added to Your Cart');
                    } else {
                        return "ERROR : 500";
                    }
                } else {
                    return redirect()->route('login');
                }
                    */
            /*
        }
*/
        } else {
            return redirect()->route('login');
        }
    }


    public function removeItem($item_id)
    {
        $cart = session()->get('cart', []);
        if ($cart != []) {
            unset($cart[$item_id]);
            session()->put('cart', $cart);
        }
    }
}
