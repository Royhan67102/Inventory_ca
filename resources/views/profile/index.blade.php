@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')

@section('content')

<div class="container-fluid py-4">
    <div class="row">

        <!-- LEFT PROFILE CARD -->
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-body text-center">

                    {{-- Foto Profile --}}
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}?v={{ time() }}"
                            class="rounded-circle img-fluid mb-3"
                            width="120">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}"
                            class="rounded-circle img-fluid mb-3"
                            width="120">
                    @endif

                    <h5 class="mb-0">{{ $user->name }}</h5>

                    <p class="text-sm text-muted text-capitalize">
                        {{ $user->role }}
                    </p>

                    <hr>

                    <a href="{{ route('profile.edit') }}"
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
                            <td>{{ $user->name }}</td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td>{{ $user->phone ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Birthday</th>
                            <td>
                                {{ $user->birthday ? $user->birthday->format('d M Y') : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Employee Number</th>
                            <td>{{ $user->employee_number ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Role</th>
                            <td class="text-capitalize">
                                {{ $user->role }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
