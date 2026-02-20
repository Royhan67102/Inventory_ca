<?php $__env->startSection('title', 'Detail Delivery'); ?>
<?php $__env->startSection('page-title', 'Detail Delivery'); ?>

<?php $__env->startSection('content'); ?>

<style>
/* Card Responsive */
.delivery-card {
    border-radius: 12px;
    overflow: hidden;
}

/* Table Styling */
.delivery-table {
    width: 100%;
    border-collapse: collapse;
}

.delivery-table th,
.delivery-table td {
    border: 1px solid #dee2e6;
    padding: 12px;
    vertical-align: middle;
}

.delivery-table th {
    background: #f8f9fa;
    width: 35%;
    font-weight: 600;
}

/* Responsive Mode */
@media(max-width:768px){

    .delivery-table,
    .delivery-table tbody,
    .delivery-table tr,
    .delivery-table td,
    .delivery-table th {
        display: block;
        width: 100%;
    }

    .delivery-table tr {
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .delivery-table th {
        background: #f1f3f5;
        border-bottom: none;
    }

    .delivery-table td {
        border-top: none;
    }
}

/* Image preview */
.delivery-img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}
</style>

<div class="card delivery-card">

    <div class="card-header bg-light">
        <h5 class="mb-0">
            Delivery - Invoice <?php echo e($delivery->order->invoice_number); ?>

        </h5>
    </div>

    <div class="card-body">

        <table class="delivery-table">
            <tr>
                <th>Customer</th>
                <td><?php echo e($delivery->order->customer->nama ?? '-'); ?></td>
            </tr>

            <tr>
                <th>Driver</th>
                <td><?php echo e($delivery->driver ?? '-'); ?></td>
            </tr>

            <tr>
                <th>Tanggal Kirim</th>
                <td><?php echo e(optional($delivery->tanggal_kirim)->format('d/m/Y')); ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-info">
                        <?php echo e(ucfirst($delivery->status)); ?>

                    </span>
                </td>
            </tr>

            <tr>
                <th>Bukti Foto</th>
                <td>
                    <?php if($delivery->bukti_foto): ?>
                        <a href="<?php echo e(asset('storage/'.$delivery->bukti_foto)); ?>" target="_blank">
                            <img src="<?php echo e(asset('storage/'.$delivery->bukti_foto)); ?>"
                                 class="delivery-img"
                                 alt="Bukti Foto">
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <div class="mt-3 text-end">
            <a href="<?php echo e(route('delivery.index')); ?>"
               class="btn btn-secondary">
               Kembali
            </a>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/show.blade.php ENDPATH**/ ?>