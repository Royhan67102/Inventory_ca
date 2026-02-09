<?php $__env->startSection('title','Pickup'); ?>
<?php $__env->startSection('page-title','Pickup'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <table class="table table-bordered align-middle">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pickups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pickup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($pickup->order->invoice_number ?? '-'); ?></td>
                    <td><?php echo e($pickup->order->customer->nama ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="badge
                            <?php echo e($pickup->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark'); ?>">
                            <?php echo e(ucfirst($pickup->status)); ?>

                        </span>
                    </td>

                    
                    
                        <td class="text-center">

                            <a href="<?php echo e(route('pickup.show',$pickup->id)); ?>"
                                class="btn btn-primary btn-sm">
                                Detail
                            </a>

                            
                            <?php if($pickup->status !== 'selesai'): ?>
                                <a href="<?php echo e(route('pickup.edit',$pickup->id)); ?>"
                                   class="btn btn-warning btn-sm">
                                   Update
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>
                                    Locked
                                </button>
                            <?php endif; ?>

                            
                            <a href="<?php echo e(route('orders.show',$pickup->order_id)); ?>"
                               class="btn btn-info btn-sm">
                               Order
                            </a>

                        </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">
                        Belum ada pickup
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/pickups/index.blade.php ENDPATH**/ ?>