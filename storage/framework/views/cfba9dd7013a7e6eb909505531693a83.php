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

.table-responsive-card {
    border: 1px solid #dee2e6;
    border-radius: 10px;
    padding: 10px;
    background: white;
}

@media(max-width:768px){

    .desktop-table {
        display: none;
    }

    .mobile-card {
        display: block;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 12px;
        background: #fff;
    }

}

@media(min-width:769px){
    .mobile-card {
        display: none;
    }
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

<div class="table-responsive desktop-table">
<table class="table align-middle">
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


<?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="mobile-card">
    <div class="table-box mb-2"><b>Nama:</b> <?php echo e($item->nama_barang); ?></div>
    <div class="table-box mb-2"><b>Jenis:</b> <?php echo e($item->jenis_barang); ?></div>
    <div class="table-box mb-2"><b>PIC:</b> <?php echo e($item->pic_barang ?? '-'); ?></div>
    <div class="table-box mb-2">
        <b>Stok:</b>
        <span class="badge bg-<?php echo e($item->jumlah > 0 ? 'success' : 'danger'); ?>">
            <?php echo e($item->jumlah); ?>

        </span>
    </div>
    <div class="table-box mb-2"><b>Kondisi:</b> <?php echo e($item->kondisi ?? '-'); ?></div>

    <div class="d-flex gap-2 mt-2 flex-wrap">
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
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/inventories/index.blade.php ENDPATH**/ ?>