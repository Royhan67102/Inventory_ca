<?php $__env->startSection('title', 'Edit Desain'); ?>
<?php $__env->startSection('page-title', 'Edit Desain'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Edit Desain - Order #<?php echo e($design->order->id ?? '-'); ?></h5>
            </div>
            <div class="card-body">

                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <form action="<?php echo e(route('designs.update', $design->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="mb-3">
                        <label class="form-label">Designer</label>
                        <input type="text" name="designer" class="form-control"
                               value="<?php echo e(old('designer', $design->designer)); ?>">
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Status Desain</label>
                        <select name="status" class="form-select" required>
                            <option value="menunggu" <?php echo e($design->status == 'menunggu' ? 'selected' : ''); ?>>Menunggu</option>
                            <option value="proses" <?php echo e($design->status == 'proses' ? 'selected' : ''); ?>>Proses</option>
                            <option value="selesai" <?php echo e($design->status == 'selesai' ? 'selected' : ''); ?>>Selesai</option>
                        </select>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Deadline</label>
                        <input
                            type="date"
                            name="deadline"
                            class="form-control"
                            value="<?php echo e(old(
                                'deadline',
                                optional($design->deadline ?? $design->order?->deadline)->format('Y-m-d')
                            )); ?>"
                        >
                    </div>


                    
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" rows="3" class="form-control"><?php echo e(old('catatan', $design->catatan)); ?></textarea>
                    </div>

                    
                    <?php if($design->file_awal): ?>
                        <div class="mb-3">
                            <label class="form-label">File Awal</label><br>
                            <a href="<?php echo e(asset('storage/'.$design->file_awal)); ?>" target="_blank">
                                Lihat File Awal
                            </a>
                        </div>
                    <?php endif; ?>

                    
                    <div class="mb-3">
                        <label class="form-label">Upload File Hasil</label>
                        <input type="file" name="file_hasil" class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf,.ai,.psd">

                        <?php if($design->file_hasil): ?>
                            <small class="text-muted">
                                File saat ini:
                                <a href="<?php echo e(asset('storage/'.$design->file_hasil)); ?>" target="_blank">
                                    Lihat File
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Bukti Pengerjaan</label>
                        <input type="file" name="bukti_pengerjaan" class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf">

                        <?php if($design->bukti_pengerjaan): ?>
                            <small class="text-muted">
                                File saat ini:
                                <a href="<?php echo e(asset('storage/'.$design->bukti_pengerjaan)); ?>" target="_blank">
                                    Lihat Bukti
                                </a>
                            </small>
                        <?php endif; ?>
                    </div>

                    
                    <?php if($design->tanggal_selesai): ?>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="text" class="form-control" readonly
                                   value="<?php echo e($design->tanggal_selesai); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('designs.index')); ?>" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/designs/edit.blade.php ENDPATH**/ ?>