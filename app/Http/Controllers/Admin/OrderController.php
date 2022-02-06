<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all()->sortByDesc('created_at');
        foreach ($orders as $order) {
            $order->products = json_decode($order->products);
        }
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->products = json_decode($order->products);
        return view('admin.orders.show', compact('order'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        $order->status = $request->status;
        if ($order->status == 'packed') {
            $order->packed_at = now();
        } elseif ($request->status == 'shipped') {
            $order->shipped_at = now();
        } elseif ($request->status == 'delivered') {
            $order->delivered_at = now();
        } elseif ($request->status == 'cancelled') {
            $order->cancelled_at = now();
        }
        $order->save();
        return  redirect()->back()->with('success', 'Order status updated successfully');
    }

}
