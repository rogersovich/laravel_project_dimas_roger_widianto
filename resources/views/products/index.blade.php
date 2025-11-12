@extends('layouts.sneat')

@section('title', 'Daftar Produk')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Master Data /</span> Daftar Produk
</h4>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Produk</h5>
    <a href="{{ route('products.create') }}" class="btn btn-primary">
      <i class="bx bx-plus me-1"></i> Tambah Produk
    </a>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Foto</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Deskripsi</th>
          <th>Harga</th>
          <th>Stok</th>
          <th>Tanggal Dibuat</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($products as $product)
        <tr>
          <td><strong>#{{ $product->id }}</strong></td>
          <td>
            @if($product->foto)
              <img 
                src="{{ asset('assets/img/products/' . $product->foto) }}" 
                alt="{{ $product->nama }}"
                class="rounded"
                style="width: 50px; height: 50px; object-fit: cover;"
                onerror="this.src='{{ asset('assets/img/avatars/1.png') }}'"
              />
            @else
              <div class="avatar avatar-sm">
                <span class="avatar-initial rounded bg-label-secondary">
                  <i class="bx bx-package"></i>
                </span>
              </div>
            @endif
          </td>
          <td>
            <strong>{{ $product->nama }}</strong>
          </td>
          <td>
            <span class="badge bg-label-info">{{ $product->kategori_nama }}</span>
          </td>
          <td>
            <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $product->deskripsi }}">
              {{ Str::limit($product->deskripsi, 50) }}
            </span>
          </td>
          <td>
            <strong>Rp {{ number_format($product->harga, 0, ',', '.') }}</strong>
          </td>
          <td>
            @if($product->stok > 20)
              <span class="badge bg-label-success">{{ $product->stok }}</span>
            @elseif($product->stok > 10)
              <span class="badge bg-label-warning">{{ $product->stok }}</span>
            @else
              <span class="badge bg-label-danger">{{ $product->stok }}</span>
            @endif
          </td>
          <td>{{ $product->created_at->format('d/m/Y') }}</td>
          <td>
            <div class="dropdown">
              <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);">
                  <i class="bx bx-edit-alt me-1"></i> Edit
                </a>
                <a class="dropdown-item" href="javascript:void(0);">
                  <i class="bx bx-trash me-1"></i> Delete
                </a>
              </div>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="9" class="text-center py-4">
            <p class="text-muted mb-0">Tidak ada data produk</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

