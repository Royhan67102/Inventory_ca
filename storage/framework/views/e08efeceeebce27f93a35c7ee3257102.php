<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('page-title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>

<style>
.profile-card {
    border-radius: 16px;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    object-fit: cover;
}

.profile-info-item {
    padding: 12px 0;
    border-bottom: 1px solid #f1f1f1;
}

.profile-info-item:last-child {
    border-bottom: none;
}

.profile-label {
    font-size: 13px;
    color: #6c757d;
}

.profile-value {
    font-weight: 500;
}

@media (max-width: 768px) {
    .profile-info-item {
        display: flex;
        flex-direction: column;
    }
}
</style>

<div class="container-fluid py-4">
    <div class="row g-4">

        <!-- LEFT PROFILE CARD -->
        <div class="col-lg-4">
            <div class="card profile-card shadow-sm">
                <div class="card-body text-center">

                    
                    <?php if($user->photo): ?>
                        <img src="<?php echo e(asset('storage/' . $user->photo)); ?>?v=<?php echo e(time()); ?>"
                             class="rounded-circle profile-avatar mb-3">
                    <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>"
                             class="rounded-circle profile-avatar mb-3">
                    <?php endif; ?>

                    <h5 class="mb-1"><?php echo e($user->name); ?></h5>

                    <span class="badge bg-dark text-capitalize mb-3">
                        <?php echo e($user->role); ?>

                    </span>

                    <div class="d-grid">
                        <a href="<?php echo e(route('profile.edit')); ?>"
                           class="btn btn-outline-dark btn-sm">
                            Edit Profile
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT PROFILE DETAIL -->
        <div class="col-lg-8">
            <div class="card shadow-sm profile-card">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0">Personal Information</h6>
                </div>

                <div class="card-body">

                    <div class="profile-info-item">
                        <div class="profile-label">Name</div>
                        <div class="profile-value"><?php echo e($user->name); ?></div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-label">Email</div>
                        <div class="profile-value"><?php echo e($user->email); ?></div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-label">Phone</div>
                        <div class="profile-value"><?php echo e($user->phone ?? '-'); ?></div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-label">Birthday</div>
                        <div class="profile-value">
                            <?php echo e($user->birthday ? $user->birthday->format('d M Y') : '-'); ?>

                        </div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-label">Employee Number</div>
                        <div class="profile-value">
                            <?php echo e($user->employee_number ?? '-'); ?>

                        </div>
                    </div>

                    <div class="profile-info-item">
                        <div class="profile-label">Role</div>
                        <div class="profile-value text-capitalize">
                            <?php echo e($user->role); ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Inventory_ca\resources\views/profile/index.blade.php ENDPATH**/ ?>