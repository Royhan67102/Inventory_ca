<?php $__env->startSection('title', 'Tambah Inventory'); ?>
<?php $__env->startSection('page-title', 'Tambah Inventory'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm">
    <div class="card-body">

        <form method="POST" action="<?php echo e(route('inventories.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jenis Barang</label>
                    <input type="text" name="jenis_barang" class="form-control" required>
                </div>

                <div class="col-md-4 mb-3">
                    <label>Jumlah Awal</label>
                    <input type="number" name="jumlah" class="form-control" value="0">
                </div>

                <div class="col-md-4 mb-3">
                    <label>Kondisi</label>
                    <input type="text" name="kondisi" class="form-control">
                </div>

                <div class="col-md-4 mb-3">
                    <label>PIC Barang</label>
                    <input type="text" name="pic_barang" class="form-control">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>
            </div>

            <button class="btn btn-primary">Simpan</button>
            <a href="<?php echo e(route('inventories.index')); ?>" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/inventories/create.blade.php ENDPATH**/ ?>