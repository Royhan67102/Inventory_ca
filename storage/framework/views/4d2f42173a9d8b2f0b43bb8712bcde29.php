<?php $__env->startSection('title', 'Detail Produksi'); ?>
<?php $__env->startSection('page-title', 'Detail Produksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Detail Produksi</h6>
        <a href="<?php echo e(route('productions.index')); ?>" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card-body">
        <p><strong>Customer:</strong> <?php echo e($production->order->customer->nama ?? '-'); ?></p>
        <p><strong>Tanggal Order:</strong> <?php echo e($production->order->tanggal_pemesanan?->format('d M Y')); ?></p>
        <p><strong>Deadline:</strong> <?php echo e($production->order->deadline?->format('d M Y') ?? '-'); ?></p>

        <hr>

        <p><strong>Tim Produksi:</strong> <?php echo e($production->tim_produksi ?? '-'); ?></p>
        <p><strong>Status:</strong>
            <span class="badge bg-<?php echo e($production->status=='selesai'?'success':($production->status=='proses'?'warning':'secondary')); ?>">
                <?php echo e(ucfirst($production->status)); ?>

            </span>
        </p>
        <p><strong>Tanggal Mulai:</strong> <?php echo e($production->tanggal_mulai?->format('d M Y') ?? '-'); ?></p>
        <p><strong>Tanggal Selesai:</strong> <?php echo e($production->tanggal_selesai?->format('d M Y') ?? '-'); ?></p>

        <hr>

        <p><strong>Catatan Produksi:</strong></p>
        <p><?php echo e($production->catatan ?? '-'); ?></p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/show.blade.php ENDPATH**/ ?>