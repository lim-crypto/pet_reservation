<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Model\ShippingAddress;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{

    public function store(Request $request)
    {
        //
        $shippingAddress = new ShippingAddress();
        $shippingAddress->user_id = auth()->user()->id;
        $shippingAddress->houseNumber = $request->houseNumber;
        $shippingAddress->street = $request->street;
        $shippingAddress->brgy = $request->brgy;
        $shippingAddress->city = $request->city;
        $shippingAddress->province = $request->province;
        $shippingAddress->country = $request->country;
        $shippingAddress->save();
        return redirect()->back()->with('success', 'Shipping Address Added');
    }

    public function update(Request $request, ShippingAddress $shippingAddress)
    {
        $request->validate([
            'brgy' => 'required',
            'city' => 'required',
            'province' => 'required',
            'country' => 'required',
        ]);
        $shippingAddress->user_id = auth()->user()->id;
        $shippingAddress->houseNumber = $request->houseNumber;
        $shippingAddress->street = $request->street;
        $shippingAddress->brgy = $request->brgy;
        $shippingAddress->city = $request->city;
        $shippingAddress->province = $request->province;
        $shippingAddress->country = $request->country;
        $shippingAddress->save();
        return redirect()->back()->with('success', 'Shipping Address Updated');
    }
    public function destroy(ShippingAddress $shippingAddress)
    {
        $shippingAddress->delete();
        return redirect()->back()->with('success', 'Shipping Address Deleted');
    }
}
