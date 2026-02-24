<?php $__env->startSection('title', 'Detail Inventory'); ?>
<?php $__env->startSection('page-title', 'Detail Inventory'); ?>

<?php $__env->startSection('content'); ?>

<style>
/* Card Styling */
.inventory-card {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
}

/* Input Styling */
.form-control, .form-select {
    border: 1px solid #ced4da !important;
    border-radius: 8px;
    padding: 10px;
    transition: 0.2s;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd !important;
    box-shadow: 0 0 0 0.15rem rgba(13,110,253,.15);
}

/* Badge */
.stock-badge {
    font-size: 14px;
    padding: 6px 10px;
    border-radius: 8px;
}

/* Responsive Table */
.table-responsive {
    overflow-x: auto;
}

/* Mobile Layout */
@media (max-width: 768px) {
    .inventory-info p {
        font-size: 14px;
        margin-bottom: 6px;
    }
}
</style>


<div class="mb-3">
    <a href="<?php echo e(route('inventories.index')); ?>" class="btn btn-secondary">
        ← Kembali ke Data Inventory
    </a>
</div>

<div class="row g-3">

    
    <div class="col-lg-4 col-md-5">

        
        <div class="card shadow-sm inventory-card mb-3">
            <div class="card-body inventory-info">
                <h6 class="mb-3">Informasi Barang</h6>
                <p><b>Nama:</b> <?php echo e($inventory->nama_barang); ?></p>
                <p><b>Jenis:</b> <?php echo e($inventory->jenis_barang); ?></p>
                <p>
                    <b>Stok:</b>
                    <span class="badge bg-success stock-badge">
                        <?php echo e($inventory->jumlah); ?>

                    </span>
                </p>
                <p><b>Kondisi:</b> <?php echo e($inventory->kondisi ?? '-'); ?></p>
            </div>
        </div>

        
        <div class="card shadow-sm inventory-card">
            <div class="card-body">
                <h6 class="mb-3">Update Stok</h6>

                <form method="POST" action="<?php echo e(route('inventories.updateStock', $inventory->id)); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="mb-2">
                        <select name="tipe" class="form-select">
                            <option value="masuk">Stok Masuk</option>
                            <option value="keluar">Stok Keluar</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <input type="number" 
                               name="jumlah" 
                               class="form-control" 
                               placeholder="Jumlah" 
                               required>
                    </div>

                    <div class="mb-3">
                        <input type="text" 
                               name="keterangan" 
                               class="form-control" 
                               placeholder="Keterangan">
                    </div>

                    <button class="btn btn-primary w-100">
                        Simpan
                    </button>
                </form>
            </div>
        </div>

    </div>

    
    <div class="col-lg-8 col-md-7">

        <div class="card shadow-sm inventory-card">
            <div class="card-body">
                <h6 class="mb-3">Riwayat Stok</h6>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $inventory->histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($row->tanggal); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($row->tipe == 'masuk' ? 'success' : 'danger'); ?>">
                                        <?php echo e(strtoupper($row->tipe)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($row->jumlah); ?></td>
                                <td><?php echo e($row->keterangan ?? '-'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    Belum ada riwayat stok
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/inventories/show.blade.php ENDPATH**/ ?>