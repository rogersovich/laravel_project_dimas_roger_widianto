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
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Kategori Produk</h5>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
      <i class="bx bx-plus me-1"></i> Tambah Kategori
    </a>
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
              <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}">
                <i class="bx bx-trash"></i>
              </button>
            </div>
          </td>
        </tr>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="deleteModalTitle{{ $category->id }}">Konfirmasi Hapus</h5>
                <button
                  type="button"
                  class="btn-close"
                  data-bs-dismiss="modal"
                  aria-label="Close"
                ></button>
              </div>
              <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus kategori <strong>"{{ $category->nama }}"</strong>?</p>
                <p class="text-danger mb-0">Tindakan ini tidak dapat dibatalkan.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                  Batal
                </button>
                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">
                    <i class="bx bx-trash me-1"></i> Hapus
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
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

