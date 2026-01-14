@extends('layouts.user.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Detail Pesanan #{{ $order->id }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Info Pesanan -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>No. Order</strong></td>
                            <td>#{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tanggal</strong></td>
                            <td>{{ $order->tanggal->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status</strong></td>
                            <td>
                                @switch($order->status_pembayaran)
                                    @case('pending')
                                        <span class="badge bg-warning">Pending</span>
                                        @break
                                    @case('lunas')
                                        <span class="badge bg-success">Lunas</span>
                                        @break
                                    @case('diproses')
                                        <span class="badge bg-info">Diproses</span>
                                        @break
                                    @case('gagal')
                                        <span class="badge bg-danger">Gagal</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Metode Pembayaran</strong></td>
                            <td>{{ ucfirst($order->metode_pembayaran) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Info Pengiriman -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama Penerima</strong></td>
                            <td>{{ $order->nama_penerima }}</td>
                        </tr>
                        <tr>
                            <td><strong>Telepon</strong></td>
                            <td>{{ $order->telepon }}</td>
                        </tr>
                        <tr>
                            <td><strong>Alamat</strong></td>
                            <td>{{ $order->alamat_pengiriman }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Produk -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Produk yang Dipesan</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderProducts as $item)
                    <tr>
                        <td>
                            @if($item->product)
                                <img src="{{ asset('storage/' . $item->product->foto) }}" width="50" class="me-2">
                                {{ $item->product->nama }}
                            @else
                                <em>Produk tidak tersedia</em>
                            @endif
                        </td>
                        <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp {{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Grand Total:</td>
                        <td class="fw-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <a href="{{ route('orders.history') }}" class="btn btn-secondary mt-3">
        <i class="bx bx-arrow-back"></i> Kembali ke Riwayat Pesanan
    </a>
</div>
@endsection
