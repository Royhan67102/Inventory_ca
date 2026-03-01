<?php $__env->startSection('title', 'Inventory'); ?>
<?php $__env->startSection('page-title', 'Data Inventory'); ?>

<?php $__env->startSection('content'); ?>

<style>
.table-box {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 8px;
    background: #fafafa;
    min-height: 55px;
    display: flex;
    align-items: center;
}

.table-wrapper {
    overflow-x: auto;
}

.inventory-table {
    min-width: 900px; /* supaya bisa scroll di HP */
}
</style>

<div class="d-flex flex-wrap justify-content-between mb-3 gap-2">
    <h5>Daftar Inventory</h5>
    <a href="<?php echo e(route('inventories.create')); ?>" class="btn btn-primary">
        + Tambah Inventory
    </a>
</div>

<div class="card shadow-sm">
<div class="card-body">

<div class="table-wrapper">
<table class="table align-middle inventory-table">
    <thead class="table-light">
        <tr>
            <th>Nama Barang</th>
            <th>Jenis Barang</th>
            <th>PIC</th>
            <th>Stok</th>
            <th>Kondisi</th>
            <th width="180">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><div class="table-box"><?php echo e($item->nama_barang); ?></div></td>
            <td><div class="table-box"><?php echo e($item->jenis_barang); ?></div></td>
            <td><div class="table-box"><?php echo e($item->pic_barang ?? '-'); ?></div></td>

            <td>
                <div class="table-box">
                    <span class="badge bg-<?php echo e($item->jumlah > 0 ? 'success' : 'danger'); ?>">
                        <?php echo e($item->jumlah); ?>

                    </span>
                </div>
            </td>

            <td><div class="table-box"><?php echo e($item->kondisi ?? '-'); ?></div></td>

            <td>
                <div class="table-box d-flex gap-1 flex-wrap">
                    <a href="<?php echo e(route('inventories.show', $item->id)); ?>"
                       class="btn btn-sm btn-info">
                        Detail
                    </a>

                    <a href="<?php echo e(route('inventories.edit', $item->id)); ?>"
                       class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form action="<?php echo e(route('inventories.destroy', $item->id)); ?>"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus data ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-sm btn-danger">
                            Hapus
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="6" class="text-center text-muted">
                Belum ada data inventory
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<div class="mt-3">
    <?php echo e($inventories->appends(request()->query())->links()); ?>

</div>

</div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/inventories/index.blade.php ENDPATH**/ ?>