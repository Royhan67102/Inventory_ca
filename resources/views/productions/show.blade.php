@extends('layouts.app')

@section('title','Detail Production')
@section('page-title','Detail Production')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Detail Production</h5>
    </div>

    <div class="card-body">

        <table class="table table-borderless">

            {{-- ORDER --}}
            <tr>
                <th width="200">Kode Order</th>
                <td>{{ $production->order->invoice_number ?? '-' }}</td>
            </tr>

            <tr>
                <th>Customer</th>
                <td>{{ $production->order->customer->nama ?? '-' }}</td>
            </tr>

            {{-- STATUS --}}
            <tr>
                <th>Status Production</th>
                <td>
                    <span class="badge
                        @if($production->status == 'menunggu') bg-warning text-dark
                        @elseif($production->status == 'proses') bg-info
                        @elseif($production->status == 'selesai') bg-success
                        @endif">
                        {{ ucfirst($production->status) }}
                    </span>
                </td>
            </tr>

            {{-- TIM --}}
            <tr>
                <th>Tim Produksi</th>
                <td>{{ $production->tim_produksi ?? '-' }}</td>
            </tr>

            {{-- TANGGAL --}}
            <tr>
                <th>Tanggal Mulai</th>
                <td>
                    {{ $production->tanggal_mulai
                        ? \Carbon\Carbon::parse($production->tanggal_mulai)->format('d/m/Y H:i')
                        : '-' }}
                </td>
            </tr>

            <tr>
                <th>Tanggal Selesai</th>
                <td>
                    {{ $production->tanggal_selesai
                        ? \Carbon\Carbon::parse($production->tanggal_selesai)->format('d/m/Y H:i')
                        : '-' }}
                </td>
            </tr>

            {{-- CATATAN DESIGN (TETAP PUNYA DESIGN) --}}
            <tr>
                <th>Catatan Design</th>
                <td>{{ $production->order->design->catatan ?? '-' }}</td>
            </tr>

            {{-- FILE HASIL DESIGN (JANGAN DIUBAH SESUAI REQUEST) --}}
            <tr>
                <th>File Hasil Design</th>
                <td>
                    @if($production->order->design?->file_hasil)
                        <a href="{{ asset('storage/'.$production->order->design->file_hasil) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           Lihat File
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>

            {{-- BUKTI PRODUKSI --}}
            <tr>
                <th>Bukti Produksi</th>
                <td>
                    @if($production->bukti)
                        <a href="{{ asset('storage/'.$production->bukti) }}"
                           target="_blank"
                           class="btn btn-sm btn-outline-success">
                           Lihat Bukti
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>

            {{-- CATATAN PRODUKSI --}}
            <tr>
                <th>Catatan Produksi</th>
                <td>{{ $production->catatan ?? '-' }}</td>
            </tr>

        </table>

        <a href="{{ route('productions.index') }}"
           class="btn btn-secondary">
           Kembali
        </a>

    </div>
</div>
@endsection
