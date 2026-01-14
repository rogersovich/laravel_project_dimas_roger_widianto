<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('user.checkout', compact('cart'));
    }

    /**
     * Proses checkout - simpan ke database
     */
    public function process(Request $request)
    {
        $cart = Session::get('cart', []);

        if (!$cart || count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'metode' => 'required|string',
        ]);

        // Hitung grand total
        $grandTotal = 0;
        foreach ($cart as $item) {
            $grandTotal += $item['harga'] * $item['quantity'];
        }

        // Simpan order ke database
        $order = Order::create([
            'user_id' => Auth::id(),
            'tanggal' => now(),
            'total' => $grandTotal,
            'nama_penerima' => $validated['nama'],
            'alamat_pengiriman' => $validated['alamat'],
            'telepon' => $validated['telepon'],
            'metode_pembayaran' => $validated['metode'],
            'status_pembayaran' => 'pending',
        ]);

        // Simpan order products
        foreach ($cart as $productId => $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'jumlah' => $item['quantity'],
                'harga_satuan' => $item['harga'],
            ]);
        }

        // Kosongkan keranjang setelah checkout
        Session::forget('cart');

        return redirect()->route('orders.history')->with('success', 'Pesanan berhasil diproses! Terima kasih sudah berbelanja.');
    }
}

