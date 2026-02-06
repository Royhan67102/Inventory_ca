<?php $__env->startSection('title', 'Edit Production'); ?>
<?php $__env->startSection('page-title', 'Edit Production'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h5>Edit Production</h5>
            </div>

            <div class="card-body">

                <form action="<?php echo e(route('productions.update',$production->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="mb-3">
                        <label>Status Production</label>
                        <select name="status" class="form-select" required>

                            <option value="menunggu"
                                <?php echo e($production->status == 'menunggu' ? 'selected':''); ?>>
                                Menunggu
                            </option>

                            <option value="proses"
                                <?php echo e($production->status == 'proses' ? 'selected':''); ?>>
                                Proses
                            </option>

                            <option value="selesai"
                                <?php echo e($production->status == 'selesai' ? 'selected':''); ?>>
                                Selesai
                            </option>

                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('productions.index')); ?>"
                           class="btn btn-secondary">
                           Kembali
                        </a>

                        <button type="submit"
                                class="btn btn-primary">
                                Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/edit.blade.php ENDPATH**/ ?>