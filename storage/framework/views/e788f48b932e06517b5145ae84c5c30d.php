<?php $__env->startSection('title','Detail Pickup'); ?>
<?php $__env->startSection('page-title','Detail Pickup'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th width="200">Invoice</th>
                <td><?php echo e($pickup->order->invoice_number ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Customer</th>
                <td><?php echo e($pickup->order->customer->nama ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge
                        <?php echo e($pickup->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark'); ?>">
                        <?php echo e(ucfirst($pickup->status)); ?>

                    </span>
                </td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td><?php echo e($pickup->catatan ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Bukti</th>
                <td>
                    <?php if($pickup->bukti): ?>
                        <a href="<?php echo e(asset('storage/'.$pickup->bukti)); ?>"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           Lihat Bukti
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <a href="<?php echo e(route('pickup.index')); ?>"
           class="btn btn-secondary mt-3">
           Kembali
        </a>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/pickups/show.blade.php ENDPATH**/ ?>