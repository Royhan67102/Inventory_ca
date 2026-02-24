<?php $__env->startSection('title', 'Edit Production'); ?>
<?php $__env->startSection('page-title', 'Edit Production'); ?>
<style>
   /* =========================
   CARD STYLE
========================= */

.card {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}

.card-header {
    background: #f8f9fa;
    font-weight: 600;
    padding: 16px 20px;
    border-bottom: 1px solid #e5e7eb;
}

.card-body {
    padding: 24px;
}

/* =========================
   FORM LABEL
========================= */

.form-label {
    font-weight: 600;
    margin-bottom: 6px;
}

/* =========================
   GLOBAL INPUT STYLE
========================= */

.form-control,
.form-select,
textarea {
    border: 1.5px solid #d1d5db !important;
    background-color: #fff;
    border-radius: 8px;
    padding: 10px 12px;
    transition: 0.2s ease;
}

/* KHUSUS INPUT TEXT (TIM PRODUKSI FIX) */
input[type="text"].form-control {
    border: 1.5px solid #d1d5db !important;
    background-color: #fff;
}

/* Hover effect */
.form-control:hover,
.form-select:hover,
textarea:hover {
    border-color: #9ca3af !important;
}

/* Focus */
.form-control:focus,
.form-select:focus,
textarea:focus {
    border: 1.5px solid #0d6efd !important;
    box-shadow: 0 0 0 2px rgba(13,110,253,0.15);
}

/* Disabled */
.form-control:disabled,
.form-select:disabled,
textarea:disabled {
    border: 1.5px solid #e5e7eb !important;
    background: #f5f5f5;
    opacity: 1;
    cursor: not-allowed;
}

/* =========================
   FILE INPUT
========================= */

input[type="file"].form-control {
    border: 1.5px dashed #d1d5db !important;
    background: #fafafa;
    padding: 8px;
}

/* Disabled file */
input[type="file"]:disabled {
    border: 1.5px dashed #e5e7eb !important;
    background: #f5f5f5;
}

/* =========================
   TEXTAREA
========================= */

textarea.form-control {
    resize: vertical;
}

/* =========================
   BUTTON STYLE
========================= */

.btn {
    border-radius: 8px;
    padding: 8px 18px;
    font-size: 14px;
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

    .form-control,
    .form-select,
    textarea {
        font-size: 14px;
        padding: 9px 11px;
    }

    .btn {
        width: 100%;
        margin-bottom: 8px;
    }

    .d-flex.justify-content-between {
        flex-direction: column-reverse;
        gap: 10px;
    }
}

/* EXTRA SMALL DEVICE */
@media (max-width: 480px) {

    .card-header h5 {
        font-size: 16px;
    }

    .form-label {
        font-size: 14px;
    }

    .form-control,
    .form-select,
    textarea {
        padding: 8px 10px;
        font-size: 13px;
    }
}
</style>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <h5>Edit Production</h5>
            </div>

            <div class="card-body">

                
                <?php if($production->status === 'selesai'): ?>
                    <div class="alert alert-danger">
                        Production sudah selesai dan tidak bisa diedit lagi.
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('productions.update',$production->id)); ?>"
                      method="POST"
                      enctype="multipart/form-data">

                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    
                    <div class="mb-3">
                        <label class="form-label">Tim Produksi</label>
                        <input type="text"
                               name="tim_produksi"
                               class="form-control"
                               value="<?php echo e($production->tim_produksi); ?>"
                               <?php echo e($production->status === 'selesai' ? 'disabled' : ''); ?>>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Status Production</label>
                        <select name="status"
                                class="form-select"
                                <?php echo e($production->status === 'selesai' ? 'disabled' : ''); ?>>

                            <option value="menunggu"
                                <?php echo e($production->status == 'menunggu' ? 'selected':''); ?>>
                                Menunggu
                            </option>

                            <option value="proses"
                                <?php echo e($production->status == 'proses' ? 'selected':''); ?>>
                                Proses
                            </option>

                            <option value="selesai"
                                <?php echo e($production->status == 'selesai' ? 'selected':''); ?>>
                                Selesai
                            </option>
                        </select>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="datetime-local"
                               name="tanggal_mulai"
                               class="form-control"
                               value="<?php echo e($production->tanggal_mulai ? \Carbon\Carbon::parse($production->tanggal_mulai)->format('Y-m-d\TH:i') : ''); ?>"
                               <?php echo e($production->status === 'selesai' ? 'disabled' : ''); ?>>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="datetime-local"
                               name="tanggal_selesai"
                               class="form-control"
                               value="<?php echo e($production->tanggal_selesai ? \Carbon\Carbon::parse($production->tanggal_selesai)->format('Y-m-d\TH:i') : ''); ?>"
                               <?php echo e($production->status === 'selesai' ? 'disabled' : ''); ?>>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Bukti Pengerjaan</label>

                        <?php if($production->bukti): ?>
                            <div class="mb-2">
                                <a href="<?php echo e(asset('storage/'.$production->bukti)); ?>"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    👁 Lihat Bukti
                                </a>
                            </div>
                        <?php endif; ?>

                        <input type="file"
                               name="bukti"
                               class="form-control"
                               <?php echo e($production->status === 'selesai' ? 'disabled' : ''); ?>>
                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti file
                        </small>
                    </div>

                    
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan"
                                  class="form-control"
                                  rows="3"
                                  <?php echo e($production->status === 'selesai' ? 'disabled' : ''); ?>><?php echo e($production->catatan); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">

                        <a href="<?php echo e(route('productions.index')); ?>"
                           class="btn btn-secondary">
                           Kembali
                        </a>

                        <?php if($production->status !== 'selesai'): ?>
                            <button type="submit"
                                    class="btn btn-primary">
                                    Simpan
                            </button>
                        <?php endif; ?>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/edit.blade.php ENDPATH**/ ?>