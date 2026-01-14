<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Menampilkan riwayat pesanan user
     */
    public function history()
    {
        $orders = Order::with('orderProducts.product')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('user.orders', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan
     */
    public function show(Order $order)
    {
        // Pastikan user hanya bisa melihat pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $order->load('orderProducts.product');

        return view('user.order-detail', compact('order'));
    }
}
