<?php $__env->startSection('title', 'Update Produksi'); ?>
<?php $__env->startSection('page-title', 'Update Produksi'); ?>

<?php $__env->startSection('content'); ?>
<form method="POST"
      action="<?php echo e(route('productions.update', $production)); ?>"
      enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>

<div class="row">
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Informasi Order</h6>

                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <input type="text" class="form-control" disabled
                        value="<?php echo e($production->order->customer->nama ?? '-'); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Pemesanan</label>
                    <input type="text" class="form-control" disabled
                        value="<?php echo e($production->order->tanggal_pemesanan?->format('d M Y')); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deadline</label>
                    <input type="text" class="form-control" disabled
                        value="<?php echo e($production->order->deadline?->format('d M Y') ?? '-'); ?>">
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Update Produksi</h6>

                <div class="mb-3">
                    <label class="form-label">Status Produksi</label>
                    <select name="status" class="form-select" required>
                        <option value="menunggu" <?php if($production->status=='menunggu'): echo 'selected'; endif; ?>>Menunggu</option>
                        <option value="proses" <?php if($production->status=='proses'): echo 'selected'; endif; ?>>Proses</option>
                        <option value="selesai" <?php if($production->status=='selesai'): echo 'selected'; endif; ?>>Selesai</option>
                    </select>
                </div>

              <div class="mb-3">
    <label class="form-label">PIC Produksi</label>
    <input
        type="text"
        name="tim_produksi"
        class="form-control border border-dark rounded-0"
        value="<?php echo e(old('tim_produksi', $production->tim_produksi)); ?>"
        required
    >
</div>

<div class="mb-3">
    <label class="form-label">Catatan Produksi</label>
    <textarea
        name="catatan"
        class="form-control border border-dark rounded-0"
        rows="3"
        placeholder="Tulis catatan produksi..."
    ></textarea>
</div>

<div class="mb-3">
    <label class="form-label">Bukti Produksi (Foto)</label>
    <input
        type="file"
        name="bukti"
        class="form-control border border-dark rounded-0"
        accept="image/*"
    >

    <?php if($production->bukti): ?>
        <small class="d-block mt-2">
            <img src="<?php echo e(asset('storage/' . $production->bukti)); ?>" alt="Bukti Produksi">

        </small>
    <?php endif; ?>
</div>


                <div class="text-end">
                    <button class="btn btn-success">Update Produksi</button>
                    <a href="<?php echo e(route('productions.index')); ?>" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/edit.blade.php ENDPATH**/ ?>