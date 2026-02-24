<?php $__env->startSection('title', 'Edit Inventory'); ?>
<?php $__env->startSection('page-title', 'Edit Inventory'); ?>

<?php $__env->startSection('content'); ?>

<style>
.form-box {
    border: 1px solid #dee2e6;
    padding: 12px;
    border-radius: 8px;
    background: #fafafa;
}

.form-label {
    font-weight: 600;
    margin-bottom: 4px;
}

@media(max-width:768px){
    .form-box {
        padding: 10px;
    }
}
</style>

<div class="card shadow-sm">
<div class="card-body">

<form action="<?php echo e(route('inventories.update', $inventory->id)); ?>" method="POST">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="row">

<div class="col-lg-6 col-md-6 col-12 mb-3">
    <div class="form-box">
        <label class="form-label">Nama Barang</label>
        <input
            type="text"
            name="nama_barang"
            class="form-control border"
            value="<?php echo e(old('nama_barang', $inventory->nama_barang)); ?>"
            required>
    </div>
</div>

<div class="col-lg-6 col-md-6 col-12 mb-3">
    <div class="form-box">
        <label class="form-label">Jenis Barang</label>
        <input
            type="text"
            name="jenis_barang"
            class="form-control border"
            value="<?php echo e(old('jenis_barang', $inventory->jenis_barang)); ?>"
            required>
    </div>
</div>

<div class="col-lg-4 col-md-6 col-12 mb-3">
    <div class="form-box">
        <label class="form-label">PIC Barang</label>
        <input
            type="text"
            name="pic_barang"
            class="form-control border"
            value="<?php echo e(old('pic_barang', $inventory->pic_barang)); ?>">
    </div>
</div>

<div class="col-lg-4 col-md-6 col-12 mb-3">
    <div class="form-box">
        <label class="form-label">Kondisi</label>
        <input
            type="text"
            name="kondisi"
            class="form-control border"
            value="<?php echo e(old('kondisi', $inventory->kondisi)); ?>">
    </div>
</div>

<div class="col-lg-4 col-md-12 col-12 mb-3">
    <div class="form-box">
        <label class="form-label">Stok Saat Ini</label>
        <input
            type="number"
            name="jumlah"
            class="form-control border"
            value="<?php echo e(old('jumlah', $inventory->jumlah)); ?>"
            min="0">
    </div>
</div>

<div class="col-12 mb-3">
    <div class="form-box">
        <label class="form-label">Deskripsi</label>
        <textarea
            name="deskripsi"
            class="form-control border"
            rows="3"><?php echo e(old('deskripsi', $inventory->deskripsi)); ?></textarea>
    </div>
</div>

</div>

<div class="d-flex flex-wrap justify-content-between gap-2 mt-3">
    <a href="<?php echo e(route('inventories.index')); ?>" class="btn btn-secondary">
        Kembali
    </a>

    <button type="submit" class="btn btn-primary">
        Simpan Perubahan
    </button>
</div>

</form>

</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/inventories/edit.blade.php ENDPATH**/ ?>