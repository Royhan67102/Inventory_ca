<?php $__env->startSection('title', 'Detail Order'); ?>
<?php $__env->startSection('page-title', 'Detail Order'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">


<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-bold">
        Order <?php echo e($order->invoice_number); ?>

    </h5>
    <a href="<?php echo e(route('orders.index')); ?>" class="btn btn-secondary btn-sm">
        ← Kembali
    </a>
</div>

<div class="row">
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="mb-2">
                    <label class="text-muted small">Nama</label>
                    <div><?php echo e($order->customer->nama); ?></div>
                </div>

                <div class="mb-2">
                    <label class="text-muted small">Alamat</label>
                    <div><?php echo e($order->customer->alamat); ?></div>
                </div>

                <div>
                    <label class="text-muted small">Telepon</label>
                    <div><?php echo e($order->customer->telepon); ?></div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Informasi Order</h6>

                <div class="row mb-3">
                    <div class="col">
                        <label class="text-muted small">Tanggal Pemesanan</label>
                        <div><?php echo e($order->tanggal_pemesanan->format('d M Y')); ?></div>
                    </div>
                    <div class="col">
                        <label class="text-muted small">Deadline</label>
                        <div><?php echo e($order->deadline?->format('d M Y') ?? '-'); ?></div>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="text-muted small">Status Pembayaran</label>
                    <div>
                        <span class="badge bg-warning text-dark">
                            <?php echo e(strtoupper(str_replace('_', ' ', $order->payment_status))); ?>

                        </span>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="text-muted small">Status Order</label>
                    <div>
                        <span class="badge bg-info">
                            <?php echo e(strtoupper($order->status)); ?>

                        </span>
                    </div>
                </div>

                <hr>

                
                <div class="mb-3">
                    <label class="text-muted small">Jasa Desain</label>
                    <div>
                        <?php echo e($order->design ? 'Ya' : 'Tidak'); ?>

                    </div>

                    <?php if($order->design && $order->design->file_awal): ?>
                        <a href="<?php echo e(asset('storage/'.$order->design->file_awal)); ?>"
                           target="_blank"
                           class="btn btn-outline-primary btn-sm mt-2">
                            Lihat File Desain
                        </a>
                    <?php endif; ?>
                </div>

                <hr>

                
                <div class="row">
                    <div class="col">
                        <label class="text-muted small">Antar Barang</label>
                        <div>
                            <?php echo e($order->antar_barang ? 'Ya' : 'Tidak'); ?>

                        </div>
                        <?php if($order->antar_barang): ?>
                            <small>Biaya: Rp<?php echo e(number_format($order->biaya_pengiriman,0,',','.')); ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="col">
                        <label class="text-muted small">Jasa Pemasangan</label>
                        <div>
                            <?php echo e($order->jasa_pemasangan ? 'Ya' : 'Tidak'); ?>

                        </div>
                        <?php if($order->jasa_pemasangan): ?>
                            <small>Biaya: Rp<?php echo e(number_format($order->biaya_pemasangan,0,',','.')); ?></small>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($order->catatan): ?>
                <hr>
                <div>
                    <label class="text-muted small">Catatan</label>
                    <div><?php echo e($order->catatan); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold">Item Order</h6>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th>Merk</th>
                        <th>Ketebalan</th>
                        <th>Warna</th>
                        <th>Panjang</th>
                        <th>Lebar</th>
                        <th>Luas (m²)</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $luas = ($item->panjang_cm * $item->lebar_cm) / 10000;
                        $total = $item->harga * $item->qty;
                    ?>
                    <tr>
                        <td><?php echo e($item->product_name); ?></td>
                        <td><?php echo e($item->ketebalan); ?></td>
                        <td><?php echo e($item->warna); ?></td>
                        <td class="text-end"><?php echo e($item->panjang_cm); ?></td>
                        <td class="text-end"><?php echo e($item->lebar_cm); ?></td>
                        <td class="text-end"><?php echo e(number_format($luas,2)); ?></td>
                        <td class="text-center"><?php echo e($item->qty); ?></td>
                        <td class="text-end">
                            Rp<?php echo e(number_format($item->harga,0,',','.')); ?>

                        </td>
                        <td class="text-end">
                            Rp<?php echo e(number_format($total,0,',','.')); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="text-end mb-5">
    <h5>
        Grand Total :
        <strong class="text-success">
            Rp<?php echo e(number_format($order->total_harga,0,',','.')); ?>

        </strong>
    </h5>
</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/show.blade.php ENDPATH**/ ?>