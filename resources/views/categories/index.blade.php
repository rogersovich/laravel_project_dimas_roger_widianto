@extends('layouts.sneat')

@section('title', 'Daftar Kategori Produk')

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Master Data /</span> Daftar Kategori Produk
</h4>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
  <div class="card-header">
    <div class="d-flex flex-column flex-lg-row gap-3 align-items-lg-center mb-3">
      <h5 class="mb-0 flex-grow-1">Daftar Kategori Produk</h5>
      <a href="{{ route('categories.create') }}" class="btn btn-primary align-self-start align-self-lg-center">
        <i class="bx bx-plus me-1"></i> Tambah Kategori
      </a>
    </div>

    <div class="d-flex flex-column flex-lg-row gap-2">
      <form method="GET" action="{{ route('categories.index') }}" class="row g-2 flex-grow-1">
        <div class="col-sm-8 col-md-6 col-lg-10">
          <div class="input-group">
            <span class="input-group-text"><i class="bx bx-search"></i></span>
            <input
              type="text"
              name="search"
              class="form-control"
              placeholder="Cari nama kategori..."
              value="{{ request('search') }}"
            />
          </div>
        </div>
        <div class="col-sm-4 col-md-3 col-lg-2 d-flex gap-2">
          <button class="btn btn-primary flex-grow-1" type="submit">
            <i class="bx bx-search-alt me-1"></i> Cari
          </button>
          @if(request('search'))
          <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary" title="Reset pencarian">
            <i class="bx bx-reset"></i>
          </a>
          @endif
        </div>
      </form>
    </div>
  </div>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama Kategori</th>
          <th>Tanggal Dibuat</th>
          <th>Tanggal Diupdate</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse($categories as $category)
        <tr>
          <td><strong>#{{ $category->id }}</strong></td>
          <td>
            <strong>{{ $category->nama }}</strong>
          </td>
          <td>{{ $category->created_at->format('d/m/Y H:i') }}</td>
          <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
          <td>
            <div class="d-flex gap-2">
              <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                <i class="bx bx-edit-alt"></i>
              </a>
              <button
                type="button"
                class="btn btn-sm btn-outline-danger btn-delete-category"
                data-id="{{ $category->id }}"
                data-name="{{ $category->nama }}"
              >
                <i class="bx bx-trash"></i>
              </button>
              <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="text-center py-4">
            <p class="text-muted mb-0">Tidak ada data kategori</p>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('styles')
<style>
  .swal2-container {
    z-index: 2050 !important;
  }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
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

    // SweetAlert delete confirmation
    const deleteButtons = document.querySelectorAll('.btn-delete-category');
    deleteButtons.forEach(function(button) {
      button.addEventListener('click', function () {
        const categoryId = this.dataset.id;
        const categoryName = this.dataset.name;
        const form = document.getElementById(`delete-category-${categoryId}`);

        Swal.fire({
          title: 'Konfirmasi Hapus',
          html: `Apakah Anda yakin ingin menghapus kategori <strong>\"${categoryName}\"</strong>?`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Ya, Hapus',
          cancelButtonText: 'Batal',
          reverseButtons: true,
        }).then((result) => {
          if (result.isConfirmed && form) {
            form.submit();
          }
        });
      });
    });
  });
</script>
@endpush

