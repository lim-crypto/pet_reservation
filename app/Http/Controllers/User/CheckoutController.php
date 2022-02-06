<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\ShippingAddress;
use Illuminate\Http\Request;


class CheckoutController extends Controller
{
    public function checkout()
    {
        $products = \Cart::session(auth()->id())->getContent()->sortBy('id');
        $cartSubTotal = \Cart::session(auth()->id())->getSubtotal();
        $shippingFee = 50;
        $cartFinalTotal = $cartSubTotal + $shippingFee;
        $shippingAddress = auth()->user()->shipping_addresses->last();
        return view('user.orders.checkout', compact('products', 'cartSubTotal', 'cartFinalTotal', 'shippingFee', 'shippingAddress'));
    }

    public function store(Request $request)
    {
        $products = \Cart::session(auth()->id())->getContent()->sortBy('id');
        $cartSubTotal = \Cart::session(auth()->id())->getSubtotal();
        $shippingFee = 50;
        $cartFinalTotal = $cartSubTotal + $shippingFee;

        $this->validate($request, [
            'brgy' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
        ]);
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->products = $products;
        $order->products = json_encode($order->products);
        $order->subTotal = $cartSubTotal;
        $order->shippingFee = $shippingFee;
        $order->total = $cartFinalTotal;
        $order->shipping_address =  $request->houseNumber . ' ' . $request->street . ' ' .$request->brgy . ' ' . $request->city . ' ' . $request->province  . ' ' . $request->country;


        $order->save();
        \Cart::session(auth()->id())->clear();

        if ($request->saveInfo) {
            $shippingAddress = new ShippingAddress();
            $shippingAddress->user_id = auth()->id();
            $shippingAddress->houseNumber = $request->houseNumber;
            $shippingAddress->street = $request->street;
            $shippingAddress->brgy = $request->brgy;
            $shippingAddress->city = $request->city;
            $shippingAddress->province = $request->province;
            $shippingAddress->country = $request->country;
            $shippingAddress->save();
        }
        return redirect()->route('orders.index')->with('success', 'Order has been placed successfully!');
    }
}
