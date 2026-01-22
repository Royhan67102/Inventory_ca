<?php $__env->startSection('title', 'Edit Inventory'); ?>
<?php $__env->startSection('page-title', 'Edit Inventory'); ?>

<?php $__env->startSection('content'); ?>

<div class="card shadow-sm">
    <div class="card-body">

        <form action="<?php echo e(route('inventories.update', $inventory->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>Nama Barang</label>
                    <input
                        type="text"
                        name="nama_barang"
                        class="form-control"
                        value="<?php echo e(old('nama_barang', $inventory->nama_barang)); ?>"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Barang</label>
                    <input
                        type="text"
                        name="jenis_barang"
                        class="form-control"
                        value="<?php echo e(old('jenis_barang', $inventory->jenis_barang)); ?>"
                        required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>PIC Barang</label>
                    <input
                        type="text"
                        name="pic_barang"
                        class="form-control"
                        value="<?php echo e(old('pic_barang', $inventory->pic_barang)); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Kondisi</label>
                    <input
                        type="text"
                        name="kondisi"
                        class="form-control"
                        value="<?php echo e(old('kondisi', $inventory->kondisi)); ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Stok Saat Ini</label>
                    <input
                        type="text"
                        class="form-control"
                        value="<?php echo e($inventory->jumlah); ?>"
                        readonly>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea
                        name="deskripsi"
                        class="form-control"
                        rows="3"><?php echo e(old('deskripsi', $inventory->deskripsi)); ?></textarea>
                </div>

            </div>

            <div class="d-flex justify-content-between">
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/inventories/edit.blade.php ENDPATH**/ ?>