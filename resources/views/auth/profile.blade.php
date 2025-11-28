@extends('layouts.app')

@section('title', 'Profile settings')

@section('content')
    <div class="col-12 col-lg-8 mx-auto">
        <div class="card mb-3">
            <div class="card-body d-flex align-items-center">
                <div class="flex-shrink-0 me-3">
                    <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="avatar" class="rounded-circle" width="56" height="56">
                </div>
                <div class="flex-grow-1">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="mb-0 text-muted small">{{ $user->email }}</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Change password</h5>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="current_password"
                            name="current_password"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New password</label>
                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
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
                            class="form-control"
                            id="password_confirmation"
                            name="password_confirmation"
                            required
                        >
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Save changes
                        </button>
                        <a href="{{ route('feedback.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

