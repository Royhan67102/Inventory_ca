@extends('layouts.app')

@section('title', 'Edit Order')
@section('page-title', 'Edit Order')

@section('content')
<form action="{{ route('orders.update', $order->id) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="row">
    {{-- ================= CUSTOMER ================= --}}
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="mb-3">
                    <label class="form-label">Nama Customer</label>
                    <input type="text" class="form-control" value="{{ optional($order->customer)->nama ?? '-' }}" readonly>
                    <input type="hidden" name="nama" value="{{ optional($order->customer)->nama ?? '-' }}">

                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" required>
                    {{ $order->customer->alamat }}
                    </textarea>

                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" class="form-control" value="{{ $order->customer->telepon }}" readonly>
                    <input type="hidden" name="telepon" value="{{ $order->customer->telepon }}">

                </div>
            </div>
        </div>
    </div>

    {{-- ================= ORDER ================= --}}
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Informasi Order</h6>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Tanggal Pemesanan</label>
                        <input type="date"
                            name="tanggal_pemesanan"
                            class="form-control"
                            value="{{ \Carbon\Carbon::parse($order->tanggal_pemesanan)->format('Y-m-d') }}"
                            required>

                    </div>
                    <div class="col">
                        <label class="form-label">Deadline</label>
                        <input type="date"
                            name="deadline"
                            class="form-control"
                            value="{{ $order->deadline
                            ? \Carbon\Carbon::parse($order->deadline)->format('Y-m-d')
                            : '' }}">

                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="belum_bayar" {{ $order->payment_status=='belum_bayar'?'selected':'' }}>Belum Bayar</option>
                        <option value="dp" {{ $order->payment_status=='dp'?'selected':'' }}>DP</option>
                        <option value="lunas" {{ $order->payment_status=='lunas'?'selected':'' }}>Lunas</option>
                    </select>
                </div>

                <hr>

                {{-- ================= DESAIN ================= --}}
                <div class="mb-3">
                    <label class="form-label">Menggunakan Jasa Desain?</label>
                    <select name="jasa_desain" class="form-select" id="jasaDesain">
                        <option value="0" {{ !$order->design ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ $order->design ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>

                <div class="mb-3 {{ !$order->design ? 'd-none' : '' }}" id="formDesain">
                    <label class="form-label">File Desain</label>

                    @if($order->design && $order->design->file_awal)
                        <div class="mb-3">
                            <p class="text-muted small mb-2"><strong>File Desain Saat Ini:</strong></p>
                            <a href="{{ asset('storage/'.$order->design->file_awal) }}"
                               target="_blank"
                               class="btn btn-outline-primary btn-sm me-2">
                               👁 Lihat File
                            </a>
                            <a href="{{ asset('storage/'.$order->design->file_awal) }}"
                               download
                               class="btn btn-outline-secondary btn-sm">
                               ⬇ Download
                            </a>
                            
                            @if(Str::endsWith($order->design->file_awal, ['jpg','jpeg','png','gif','webp']))
                                <div class="mt-2">
                                    <img src="{{ asset('storage/'.$order->design->file_awal) }}"
                                         class="img-fluid rounded"
                                         style="max-height:200px; max-width:100%;">
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="mb-2">
                        <label class="form-label text-muted">Ganti File Desain (Opsional)</label>
                        <input type="file" name="file_desain" class="form-control" accept="image/*,.pdf">
                        <small class="text-muted">
                            @if($order->design && $order->design->file_awal)
                                Kosongkan jika tidak ingin mengganti file
                            @else
                                Upload file desain awal dari customer
                            @endif
                        </small>
                    </div>
                </div>


                <hr>

                {{-- ================= JASA TAMBAHAN ================= --}}
                <div class="mb-3">
                    <label class="form-label">Antar Barang?</label>
                    <select name="antar_barang" class="form-select" id="antarBarang">
                        <option value="0" {{ !$order->antar_barang ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ $order->antar_barang ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>

                <div class="mb-3 {{ !$order->antar_barang ? 'd-none' : '' }}" id="formBiayaPengiriman">
                    <label class="form-label">Biaya Pengiriman</label>
                    <input type="number" name="biaya_pengiriman"
                           class="form-control"
                           value="{{ $order->biaya_pengiriman }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jasa Pemasangan?</label>
                    <select name="jasa_pemasangan" class="form-select" id="jasaPasang">
                        <option value="0" {{ !$order->jasa_pemasangan ? 'selected' : '' }}>Tidak</option>
                        <option value="1" {{ $order->jasa_pemasangan ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>

                <div class="mb-3 {{ !$order->jasa_pemasangan ? 'd-none' : '' }}" id="formBiayaPemasangan">
                    <label class="form-label">Biaya Pemasangan</label>
                    <input type="number" name="biaya_pemasangan"
                           class="form-control"
                           value="{{ $order->biaya_pemasangan }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="catatan"
                           class="form-control"
                           value="{{ $order->catatan }}">
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= ITEM ================= --}}
<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold">Item Order</h6>

        <table class="table table-bordered" id="tableItemOrder">
            <thead class="text-center">
                <tr>
                    <th style="width:40px"></th>
                    <th>Merk</th>
                    <th>Ketebalan</th>
                    <th>Warna</th>
                    <th>Panjang</th>
                    <th>Lebar</th>
                    <th>Luas</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr class="item-row">
                    <td class="text-center align-middle">
                        <button type="button" class="btn btn-danger btn-sm btn-remove-row">
                            ×
                        </button>
                    </td>
                    <td><input name="merk[]" class="form-control form-control-sm" value="{{ $item->merk }}"></td>
                    <td><input name="ketebalan[]" class="form-control form-control-sm" value="{{ $item->ketebalan }}"></td>
                    <td><input name="warna[]" class="form-control form-control-sm" value="{{ $item->warna }}"></td>
                    <td><input name="panjang_cm[]" class="form-control form-control-sm panjang" value="{{ $item->panjang_cm }}"></td>
                    <td><input name="lebar_cm[]" class="form-control form-control-sm lebar" value="{{ $item->lebar_cm }}"></td>
                    <td><input name="luas[]" class="form-control form-control-sm luas" readonly></td>
                    <td><input name="qty[]" class="form-control form-control-sm qty" value="{{ $item->qty }}"></td>
                    <td><input name="harga[]" class="form-control form-control-sm harga" value="{{ $item->harga }}"></td>
                    <td><input name="subtotal[]" class="form-control form-control-sm subtotal" readonly></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button type="button" id="addRow" class="btn btn-primary btn-sm">
            + Tambah Item
        </button>
    </div>
</div>

<div class="text-end mt-3">
    <h5>Grand Total : <span id="grandTotalText">Rp0</span></h5>
</div>

<div class="d-flex justify-content-end gap-2 mb-5">
    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
        Batal
    </a>
    <button type="submit" class="btn btn-success">
        Update Order
    </button>
</div>




@push('scripts')
<script>
        // ================= TOGGLE FORM TAMBAHAN =================
    function toggleForm(selectId, formId) {
        const selectEl = document.getElementById(selectId);
        const formEl   = document.getElementById(formId);

        if (!selectEl || !formEl) return;

        formEl.classList.toggle('d-none', selectEl.value == 0);
    }

    // Jasa Desain
    document.getElementById('jasaDesain')?.addEventListener('change', function () {
        toggleForm('jasaDesain', 'formDesain');
    });

    // Antar Barang
    document.getElementById('antarBarang')?.addEventListener('change', function () {
        toggleForm('antarBarang', 'formBiayaPengiriman');
    });

    // Jasa Pemasangan
    document.getElementById('jasaPasang')?.addEventListener('change', function () {
        toggleForm('jasaPasang', 'formBiayaPemasangan');
    });

    // Jalankan saat halaman pertama kali dibuka
    document.addEventListener('DOMContentLoaded', function () {
        toggleForm('jasaDesain', 'formDesain');
        toggleForm('antarBarang', 'formBiayaPengiriman');
        toggleForm('jasaPasang', 'formBiayaPemasangan');
    });

    function formatRp(val) {
        return 'Rp' + Math.round(val || 0).toLocaleString('id-ID');
    }

    function hitungRow(row) {
        const panjang = parseFloat(row.querySelector('.panjang').value || 0);
        const lebar   = parseFloat(row.querySelector('.lebar').value || 0);
        const qty     = parseInt(row.querySelector('.qty').value || 0);
        const harga   = parseFloat(row.querySelector('.harga').value || 0);

        // luas = p x l
        const luas = (panjang * lebar) / 10000;
        row.querySelector('.luas').value = luas ? luas.toFixed(2) : '';

        // total item = harga x qty
        const total = harga * qty;
        row.querySelector('.subtotal').value = formatRp(total);

        hitungGrandTotal();
    }

    function hitungGrandTotal() {
        let totalItem = 0;

        document.querySelectorAll('.subtotal').forEach(el => {
            totalItem += parseInt(el.value.replace(/[^\d]/g, '') || 0);
        });

        const antar  = parseInt(document.querySelector('[name="biaya_pengiriman"]')?.value || 0);
        const pasang = parseInt(document.querySelector('[name="biaya_pemasangan"]')?.value || 0);

        const grandTotal = totalItem + antar + pasang;

        document.getElementById('grandTotalText').innerText = formatRp(grandTotal);
    }

    function bindRow(row) {
        row.querySelectorAll('input').forEach(el => {
            el.addEventListener('input', () => hitungRow(row));
        });
        hitungRow(row);
    }

    // bind awal
   document.addEventListener('DOMContentLoaded', function () {

    // ================= TOGGLE FORM TAMBAHAN =================
    toggleForm('jasaDesain', 'formDesain');
    toggleForm('antarBarang', 'formBiayaPengiriman');
    toggleForm('jasaPasang', 'formBiayaPemasangan');

    // bind awal item
    document.querySelectorAll('.item-row').forEach(bindRow);

    // hitung ulang grand total
    hitungGrandTotal();
});

    // tambah row
    document.getElementById('addRow').addEventListener('click', () => {
        const tbody = document.querySelector('#tableItemOrder tbody');
        const row = tbody.querySelector('.item-row').cloneNode(true);

        row.querySelectorAll('input').forEach(i => i.value = '');
        tbody.appendChild(row);
        bindRow(row);
    });


    // update kalau biaya tambahan berubah
    ['biaya_pengiriman', 'biaya_pemasangan'].forEach(name => {
        const el = document.querySelector(`[name="${name}"]`);
        if (el) el.addEventListener('input', hitungGrandTotal);
    });

    /* ================= HAPUS BARIS ITEM ================= */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-remove-row');
        if (!btn) return;

        const row = btn.closest('.item-row');
        const tbody = row.closest('tbody');

        // minimal 1 baris
        if (tbody.querySelectorAll('.item-row').length === 1) {
            row.querySelectorAll('input').forEach(i => i.value = '');
            row.querySelector('.qty').value = 1;
            hitungRow(row);
            return;
        }

        row.remove();
        hitungGrandTotal();
    });
</script>
@endpush {{-- pakai script yang sama persis dengan create --}}
@endsection
