<?php $__env->startSection('title', 'Update Delivery'); ?>
<?php $__env->startSection('page-title', 'Update Delivery'); ?>

<?php $__env->startSection('content'); ?>
<style>
/* Card Form */
.form-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* Title */
.form-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 20px;
}

/* Label */
.form-label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
}

/* Input Styling */
.form-control {
    border: 1px solid #d1d5db !important;
    border-radius: 10px !important;
    padding: 10px 12px;
    transition: all 0.2s ease;
}

/* Focus */
.form-control:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 2px rgba(13,110,253,0.15) !important;
}

/* File Input */
input[type="file"].form-control {
    padding: 8px;
}

/* Responsive Button */
.form-action {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    flex-wrap: wrap;
}

/* Mobile */
@media (max-width: 768px) {
    .form-card {
        padding: 18px;
    }

    .form-action {
        justify-content: center;
    }

    .btn {
        width: 100%;
    }
}
</style>



<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Kesalahan!</strong>
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo e(session('error')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="form-card">
<div class="form-title">Update Delivery</div>

<form action="<?php echo e(route('delivery.update',$delivery->id)); ?>"
      method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="row">

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Nama Pembeli</label>
            <input type="text"
                   name="nama_pengirim"
                   value="<?php echo e(old('nama_pengirim',$delivery->nama_pengirim)); ?>"
                   class="form-control <?php $__errorArgs = ['nama_pengirim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   required>
            <?php $__errorArgs = ['nama_pengirim'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Driver</label>
            <input type="text"
                   name="driver"
                   value="<?php echo e(old('driver',$delivery->driver)); ?>"
                   class="form-control <?php $__errorArgs = ['driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   required>
            <?php $__errorArgs = ['driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <option value="">-- Pilih Status --</option>
                <option value="menunggu" <?php if($delivery->status=='menunggu'): echo 'selected'; endif; ?>>Menunggu</option>
                <option value="proses" <?php if($delivery->status=='proses'): echo 'selected'; endif; ?>>Proses</option>
                <option value="selesai" <?php if($delivery->status=='selesai'): echo 'selected'; endif; ?>>Selesai</option>
            </select>
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <label class="form-label">Jam Berangkat</label>
            <input type="time"
                   name="jam_berangkat"
                   value="<?php echo e(old('jam_berangkat',$delivery->jam_berangkat)); ?>"
                   class="form-control">
        </div>

        <div class="col-lg-3 col-md-6 col-12 mb-3">
            <label class="form-label">Jam Sampai</label>
            <input type="time"
                   name="jam_sampai_tujuan"
                   value="<?php echo e(old('jam_sampai_tujuan',$delivery->jam_sampai_tujuan)); ?>"
                   class="form-control">
        </div>

        <div class="col-12 mb-3">
            <label class="form-label">Bukti Foto</label>
            <input type="file"
                   name="bukti_foto"
                   class="form-control <?php $__errorArgs = ['bukti_foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   accept="image/*">

            <?php if($delivery->bukti_foto): ?>
                <small class="d-block mt-2 text-muted">
                    Foto saat ini:
                    <a href="<?php echo e(asset('storage/'.$delivery->bukti_foto)); ?>" target="_blank">
                        Lihat
                    </a>
                </small>
            <?php endif; ?>
        </div>

    </div>

    <div class="form-action mt-4">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?php echo e(route('delivery.index')); ?>" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/edit.blade.php ENDPATH**/ ?>