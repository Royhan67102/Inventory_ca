<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Pengiriman</h4>
    </div>

    
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('delivery.index')); ?>">
                <div class="row g-2">

                    <div class="col-md-5">
                        <input type="text"
                               name="search"
                               value="<?php echo e(request('search')); ?>"
                               class="form-control"
                               placeholder="Cari invoice / customer">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="menunggu" <?php echo e(request('status')=='menunggu'?'selected':''); ?>>Menunggu</option>
                            <option value="berangkat" <?php echo e(request('status')=='berangkat'?'selected':''); ?>>Berangkat</option>
                            <option value="sampai" <?php echo e(request('status')=='sampai'?'selected':''); ?>>Sampai</option>
                            <option value="selesai" <?php echo e(request('status')=='selesai'?'selected':''); ?>>Selesai</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button class="btn btn-primary">Filter</button>
                        <a href="<?php echo e(route('delivery.index')); ?>" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">No</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th width="140">Tanggal Kirim</th>
                            <th>Driver</th>
                            <th width="120">Status</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $deliveryNotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>

                                <td>
                                    <?php echo e($delivery->order->invoice_number ?? '-'); ?>

                                </td>

                                <td>
                                    <?php echo e($delivery->order->customer->nama ?? '-'); ?>

                                </td>

                                <td>
                                    <?php echo e(optional($delivery->tanggal_kirim)->format('d-m-Y')); ?>

                                </td>

                                <td>
                                    <?php echo e($delivery->driver ?? '-'); ?>

                                </td>

                                <td>
                                    <?php
                                        $color = [
                                            'menunggu' => 'secondary',
                                            'berangkat' => 'primary',
                                            'sampai' => 'warning',
                                            'selesai' => 'success'
                                        ];
                                    ?>

                                    <span class="badge bg-<?php echo e($color[$delivery->status] ?? 'dark'); ?>">
                                        <?php echo e(ucfirst($delivery->status)); ?>

                                    </span>
                                </td>

                                <td>
                                    <a href="<?php echo e(route('delivery.show',$delivery->id)); ?>"
                                       class="btn btn-sm btn-info">
                                       Detail
                                    </a>

                                    <?php if(!$delivery->status_lock): ?>
                                        <a href="<?php echo e(route('delivery.edit',$delivery->id)); ?>"
                                           class="btn btn-sm btn-warning">
                                           Update
                                        </a>
                                    <?php endif; ?>

                                    <?php if($delivery->status_lock): ?>
                                        <a href="<?php echo e(route('delivery.print',$delivery->id)); ?>"
                                           class="btn btn-sm btn-success">
                                           Cetak
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center p-3">
                                    Tidak ada data pengiriman
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/index.blade.php ENDPATH**/ ?>