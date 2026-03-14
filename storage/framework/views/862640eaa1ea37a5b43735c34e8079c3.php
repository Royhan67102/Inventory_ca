<?php $__env->startSection('title', 'Tambah Order'); ?>
<?php $__env->startSection('page-title', 'Tambah Order'); ?>

<style>

/* CARD STYLE */
.order-card {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
}

/* INPUT STYLE */
.form-control,
.form-select {
    border: 1px solid #ced4da !important;
    border-radius: 8px;
    padding: 10px;
    transition: 0.2s;
}

.form-control:focus,
.form-select:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.15rem rgba(13,110,253,.15);
}

/* TABLE */
.table-responsive {
    overflow-x: auto;
}

#tableItemOrder th,
#tableItemOrder td {
    vertical-align: middle;
    white-space: nowrap;
}

#tableItemOrder input{
min-width:90px;
}

#tableItemOrder td{
text-align:center;
}

/* GRAND TOTAL */
#grandTotalText {
    font-weight: bold;
    color: #0d6efd;
}

/* MOBILE */
@media (max-width: 768px) {

    .card-body {
        padding: 16px;
    }

    h6 {
        font-size: 14px;
    }

    .form-label {
        font-size: 13px;
    }

    #tableItemOrder input {
        min-width: 80px;
    }

}

</style>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('orders.store')); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>

<div class="d-flex justify-content-end mb-3">
    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">
        ← Kembali
    </a>
</div>


<div class="row g-3">
    
    <div class="col-md-4">
        <div class="card mb-4 order-card shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="mb-3">
                    <label class="form-label">Nama Customer</label>
                    <input type="text" name="nama" class="form-control border rounded-2" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control border rounded-2" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="number" name="telepon" class="form-control border rounded-2" required>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Informasi Order</h6>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Tanggal Pemesanan</label>
                        <input type="date" name="tanggal_pemesanan" class="form-control" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="deadline" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="belum_bayar">Belum Bayar</option>
                        <option value="dp">DP</option>
                        <option value="lunas">Lunas</option>
                    </select>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label">Tipe Order</label>
                    <select name="tipe_order" class="form-select" id="tipeOrder" required>
                        <option value="custom">Custom</option>
                        <option value="lembaran">Lembaran</option>
                    </select>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Menggunakan Jasa Desain?</label>
                    <select name="jasa_desain" class="form-select" id="jasaDesain">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="mb-3 d-none" id="formDesain">
                    <label class="form-label">Upload File Desain (Opsional)</label>
                    <input type="file" name="file_desain" class="form-control border rounded-2">
                    <small class="text-muted">Boleh kosong jika desain dibuat oleh tim desain</small>
                </div>

                <hr>

                
                <div class="mb-3">
                    <label class="form-label">Antar Barang?</label>
                    <select name="antar_barang" class="form-select" id="antarBarang">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="mb-3 d-none" id="formBiayaPengiriman">
                    <label class="form-label">Biaya Pengiriman</label>
                    <input type="number" name="biaya_pengiriman" class="form-control" value="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jasa Pemasangan?</label>
                    <select name="jasa_pemasangan" class="form-select" id="jasaPasang">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="mb-3 d-none" id="formBiayaPemasangan">
                    <label class="form-label">Biaya Pemasangan</label>
                    <input type="number" name="biaya_pemasangan" class="form-control" value="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="catatan" class="form-control border rounded-2">
                </div>
            </div>
        </div>
    </div>
</div>


<div id="itemContainer">

    <div class="card mb-3 item-row">
        <div class="card-body">

            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-bold">Item</h6>

                <button type="button"
                class="btn btn-danger btn-sm btn-clear-row">
                Hapus
                </button>
            </div>

            <div class="mb-3">
                <label class="form-label">Produk</label>
                <input name="product_name[]" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Merk</label>
                <input name="merk[]" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Ketebalan</label>
                <input name="ketebalan[]" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Warna</label>
                <input name="warna[]" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input name="keterangan[]" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Panjang (cm)</label>
                <input type="number"
                name="panjang_cm[]"
                class="form-control panjang">
            </div>

            <div class="mb-3">
                <label class="form-label">Lebar (cm)</label>
                <input type="number"
                name="lebar_cm[]"
                class="form-control lebar">
            </div>

            <div class="mb-3">
                <label class="form-label">Luas</label>
                <input name="luas[]"
                class="form-control luas"
                readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Qty</label>
                <input type="number"
                name="qty[]"
                class="form-control qty"
                value="1">
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number"
                name="harga[]"
                class="form-control harga">
            </div>

            <div class="mb-3">
                <label class="form-label">Subtotal</label>
                <input name="subtotal[]"
                class="form-control subtotal"
                readonly>
            </div>

        </div>
    </div>

</div>

<div class="row mt-3 justify-content-end">

<div class="col-md-3">
    <label class="form-label">Diskon</label>
    <input type="number" name="diskon"
        class="form-control"
        value="0"
        id="diskonInput">
</div>

</div>
<div class="text-end mt-3">
    <h5>
        Grand Total :
        <span id="grandTotalText">Rp0</span>
    </h5>
</div>

<div class="row mt-3 justify-content-end">
    <div class="col-md-3">
        <label class="form-label">Jumlah Bayar</label>
        <input type="number"
        name="jumlah_bayar"
        class="form-control"
        value="0">
    </div>
</div>


