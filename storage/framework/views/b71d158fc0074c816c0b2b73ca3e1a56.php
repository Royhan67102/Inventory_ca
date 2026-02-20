<?php $__env->startSection('title', 'Tambah Stok Acrylic'); ?>
<?php $__env->startSection('page-title', 'Tambah Stok Acrylic'); ?>

<style>
/* Card Form */
.form-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* Label */
.form-label {
    font-weight: 600;
    margin-bottom: 6px;
    font-size: 14px;
}

/* Input Styling */
.form-control {
    border: 1px solid #d1d5db !important;
    border-radius: 10px !important;
    padding: 10px 12px;
    transition: 0.2s ease;
}

.form-control:focus {
    border-color: #198754 !important;
    box-shadow: 0 0 0 2px rgba(25,135,84,0.15) !important;
}

/* Section Title */
.form-section-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 16px;
}

/* Luas Display */
#luas_total_display {
    background: #f9fafb;
    font-weight: 600;
}

/* Button Responsive */
.form-action {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    flex-wrap: wrap;
}

/* Mobile Optimization */
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

<?php $__env->startSection('content'); ?>
<div class="form-card">
<form action="<?php echo e(route('acrylic-stocks.store')); ?>" method="POST" id="acrylicForm">
    <?php echo csrf_field(); ?>

    <input type="hidden" name="luas_total">
    <input type="hidden" name="luas_tersedia">

    <div class="form-section-title">Informasi Acrylic</div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Merk</label>
            <input type="text" name="merk" class="form-control" required>
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Warna</label>
            <input type="text" name="warna" class="form-control">
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Jenis</label>
            <select name="jenis" class="form-control" required>
                <option value="lembar">Lembar</option>
                <option value="sisa">Sisa</option>
            </select>
        </div>

        <div class="col-lg-6 col-md-6 col-12 mb-3">
            <label class="form-label">Ketebalan (mm)</label>
            <input type="number" step="0.01" name="ketebalan" class="form-control" required>
        </div>
    </div>

    <div class="form-section-title mt-3">Ukuran</div>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-12 mb-3">
            <label class="form-label">Panjang (cm)</label>
            <input type="number" step="0.01" name="panjang" class="form-control" required>
        </div>

        <div class="col-lg-4 col-md-4 col-12 mb-3">
            <label class="form-label">Lebar (cm)</label>
            <input type="number" step="0.01" name="lebar" class="form-control" required>
        </div>

        <div class="col-lg-4 col-md-4 col-12 mb-3">
            <label class="form-label">Jumlah Lembar</label>
            <input type="number" name="jumlah_lembar" class="form-control" min="1" value="1" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Luas Total (m²)</label>
        <input type="text" id="luas_total_display" class="form-control" readonly>
    </div>

    <div class="form-action mt-4">
        <button class="btn btn-success">Simpan</button>
        <a href="<?php echo e(route('acrylic-stocks.index')); ?>" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
</div>

<script>
const panjang = document.querySelector('[name="panjang"]');
const lebar = document.querySelector('[name="lebar"]');
const jumlah = document.querySelector('[name="jumlah_lembar"]');
const luasTotal = document.querySelector('[name="luas_total"]');
const luasTersedia = document.querySelector('[name="luas_tersedia"]');
const display = document.getElementById('luas_total_display');

function hitungLuas() {
    const p = parseFloat(panjang.value) || 0;
    const l = parseFloat(lebar.value) || 0;
    const j = parseInt(jumlah.value) || 1;

    const luasCm2 = p * l * j;
    luasTotal.value = luasCm2;
    luasTersedia.value = luasCm2;
    display.value = (luasCm2 / 10000).toFixed(2);
}

[panjang, lebar, jumlah].forEach(el => el.addEventListener('input', hitungLuas));
hitungLuas();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/acrylicstocks/create.blade.php ENDPATH**/ ?>