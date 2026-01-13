@extends('layouts.user.app')

@section('title', $product->nama)

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Gambar Produk -->
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <img src="{{ asset('storage/' . $product->foto) }}"
                        class="card-img-top rounded"
                        alt="{{ $product->nama }}"
                        style="max-height: 400px; object-fit: cover;">
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="col-md-7">
                <h2 class="fw-bold">{{ $product->nama }}</h2>
                <h4 class="text-primary fw-bold mb-3">
                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                </h4>
                <p>{{ $product->deskripsi }}</p>

                <p class="mt-3">
                    <span class="fw-bold">Stok:</span>
                    {{ $product->stok > 0 ? $product->stok . ' tersedia' : 'Habis' }}
                </p>

                <p class="mt-2">
                    <span class="fw-bold">Kategori:</span>
                    <span class="badge bg-info">{{ $product->category->nama ?? '-' }}</span>
                </p>

                @if($product->stok > 0)
                <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bx bx-cart-add me-2"></i>Tambah ke Keranjang
                    </button>
                </form>
                @else
                <button class="btn btn-secondary btn-lg mt-4" disabled>Stok Habis</button>
                @endif

                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg mt-2">
                    <i class="bx bx-arrow-back me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
