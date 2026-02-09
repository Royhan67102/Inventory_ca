<?php $__env->startSection('title', 'Detail Delivery'); ?>
<?php $__env->startSection('page-title', 'Detail Delivery'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5>Delivery - Invoice <?php echo e($delivery->order->invoice_number); ?></h5>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Customer</th>
                <td><?php echo e($delivery->order->customer->nama ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Driver</th>
                <td><?php echo e($delivery->driver ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Tanggal Kirim</th>
                <td><?php echo e(optional($delivery->tanggal_kirim)->format('d/m/Y')); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo e(ucfirst($delivery->status)); ?></td>
            </tr>
            <tr>
                <th>Bukti Foto</th>
                <td>
                    <?php if($delivery->bukti_foto): ?>
                        <a href="<?php echo e(asset('storage/'.$delivery->bukti_foto)); ?>"
                           target="_blank">Lihat</a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <a href="<?php echo e(route('delivery.index')); ?>"
           class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/show.blade.php ENDPATH**/ ?>