<div class="text-end mb-5">
    <button type="button" class="btn btn-primary" id="addRow">Tambah Item</button>
    <button class="btn btn-success">Simpan Order</button>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
/* ================= TOGGLE FORM ================= */
function toggleForm(selectId, formId) {
    const selectEl = document.getElementById(selectId);
    const formEl   = document.getElementById(formId);
    if (!selectEl || !formEl) return;
    formEl.classList.toggle('d-none', selectEl.value == 0);
}

['jasaDesain', 'antarBarang', 'jasaPasang'].forEach(id => {
    document.getElementById(id)?.addEventListener('change', () => {
        toggleForm('jasaDesain', 'formDesain');
        toggleForm('antarBarang', 'formBiayaPengiriman');
        toggleForm('jasaPasang', 'formBiayaPemasangan');
    });
});

document.addEventListener('DOMContentLoaded', () => {
    toggleForm('jasaDesain', 'formDesain');
    toggleForm('antarBarang', 'formBiayaPengiriman');
    toggleForm('jasaPasang', 'formBiayaPemasangan');
});

/* ================= HELPER ================= */
function formatRp(val) {
    return 'Rp' + (val || 0).toLocaleString('id-ID');
}

function angka(val) {
    return parseFloat(val) || 0;
}

/* ================= HITUNG ROW ================= */
function hitungRow(row) {
    const panjang = angka(row.querySelector('.panjang')?.value);
    const lebar   = angka(row.querySelector('.lebar')?.value);
    const qty     = angka(row.querySelector('.qty')?.value);
    const harga   = angka(row.querySelector('.harga')?.value);

    // luas (m²) hanya tampilan
    const luas = (panjang * lebar) / 10000;
    row.querySelector('.luas').value = luas ? luas.toFixed(2) : '';

    // subtotal
    const subtotal = harga * qty;
    row.querySelector('.subtotal').value = subtotal ? formatRp(subtotal) : '';

    hitungGrandTotal();
}

/* ================= GRAND TOTAL ================= */
function hitungGrandTotal() {

    let totalItem = 0;

    document.querySelectorAll('.subtotal').forEach(el => {
        totalItem += angka(el.value.replace(/[^\d]/g, ''));
    });

    const antar  = angka(document.querySelector('[name="biaya_pengiriman"]')?.value);
    const pasang = angka(document.querySelector('[name="biaya_pemasangan"]')?.value);
    const diskon = angka(document.getElementById('diskonInput')?.value);

    const grand = totalItem + antar + pasang - diskon;

    document.getElementById('grandTotalText').innerText = formatRp(grand);

}

/* ================= BIND ROW ================= */
function bindRow(row) {
    row.querySelectorAll('.panjang, .lebar, .qty, .harga').forEach(el => {
        el.addEventListener('input', () => hitungRow(row));
    });
    hitungRow(row);
}

/* ================= INIT ================= */
document.querySelectorAll('.item-row').forEach(bindRow);

/* ================= TAMBAH ROW ================= */
document.getElementById('addRow').addEventListener('click', () => {

    const container = document.getElementById('itemContainer');
    const template  = container.querySelector('.item-row');

    const row = template.cloneNode(true);

    // reset input
    row.querySelectorAll('input').forEach(i => i.value = '');

    // default qty
    row.querySelector('.qty').value = 1;

    container.appendChild(row);

    bindRow(row);

});

/* ================= BIAYA TAMBAHAN ================= */
['biaya_pengiriman', 'biaya_pemasangan'].forEach(name => {
    document.querySelector(`[name="${name}"]`)
        ?.addEventListener('input', hitungGrandTotal);
});

/* ================= DISKON ================= */
document.getElementById('diskonInput')
?.addEventListener('input', hitungGrandTotal);

/* ================= HAPUS SATU BARIS ================= */
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-clear-row');
    if (!btn) return;

    const row = btn.closest('.item-row');
    const container = row.closest('#itemContainer');

    // minimal harus ada 1 baris
    if (container.querySelectorAll('.item-row').length === 1){
        // kalau tinggal satu, jangan hapus — cukup reset
        row.querySelectorAll('input, select, textarea').forEach(el => el.value = '');
        row.querySelector('.qty').value = 1;
        hitungRow(row);
        return;
    }

    // hapus baris
    row.remove();
    hitungGrandTotal();
});

document.getElementById('tipeOrder')?.addEventListener('change', function() {
    const jasaDesain = document.getElementById('jasaDesain');

    if (this.value === 'custom') {
        jasaDesain.value = '1';
    } else {
        jasaDesain.value = '0';
    }

    toggleForm('jasaDesain', 'formDesain');
});

document.querySelector('[name="jumlah_bayar"]')
?.addEventListener('input', function(){

const bayar = angka(this.value);

const totalText = document
.getElementById('grandTotalText')
.innerText.replace(/[^\d]/g,'');

const total = angka(totalText);

const status = document.querySelector('[name="payment_status"]');

if(bayar >= total && total > 0){
    status.value = "lunas";
}else if(bayar > 0){
    status.value = "dp";
}else{
    status.value = "belum_bayar";
}

});

document.getElementById('tipeOrder')
.addEventListener('change', function(){

const isCustom = this.value === "custom";

document.querySelectorAll('.panjang,.lebar').forEach(el=>{
    el.disabled = !isCustom;
});

});

</script>


<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/create.blade.php ENDPATH**/ ?>