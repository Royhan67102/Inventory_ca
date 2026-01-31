@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3">Detail Pengiriman</h4>

    <div class="card mb-3">
        <div class="card-body">

            <h5>Informasi Order</h5>
            <table class="table table-bordered">
                <tr>
                    <th width="200">Invoice</th>
                    <td>{{ $deliveryNote->order->invoice_number ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Customer</th>
                    <td>{{ $deliveryNote->order->customer->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $deliveryNote->order->customer->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $deliveryNote->order->customer->telepon ?? '-' }}</td>
                </tr>
            </table>

        </div>
    </div>

    {{-- ITEM ORDER --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5>Item Pesanan</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Qty</th>
                        <th>Ukuran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveryNote->order->items as $item)
                        <tr>
                            <td>{{ $item->nama_produk ?? '-' }}</td>
                            <td>{{ $item->qty ?? '-' }}</td>
                            <td>{{ $item->ukuran ?? '-' }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                Tidak ada item
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- DATA PENGIRIMAN --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5>Informasi Pengiriman</h5>

            <table class="table table-bordered">
                <tr>
                    <th width="200">Driver</th>
                    <td>{{ $deliveryNote->driver ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Kirim</th>
                    <td>{{ optional($deliveryNote->tanggal_kirim)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Jam Berangkat</th>
                    <td>{{ $deliveryNote->jam_berangkat ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jam Sampai</th>
                    <td>{{ $deliveryNote->jam_sampai_tujuan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jam Kembali</th>
                    <td>{{ $deliveryNote->jam_kembali ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @php
                            $badge = [
                                'menunggu' => 'secondary',
                                'berangkat' => 'primary',
                                'sampai' => 'warning',
                                'selesai' => 'success',
                            ];
                        @endphp

                        <span class="badge bg-{{ $badge[$deliveryNote->status] ?? 'dark' }}">
                            {{ ucfirst($deliveryNote->status) }}
                        </span>
                    </td>
                </tr>
            </table>

            {{-- FOTO --}}
            @if($deliveryNote->bukti_foto)
                <h6>Bukti Foto Pengiriman</h6>
                <img src="{{ asset('storage/'.$deliveryNote->bukti_foto) }}"
                     class="img-fluid"
                     style="max-width:400px;">
            @endif

        </div>
    </div>

    <a href="{{ route('delivery.index') }}"
       class="btn btn-secondary">Kembali</a>

    @if(!$deliveryNote->status_lock)
        <a href="{{ route('delivery.edit', $deliveryNote->id) }}"
           class="btn btn-warning">Update</a>
    @endif

    @if($deliveryNote->status_lock)
        <a href="{{ route('delivery.print', $deliveryNote->id) }}"
           class="btn btn-success">Cetak Surat Jalan</a>
    @endif

</div>
@endsection
