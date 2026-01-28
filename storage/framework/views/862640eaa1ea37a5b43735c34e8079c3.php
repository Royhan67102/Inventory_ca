<?php $__env->startSection('title', 'Tambah Order'); ?>
<?php $__env->startSection('page-title', 'Tambah Order'); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('orders.store')); ?>" method="POST">
<?php echo csrf_field(); ?>

<div class="row">
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Data Customer</h6>

                <div class="mb-3">
                    <label class="form-label">Nama Customer</label>
                        <input 
                            type="text" 
                            name="nama" 
                            class="form-control border border-dark rounded-0" 
                            required
                                >
                </div>


                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control border border-dark rounded-0" rows="3" required></textarea>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold">Informasi Order</h6>

                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Tanggal Pemesanan</label>
                        <input type="date" name="tanggal_pemesanan" class="form-control" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Deadline</label>
                        <input type="date" name="deadline" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Status Pembayaran</label>
                    <select name="payment_status" class="form-select" required>
                        <option value="belum_bayar">Belum Bayar</option>
                        <option value="dp">DP</option>
                        <option value="lunas">Lunas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Antar Barang?</label>
                    <select name="antar_barang" class="form-select" required>
                        <option value="tidak">Tidak</option>
                        <option value="ya">Ya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya Pengiriman</label>
                    <input type="number" name="biaya_pengiriman" class="form-control" value="0">
                </div>

                
                <div class="mb-3">
                    <label class="form-label">Jasa Pemasangan?</label>
                    <select name="jasa_pemasangan" class="form-select" required>
                        <option value="tidak">Tidak</option>
                        <option value="ya">Ya</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biaya Pemasangan</label>
                    <input type="number" name="biaya_pemasangan" class="form-control" value="0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="catatan" class="form-control">
                </div>

            </div>
        </div>
    </div>
</div>


<div class="card mb-4">
    <div class="card-body">
        <h6 class="fw-bold">Item Order</h6>

        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Produk</th>
                    <th>Merk</th>
                    <th>Panjang (cm)</th>
                    <th>Lebar (cm)</th>
                    <th>Qty</th>
                    <th>Harga / m²</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input name="product_name[]" class="form-control" required></td>
                    <td><input name="acrylic_brand[]" class="form-control"></td>
                    <td><input type="number" name="panjang_cm[]" class="form-control" required></td>
                    <td><input type="number" name="lebar_cm[]" class="form-control" required></td>
                    <td><input type="number" name="qty[]" class="form-control" required></td>
                    <td><input type="number" name="harga_per_m2[]" class="form-control" required></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end">
    <button class="btn btn-success">Simpan Order</button>
</div>
</form>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/orders/create.blade.php ENDPATH**/ ?>