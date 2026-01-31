<?php $__env->startSection('content'); ?>
<div class="container">

    <h4 class="mb-3">Detail Produksi (SPK)</h4>

    
    <div class="card mb-3">
        <div class="card-body">
            <h5>Informasi Order</h5>

            <div class="row">
                <div class="col-md-4">
                    <b>No Order</b><br>
                    #<?php echo e($production->order->id); ?>

                </div>

                <div class="col-md-4">
                    <b>Customer</b><br>
                    <?php echo e($production->order->customer->nama ?? '-'); ?>

                </div>

                <div class="col-md-4">
                    <b>Status Order</b><br>
                    <?php echo e(ucfirst($production->order->status)); ?>

                </div>
            </div>
        </div>
    </div>

    
    <div class="card mb-3">
        <div class="card-body">
            <h5>Informasi Produksi</h5>

            <div class="row mb-2">
                <div class="col-md-4">
                    <b>Tim Produksi</b><br>
                    <?php echo e($production->tim_produksi ?? '-'); ?>

                </div>

                <div class="col-md-4">
                    <b>Status</b><br>

                    <?php if($production->status == 'menunggu'): ?>
                        <span class="badge bg-secondary">Menunggu</span>
                    <?php elseif($production->status == 'proses'): ?>
                        <span class="badge bg-warning text-dark">Proses</span>
                    <?php else: ?>
                        <span class="badge bg-success">Selesai</span>
                    <?php endif; ?>
                </div>

                <div class="col-md-4">
                    <b>Status Lock</b><br>
                    <?php echo e($production->status_lock ? 'Terkunci' : 'Aktif'); ?>

                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-4">
                    <b>Tanggal Mulai</b><br>
                    <?php echo e(optional($production->tanggal_mulai)->format('d-m-Y H:i')); ?>

                </div>

                <div class="col-md-4">
                    <b>Tanggal Selesai</b><br>
                    <?php echo e(optional($production->tanggal_selesai)->format('d-m-Y H:i')); ?>

                </div>

                <div class="col-md-4">
                    <b>Stok Dipotong</b><br>
                    <?php echo e($production->stok_dipotong ? 'Ya' : 'Belum'); ?>

                </div>
            </div>

            <div>
                <b>Catatan Produksi</b><br>
                <?php echo e($production->catatan ?? '-'); ?>

            </div>
        </div>
    </div>

    
    <div class="card mb-3">
        <div class="card-body">
            <h5>Item Produksi</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Ukuran</th>
                        <th>Qty</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $production->order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>
                        <td><?php echo e($item->nama_produk ?? '-'); ?></td>
                        <td><?php echo e($item->ukuran ?? '-'); ?></td>
                        <td><?php echo e($item->qty); ?></td>
                        <td><?php echo e($item->keterangan ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            Tidak ada item
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>

    
    <div class="card mb-3">
        <div class="card-body">
            <h5>Bukti Produksi</h5>

            <?php if($production->bukti): ?>
                <a href="<?php echo e(asset('storage/'.$production->bukti)); ?>"
                   target="_blank">
                    Lihat Bukti Produksi
                </a>
            <?php else: ?>
                <p>Belum ada bukti produksi.</p>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?php echo e(route('productions.index')); ?>"
       class="btn btn-secondary">
        Kembali
    </a>

    <?php if(!$production->status_lock): ?>
        <a href="<?php echo e(route('productions.edit', $production)); ?>"
           class="btn btn-primary">
            Update Produksi
        </a>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/show.blade.php ENDPATH**/ ?>