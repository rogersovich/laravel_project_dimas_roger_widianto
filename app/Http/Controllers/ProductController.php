<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(): View
    {
        // Dummy data untuk list produk
        $products = [
            (object)[
                'id' => 1,
                'kategori_id' => 1,
                'kategori_nama' => 'Elektronik',
                'nama' => 'Laptop ASUS ROG',
                'deskripsi' => 'Laptop gaming dengan processor Intel i7 dan GPU RTX 3060',
                'harga' => 15000000,
                'stok' => 15,
                'foto' => 'laptop-asus.jpg',
                'created_at' => now()->subDays(5),
            ],
            (object)[
                'id' => 2,
                'kategori_id' => 2,
                'kategori_nama' => 'Fashion',
                'nama' => 'Kemeja Formal Pria',
                'deskripsi' => 'Kemeja formal dengan bahan katun premium, cocok untuk acara resmi',
                'harga' => 350000,
                'stok' => 50,
                'foto' => 'kemeja-formal.jpg',
                'created_at' => now()->subDays(3),
            ],
            (object)[
                'id' => 3,
                'kategori_id' => 3,
                'kategori_nama' => 'Makanan & Minuman',
                'nama' => 'Kopi Arabika Premium',
                'deskripsi' => 'Kopi arabika pilihan dengan rasa yang khas dan aroma yang harum',
                'harga' => 125000,
                'stok' => 100,
                'foto' => 'kopi-arabika.jpg',
                'created_at' => now()->subDays(7),
            ],
            (object)[
                'id' => 4,
                'kategori_id' => 4,
                'kategori_nama' => 'Kesehatan',
                'nama' => 'Vitamin C 1000mg',
                'deskripsi' => 'Suplemen vitamin C untuk meningkatkan daya tahan tubuh',
                'harga' => 75000,
                'stok' => 200,
                'foto' => 'vitamin-c.jpg',
                'created_at' => now()->subDays(2),
            ],
            (object)[
                'id' => 5,
                'kategori_id' => 5,
                'kategori_nama' => 'Olahraga',
                'nama' => 'Sepatu Running Nike',
                'deskripsi' => 'Sepatu running dengan teknologi Air Max untuk kenyamanan maksimal',
                'harga' => 1200000,
                'stok' => 25,
                'foto' => 'sepatu-nike.jpg',
                'created_at' => now()->subDays(1),
            ],
            (object)[
                'id' => 6,
                'kategori_id' => 1,
                'kategori_nama' => 'Elektronik',
                'nama' => 'Smartphone Samsung Galaxy',
                'deskripsi' => 'Smartphone dengan kamera 108MP dan layar AMOLED 120Hz',
                'harga' => 8000000,
                'stok' => 30,
                'foto' => 'samsung-galaxy.jpg',
                'created_at' => now()->subDays(4),
            ],
        ];

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        return view('products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '_' . $foto->getClientOriginalName();
            // TODO: Simpan file ke storage nanti
            // $foto->storeAs('public/products', $fotoName);
            $validated['foto'] = $fotoName;
        }

        // TODO: Simpan ke database nanti
        // Product::create($validated);

        return redirect()->route('products.create')
            ->with('success', 'Produk berhasil ditambahkan!');
    }
}

