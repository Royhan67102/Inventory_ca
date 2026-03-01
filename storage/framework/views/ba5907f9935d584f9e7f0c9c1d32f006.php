<?php $__env->startSection('title', 'Daftar Production'); ?>
<?php $__env->startSection('page-title', 'Daftar Production'); ?>


<style>
    /* =========================
   CARD
========================= */
.card {
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    overflow: hidden;
}

.card-header {
    background: #f8f9fa;
    padding: 16px 20px;
    font-weight: 600;
    border-bottom: 1px solid #e5e7eb;
}

.card-body {
    padding: 24px;
}

/* =========================
   TABLE STYLE
========================= */

.table {
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 0;
}

.table thead th {
    background: #f1f3f5;
    font-weight: 600;
    font-size: 14px;
    text-align: center;
    vertical-align: middle;
}

.table tbody td {
    vertical-align: middle;
    font-size: 14px;
    padding: 12px;
}

/* Zebra lebih soft */
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #fafafa;
}

/* Hover effect */
.table tbody tr:hover {
    background: #f5f7fa;
    transition: 0.2s ease;
}

/* =========================
   BADGE
========================= */

.badge {
    padding: 6px 10px;
    font-size: 12px;
    border-radius: 6px;
}

/* =========================
   BUTTON
========================= */

.btn-sm {
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 12px;
    margin: 2px;
}

/* =========================
   ALERT
========================= */

.alert {
    border-radius: 10px;
}

/* =========================
   MOBILE RESPONSIVE
========================= */

@media (max-width: 768px) {

    .card-body {
        padding: 18px;
    }

    .table thead {
        display: none;
    }

    .table tbody tr {
        display: block;
        background: #fff;
        margin-bottom: 14px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 10px;
    }

    .table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-align: right;
        padding: 8px 10px;
        border: none;
        border-bottom: 1px dashed #eee;
        font-size: 13px;
    }

    .table tbody td:last-child {
        border-bottom: none;
    }

    /* Label otomatis */
    .table tbody td:nth-child(1)::before { content: "#"; }
    .table tbody td:nth-child(2)::before { content: "Invoice"; }
    .table tbody td:nth-child(3)::before { content: "Customer"; }
    .table tbody td:nth-child(4)::before { content: "Tim"; }
    .table tbody td:nth-child(5)::before { content: "Bukti"; }
    .table tbody td:nth-child(6)::before { content: "Deadline"; }
    .table tbody td:nth-child(7)::before { content: "Status"; }
    .table tbody td:nth-child(8)::before { content: "Aksi"; }

    .table tbody td::before {
        font-weight: 600;
        text-align: left;
        color: #555;
    }

    /* Tombol aksi full width */
    .table tbody td:last-child {
        flex-direction: column;
        gap: 6px;
        align-items: stretch;
    }

    .table tbody td:last-child .btn {
        width: 100%;
    }
}

/* EXTRA SMALL DEVICE */
@media (max-width: 480px) {

    .btn-sm {
        font-size: 11px;
        padding: 5px 8px;
    }

    .badge {
        font-size: 11px;
    }

}
</style>
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
        <div class="mt-3">
            <?php echo e($productions->appends(request()->query())->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/index.blade.php ENDPATH**/ ?>