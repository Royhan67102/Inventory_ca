<?php $__env->startSection('title','Update Pickup'); ?>
<?php $__env->startSection('page-title','Update Pickup'); ?>

<style>
    /* =========================
   FORM WRAPPER
========================= */
.pickup-form {
    max-width: 600px;
}

/* =========================
   FORM GROUP
========================= */
.form-group-custom {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

/* =========================
   LABEL
========================= */
.form-group-custom label {
    font-weight: 600;
    margin-bottom: 6px;
}

/* =========================
   INPUT BORDER STYLE
========================= */
.form-control-custom {
    border: 1.5px solid #dcdcdc;
    border-radius: 8px;
    padding: 10px 12px;
    transition: all 0.2s ease;
    width: 100%;
}

/* Focus Effect */
.form-control-custom:focus {
    outline: none;
    border-color: #198754;
    box-shadow: 0 0 0 2px rgba(25,135,84,0.15);
}

/* =========================
   MOBILE OPTIMIZATION
========================= */
@media (max-width: 576px) {

    .card-body {
        padding: 16px;
    }

    .form-control-custom {
        font-size: 14px;
        padding: 9px 10px;
    }

    label {
        font-size: 14px;
    }

}
</style>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="pickup-form">
        <form action="<?php echo e(route('pickup.update',$pickup->id)); ?>"
        method="POST"
        enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group-custom">
                <label>Status</label>
                <select name="status" class="form-control-custom" required>
                    <option value="menunggu"
                        <?php echo e($pickup->status == 'menunggu' ? 'selected' : ''); ?>>
                        Menunggu
                    </option>
                    <option value="selesai"
                        <?php echo e($pickup->status == 'selesai' ? 'selected' : ''); ?>>
                        Selesai
                    </option>
                </select>
            </div>


           <div class="form-group-custom">
            <label>Bukti (opsional)</label>
            <input type="file" name="bukti" class="form-control-custom">
        </div>

            <div class="form-group-custom">
                <label>Catatan</label>
                <textarea name="catatan"
                        rows="3"
                        class="form-control-custom"><?php echo e(old('catatan',$pickup->catatan)); ?></textarea>
            </div>

            <div class="d-flex flex-column flex-md-row gap-2 mt-3">
                <button class="btn btn-success w-100 w-md-auto">
                    Simpan
                </button>

                <a href="<?php echo e(route('pickup.index')); ?>"
                class="btn btn-secondary w-100 w-md-auto">
                Batal
                </a>
            </div>

        </form>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/pickups/edit.blade.php ENDPATH**/ ?>