<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('page-title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-4">
    <div class="row">

        <!-- LEFT PROFILE CARD -->
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-body text-center">

                    
                    <?php if($user->photo): ?>
                        <img src="<?php echo e(asset('storage/' . $user->photo)); ?>?v=<?php echo e(time()); ?>"
                            class="rounded-circle img-fluid mb-3"
                            width="120">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>"
                            class="rounded-circle img-fluid mb-3"
                            width="120">
                    <?php endif; ?>

                    <h5 class="mb-0"><?php echo e($user->name); ?></h5>

                    <p class="text-sm text-muted text-capitalize">
                        <?php echo e($user->role); ?>

                    </p>

                    <hr>

                    <a href="<?php echo e(route('profile.edit')); ?>"
                        class="btn btn-dark btn-sm w-100">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- RIGHT PROFILE DETAIL -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Personal Information</h6>
                </div>

                <div class="card-body">
                    <table class="table align-items-center">
                        <tr>
                            <th width="200">Name</th>
                            <td><?php echo e($user->name); ?></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td><?php echo e($user->email); ?></td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td><?php echo e($user->phone ?? '-'); ?></td>
                        </tr>

                        <tr>
                            <th>Birthday</th>
                            <td>
                                <?php echo e($user->birthday ? $user->birthday->format('d M Y') : '-'); ?>

                            </td>
                        </tr>

                        <tr>
                            <th>Employee Number</th>
                            <td><?php echo e($user->employee_number ?? '-'); ?></td>
                        </tr>

                        <tr>
                            <th>Role</th>
                            <td class="text-capitalize">
                                <?php echo e($user->role); ?>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/profile/index.blade.php ENDPATH**/ ?>