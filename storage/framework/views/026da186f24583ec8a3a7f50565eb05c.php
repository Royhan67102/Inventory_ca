<?php $__env->startSection('title', 'Stok Acrylic'); ?>
<?php $__env->startSection('page-title', 'Stok Acrylic'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('acrylic-stocks.create')); ?>" class="btn btn-primary">+ Tambah Stok</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Merk</th>
            <th>Warna</th>
            <th>Ketebalan (mm)</th>
            <th>Luas Total (m²)</th>
            <th>Luas Tersedia (m²)</th>
            <th>Jumlah Lembar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td><?php echo e($stock->merk); ?></td>
            <td><?php echo e($stock->warna ?? '-'); ?></td>
            <td><?php echo e($stock->ketebalan); ?></td>
            <td><?php echo e($stock->luas_total); ?></td>
            <td><?php echo e($stock->luas_tersedia); ?></td>
            <td><?php echo e($stock->jumlah_lembar); ?></td>
            <td>
                <a href="<?php echo e(route('acrylic_stocks.edit', $stock)); ?>" class="btn btn-warning btn-sm">Edit</a>
                <form action="<?php echo e(route('acrylic-stocks.destroy', $stock)); ?>" method="POST" style="display:inline-block">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/acrylic_stocks/index.blade.php ENDPATH**/ ?>