<?php $__env->startSection('title', 'Detail Desain'); ?>
<?php $__env->startSection('page-title', 'Detail Desain'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Detail Desain - Order #<?php echo e($design->order_id); ?></h5>
                <a href="<?php echo e(route('designs.index')); ?>" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card-body">

                
                <h6 class="fw-bold">Info Order</h6>
                <table class="table table-borderless table-sm mb-3">
                    <tr>
                        <th>Order ID</th>
                        <td><?php echo e($design->order_id); ?></td>
                    </tr>
                    <tr>
                        <th>Nama Customer</th>
                        <td><?php echo e($design->order?->customer?->nama ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td><?php echo e(ucfirst($design->order?->kategori ?? '-')); ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Order</th>
                        <td><?php echo e($design->order?->created_at?->format('d/m/Y H:i') ?? '-'); ?></td>
                    </tr>
                </table>

                
                <h6 class="fw-bold">Info Desain</h6>
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge
                                <?php if($design->status == 'menunggu'): ?> bg-warning
                                <?php elseif($design->status == 'proses'): ?> bg-info
                                <?php elseif($design->status == 'selesai'): ?> bg-success
                                <?php endif; ?>">
                                <?php echo e(ucfirst($design->status)); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Designer</th>
                        <td><?php echo e($design->designer ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td><?php echo e($design->catatan ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <th>File Awal</th>
                        <td>
                            <?php if($design->file_awal): ?>
                                <a href="<?php echo e(asset('storage/' . $design->file_awal)); ?>" target="_blank">Lihat File</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>File Hasil</th>
                        <td>
                            <?php if($design->file_hasil): ?>
                                <a href="<?php echo e(asset('storage/' . $design->file_hasil)); ?>" target="_blank">Lihat File</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td><?php echo e($design->created_at?->format('d/m/Y H:i') ?? '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Terakhir Diperbarui</th>
                        <td><?php echo e($design->updated_at?->format('d/m/Y H:i') ?? '-'); ?></td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/designs/show.blade.php ENDPATH**/ ?>