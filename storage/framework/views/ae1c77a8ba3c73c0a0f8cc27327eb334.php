<?php $__env->startSection('title', 'Buat Produksi'); ?>
<?php $__env->startSection('page-title', 'Buat Produksi'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <form method="POST" action="<?php echo e(route('productions.store')); ?>">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">

            <div class="mb-3">
                <label>Order</label>
                <input type="text" class="form-control" value="Order #<?php echo e($order->id); ?>" disabled>
            </div>

            <div class="mb-3">
                <label>Tim Produksi</label>
                <input type="text" name="tim_produksi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control">
            </div>

            <div class="mb-3">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary">Simpan Produksi</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/productions/create.blade.php ENDPATH**/ ?>