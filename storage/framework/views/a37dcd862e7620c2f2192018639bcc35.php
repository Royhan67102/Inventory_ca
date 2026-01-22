<?php $__env->startSection('title', 'Edit Stok Acrylic'); ?>
<?php $__env->startSection('page-title', 'Edit Stok Acrylic'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('acrylic-stocks.update', $acrylic_stock)); ?>" method="POST" id="acrylicForm">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Merk</label>
            <input type="text" name="merk" class="form-control" value="<?php echo e($acrylic_stock->merk); ?>" required>
        </div>

        <div class="col-md-6 mb-3">
            <label>Warna</label>
            <input type="text" name="warna" class="form-control" value="<?php echo e($acrylic_stock->warna); ?>">
        </div>

        <div class="col-md-6 mb-3">
            <label>Jenis</label>
            <select name="jenis" class="form-control" required>
                <option value="lembar" <?php echo e($acrylic_stock->jenis == 'lembar' ? 'selected' : ''); ?>>Lembar</option>
                <option value="sisa" <?php echo e($acrylic_stock->jenis == 'sisa' ? 'selected' : ''); ?>>Sisa Potongan</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label>Ketebalan (mm)</label>
            <input type="number" step="0.01" name="ketebalan" class="form-control" value="<?php echo e($acrylic_stock->ketebalan); ?>" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Panjang (cm)</label>
            <input type="number" step="0.01" name="panjang" class="form-control" value="<?php echo e($acrylic_stock->panjang); ?>" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Lebar (cm)</label>
            <input type="number" step="0.01" name="lebar" class="form-control" value="<?php echo e($acrylic_stock->lebar); ?>" required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Jumlah Lembar</label>
            <input type="number" name="jumlah_lembar" class="form-control" min="1" value="<?php echo e($acrylic_stock->jumlah_lembar); ?>" required>
        </div>
    </div>

    
    <div class="mb-3">
        <label>Luas Total (m²)</label>
        <input type="text" name="luas_total" class="form-control" id="luas_total" value="<?php echo e($acrylic_stock->luas_total); ?>" readonly>
    </div>

    <div class="text-end">
        <button class="btn btn-success">Update</button>
        <a href="<?php echo e(route('acrylic-stocks.index')); ?>" class="btn btn-secondary">Batal</a>
    </div>
</form>

<script>
const form = document.getElementById('acrylicForm');
const panjang = form.querySelector('input[name="panjang"]');
const lebar = form.querySelector('input[name="lebar"]');
const jumlah = form.querySelector('input[name="jumlah_lembar"]');
const luasTotal = document.getElementById('luas_total');

function hitungLuas() {
    const p = parseFloat(panjang.value) || 0;
    const l = parseFloat(lebar.value) || 0;
    const j = parseInt(jumlah.value) || 1;
    const luas = ((p * l * j) / 10000).toFixed(2); // cm² -> m²
    luasTotal.value = luas;
}

// Event listener
panjang.addEventListener('input', hitungLuas);
lebar.addEventListener('input', hitungLuas);
jumlah.addEventListener('input', hitungLuas);

// Hitung saat load form
hitungLuas();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/acrylicstocks/edit.blade.php ENDPATH**/ ?>