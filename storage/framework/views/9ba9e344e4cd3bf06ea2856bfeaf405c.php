<?php $__env->startSection('title', 'Update Delivery'); ?>
<?php $__env->startSection('page-title', 'Update Delivery'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5>Update Delivery</h5>
    </div>

    <div class="card-body">
        <form action="<?php echo e(route('delivery.update',$delivery->id)); ?>"
              method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label>Driver</label>
                <input type="text" name="driver"
                       value="<?php echo e(old('driver',$delivery->driver)); ?>"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="menunggu" <?php if($delivery->status=='menunggu'): echo 'selected'; endif; ?>>Menunggu</option>
                    <option value="dikirim" <?php if($delivery->status=='dikirim'): echo 'selected'; endif; ?>>Dikirim</option>
                    <option value="selesai" <?php if($delivery->status=='selesai'): echo 'selected'; endif; ?>>Selesai</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Bukti Foto</label>
                <input type="file" name="bukti_foto" class="form-control">
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="<?php echo e(route('delivery.index')); ?>"
               class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/edit.blade.php ENDPATH**/ ?>