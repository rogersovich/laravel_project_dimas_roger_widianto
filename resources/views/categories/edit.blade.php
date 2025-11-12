@extends('layouts.sneat')

@section('title', 'Edit Kategori')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Master Data /</span> Edit Kategori
</h4>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
  <div class="col-md-12">
    <div class="card mb-4">
      <h5 class="card-header">Form Edit Kategori</h5>
      <div class="card-body">
        <form action="{{ route('categories.update', $category) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('nama') is-invalid @enderror"
              id="nama"
              name="nama"
              placeholder="Masukkan nama kategori"
              value="{{ old('nama', $category->nama) }}"
              required
            />
            @error('nama')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">
              Masukkan nama kategori produk yang akan digunakan.
            </div>
          </div>

          <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2">
              <i class="bx bx-save me-1"></i> Update
            </button>
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
              <i class="bx bx-x me-1"></i> Batal
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  // Alert success dengan auto dismiss
  @if(session('success'))
    setTimeout(function() {
      const alert = document.querySelector('.alert-success');
      if (alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
      }
    }, 3000);
  @endif
</script>
@endpush

