<?php $__env->startSection('title', 'Detail Stok Acrylic'); ?>
<?php $__env->startSection('page-title', 'Detail Stok Acrylic'); ?>

<?php $__env->startSection('content'); ?>
<div class="card mb-4">
    <div class="card-body">
        <h5 class="mb-3">
            <?php echo e($acrylic_stock->merk); ?>

            <?php echo e($acrylic_stock->warna ? ' - '.$acrylic_stock->warna : ''); ?>

        </h5>

        <table class="table table-bordered">
            <tr>
                <th>Jenis</th>
                <td><?php echo e(ucfirst($acrylic_stock->jenis)); ?></td>
            </tr>
            <tr>
                <th>Ukuran</th>
                <td><?php echo e($acrylic_stock->panjang); ?> × <?php echo e($acrylic_stock->lebar); ?> cm</td>
            </tr>
            <tr>
                <th>Ketebalan</th>
                <td><?php echo e($acrylic_stock->ketebalan); ?> mm</td>
            </tr>
            <tr>
                <th>Luas Total</th>
                <td><?php echo e(number_format($acrylic_stock->luas_total / 10000, 4)); ?> m²</td>
            </tr>
            <tr>
                <th>Luas Tersedia</th>
                <td><?php echo e(number_format($acrylic_stock->luas_tersedia / 10000, 4)); ?> m²</td>
            </tr>
            <tr>
                <th>Jumlah Lembar</th>
                <td><?php echo e($acrylic_stock->jumlah_lembar); ?></td>
            </tr>
        </table>

        <a href="<?php echo e(route('acrylic-stocks.index')); ?>" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h6>Riwayat Sisa / Limbah</h6>

        <?php if($acrylic_stock->wastes->isEmpty()): ?>
            <p class="text-muted">Belum ada sisa potongan</p>
        <?php else: ?>
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Luas Sisa (m²)</th>
                    <th>Status</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $acrylic_stock->wastes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $waste): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e(number_format($waste->luas_sisa / 10000, 4)); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($waste->terpakai ? 'danger' : 'success'); ?>">
                            <?php echo e($waste->terpakai ? 'Terpakai' : 'Tersedia'); ?>

                        </span>
                    </td>
                    <td><?php echo e($waste->orderItem->order->invoice_number ?? '-'); ?></td>
                    <td><?php echo e($waste->orderItem->order->customer->nama ?? '-'); ?></td>
                    <td><?php echo e($waste->created_at->format('d-m-Y')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/acrylicstocks/show.blade.php ENDPATH**/ ?>