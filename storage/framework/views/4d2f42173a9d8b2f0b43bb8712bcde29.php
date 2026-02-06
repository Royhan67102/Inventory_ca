<?php $__env->startSection('title', 'Detail Production'); ?>
<?php $__env->startSection('page-title', 'Detail Production'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

<div class="card">
    <div class="card-body">

        <table class="table table-borderless">
            <tr>
                <th width="200">Invoice</th>
                <td>: <?php echo e($production->order->invoice_number ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Customer</th>
                <td>: <?php echo e($production->order->customer->name ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Status Production</th>
                <td>
                    :
                    <span class="badge bg-<?php echo e($production->status == 'selesai' ? 'success' :
                        ($production->status == 'proses' ? 'warning' : 'secondary')); ?>">
                        <?php echo e(ucfirst($production->status)); ?>

                    </span>
                </td>
            </tr>
            <tr>
                <th>Dibuat</th>
                <td>: <?php echo e($production->created_at->format('d M Y H:i')); ?></td>
            </tr>
        </table>

        <a href="<?php echo e(route('productions.index')); ?>" class="btn btn-secondary mt-3">
            Kembali
        </a>

    </div>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/show.blade.php ENDPATH**/ ?>