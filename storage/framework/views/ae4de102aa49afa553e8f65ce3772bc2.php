<?php $__env->startSection('title', 'Stok Acrylic'); ?>
<?php $__env->startSection('page-title', 'Stok Acrylic'); ?>

<style>
.table-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.custom-table {
    width: 100%;
    min-width: 1000px; /* supaya bisa scroll horizontal */
    border-collapse: separate;
    border-spacing: 0;
}

.custom-table thead th {
    border: 1px solid #e5e7eb;
    background: #f9fafb;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    padding: 10px;
}

.custom-table tbody td {
    border: 1px solid #e5e7eb;
    vertical-align: middle;
    font-size: 14px;
    padding: 8px 10px;
}

.custom-table tbody tr:hover {
    background: #f9fafb;
}

.badge {
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 12px;
}

.action-buttons {
    display: flex;
    gap: 5px;
    justify-content: center;
    flex-wrap: wrap;
}

.text-number {
    text-align: right;
}

/* Mobile hanya kecilkan font, jangan ubah jadi block */
@media (max-width: 768px) {
    .custom-table {
        font-size: 13px;
    }
}
</style>

<?php $__env->startSection('content'); ?>
<div class="mb-3">
    <a href="<?php echo e(route('acrylic-stocks.create')); ?>" class="btn btn-primary">
        + Tambah Stok
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Apakah kamu yakin ingin menghapus stok acrylic ini?
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Tidak
        </button>

        <form id="deleteForm" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
                Ya, Hapus
            </button>
        </form>
      </div>

    </div>
  </div>
</div>

<div class="table-card">
<div class="table-responsive">
<table class="table custom-table align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>Merk</th>
            <th>Warna</th>
            <th>Jenis</th>
            <th>Ukuran</th>
            <th>Ketebalan</th>
            <th>Luas Total</th>
            <th>Luas Tersedia</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($loop->iteration); ?></td>
            <td><?php echo e($stock->merk); ?></td>
            <td><?php echo e($stock->warna ?? '-'); ?></td>
            <td class="text-center">
                <span class="badge bg-<?php echo e($stock->jenis == 'lembar' ? 'primary' : 'secondary'); ?>">
                    <?php echo e(ucfirst($stock->jenis)); ?>

                </span>
            </td>
            <td><?php echo e($stock->panjang); ?> × <?php echo e($stock->lebar); ?> cm</td>
            <td class="text-number"><?php echo e($stock->ketebalan); ?> mm</td>
            <td class="text-number">
                <?php echo e(number_format($stock->luas_total / 10000, 2)); ?> m²
            </td>
            <td class="text-number">
                <?php echo e(number_format($stock->luas_tersedia / 10000, 2)); ?> m²
            </td>
            <td class="text-number"><?php echo e($stock->jumlah_lembar); ?></td>
            <td>
                <div class="action-buttons">
                    <a href="<?php echo e(route('acrylic-stocks.show', $stock)); ?>"
                       class="btn btn-info btn-sm">Detail</a>

                    <a href="<?php echo e(route('acrylic-stocks.edit', $stock)); ?>"
                       class="btn btn-warning btn-sm">Edit</a>

                    <button type="button"
                            class="btn btn-danger btn-sm delete-btn"
                            data-url="<?php echo e(route('acrylic-stocks.destroy', $stock)); ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal">
                        Hapus
                    </button>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="10" class="text-center text-muted">
                Belum ada stok acrylic
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteForm = document.getElementById('deleteForm');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            deleteForm.setAttribute('action', this.dataset.url);
        });
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/acrylicstocks/index.blade.php ENDPATH**/ ?>