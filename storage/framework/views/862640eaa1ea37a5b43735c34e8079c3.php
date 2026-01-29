<?php $__env->startSection('title', 'Tambah Order'); ?>
<?php $__env->startSection('page-title', 'Tambah Order'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('orders.store')); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>

<div class="row">
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="mb-3">
                    <label class="form-label">Nama Customer</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" required>
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
                    <label class="form-label">Menggunakan Jasa Desain?</label>
                    <select name="jasa_desain" class="form-select" id="jasaDesain">
                        <option value="0">Tidak</option>
                        <option value="1">Ya</option>
                    </select>
                </div>

                <div class="mb-3 d-none" id="formDesain">
                    <label class="form-label">Upload File Desain (Opsional)</label>
                    <input type="file" name="file_desain" class="form-control">
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
                    <input type="text" name="catatan" class="form-control">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold">Item Order</h6>

        <table class="table table-bordered" id="tableItemOrder">
            <thead class="text-center">
                <tr>
                    <th>Merk</th>
                    <th>Ketebalan</th>
                    <th>Warna</th>
                    <th>Panjang (cm)</th>
                    <th>Lebar (cm)</th>
                    <th>Luas (m²)</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr class="item-row">
                    <td><input name="merk[]" class="form-control form-control-sm"></td>
                    <td><input name="ketebalan[]" class="form-control form-control-sm"></td>
                    <td><input name="warna[]" class="form-control form-control-sm"></td>

                    <td>
                        <input type="number" name="panjang_cm[]"
                            class="form-control form-control-sm panjang" step="0.01">
                    </td>

                    <td>
                        <input type="number" name="lebar_cm[]"
                            class="form-control form-control-sm lebar" step="0.01">
                    </td>

                    <td>
                        <input type="text" name="luas[]"
                            class="form-control form-control-sm luas" readonly>
                    </td>

                    <td style="width:70px">
                        <input type="number" name="qty[]"
                            class="form-control form-control-sm qty" value="1">
                    </td>

                    <td style="width:110px">
                        <input type="number" name="harga[]"
                            class="form-control form-control-sm harga">
                    </td>

                    <td style="width:130px">
                        <input type="text" name="subtotal[]"
                            class="form-control form-control-sm subtotal" readonly>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end mt-3">
    <h5>
        Grand Total :
        <span id="grandTotalText">Rp0</span>
    </h5>
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

    // luas (m²) hanya untuk tampilan
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

    document.getElementById('grandTotalText').innerText =
        formatRp(totalItem + antar + pasang);
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
    const tbody = document.querySelector('#tableItemOrder tbody');
    const template = tbody.querySelector('.item-row');
    const row = template.cloneNode(true);

    // reset input
    row.querySelectorAll('input').forEach(i => i.value = '');

    tbody.appendChild(row);
    bindRow(row);
});

/* ================= BIAYA TAMBAHAN ================= */
['biaya_pengiriman', 'biaya_pemasangan'].forEach(name => {
    document.querySelector(`[name="${name}"]`)
        ?.addEventListener('input', hitungGrandTotal);
});
</script>


<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/create.blade.php ENDPATH**/ ?>