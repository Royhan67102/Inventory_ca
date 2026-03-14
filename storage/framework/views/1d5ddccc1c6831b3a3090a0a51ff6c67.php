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
    white-space: nowrap;
    font-size: 14px;
}

.delivery-table thead th {
    background: #f9fafb;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
}

.delivery-table tbody td {
    vertical-align: middle;
}

/* Status */
.status-badge {
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
}

/* Responsive font */
@media (max-width: 768px) {
    .delivery-table {
        font-size: 13px;
    }
}
</style>

<?php $__env->startSection('content'); ?>
<div class="delivery-card">

<div class="table-responsive">
<table class="table table-bordered table-hover align-middle delivery-table">
    <thead>
        <tr>
            <th width="50">#</th>
            <th>Invoice</th>
            <th>Customer</th>
            <th>Driver</th>
            <th>Status</th>
            <th width="120">Detail</th>
            <th width="80">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $deliveries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $delivery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td class="text-center">
                <?php echo e($loop->iteration); ?>

            </td>

            <td>
                <?php echo e($delivery->order->invoice_number ?? '-'); ?>

            </td>

            <td>
                <?php echo e($delivery->order->produk_name ?? '-'); ?>

            </td>

            <td>
                <?php echo e($delivery->order->customer->nama ?? '-'); ?>

            </td>

            <td>
                <?php echo e($delivery->driver ?? '-'); ?>

            </td>

            <td class="text-center">
                <span class="badge status-badge bg-info">
                    <?php echo e(ucfirst($delivery->status)); ?>

                </span>
            </td>

            
            <td class="text-center">
                <a href="<?php echo e(route('delivery.show',$delivery->id)); ?>"
                   class="btn btn-primary btn-sm">
                   Detail
                </a>
            </td>

            
            <td class="text-center">
                <div class="dropdown">
                    <button class="btn btn-light btn-sm dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown">
                        Aksi
                    </button>

                    <ul class="dropdown-menu">

                        <?php if($delivery->status !== 'selesai'): ?>
                        <li>
                            <a class="dropdown-item"
                               href="<?php echo e(route('delivery.edit',$delivery->id)); ?>">
                               Update
                            </a>
                        </li>
                        <?php endif; ?>

                        <li>
                            <a class="dropdown-item"
                               href="<?php echo e(route('delivery.suratjln.preview',$delivery->id)); ?>">
                               Surat Jalan
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="<?php echo e(route('orders.show',$delivery->order_id)); ?>">
                               Lihat Order
                            </a>
                        </li>

                    </ul>
                </div>
            </td>

        </tr>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="7" class="text-center">
                Belum ada delivery
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<div class="mt-3">
    <?php echo e($deliveries->appends(request()->query())->links()); ?>

</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/delivery/index.blade.php ENDPATH**/ ?>