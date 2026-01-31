<?php $__env->startSection('content'); ?>
<div class="container">
    <h3 class="mb-4">Daftar Pickup Order</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Order</th>
                        <th>Customer</th>
                        <th>Status Pickup</th>
                        <th>Bukti</th>
                        <th>Catatan</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pickups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pickup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td>#<?php echo e($pickup->order->id); ?></td>
                            <td><?php echo e($pickup->order->customer->nama ?? '-'); ?></td>

                            <td>
                                <?php if($pickup->status == 'menunggu'): ?>
                                    <span class="badge bg-secondary">Menunggu</span>
                                <?php elseif($pickup->status == 'siap'): ?>
                                    <span class="badge bg-warning text-dark">Siap Diambil</span>
                                <?php elseif($pickup->status == 'diambil'): ?>
                                    <span class="badge bg-success">Sudah Diambil</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if($pickup->bukti): ?>
                                    <a href="<?php echo e(asset('storage/'.$pickup->bukti)); ?>"
                                       target="_blank">
                                        Lihat Bukti
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td><?php echo e($pickup->catatan ?? '-'); ?></td>

                            <td>
                                <a href="<?php echo e(route('pickup.edit', $pickup->order->id)); ?>"
                                   class="btn btn-sm btn-primary">
                                    Update
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center">
                                Belum ada data pickup
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/pickups/index.blade.php ENDPATH**/ ?>