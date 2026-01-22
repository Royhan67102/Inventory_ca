<?php $__env->startSection('title', 'Daftar Order'); ?>
<?php $__env->startSection('page-title', 'Daftar Order'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">Daftar Order</h6>
        <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-primary btn-sm">+ Order Baru</a>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Produksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td class="text-center"><?php echo e($loop->iteration); ?></td>
                    <td><?php echo e($order->tanggal_pemesanan->format('d M Y')); ?></td>
                    <td><?php echo e($order->customer->nama); ?></td>
                    <td>Rp <?php echo e(number_format($order->total_harga,0,',','.')); ?></td>
                    <td class="text-center">
                        <span class="badge bg-<?php echo e($order->payment_status=='lunas'?'success':($order->payment_status=='dp'?'warning':'secondary')); ?>">
                            <?php echo e(strtoupper($order->payment_status)); ?>

                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-<?php echo e(($order->production?->status ?? '')=='selesai'?'success':'secondary'); ?>">
                            <?php echo e(ucfirst($order->production->status ?? 'menunggu')); ?>

                        </span>
                    </td>
                    <td class="text-center">
                        <a href="<?php echo e(route('orders.show', $order)); ?>" class="btn btn-info btn-sm">
                            Detail
                        </a>

                        <a href="<?php echo e(route('orders.invoice', $order)); ?>" class="btn btn-secondary btn-sm">
                            Invoice
                        </a>

                        <a href="<?php echo e(route('orders.edit', $order)); ?>" class="btn btn-primary btn-sm">
                            Edit
                        </a>

                        
                        <form action="<?php echo e(route('orders.destroy', $order)); ?>"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus order ini?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada order</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/orders/index.blade.php ENDPATH**/ ?>