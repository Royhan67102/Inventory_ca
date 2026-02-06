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

            <tr>
                <th>Kode Order</th>
                <td>{{ $production->order->invoice_number }}</td>
            </tr>

            <tr>
                <th>Customer</th>
                <td>{{ $production->order->customer->nama }}</td>
            </tr>

            <tr>
                <th>Status Production</th>
                <td>{{ ucfirst($production->status) }}</td>
            </tr>

            <tr>
                <th>Catatan Design</th>
                <td>{{ $production->order->design->catatan ?? '-' }}</td>
            </tr>

            <tr>
                <th>File Hasil Design</th>
                <td>
                    @if($production->order->design?->file_hasil)
                        <a href="{{ asset('storage/'.$production->order->design->file_hasil) }}"
                           target="_blank">
                           Lihat File
                        </a>
                    @endif
                </td>
            </tr>

        </table>

        <a href="{{ route('productions.index') }}"
           class="btn btn-secondary">
           Kembali
        </a>

    </div>
</div>
@endsection
