<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $user = Auth::user();
        return view('user.checkout', compact('cart', 'user'));
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
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'metode' => 'required|string',
        ]);

        // Hitung grand total
        $total = collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity']);

        // Simpan order ke database
        $order = Order::create([
            'user_id' => Auth::id(),
            'tanggal' => now(),
            'total' => $total,
            'nama_penerima' => Auth::user()->name,
            'alamat_pengiriman' => $validated['alamat'],
            'telepon' => $validated['telepon'],
            'metode_pembayaran' => $validated['metode'],
            'status_pembayaran' => 'pending',
        ]);

        // Simpan order products dan kurangi stok
        foreach ($cart as $productId => $item) {
            $order->products()->attach($productId, [
                'jumlah' => $item['quantity'],
                'harga_satuan' => $item['harga'],
            ]);

            // Kurangi stok produk
            $product = Product::find($productId);
            if ($product) {
                if ($product->stok < $item['quantity']) {
                    return redirect()->back()->with('error', 
                        "Stok produk {$product->nama} tidak mencukupi."
                    );
                }
                $product->stok = $product->stok - $item['quantity'];
                $product->save();
            }
        }

        // Kosongkan keranjang setelah checkout
        Session::forget('cart');

        return redirect()->route('checkout.sukses')->with('success', 'Pesanan berhasil diproses!');
    }

    /**
     * Menampilkan halaman sukses setelah checkout
     */
    public function sukses()
    {
        $order = Order::where('user_id', Auth::id())->latest()->first();
        return view('user.sukses', compact('order'));
    }

    /**
     * Update bukti pembayaran
     */
    public function updatePaymentProof(Request $request, Order $order)
    {
        // Pastikan user hanya bisa update order miliknya
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus file lama jika ada
            if ($order->bukti_pembayaran && Storage::disk('public')->exists('payment/' . $order->bukti_pembayaran)) {
                Storage::disk('public')->delete('payment/' . $order->bukti_pembayaran);
            }

            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('payment', $filename, 'public');

            $order->bukti_pembayaran = $filename;
            $order->status_pembayaran = 'lunas';
            $order->save();
        }

        return redirect()->route('orders.history')->with('success', 'Bukti pembayaran berhasil diupload.');
    }
}

