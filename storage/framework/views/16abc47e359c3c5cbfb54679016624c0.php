<?php $__env->startSection('title', 'Detail Order'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Order</h5>
        <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary btn-sm">
            Kembali
        </a>
    </div>

    <div class="card-body">

        
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Customer:</strong> <?php echo e($order->customer->nama ?? '-'); ?></p>
                <p><strong>Tanggal Pesanan:</strong> <?php echo e($order->tanggal_pemesanan?->format('d M Y')); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Status Pembayaran:</strong>
                    <?php
                        $paymentBadge = match($order->payment_status) {
                            'lunas' => 'success',
                            'dp' => 'warning',
                            default => 'secondary'
                        };
                    ?>
                    <span class="badge bg-<?php echo e($paymentBadge); ?>">
                        <?php echo e(strtoupper($order->payment_status)); ?>

                    </span>
                </p>

                <p><strong>Status Produksi:</strong>
                    <?php if($order->production): ?>
                        <?php
                            $prodBadge = match($order->production->status) {
                                'menunggu' => 'secondary',
                                'proses' => 'warning',
                                'selesai' => 'success',
                                default => 'secondary'
                            };
                        ?>
                        <span class="badge bg-<?php echo e($prodBadge); ?>">
                            <?php echo e(ucfirst($order->production->status)); ?>

                        </span>
                    <?php else: ?>
                        <span class="badge bg-secondary">Belum Diproses</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <hr>

        
        <h6 class="mb-3">Detail Produk</h6>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Ukuran (cm)</th>
                        <th>Qty</th>
                        <th>Harga / m²</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->product_name); ?></td>
                        <td><?php echo e($item->panjang_cm); ?> x <?php echo e($item->lebar_cm); ?> (<?php echo e(number_format($item->hitungLuas(),4)); ?> m²)</td>
                        <td><?php echo e($item->qty); ?></td>
                        <td>Rp <?php echo e(number_format($item->harga_per_m2, 0, ',', '.')); ?></td>
                        <td>Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        
        <div class="text-end mt-3">
            <h5>
                Total Pembayaran :
                <strong>Rp <?php echo e(number_format($order->total_harga, 0, ',', '.')); ?></strong>
            </h5>
        </div>

        
        <div class="mt-4 d-flex gap-2">
            <a href="<?php echo e(route('orders.invoice', $order->id)); ?>" class="btn btn-primary">
                Lihat Invoice
            </a>

            <?php if($order->production): ?>
                <a href="<?php echo e(route('productions.show', $order->production->id)); ?>" class="btn btn-success">
                    Detail Produksi
                </a>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/orders/show.blade.php ENDPATH**/ ?>