<?php $__env->startSection('title', 'Edit Order'); ?>
<?php $__env->startSection('page-title', 'Edit Order'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('orders.update', $order)); ?>" method="POST">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="card shadow-sm">
    <div class="card-body">
        <h6>Edit Informasi Order</h6>

        <div class="mb-3">
            <label>Status Pembayaran</label>
            <select name="payment_status" class="form-control">
                <option value="belum_bayar" <?php if($order->payment_status=='belum_bayar'): echo 'selected'; endif; ?>>Belum Bayar</option>
                <option value="dp" <?php if($order->payment_status=='dp'): echo 'selected'; endif; ?>>DP</option>
                <option value="lunas" <?php if($order->payment_status=='lunas'): echo 'selected'; endif; ?>>Lunas</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Deadline</label>
            <input type="date" name="deadline" value="<?php echo e($order->deadline?->format('Y-m-d')); ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control" rows="3"><?php echo e($order->catatan); ?></textarea>
        </div>

        <div class="text-end">
            <button class="btn btn-success">Update</button>
            <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/orders/edit.blade.php ENDPATH**/ ?>