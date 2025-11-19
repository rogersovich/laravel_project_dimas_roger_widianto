@extends('layouts.sneat')

@section('title', 'Edit Produk')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Master Data /</span> Edit Produk
</h4>

<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <h5 class="card-header">Form Edit Produk</h5>
      <div class="card-body">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
              <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('kategori_id', $product->kategori_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->nama }}
                  </option>
                @endforeach
              </select>
              @error('kategori_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label for="nama" class="form-label">Nama Produk <span class="text-danger">*</span></label>
              <input
                type="text"
                class="form-control @error('nama') is-invalid @enderror"
                id="nama"
                name="nama"
                placeholder="Masukkan nama produk"
                value="{{ old('nama', $product->nama) }}"
                required
              />
              @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea
              class="form-control @error('deskripsi') is-invalid @enderror"
              id="deskripsi"
              name="deskripsi"
              rows="4"
              placeholder="Masukkan deskripsi produk"
            >{{ old('deskripsi', $product->deskripsi) }}</textarea>
            @error('deskripsi')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input
                  type="number"
                  class="form-control @error('harga') is-invalid @enderror"
                  id="harga"
                  name="harga"
                  placeholder="0"
                  min="0"
                  step="0.01"
                  value="{{ old('harga', $product->harga) }}"
                  required
                />
                @error('harga')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
              <input
                type="number"
                class="form-control @error('stok') is-invalid @enderror"
                id="stok"
                name="stok"
                placeholder="0"
                min="0"
                value="{{ old('stok', $product->stok) }}"
                required
              />
              @error('stok')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="foto" class="form-label">Foto Produk</label>
            <input
              class="form-control @error('foto') is-invalid @enderror"
              type="file"
              id="foto"
              name="foto"
              accept="image/*"
            />
            <div class="form-text">Format: JPG, PNG, GIF, WEBP. Maksimal 2MB.</div>
            @error('foto')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          @if($product->foto)
          <div class="mb-4">
            <label class="form-label d-block">Preview Foto Saat Ini</label>
            <img
              src="{{ $product->foto_url }}"
              alt="{{ $product->nama }}"
              class="rounded border"
              style="max-width: 200px; height: auto;"
            />
          </div>
          @endif

          <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bx bx-save me-1"></i> Update
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
              <i class="bx bx-x me-1"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

