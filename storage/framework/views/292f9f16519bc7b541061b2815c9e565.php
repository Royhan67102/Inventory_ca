<?php $__env->startSection('content'); ?>
<div class="container">

    <h4 class="mb-3">Update Produksi (SPK)</h4>

    <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <div class="card mb-3">
        <div class="card-body">
            <h5>Informasi Order</h5>

            <p><b>No Order:</b> #<?php echo e($production->order->id); ?></p>
            <p><b>Customer:</b>
                <?php echo e($production->order->customer->nama ?? '-'); ?>

            </p>

            <p><b>Status Order:</b>
                <?php echo e(ucfirst($production->order->status)); ?>

            </p>
        </div>
    </div>

    
    <div class="card">
        <div class="card-body">

            <form action="<?php echo e(route('productions.update', $production)); ?>"
                  method="POST"
                  enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label">Tim Produksi</label>
                    <input type="text"
                           name="tim_produksi"
                           class="form-control"
                           value="<?php echo e(old('tim_produksi', $production->tim_produksi)); ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Produksi</label>
                    <select name="status" class="form-control" required>
                        <option value="menunggu"
                            <?php echo e($production->status=='menunggu'?'selected':''); ?>>
                            Menunggu
                        </option>
                        <option value="proses"
                            <?php echo e($production->status=='proses'?'selected':''); ?>>
                            Proses
                        </option>
                        <option value="selesai"
                            <?php echo e($production->status=='selesai'?'selected':''); ?>>
                            Selesai
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan Produksi</label>
                    <textarea name="catatan"
                              class="form-control"
                              rows="3"><?php echo e(old('catatan', $production->catatan)); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Bukti Produksi</label>
                    <input type="file"
                           name="bukti"
                           class="form-control">

                    <?php if($production->bukti): ?>
                        <div class="mt-2">
                            <small>Bukti saat ini:</small><br>
                            <a href="<?php echo e(asset('storage/'.$production->bukti)); ?>"
                               target="_blank">
                                Lihat Bukti
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <button class="btn btn-primary">
                    Update Produksi
                </button>

                <a href="<?php echo e(route('productions.index')); ?>"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/edit.blade.php ENDPATH**/ ?>