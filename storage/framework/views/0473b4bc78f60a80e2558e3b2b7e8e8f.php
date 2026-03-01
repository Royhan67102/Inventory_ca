<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl">
    <div class="container-fluid py-1 px-3">

        <button class="btn btn-icon btn-2 btn-primary d-xl-none" id="iconNavbarSidenav" type="button">
            <i class="material-symbols-rounded">menu</i>
        </button>

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
                <li class="breadcrumb-item text-sm opacity-5">Pages</li>
                <li class="breadcrumb-item text-sm text-dark active">
                    <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                </li>
            </ol>
        </nav>

        <form method="GET" action="<?php echo e(url()->current()); ?>" class="d-flex">
            <div class="input-group input-group-outline">
                <input type="text"
                    name="search"
                    value="<?php echo e(request('search')); ?>"
                    class="form-control"
                    placeholder="Cari data..."
                    onkeydown="if(event.key==='Enter'){this.form.submit();}">
            </div>
        </form>

    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/layouts/partials/navbar.blade.php ENDPATH**/ ?>