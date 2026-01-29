<?php $__env->startSection('title', 'Edit Order'); ?>
<?php $__env->startSection('page-title', 'Edit Order'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('orders.update', $order->id)); ?>" method="POST" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="row">
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="mb-3">
                    <label class="form-label">Nama Customer</label>
                    <input type="text" name="nama" class="form-control"
                           value="<?php echo e($order->nama); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3" required><?php echo e($order->alamat); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control"
                           value="<?php echo e($order->telepon); ?>" required>
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
                        <input type="date" name="tanggal_pemesanan"
                               class="form-control"
                               value="<?php echo e($order->tanggal_pemesanan); ?>" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="deadline"
                               class="form-control"
                               value="<?php echo e($order->deadline); ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="belum_bayar" <?php echo e($order->payment_status=='belum_bayar'?'selected':''); ?>>Belum Bayar</option>
                        <option value="dp" <?php echo e($order->payment_status=='dp'?'selected':''); ?>>DP</option>
                        <option value="lunas" <?php echo e($order->payment_status=='lunas'?'selected':''); ?>>Lunas</option>
                    </select>
                </div>

                <hr>

                
                <div class="mb-3">
                    <label class="form-label">Menggunakan Jasa Desain?</label>
                    <select name="jasa_desain" class="form-select" id="jasaDesain">
                        <option value="0" <?php echo e(!$order->jasa_desain ? 'selected' : ''); ?>>Tidak</option>
                        <option value="1" <?php echo e($order->jasa_desain ? 'selected' : ''); ?>>Ya</option>
                    </select>
                </div>

                <div class="mb-3 <?php echo e(!$order->jasa_desain ? 'd-none' : ''); ?>" id="formDesain">
                    <label class="form-label">Upload File Desain</label>
                    <input type="file" name="file_desain" class="form-control">
                </div>

                <hr>

                
                <div class="mb-3">
                    <label class="form-label">Antar Barang?</label>
                    <select name="antar_barang" class="form-select" id="antarBarang">
                        <option value="0" <?php echo e(!$order->antar_barang ? 'selected' : ''); ?>>Tidak</option>
                        <option value="1" <?php echo e($order->antar_barang ? 'selected' : ''); ?>>Ya</option>
                    </select>
                </div>

                <div class="mb-3 <?php echo e(!$order->antar_barang ? 'd-none' : ''); ?>" id="formBiayaPengiriman">
                    <label class="form-label">Biaya Pengiriman</label>
                    <input type="number" name="biaya_pengiriman"
                           class="form-control"
                           value="<?php echo e($order->biaya_pengiriman); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Jasa Pemasangan?</label>
                    <select name="jasa_pemasangan" class="form-select" id="jasaPasang">
                        <option value="0" <?php echo e(!$order->jasa_pemasangan ? 'selected' : ''); ?>>Tidak</option>
                        <option value="1" <?php echo e($order->jasa_pemasangan ? 'selected' : ''); ?>>Ya</option>
                    </select>
                </div>

                <div class="mb-3 <?php echo e(!$order->jasa_pemasangan ? 'd-none' : ''); ?>" id="formBiayaPemasangan">
                    <label class="form-label">Biaya Pemasangan</label>
                    <input type="number" name="biaya_pemasangan"
                           class="form-control"
                           value="<?php echo e($order->biaya_pemasangan); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="catatan"
                           class="form-control"
                           value="<?php echo e($order->catatan); ?>">
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
                    <th>Panjang</th>
                    <th>Lebar</th>
                    <th>Luas</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="item-row">
                    <td><input name="merk[]" class="form-control form-control-sm" value="<?php echo e($item->merk); ?>"></td>
                    <td><input name="ketebalan[]" class="form-control form-control-sm" value="<?php echo e($item->ketebalan); ?>"></td>
                    <td><input name="warna[]" class="form-control form-control-sm" value="<?php echo e($item->warna); ?>"></td>
                    <td><input name="panjang_cm[]" class="form-control form-control-sm panjang" value="<?php echo e($item->panjang_cm); ?>"></td>
                    <td><input name="lebar_cm[]" class="form-control form-control-sm lebar" value="<?php echo e($item->lebar_cm); ?>"></td>
                    <td><input name="luas[]" class="form-control form-control-sm luas" readonly></td>
                    <td><input name="qty[]" class="form-control form-control-sm qty" value="<?php echo e($item->qty); ?>"></td>
                    <td><input name="harga[]" class="form-control form-control-sm harga" value="<?php echo e($item->harga); ?>"></td>
                    <td><input name="subtotal[]" class="form-control form-control-sm subtotal" readonly></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end mt-3">
    <h5>Grand Total : <span id="grandTotalText">Rp0</span></h5>
</div>

<div class="text-end mb-5">
    <button type="submit" class="btn btn-success">Update Order</button>
</div>

<?php $__env->startPush('scripts'); ?>
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
    document.querySelectorAll('.item-row').forEach(bindRow);

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
</script>
<?php $__env->stopPush(); ?> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/edit.blade.php ENDPATH**/ ?>