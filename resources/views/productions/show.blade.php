@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-3">Detail Produksi (SPK)</h4>

    {{-- INFO ORDER --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5>Informasi Order</h5>

            <div class="row">
                <div class="col-md-4">
                    <b>No Order</b><br>
                    #{{ $production->order->id }}
                </div>

                <div class="col-md-4">
                    <b>Customer</b><br>
                    {{ $production->order->customer->nama ?? '-' }}
                </div>

                <div class="col-md-4">
                    <b>Status Order</b><br>
                    {{ ucfirst($production->order->status) }}
                </div>
            </div>
        </div>
    </div>

    {{-- INFO PRODUKSI --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5>Informasi Produksi</h5>

            <div class="row mb-2">
                <div class="col-md-4">
                    <b>Tim Produksi</b><br>
                    {{ $production->tim_produksi ?? '-' }}
                </div>

                <div class="col-md-4">
                    <b>Status</b><br>

                    @if($production->status == 'menunggu')
                        <span class="badge bg-secondary">Menunggu</span>
                    @elseif($production->status == 'proses')
                        <span class="badge bg-warning text-dark">Proses</span>
                    @else
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </div>

                <div class="col-md-4">
                    <b>Status Lock</b><br>
                    {{ $production->status_lock ? 'Terkunci' : 'Aktif' }}
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <b>Tanggal Mulai</b><br>
                    {{ optional($production->tanggal_mulai)->format('d-m-Y H:i') }}
                </div>

                <div class="col-md-4">
                    <b>Tanggal Selesai</b><br>
                    {{ optional($production->tanggal_selesai)->format('d-m-Y H:i') }}
                </div>

                <div class="col-md-4">
                    <b>Stok Dipotong</b><br>
                    {{ $production->stok_dipotong ? 'Ya' : 'Belum' }}
                </div>
            </div>

            <div>
                <b>Catatan Produksi</b><br>
                {{ $production->catatan ?? '-' }}
            </div>
        </div>
    </div>

    {{-- ITEM PRODUKSI --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5>Item Produksi</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>Qty</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($production->order->items as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item->nama_produk ?? '-' }}</td>
                        <td>{{ $item->ukuran ?? '-' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Tidak ada item
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- BUKTI PRODUKSI --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5>Bukti Produksi</h5>

            @if($production->bukti)
                <a href="{{ asset('storage/'.$production->bukti) }}"
                   target="_blank">
                    Lihat Bukti Produksi
                </a>
            @else
                <p>Belum ada bukti produksi.</p>
            @endif
        </div>
    </div>

    <a href="{{ route('productions.index') }}"
       class="btn btn-secondary">
        Kembali
    </a>

    @if(!$production->status_lock)
        <a href="{{ route('productions.edit', $production) }}"
           class="btn btn-primary">
            Update Produksi
        </a>
    @endif

</div>
@endsection
