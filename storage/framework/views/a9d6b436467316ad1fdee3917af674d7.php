<?php $__env->startSection('title', 'Detail Inventory'); ?>
<?php $__env->startSection('page-title', 'Detail Inventory'); ?>

<?php $__env->startSection('content'); ?>


<div class="mb-3">
    <a href="<?php echo e(route('inventories.index')); ?>" class="btn btn-secondary">
        ← Kembali ke Data Inventory
    </a>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Informasi Barang</h6>
                <p><b>Nama:</b> <?php echo e($inventory->nama_barang); ?></p>
                <p><b>Jenis:</b> <?php echo e($inventory->jenis_barang); ?></p>
                <p><b>Stok:</b> <?php echo e($inventory->jumlah); ?></p>
                <p><b>Kondisi:</b> <?php echo e($inventory->kondisi); ?></p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Update Stok</h6>
                <form method="POST" action="<?php echo e(route('inventories.updateStock', $inventory->id)); ?>">
                    <?php echo csrf_field(); ?>

                    <select name="tipe" class="form-control mb-2">
                        <option value="masuk">Stok Masuk</option>
                        <option value="keluar">Stok Keluar</option>
                    </select>

                    <input type="number" name="jumlah" class="form-control mb-2" placeholder="Jumlah" required>

                    <input type="text" name="keterangan" class="form-control mb-2" placeholder="Keterangan">

                    <button class="btn btn-primary w-100">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Riwayat Stok</h6>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $inventory->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($row->tanggal); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($row->tipe == 'masuk' ? 'success' : 'danger'); ?>">
                                    <?php echo e(strtoupper($row->tipe)); ?>

                                </span>
                            </td>
                            <td><?php echo e($row->jumlah); ?></td>
                            <td><?php echo e($row->keterangan); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/inventories/show.blade.php ENDPATH**/ ?>