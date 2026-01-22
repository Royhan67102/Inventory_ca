<?php $__env->startSection('title', 'Daftar Produksi'); ?>
<?php $__env->startSection('page-title', 'Daftar Produksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm">
    <div class="card-header">
        <h6 class="mb-0">Daftar Produksi</h6>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Deadline</th>
                    <th>Tim Produksi</th>
                    <th>Status</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $productions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($prod->order->customer->nama ?? '-'); ?></td>
                    <td class="text-center">
                        <?php echo e($prod->order->deadline?->format('d M Y') ?? '-'); ?>

                    </td>
                    <td><?php echo e($prod->tim_produksi ?? '-'); ?></td>
                    <td class="text-center">
                        <?php
                            $badge = match($prod->status) {
                                'menunggu' => 'secondary',
                                'proses' => 'warning',
                                'selesai' => 'success',
                                default => 'secondary'
                            };
                        ?>
                        <span class="badge bg-<?php echo e($badge); ?>"><?php echo e(ucfirst($prod->status)); ?></span>
                    </td>
                    <td class="text-center"><?php echo e($prod->tanggal_mulai?->format('d M Y') ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($prod->tanggal_selesai?->format('d M Y') ?? '-'); ?></td>
                    <td class="text-center">
                        <a href="<?php echo e(route('productions.show', $prod)); ?>" class="btn btn-info btn-sm">Detail</a>
                        <a href="<?php echo e(route('productions.edit', $prod)); ?>" class="btn btn-primary btn-sm">Update</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada produksi</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/productions/index.blade.php ENDPATH**/ ?>