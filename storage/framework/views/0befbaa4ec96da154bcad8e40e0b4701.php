<?php $__env->startSection('title', 'Daftar Desain'); ?>
<?php $__env->startSection('page-title', 'Daftar Desain'); ?>

<?php $__env->startSection('content'); ?>

<style>
.design-table th,
.design-table td {
    border: 1px solid #dee2e6 !important;
    vertical-align: middle;
    white-space: nowrap;
}

/* Supaya text panjang tidak merusak layout */
.design-table td {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive */
.table-responsive-custom {
    width: 100%;
    overflow-x: auto;
}

@media(max-width:768px){

    .design-table th,
    .design-table td {
        font-size: 12px;
        padding: 6px;
    }

    .btn-sm {
        padding: 3px 6px;
        font-size: 11px;
    }

    .action-btn-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
}
</style>

<div class="row">
<div class="col-12">

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="mb-0">Daftar Desain</h5>
</div>

<div class="card-body">

<?php if(session('success')): ?>
<div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<div class="table-responsive-custom">
<table class="table table-bordered design-table">

<thead class="table-light text-center">
<tr>
    <th>#</th>
    <th>Kode</th>
    <th>Customer</th>
    <th>Status</th>
    <th>Designer</th>
    <th>Catatan</th>
    <th>File Awal</th>
    <th>File Hasil</th>
    <th>Deadline</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php $__empty_1 = true; $__currentLoopData = $designs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $design): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr>

<td class="text-center"><?php echo e($loop->iteration); ?></td>

<td class="text-center">
    <?php echo e($design->order->invoice_number ?? '-'); ?>

</td>

<td>
    <?php echo e($design->order->customer->nama ?? '-'); ?>

</td>

<td class="text-center">
    <span class="badge
        <?php if($design->status === 'menunggu'): ?> bg-warning
        <?php elseif($design->status === 'proses'): ?> bg-info
        <?php elseif($design->status === 'selesai'): ?> bg-success
        <?php endif; ?>">
        <?php echo e(ucfirst($design->status)); ?>

    </span>
</td>

<td><?php echo e($design->designer ?? '-'); ?></td>

<td title="<?php echo e($design->catatan); ?>">
    <?php echo e($design->catatan ?? '-'); ?>

</td>

<td class="text-center">
<?php if($design->file_awal): ?>
<a href="<?php echo e(asset('storage/'.$design->file_awal)); ?>"
   target="_blank"
   class="btn btn-outline-primary btn-sm">
   Lihat
</a>
<?php else: ?>
-
<?php endif; ?>
</td>

<td class="text-center">
<?php if($design->file_hasil): ?>
<a href="<?php echo e(asset('storage/'.$design->file_hasil)); ?>"
   target="_blank"
   class="btn btn-outline-success btn-sm">
   Lihat
</a>
<?php else: ?>
-
<?php endif; ?>
</td>

<td class="text-center">
<?php echo e($design->order->deadline
    ? $design->order->deadline->format('d/m/Y')
    : '-'); ?>

</td>

<td>
<div class="action-btn-group text-center">

<a href="<?php echo e(route('designs.show',$design->id)); ?>"
   class="btn btn-primary btn-sm">
   Detail
</a>

<a href="<?php echo e(route('designs.edit', $design->id)); ?>"
   class="btn btn-warning btn-sm">
   Update
</a>

<a href="<?php echo e(route('orders.show', $design->order_id)); ?>"
   class="btn btn-info btn-sm">
   Order
</a>

</div>
</td>

</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
<td colspan="10" class="text-center text-muted">
    Belum ada data desain
</td>
</tr>
<?php endif; ?>

</tbody>
</table>
</div>

</div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/designs/index.blade.php ENDPATH**/ ?>