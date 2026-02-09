<?php $__env->startSection('title','Delivery'); ?>
<?php $__env->startSection('page-title','Delivery'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="text-center">
                <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Driver</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $deliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($delivery->order->invoice_number ?? '-'); ?></td>
                <td><?php echo e($delivery->order->customer->nama ?? '-'); ?></td>
                <td><?php echo e($delivery->driver ?? '-'); ?></td>
                <td class="text-center">
                    <span class="badge bg-info">
                        <?php echo e(ucfirst($delivery->status)); ?>

                    </span>
                </td>
                
                        <td class="text-center">

                            <a href="<?php echo e(route('delivery.show',$delivery->id)); ?>"
                                class="btn btn-primary btn-sm">
                                Detail
                            </a>

                            
                            <?php if($delivery->status !== 'selesai'): ?>
                                <a href="<?php echo e(route('delivery.edit',$delivery->id)); ?>"
                                   class="btn btn-warning btn-sm">
                                   Update
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>
                                    Locked
                                </button>
                            <?php endif; ?>

                            
                            <a href="<?php echo e(route('orders.show',$delivery->order_id)); ?>"
                               class="btn btn-info btn-sm">
                               Order
                            </a>

                        </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="text-center">
                    Belum ada delivery
                </td>
            </tr>
        <?php endif; ?>
        </tbody>

        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/index.blade.php ENDPATH**/ ?>