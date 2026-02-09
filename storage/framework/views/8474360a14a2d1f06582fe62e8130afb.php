<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>




<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Hari Ini</small>
                <h5 class="mb-0">Rp <?php echo e(number_format($today ?? 0)); ?></h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Minggu Ini</small>
                <h5 class="mb-0">Rp <?php echo e(number_format($week ?? 0)); ?></h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Bulan Ini</small>
                <h5 class="mb-0">Rp <?php echo e(number_format($month ?? 0)); ?></h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <small class="text-muted">Tahun Ini</small>
                <h5 class="mb-0">Rp <?php echo e(number_format($year ?? 0)); ?></h5>
            </div>
        </div>
    </div>
</div>




<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <h6 class="mb-3">
            Grafik Penjualan
            (<?php echo e($from->format('d M Y')); ?> - <?php echo e($to->format('d M Y')); ?>)
        </h6>
        <canvas id="salesChart" height="100"></canvas>
    </div>
</div>




<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6>Status Pembayaran</h6>
                <ul class="mb-0">
                    <?php
                        $paymentLabel = [
                            'belum_bayar' => 'Belum Bayar',
                            'dp' => 'DP',
                            'lunas' => 'Lunas'
                        ];
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $paymentStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li><?php echo e($paymentLabel[$status] ?? ucfirst($status)); ?> : <?php echo e($total); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="text-muted">Belum ada data</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6>Status Produksi</h6>
                <ul class="mb-0">
                    <?php $__empty_1 = true; $__currentLoopData = $productionStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li><?php echo e(ucfirst($status)); ?> : <?php echo e($total); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <li class="text-muted">Belum ada data</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>




<div class="card shadow-sm">
    <div class="card-header fw-bold">
        Riwayat Produksi
    </div>
    <div class="card-body">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. Telp</th>
                    <th>Alamat</th>
                    <th>Tanggal Pesan</th>
                    <th>Status Pembayaran</th>
                    <th>Total Harga</th>
                </tr>
            </thead>

            <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $productionHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($order->customer->nama); ?></td>
                <td><?php echo e($order->customer->telepon); ?></td>
                <td><?php echo e($order->customer->alamat); ?></td>
                <td><?php echo e($order->tanggal_pemesanan->format('d M Y')); ?></td>
                <td><?php echo e(strtoupper(str_replace('_', ' ', $order->payment_status))); ?></td>
                <td>Rp <?php echo e(number_format($order->total_harga)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" class="text-center text-muted">
                    Belum ada riwayat produksi
                </td>
            </tr>
            <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($salesChart->pluck('tanggal')); ?>,
            datasets: [{
                label: 'Penjualan',
                data: <?php echo json_encode($salesChart->pluck('total')); ?>,
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/dashboard/index.blade.php ENDPATH**/ ?>