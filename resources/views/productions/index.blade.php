@extends('layouts.app')

@section('title', 'Daftar Production')
@section('page-title', 'Daftar Production')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Daftar Production</h5>
    </div>

    <div class="card-body">

        {{-- ALERT --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Tim</th>
                        <th>Bukti</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($productions as $production)

                    <tr>
                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        {{-- INVOICE --}}
                        <td>
                            {{ $production->order->invoice_number ?? '-' }}
                        </td>

                        {{-- CUSTOMER --}}
                        <td>
                            {{ $production->order->customer->nama ?? '-' }}
                        </td>

                        {{-- TIM --}}
                        <td>
                            {{ $production->tim_produksi ?? '-' }}
                        </td>

                        {{-- BUKTI PRODUKSI --}}
                        <td class="text-center">
                            @if($production->bukti)
                                <a href="{{ asset('storage/'.$production->bukti) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                   Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        {{-- DEADLINE --}}
                        <td class="text-center">
                            {{ optional($production->order->deadline)->format('d/m/Y') ?? '-' }}
                        </td>

                        {{-- STATUS --}}
                        <td class="text-center">
                            <span class="badge
                                @if($production->status == 'menunggu') bg-warning text-dark
                                @elseif($production->status == 'proses') bg-info
                                @elseif($production->status == 'selesai') bg-success
                                @endif">
                                {{ ucfirst($production->status) }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td class="text-center">

                            <a href="{{ route('productions.show',$production->id) }}"
                                class="btn btn-primary btn-sm">
                                Detail
                            </a>

                            {{-- UPDATE --}}
                            @if($production->status !== 'selesai')
                                <a href="{{ route('productions.edit',$production->id) }}"
                                   class="btn btn-warning btn-sm">
                                   Update
                                </a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    Locked
                                </button>
                            @endif

                            {{-- LIHAT ORDER --}}
                            <a href="{{ route('orders.show',$production->order_id) }}"
                               class="btn btn-info btn-sm">
                               Order
                            </a>

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Belum ada data production
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
