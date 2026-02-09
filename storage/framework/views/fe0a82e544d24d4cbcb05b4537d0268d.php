<?php $__env->startSection('title','Update Pickup'); ?>
<?php $__env->startSection('page-title','Update Pickup'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">

        <form action="<?php echo e(route('pickup.update',$pickup->id)); ?>"
              method="POST"
              enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="menunggu"
                        <?php echo e($pickup->status == 'menunggu' ? 'selected' : ''); ?>>
                        Menunggu
                    </option>
                    <option value="selesai">
                        Selesai
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Bukti (opsional)</label>
                <input type="file" name="bukti" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan"
                          class="form-control"
                          rows="3"><?php echo e(old('catatan',$pickup->catatan)); ?></textarea>
            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="<?php echo e(route('pickup.index')); ?>"
               class="btn btn-secondary">
               Batal
            </a>

        </form>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/pickups/edit.blade.php ENDPATH**/ ?>