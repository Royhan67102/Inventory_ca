<?php $__env->startSection('title', 'Inventory'); ?>
<?php $__env->startSection('page-title', 'Data Inventory'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between mb-3">
    <h5>Daftar Inventory</h5>
    <a href="<?php echo e(route('inventories.create')); ?>" class="btn btn-primary">
        + Tambah Inventory
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead>
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
                    <td><?php echo e($item->nama_barang); ?></td>
                    <td><?php echo e($item->jenis_barang); ?></td>
                    <td><?php echo e($item->pic_barang ?? '-'); ?></td>
                    <td>
                        <span class="badge bg-<?php echo e($item->jumlah > 0 ? 'success' : 'danger'); ?>">
                            <?php echo e($item->jumlah); ?>

                        </span>
                    </td>
                    <td><?php echo e($item->kondisi ?? '-'); ?></td>
                    <td>
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
                              class="d-inline"
                              onsubmit="return confirm('Yakin hapus data ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">
                        Belum ada data inventory
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/inventories/index.blade.php ENDPATH**/ ?>