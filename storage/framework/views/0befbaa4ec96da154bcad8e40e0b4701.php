<?php $__env->startSection('title', 'Daftar Desain'); ?>
<?php $__env->startSection('page-title', 'Daftar Desain'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Daftar Desain</h5>
            </div>
            <div class="card-body">
                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama Customer</th>
                            <th>Status Desain</th>
                            <th>Designer</th>
                            <th>Catatan</th>
                            <th>File Awal</th>
                            <th>File Hasil</th>
                            <th>Deadline</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $designs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $design): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>

                                
                            <td>
                            <?php echo e($design->order->invoice_number ?? '-'); ?>

                            </td>

                        
                            <td>
                                <?php echo e($design->order->customer->nama ?? '-'); ?>

                            </td>

                        
                            <td>
                                <span class="badge
                                    <?php if($design->status === 'menunggu'): ?> bg-warning
                                    <?php elseif($design->status === 'proses'): ?> bg-info
                                    <?php elseif($design->status === 'selesai'): ?> bg-success
                                    <?php endif; ?>
                                ">
                                <?php echo e(ucfirst($design->status)); ?>

                            </span>
                        </td>

                        
                        <td><?php echo e($design->designer ?? '-'); ?></td>

                        
                        <td><?php echo e($design->catatan ?? '-'); ?></td>

                        
                        <td class="text-center">
                            <?php if($design->file_awal): ?>
                                <a href="<?php echo e(asset('storage/'.$design->file_awal)); ?>"
                                target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                    Lihat
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        
                        <td class="text-center">
                            <?php if($design->file_hasil): ?>
                                <a href="<?php echo e(asset('storage/'.$design->file_hasil)); ?>"
                                target="_blank"
                                class="btn btn-sm btn-outline-success">
                                    Lihat
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>

                        
                        <td>
                            <?php echo e($design->order->deadline
                                ? $design->order->deadline->format('d/m/Y')
                                : '-'); ?>

                        </td>

                        
                        <td class="text-nowrap">
                            <a href="<?php echo e(route('designs.show',$design->id)); ?>"
                                class="btn btn-primary btn-sm">
                                Detail
                            </a>

                            <a href="<?php echo e(route('designs.edit', $design->id)); ?>"
                            class="btn btn-sm btn-warning">
                                Update
                            </a>

                            <a href="<?php echo e(route('orders.show', $design->order_id)); ?>"
                            class="btn btn-sm btn-info">
                                Order
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="10" class="text-center text-muted">
                            Belum ada data desain
                        </td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>

                
                <div class="d-flex justify-content-center">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/designs/index.blade.php ENDPATH**/ ?>