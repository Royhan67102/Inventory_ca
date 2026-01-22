@extends('layouts.app')

@section('title', 'Stok Acrylic')
@section('page-title', 'Stok Acrylic')

@section('content')
<div class="mb-3">
    <a href="{{ route('acrylic-stocks.create') }}" class="btn btn-primary">+ Tambah Stok</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light text-center">
            <tr>
                <th>#</th>
                <th>Merk</th>
                <th>Warna</th>
                <th>Jenis</th>
                <th>Ukuran (P × L)</th>
                <th>Ketebalan</th>
                <th>Luas Total (m²)</th>
                <th>Luas Tersedia (m²)</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stocks as $stock)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $stock->merk }}</td>
                <td>{{ $stock->warna ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge bg-{{ $stock->jenis == 'lembar' ? 'primary' : 'secondary' }}">
                        {{ ucfirst($stock->jenis) }}
                    </span>
                </td>
                <td class="text-center">{{ $stock->panjang }} × {{ $stock->lebar }} cm</td>
                <td class="text-center">{{ $stock->ketebalan }} mm</td>
                <td class="text-end">
                    {{ number_format($stock->luas_total / 10000, 2) }}
                </td>
                <td class="text-end">
                    {{ number_format($stock->luas_tersedia / 10000, 2) }}
                </td>
                <td class="text-center">{{ $stock->jumlah_lembar }}</td>
                <td class="text-center">
                    <a href="{{ route('acrylic-stocks.show', $stock) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('acrylic-stocks.edit', $stock) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('acrylic-stocks.destroy', $stock) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
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
@endsection
