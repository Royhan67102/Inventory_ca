<?php $__env->startSection('title', 'Edit Stok Acrylic'); ?>
<?php $__env->startSection('page-title', 'Edit Stok Acrylic'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $locked = $acrylic_stock->luas_tersedia < $acrylic_stock->luas_total;
?>

<style>
/* Card Wrapper */
.form-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* Label */
.form-label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
}

/* Input */
.form-control {
    border: 1px solid #d1d5db !important;
    border-radius: 10px !important;
    padding: 10px 12px;
    transition: all 0.2s ease;
}

/* Focus */
.form-control:focus {
    border-color: #198754 !important;
    box-shadow: 0 0 0 2px rgba(25,135,84,0.15) !important;
}

/* Readonly Style */
.form-control[readonly] {
    background-color: #f3f4f6;
    border-style: dashed !important;
    color: #6b7280;
}

/* Section Title */
.form-section-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 16px;
}

/* Action Button Responsive */
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

<div class="form-card">
<form action="<?php echo e(route('acrylic-stocks.update', $acrylic_stock)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="form-section-title">Informasi Acrylic</div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Merk</label>
            <input type="text" name="merk" class="form-control"
                value="<?php echo e($acrylic_stock->merk); ?>" required>
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Warna</label>
            <input type="text" name="warna" class="form-control"
                value="<?php echo e($acrylic_stock->warna); ?>">
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Jenis</label>
            <select name="jenis" class="form-control">
                <option value="lembar" <?php echo e($acrylic_stock->jenis == 'lembar' ? 'selected' : ''); ?>>Lembar</option>
                <option value="sisa" <?php echo e($acrylic_stock->jenis == 'sisa' ? 'selected' : ''); ?>>Sisa</option>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Ketebalan (mm)</label>
            <input type="number" step="0.01" name="ketebalan" class="form-control"
                value="<?php echo e($acrylic_stock->ketebalan); ?>" required>
        </div>
    </div>

    <div class="form-section-title mt-3">Ukuran</div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-12 mb-3">
            <label class="form-label">Panjang (cm)</label>
            <input type="number" step="0.01" name="panjang" class="form-control"
                value="<?php echo e($acrylic_stock->panjang); ?>" <?php echo e($locked ? 'readonly' : ''); ?>>
        </div>

        <div class="col-lg-4 col-md-4 col-12 mb-3">
            <label class="form-label">Lebar (cm)</label>
            <input type="number" step="0.01" name="lebar" class="form-control"
                value="<?php echo e($acrylic_stock->lebar); ?>" <?php echo e($locked ? 'readonly' : ''); ?>>
        </div>

        <div class="col-lg-4 col-md-4 col-12 mb-3">
            <label class="form-label">Jumlah Lembar</label>
            <input type="number" name="jumlah_lembar" class="form-control"
                value="<?php echo e($acrylic_stock->jumlah_lembar); ?>" <?php echo e($locked ? 'readonly' : ''); ?>>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Luas Total (m²)</label>
        <input type="text" class="form-control"
            value="<?php echo e(number_format($acrylic_stock->luas_total / 10000, 2)); ?>" readonly>
    </div>

    <div class="form-action mt-4">
        <button class="btn btn-success">Update</button>
        <a href="<?php echo e(route('acrylic-stocks.index')); ?>" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/acrylicstocks/edit.blade.php ENDPATH**/ ?>