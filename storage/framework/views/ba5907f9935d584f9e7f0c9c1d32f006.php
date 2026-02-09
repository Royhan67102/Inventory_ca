<?php $__env->startSection('title', 'Daftar Production'); ?>
<?php $__env->startSection('page-title', 'Daftar Production'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5>Daftar Production</h5>
    </div>

    <div class="card-body">

        
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="text-center">
                    <tr>
                        <th>#</th>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Tim</th>
                        <th>Bukti</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th width="170">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $productions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $production): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

                    <tr>
                        <td class="text-center">
                            <?php echo e($loop->iteration); ?>

                        </td>

                        
                        <td>
                            <?php echo e($production->order->invoice_number ?? '-'); ?>

                        </td>

                        
                        <td>
                            <?php echo e($production->order->customer->nama ?? '-'); ?>

                        </td>

                        
                        <td>
                            <?php echo e($production->tim_produksi ?? '-'); ?>

                        </td>

                        
                        <td class="text-center">
                            <?php if($production->bukti): ?>
                                <a href="<?php echo e(asset('storage/'.$production->bukti)); ?>"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                   Lihat
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        
                        <td class="text-center">
                            <?php echo e(optional($production->order->deadline)->format('d/m/Y') ?? '-'); ?>

                        </td>

                        
                        <td class="text-center">
                            <span class="badge
                                <?php if($production->status == 'menunggu'): ?> bg-warning text-dark
                                <?php elseif($production->status == 'proses'): ?> bg-info
                                <?php elseif($production->status == 'selesai'): ?> bg-success
                                <?php endif; ?>">
                                <?php echo e(ucfirst($production->status)); ?>

                            </span>
                        </td>

                        
                        <td class="text-center">

                            <a href="<?php echo e(route('productions.show',$production->id)); ?>"
                                class="btn btn-primary btn-sm">
                                Detail
                            </a>

                            
                            <?php if($production->status !== 'selesai'): ?>
                                <a href="<?php echo e(route('productions.edit',$production->id)); ?>"
                                   class="btn btn-warning btn-sm">
                                   Update
                                </a>
                            <?php else: ?>
                                <button class="btn btn-secondary btn-sm" disabled>
                                    Locked
                                </button>
                            <?php endif; ?>

                            
                            <a href="<?php echo e(route('orders.show',$production->order_id)); ?>"
                               class="btn btn-info btn-sm">
                               Order
                            </a>

                        </td>
                    </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Belum ada data production
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/index.blade.php ENDPATH**/ ?>