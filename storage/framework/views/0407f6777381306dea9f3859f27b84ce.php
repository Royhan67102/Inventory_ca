<?php $__env->startSection('title', 'Edit Order'); ?>
<?php $__env->startSection('page-title', 'Edit Order'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('orders.update', $order)); ?>" method="POST">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="row">
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="mb-3">
                    <label class="form-label">Nama Customer</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-control border border-dark rounded-0"
                        value="<?php echo e(old('nama', $order->customer->nama)); ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea
                        name="alamat"
                        class="form-control border border-dark rounded-0"
                        rows="3"
                        required
                    ><?php echo e(old('alamat', $order->customer->alamat)); ?></textarea>
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
                        <input
                            type="date"
                            name="tanggal_pemesanan"
                            class="form-control"
                            value="<?php echo e(old('tanggal_pemesanan', $order->tanggal_pemesanan->format('Y-m-d'))); ?>"
                            required
                        >
                    </div>
                    <div class="col">
                        <label class="form-label">Deadline</label>
                        <input
                            type="date"
                            name="deadline"
                            class="form-control"
                            value="<?php echo e(old('deadline', $order->deadline?->format('Y-m-d'))); ?>"
                        >
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="belum_bayar" <?php if($order->payment_status=='belum_bayar'): echo 'selected'; endif; ?>>Belum Bayar</option>
                        <option value="dp" <?php if($order->payment_status=='dp'): echo 'selected'; endif; ?>>DP</option>
                        <option value="lunas" <?php if($order->payment_status=='lunas'): echo 'selected'; endif; ?>>Lunas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Antar Barang?</label>
                    <select name="antar_barang" class="form-select" required>
                        <option value="tidak" <?php if($order->antar_barang=='tidak'): echo 'selected'; endif; ?>>Tidak</option>
                        <option value="ya" <?php if($order->antar_barang=='ya'): echo 'selected'; endif; ?>>Ya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya Pengiriman</label>
                    <input
                        type="number"
                        name="biaya_pengiriman"
                        class="form-control"
                        value="<?php echo e(old('biaya_pengiriman', $order->biaya_pengiriman)); ?>"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Jasa Pemasangan?</label>
                    <select name="jasa_pemasangan" class="form-select" required>
                        <option value="tidak" <?php if($order->jasa_pemasangan=='tidak'): echo 'selected'; endif; ?>>Tidak</option>
                        <option value="ya" <?php if($order->jasa_pemasangan=='ya'): echo 'selected'; endif; ?>>Ya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya Pemasangan</label>
                    <input
                        type="number"
                        name="biaya_pemasangan"
                        class="form-control"
                        value="<?php echo e(old('biaya_pemasangan', $order->biaya_pemasangan)); ?>"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <input
                        type="text"
                        name="catatan"
                        class="form-control"
                        value="<?php echo e(old('catatan', $order->catatan)); ?>"
                    >
                </div>

            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold">Item Order</h6>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Produk</th>
                    <th>Merk</th>
                    <th>Panjang (cm)</th>
                    <th>Lebar (cm)</th>
                    <th>Qty</th>
                    <th>Harga / m²</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input name="product_name[]" class="form-control" value="<?php echo e($item->product_name); ?>" required></td>
                    <td><input name="acrylic_brand[]" class="form-control" value="<?php echo e($item->acrylic_brand); ?>"></td>
                    <td><input type="number" name="panjang_cm[]" class="form-control" value="<?php echo e($item->panjang_cm); ?>" required></td>
                    <td><input type="number" name="lebar_cm[]" class="form-control" value="<?php echo e($item->lebar_cm); ?>" required></td>
                    <td><input type="number" name="qty[]" class="form-control" value="<?php echo e($item->qty); ?>" required></td>
                    <td><input type="number" name="harga_per_m2[]" class="form-control" value="<?php echo e($item->harga_per_m2); ?>" required></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end">
    <button class="btn btn-success">Update Order</button>
    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">Batal</a>
</div>

</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/edit.blade.php ENDPATH**/ ?>