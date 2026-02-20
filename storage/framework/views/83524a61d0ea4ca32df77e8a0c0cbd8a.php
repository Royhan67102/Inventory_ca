<?php $__env->startSection('title', 'Detail Desain'); ?>
<?php $__env->startSection('page-title', 'Detail Desain'); ?>

<?php $__env->startSection('content'); ?>

<style>
.detail-table th,
.detail-table td {
    border: 1px solid #dee2e6 !important;
    padding: 10px;
    vertical-align: middle;
}

.detail-table th {
    width: 35%;
    background: #f8f9fa;
    font-weight: 600;
}

@media(max-width:768px){
    .detail-table th,
    .detail-table td {
        font-size: 13px;
        padding: 8px;
    }

    .detail-table th {
        width: 45%;
    }
}
</style>

<div class="row justify-content-center">
<div class="col-lg-8 col-md-10 col-12">

<div class="card shadow-sm">

<div class="card-header d-flex justify-content-between align-items-center flex-wrap">
    <h5 class="mb-2 mb-md-0">
        Detail Desain - Order #<?php echo e($design->order_id); ?>

    </h5>

    <a href="<?php echo e(route('designs.index')); ?>" class="btn btn-secondary btn-sm">
        Kembali
    </a>
</div>

<div class="card-body">


<h6 class="fw-bold mb-2">Info Order</h6>

<div class="table-responsive">
<table class="table detail-table">

<tr>
<th>Order ID</th>
<td><?php echo e($design->order_id); ?></td>
</tr>

<tr>
<th>Nama Customer</th>
<td><?php echo e($design->order?->customer?->nama ?? '-'); ?></td>
</tr>

<tr>
<th>Kategori</th>
<td><?php echo e(ucfirst($design->order?->kategori ?? '-')); ?></td>
</tr>

<tr>
<th>Tanggal Order</th>
<td><?php echo e($design->order?->created_at?->format('d/m/Y H:i') ?? '-'); ?></td>
</tr>

</table>
</div>


<h6 class="fw-bold mt-4 mb-2">Info Desain</h6>

<div class="table-responsive">
<table class="table detail-table">

<tr>
<th>Status</th>
<td>
<span class="badge
<?php if($design->status == 'menunggu'): ?> bg-warning
<?php elseif($design->status == 'proses'): ?> bg-info
<?php elseif($design->status == 'selesai'): ?> bg-success
<?php endif; ?>">
<?php echo e(ucfirst($design->status)); ?>

</span>
</td>
</tr>

<tr>
<th>Designer</th>
<td><?php echo e($design->designer ?? '-'); ?></td>
</tr>

<tr>
<th>Catatan</th>
<td><?php echo e($design->catatan ?? '-'); ?></td>
</tr>

<tr>
<th>File Awal</th>
<td>
<?php if($design->file_awal): ?>
<a href="<?php echo e(asset('storage/' . $design->file_awal)); ?>" target="_blank"
   class="btn btn-sm btn-outline-primary">
   Lihat File
</a>
<?php else: ?>
-
<?php endif; ?>
</td>
</tr>

<tr>
<th>File Hasil</th>
<td>
<?php if($design->file_hasil): ?>
<a href="<?php echo e(asset('storage/' . $design->file_hasil)); ?>" target="_blank"
   class="btn btn-sm btn-outline-success">
   Lihat File
</a>
<?php else: ?>
-
<?php endif; ?>
</td>
</tr>

<tr>
<th>Tanggal Dibuat</th>
<td><?php echo e($design->created_at?->format('d/m/Y H:i') ?? '-'); ?></td>
</tr>

<tr>
<th>Terakhir Diperbarui</th>
<td><?php echo e($design->updated_at?->format('d/m/Y H:i') ?? '-'); ?></td>
</tr>

</table>
</div>

</div>
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/designs/show.blade.php ENDPATH**/ ?>