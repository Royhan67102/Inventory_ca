<?php $__env->startSection('title','Detail Pickup'); ?>
<?php $__env->startSection('page-title','Detail Pickup'); ?>


<style>
    /* =========================
   DETAIL PICKUP STYLE
========================= */

.card-body {
    overflow-x: auto;
}

/* Table styling biar clean */
.table {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 0;
}

.table th {
    background: #f8f9fa;
    font-weight: 600;
    width: 200px;
}

.table th,
.table td {
    padding: 14px 16px;
    vertical-align: middle;
}

/* Badge lebih modern */
.badge {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 20px;
}

/* Button spacing */
.table .btn {
    padding: 6px 14px;
    font-size: 13px;
    border-radius: 6px;
}

/* =========================
   MOBILE VIEW
========================= */
@media (max-width: 768px) {

    .table {
        font-size: 14px;
    }

    .table th {
        width: 40%;
        font-size: 13px;
    }

    .table td {
        font-size: 13px;
    }

    .table th,
    .table td {
        padding: 10px;
    }

    /* Tombol bukti full width */
    .table .btn {
        display: block;
        width: 100%;
        text-align: center;
    }

}

/* =========================
   EXTRA SMALL DEVICE
========================= */
@media (max-width: 480px) {

    .table th,
    .table td {
        display: block;
        width: 100%;
    }

    .table tr {
        display: block;
        margin-bottom: 10px;
        border-bottom: 1px solid #eee;
    }

    .table th {
        background: transparent;
        padding-bottom: 4px;
        color: #666;
        font-size: 12px;
    }

    .table td {
        padding-top: 0;
        font-size: 14px;
    }

}
</style>
<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body">

        <table class="table table-bordered">
            <tr>
                <th width="200">Invoice</th>
                <td><?php echo e($pickup->order->invoice_number ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Customer</th>
                <td><?php echo e($pickup->order->customer->nama ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge
                        <?php echo e($pickup->status === 'selesai' ? 'bg-success' : 'bg-warning text-dark'); ?>">
                        <?php echo e(ucfirst($pickup->status)); ?>

                    </span>
                </td>
            </tr>
            <tr>
                <th>Catatan</th>
                <td><?php echo e($pickup->catatan ?? '-'); ?></td>
            </tr>
            <tr>
                <th>Bukti</th>
                <td>
                    <?php if($pickup->bukti): ?>
                        <a href="<?php echo e(asset('storage/'.$pickup->bukti)); ?>"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           Lihat Bukti
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <a href="<?php echo e(route('pickup.index')); ?>"
           class="btn btn-secondary mt-3">
           Kembali
        </a>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/pickups/show.blade.php ENDPATH**/ ?>