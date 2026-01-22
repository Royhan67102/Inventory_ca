<?php $__env->startSection('title', 'Invoice'); ?>
<?php $__env->startSection('page-title', 'Invoice'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm">
    <div class="card-body">

        
        <div class="d-flex justify-content-between mb-4">
            <div>
                <p><strong>Nama Pemesan</strong> : <?php echo e($order->customer->nama); ?></p>
                <p><strong>Nama Penerima</strong> : Cahaya Akrilik</p>
                <p><strong>Tanggal Pemesanan</strong> : <?php echo e($order->tanggal_pemesanan->format('d F Y')); ?></p>
                <p><strong>No Rekening</strong> : BCA A/N Mahmud</p>
            </div>
            <div class="text-end">
                <h4 class="fw-bold">INVOICE</h4>
                <p><strong>No Invoice</strong><br><?php echo e($order->invoice_number); ?></p>
            </div>
        </div>

        
        <table class="table table-bordered">
            <thead class="table-light text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Keterangan</th>
                    <th width="10%">QTY</th>
                    <th width="15%">Harga</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($i + 1); ?></td>
                    <td>
                        <?php echo e(strtoupper($item->product_name)); ?>

                        <?php echo e($item->panjang_cm); ?> x <?php echo e($item->lebar_cm); ?> CM
                    </td>
                    <td class="text-center"><?php echo e($item->qty); ?> SET</td>
                    <td class="text-end">
                        Rp <?php echo e(number_format($item->harga_per_m2,0,',','.')); ?>

                    </td>
                    <td class="text-end">
                        Rp <?php echo e(number_format($item->subtotal,0,',','.')); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        
        <div class="row mt-3">
            <div class="col-md-6">
                <p class="fw-bold">TOTAL SISA PEMBAYARAN</p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>TOTAL :</strong> Rp <?php echo e(number_format($order->total_harga,0,',','.')); ?></p>
                <p><strong>DP :</strong> Rp 0</p>
                <p><strong>SISA :</strong> Rp <?php echo e(number_format($order->total_harga,0,',','.')); ?></p>
            </div>
        </div>

        
        <p class="mt-3">
            Kami tidak menerima selain pembayaran atau transaksi ke No rekening yang tertera.
        </p>

        
        <div class="row mt-5">
            <div class="col text-end">
                <p>Penerima</p>
                <br><br>
                <p><strong>Mahmud</strong></p>
            </div>
        </div>

        
        <div class="mt-4 d-flex gap-2">
            <a href="<?php echo e(route('orders.invoice.download', $order)); ?>" class="btn btn-success">
                Download PDF
            </a>
            <button onclick="window.print()" class="btn btn-secondary">
                Print
            </button>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\inventory_ca\resources\views/orders/invoice.blade.php ENDPATH**/ ?>