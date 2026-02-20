<?php $__env->startSection('title','Delivery'); ?>
<?php $__env->startSection('page-title','Delivery'); ?>

<style>
.delivery-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* Table */
.delivery-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.delivery-table thead th {
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    text-align: center;
    font-size: 14px;
}

.delivery-table tbody td {
    border: 1px solid #e5e7eb;
    font-size: 14px;
    vertical-align: middle;
}

/* Status Badge */
.status-badge {
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    justify-content: center;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .delivery-table thead {
        display: none;
    }

    .delivery-table, 
    .delivery-table tbody, 
    .delivery-table tr, 
    .delivery-table td {
        display: block;
        width: 100%;
    }

    .delivery-table tr {
        margin-bottom: 12px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px;
        background: #fff;
    }

    .delivery-table td {
        border: none;
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
    }

    .delivery-table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #6b7280;
    }

    .action-buttons {
        justify-content: flex-start;
    }
}
</style>

<?php $__env->startSection('content'); ?>
<div class="delivery-card">
<table class="delivery-table align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Driver</th>
            <th>Status</th>
            <th width="200">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $deliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td data-label="#"> <?php echo e($loop->iteration); ?> </td>
            <td data-label="Invoice"> <?php echo e($delivery->order->invoice_number ?? '-'); ?> </td>
            <td data-label="Customer"> <?php echo e($delivery->order->customer->nama ?? '-'); ?> </td>
            <td data-label="Driver"> <?php echo e($delivery->driver ?? '-'); ?> </td>

            <td data-label="Status" class="text-center">
                <span class="badge status-badge bg-info">
                    <?php echo e(ucfirst($delivery->status)); ?>

                </span>
            </td>

            <td data-label="Aksi">
                <div class="action-buttons">

                    <a href="<?php echo e(route('delivery.show',$delivery->id)); ?>"
                       class="btn btn-primary btn-sm">
                       Detail
                    </a>

                    <?php if($delivery->status !== 'selesai'): ?>
                        <a href="<?php echo e(route('delivery.edit',$delivery->id)); ?>"
                           class="btn btn-warning btn-sm">
                           Update
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary btn-sm" disabled>
                            Locked
                        </button>
                    <?php endif; ?>

                    <a href="<?php echo e(route('delivery.suratjln.preview',$delivery->id)); ?>"
                       class="btn btn-success btn-sm">
                       Surat Jalan
                    </a>

                    <a href="<?php echo e(route('orders.show',$delivery->order_id)); ?>"
                       class="btn btn-info btn-sm">
                       Order
                    </a>

                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="6" class="text-center">
                Belum ada delivery
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/index.blade.php ENDPATH**/ ?>