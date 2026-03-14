<?php $__env->startSection('title','Detail Production'); ?>
<?php $__env->startSection('page-title','Detail Production'); ?>

<style>
    /* =========================
   CARD
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
   TABLE DETAIL
========================= */

.table-borderless tr {
    border-bottom: 1px solid #f1f3f5;
}

.table-borderless th {
    font-weight: 600;
    color: #6c757d;
    padding: 14px 10px;
    vertical-align: middle;
    white-space: nowrap;
}

.table-borderless td {
    padding: 14px 10px;
    font-weight: 500;
    color: #212529;
}

/* Supaya value tidak terlalu mepet */
.table-borderless td,
.table-borderless th {
    line-height: 1.6;
}

/* =========================
   BADGE
========================= */

.badge {
    padding: 6px 12px;
    font-size: 13px;
    border-radius: 6px;
}

/* =========================
   BUTTON
========================= */

.btn {
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 14px;
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 768px) {

    .card-body {
        padding: 18px;
    }

    .table-borderless,
    .table-borderless tbody,
    .table-borderless tr,
    .table-borderless th,
    .table-borderless td {
        display: block;
        width: 100%;
    }

    .table-borderless tr {
        margin-bottom: 12px;
        background: #fafafa;
        border-radius: 10px;
        padding: 12px;
    }

    .table-borderless th {
        padding: 0;
        margin-bottom: 4px;
        font-size: 13px;
        color: #6c757d;
    }

    .table-borderless td {
        padding: 0;
        margin-bottom: 6px;
        font-size: 14px;
    }

    .btn {
        width: 100%;
        margin-top: 12px;
    }
}

/* EXTRA SMALL */
@media (max-width: 480px) {

    .card-header h5 {
        font-size: 16px;
    }

    .table-borderless td {
        font-size: 13px;
    }

    .badge {
        font-size: 12px;
    }
}
</style>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h5>Detail Production</h5>
    </div>

    <div class="card-body">

        <table class="table table-borderless">

            
            <tr>
                <th width="200">Kode Order</th>
                <td><?php echo e($production->order->invoice_number ?? '-'); ?></td>
            </tr>

            <tr>
                <th>Customer</th>
                <td><?php echo e($production->order->customer->nama ?? '-'); ?></td>
            </tr>

            <tr>
                <th>Produk</th>
                <td><?php echo e($production->order->produk_name ?? '-'); ?></td>
            </tr>

            
            <tr>
                <th>Status Production</th>
                <td>
                    <span class="badge
                        <?php if($production->status == 'menunggu'): ?> bg-warning text-dark
                        <?php elseif($production->status == 'proses'): ?> bg-info
                        <?php elseif($production->status == 'selesai'): ?> bg-success
                        <?php endif; ?>">
                        <?php echo e(ucfirst($production->status)); ?>

                    </span>
                </td>
            </tr>

            
            <tr>
                <th>Tim Produksi</th>
                <td><?php echo e($production->tim_produksi ?? '-'); ?></td>
            </tr>

            
            <tr>
                <th>Tanggal Mulai</th>
                <td>
                    <?php echo e($production->tanggal_mulai
                        ? \Carbon\Carbon::parse($production->tanggal_mulai)->format('d/m/Y H:i')
                        : '-'); ?>

                </td>
            </tr>

            <tr>
                <th>Tanggal Selesai</th>
                <td>
                    <?php echo e($production->tanggal_selesai
                        ? \Carbon\Carbon::parse($production->tanggal_selesai)->format('d/m/Y H:i')
                        : '-'); ?>

                </td>
            </tr>

            
            <tr>
                <th>Catatan Design</th>
                <td><?php echo e($production->order->design->catatan ?? '-'); ?></td>
            </tr>

            
            <tr>
                <th>File Hasil Design</th>
                <td>
                    <?php if($production->order->design?->file_hasil): ?>
                        <a href="<?php echo e(asset('storage/'.$production->order->design->file_hasil)); ?>"
                           target="_blank"
                           class="btn btn-sm btn-outline-primary">
                           Lihat File
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>

            
            <tr>
                <th>Bukti Produksi</th>
                <td>
                    <?php if($production->bukti): ?>
                        <a href="<?php echo e(asset('storage/'.$production->bukti)); ?>"
                           target="_blank"
                           class="btn btn-sm btn-outline-success">
                           Lihat Bukti
                        </a>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>

            
            <tr>
                <th>Keterangan</th>
                <td><?php echo e($production->keterangan ?? '-'); ?></td>
            </tr>

            
            <tr>
                <th>Catatan Produksi</th>
                <td><?php echo e($production->catatan ?? '-'); ?></td>
            </tr>

        </table>

        <a href="<?php echo e(route('productions.index')); ?>"
           class="btn btn-secondary">
           Kembali
        </a>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/productions/show.blade.php ENDPATH**/ ?>