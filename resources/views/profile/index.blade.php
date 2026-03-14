@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')

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

                    {{-- Foto Profile --}}
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}?v={{ time() }}"
                             class="rounded-circle profile-avatar mb-3">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                             class="rounded-circle profile-avatar mb-3">
                    @endif

                    <h5 class="mb-1">{{ $user->name }}</h5>

                    <span class="badge bg-dark text-capitalize mb-3">
                        {{ $user->role }}
                    </span>

                    <div class="d-grid">
                        <a href="{{ route('profile.edit') }}"
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
                    <h6 class="mb-0">Account Information</h6>
                </div>

                <div class="card-body">

                    <!-- PERSONAL INFORMATION -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Personal Information</h6>

                        <div class="profile-info-item">
                            <div class="profile-label">Name</div>
                            <div class="profile-value">{{ $user->name }}</div>
                        </div>

                        <div class="profile-info-item">
                            <div class="profile-label">Email</div>
                            <div class="profile-value">{{ $user->email }}</div>
                        </div>

                        <div class="profile-info-item">
                            <div class="profile-label">Phone</div>
                            <div class="profile-value">{{ $user->phone ?? '-' }}</div>
                        </div>

                        <div class="profile-info-item">
                            <div class="profile-label">Birthday</div>
                            <div class="profile-value">
                                {{ $user->birthday ? $user->birthday->format('d M Y') : '-' }}
                            </div>
                        </div>

                        <div class="profile-info-item">
                            <div class="profile-label">Employee Number</div>
                            <div class="profile-value">
                                {{ $user->employee_number ?? '-' }}
                            </div>
                        </div>

                        <div class="profile-info-item">
                            <div class="profile-label">Role</div>
                            <div class="profile-value text-capitalize">
                                {{ $user->role }}
                            </div>
                        </div>
                    </div>


                    <hr class="my-4">


                    <!-- CHANGE PASSWORD -->
                    <div>

                        <h6 class="text-muted mb-3">
                            <i class="fa-solid fa-lock me-2"></i>
                            Change Password
                        </h6>

                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success">
                                Password berhasil diperbarui
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password"
                                    name="current_password"
                                    class="form-control"
                                    required>
                                @error('current_password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password"
                                    name="password"
                                    class="form-control"
                                    required>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Confirm Password</label>
                                <input type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-dark">
                                Update Password
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </div>

@endsection
