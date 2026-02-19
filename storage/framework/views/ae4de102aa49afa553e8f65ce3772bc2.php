<?php $__env->startSection('title', 'Stok Acrylic'); ?>
<?php $__env->startSection('page-title', 'Stok Acrylic'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('acrylic-stocks.create')); ?>" class="btn btn-primary">+ Tambah Stok</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light text-center">
            <tr>
                <th>#</th>
                <th>Merk</th>
                <th>Warna</th>
                <th>Jenis</th>
                <th>Ukuran (P × L)</th>
                <th>Ketebalan</th>
                <th>Luas Total (m²)</th>
                <th>Luas Tersedia (m²)</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="text-center"><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($stock->merk); ?></td>
                <td><?php echo e($stock->warna ?? '-'); ?></td>
                <td class="text-center">
                    <span class="badge bg-<?php echo e($stock->jenis == 'lembar' ? 'primary' : 'secondary'); ?>">
                        <?php echo e(ucfirst($stock->jenis)); ?>

                    </span>
                </td>
                <td class="text-center"><?php echo e($stock->panjang); ?> × <?php echo e($stock->lebar); ?> cm</td>
                <td class="text-center"><?php echo e($stock->ketebalan); ?> mm</td>
                <td class="text-end">
                    <?php echo e(number_format($stock->luas_total / 10000, 2)); ?>

                </td>
                <td class="text-end">
                    <?php echo e(number_format($stock->luas_tersedia / 10000, 2)); ?>

                </td>
                <td class="text-center"><?php echo e($stock->jumlah_lembar); ?></td>
                <td class="text-center">
                    <a href="<?php echo e(route('acrylic-stocks.show', $stock)); ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="<?php echo e(route('acrylic-stocks.edit', $stock)); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form action="<?php echo e(route('acrylic-stocks.destroy', $stock)); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="10" class="text-center text-muted">
                    Belum ada stok acrylic
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/acrylicstocks/index.blade.php ENDPATH**/ ?>