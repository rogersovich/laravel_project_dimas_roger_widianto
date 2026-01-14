@extends('layouts.user.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4">Riwayat Pesanan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No. Order</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->tanggal->format('d M Y') }}</td>
                        <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
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
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">
                                <i class="bx bx-show"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Anda belum memiliki pesanan. <a href="{{ route('home') }}">Mulai belanja sekarang!</a>
        </div>
    @endif

    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">
        <i class="bx bx-arrow-back"></i> Kembali ke Beranda
    </a>
</div>
@endsection
