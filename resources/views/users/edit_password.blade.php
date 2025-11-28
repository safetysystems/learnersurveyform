@extends('layouts.app')

@section('title', 'Change user password')

@section('content')
    <div class="col-12 col-lg-8 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-0">Change password</h1>
                <p class="text-muted mb-0 small">
                    Update the password for this user account.
                </p>
            </div>
            <a href="{{ route('users.index') }}" class="btn btn-light-secondary">
                Back to users
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3 d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="avatar" class="rounded-circle" width="48" height="48">
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">{{ $user->name }}</div>
                        <div class="small text-muted">{{ $user->email }}</div>
                    </div>
                         <form method="POST" action="{{ route('users.toggle-status', $user->id) }}">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                            >
                                                {{ $user->is_active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.password.update', $user) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="password" class="form-label">New password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            required
                        >
                        <div class="form-text">
                            Use at least 8 characters, including letters and numbers.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm new password</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Save password
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

