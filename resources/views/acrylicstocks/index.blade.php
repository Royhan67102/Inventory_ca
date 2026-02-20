@extends('layouts.app')

@section('title', 'Stok Acrylic')
@section('page-title', 'Stok Acrylic')

<style>
/* Card Wrapper */
.table-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* Table Styling */
.custom-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

/* Header */
.custom-table thead th {
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

/* Body */
.custom-table tbody td {
    border: 1px solid #e5e7eb;
    vertical-align: middle;
    font-size: 14px;
}

/* Row Hover */
.custom-table tbody tr:hover {
    background: #f9fafb;
}

/* Badge */
.badge {
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    justify-content: center;
}

/* Mobile Responsive Table */
@media (max-width: 768px) {
    .custom-table thead {
        display: none;
    }

    .custom-table, 
    .custom-table tbody, 
    .custom-table tr, 
    .custom-table td {
        display: block;
        width: 100%;
    }

    .custom-table tr {
        margin-bottom: 12px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px;
        background: #fff;
    }

    .custom-table td {
        border: none;
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
    }

    .custom-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #6b7280;
    }

    .action-buttons {
        justify-content: flex-start;
    }
}
</style>

@section('content')
<div class="mb-3">
    <a href="{{ route('acrylic-stocks.create') }}" class="btn btn-primary">+ Tambah Stok</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Apakah kamu yakin ingin menghapus stok acrylic ini?</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Tidak
        </button>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                Ya, Hapus
            </button>
        </form>
      </div>

    </div>
  </div>
</div>


<div class="table-card">
<div class="table-responsive">
<table class="table custom-table align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>Merk</th>
            <th>Warna</th>
            <th>Jenis</th>
            <th>Ukuran</th>
            <th>Ketebalan</th>
            <th>Luas Total</th>
            <th>Luas Tersedia</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($stocks as $stock)
        <tr>
            <td data-label="#"> {{ $loop->iteration }} </td>
            <td data-label="Merk"> {{ $stock->merk }} </td>
            <td data-label="Warna"> {{ $stock->warna ?? '-' }} </td>
            <td data-label="Jenis" class="text-center">
                <span class="badge bg-{{ $stock->jenis == 'lembar' ? 'primary' : 'secondary' }}">
                    {{ ucfirst($stock->jenis) }}
                </span>
            </td>
            <td data-label="Ukuran"> {{ $stock->panjang }} × {{ $stock->lebar }} cm </td>
            <td data-label="Ketebalan"> {{ $stock->ketebalan }} mm </td>
            <td data-label="Luas Total">
                {{ number_format($stock->luas_total / 10000, 2) }}
            </td>
            <td data-label="Luas Tersedia">
                {{ number_format($stock->luas_tersedia / 10000, 2) }}
            </td>
            <td data-label="Jumlah"> {{ $stock->jumlah_lembar }} </td>
            <td data-label="Aksi">
                <div class="action-buttons">
                    <a href="{{ route('acrylic-stocks.show', $stock) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('acrylic-stocks.edit', $stock) }}" class="btn btn-warning btn-sm">Edit</a>
                    <button type="button" 
                            class="btn btn-danger btn-sm delete-btn"
                            data-url="{{ route('acrylic-stocks.destroy', $stock) }}"
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteModal">
                        Hapus
                    </button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="10" class="text-center text-muted">
                Belum ada stok acrylic
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all delete buttons and modal elements
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');
    const deleteModal = document.getElementById('deleteModal');

    // Handle delete button clicks
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const deleteUrl = this.getAttribute('data-url');
            // Set the form action to the delete URL
            deleteForm.action = deleteUrl;
        });
    });

    // Optional: Reset form when modal is hidden
    if (deleteModal) {
        deleteModal.addEventListener('hidden.bs.modal', function() {
            deleteForm.action = '';
        });
    }
});
</script>
@endsection
