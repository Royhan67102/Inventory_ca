<?php $__env->startSection('content'); ?>
<div class="container">

    <h4 class="mb-3">Antrian Produksi (SPK)</h4>

    
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="row">

                    <div class="col-md-4">
                        <input type="text"
                               name="search"
                               value="<?php echo e(request('search')); ?>"
                               class="form-control"
                               placeholder="Cari Order / Customer">
                    </div>

                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="menunggu"
                                <?php echo e(request('status')=='menunggu'?'selected':''); ?>>
                                Menunggu
                            </option>
                            <option value="proses"
                                <?php echo e(request('status')=='proses'?'selected':''); ?>>
                                Proses
                            </option>
                            <option value="selesai"
                                <?php echo e(request('status')=='selesai'?'selected':''); ?>>
                                Selesai
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            Filter
                        </button>
                    </div>

                    <div class="col-md-2">
                        <a href="<?php echo e(route('productions.index')); ?>"
                           class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Tim</th>
                        <th>Status</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $productions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($i + 1); ?></td>

                        <td>#<?php echo e($p->order->id); ?></td>

                        <td><?php echo e($p->order->customer->nama ?? '-'); ?></td>

                        <td><?php echo e($p->tim_produksi ?? '-'); ?></td>

                        <td>
                            <?php if($p->status=='menunggu'): ?>
                                <span class="badge bg-secondary">Menunggu</span>
                            <?php elseif($p->status=='proses'): ?>
                                <span class="badge bg-warning text-dark">Proses</span>
                            <?php else: ?>
                                <span class="badge bg-success">Selesai</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php echo e(optional($p->tanggal_mulai)->format('d-m H:i')); ?>

                        </td>

                        <td>
                            <?php echo e(optional($p->tanggal_selesai)->format('d-m H:i')); ?>

                        </td>

                        <td>
                            <a href="<?php echo e(route('productions.show',$p)); ?>"
                               class="btn btn-sm btn-info">
                                Detail
                            </a>

                            <?php if(!$p->status_lock): ?>
                                <a href="<?php echo e(route('productions.edit',$p)); ?>"
                                   class="btn btn-sm btn-primary">
                                    Update
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Tidak ada data produksi
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