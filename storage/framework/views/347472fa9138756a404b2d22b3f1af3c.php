<?php $__env->startSection('title', 'Daftar Pengiriman'); ?>
<?php $__env->startSection('page-title', 'Daftar Pengiriman'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Pengirim</th>
                    <th>Driver</th>
                    <th>Tanggal Kirim</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $deliveryNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($loop->iteration); ?></td>
                        <td><?php echo e($dn->order->customer->nama); ?></td>
                        <td><?php echo e($dn->nama_pengirim ?? '-'); ?></td>
                        <td><?php echo e($dn->driver ?? '-'); ?></td>
                        <td><?php echo e($dn->tanggal_kirim?->format('d M Y') ?? '-'); ?></td>
                        <td class="text-center">
                            <a href="<?php echo e(route('delivery.show', $dn)); ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="<?php echo e(route('delivery.edit', $dn)); ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="<?php echo e(route('delivery.print', $dn)); ?>" class="btn btn-secondary btn-sm">PDF</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada data pengiriman
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/delivery/index.blade.php ENDPATH**/ ?>