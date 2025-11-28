<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->
<head>
    <title>Admin Login | Learner Survey</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Login to manage AQTF learner questionnaires and feedback forms.">
    <meta name="keywords" content="Learner Survey, AQTF, Admin, Login">
    <meta name="author" content="Learner Survey">

    <!-- [Favicon] icon -->
    <link rel="icon" href="https://www.safeworktraining.com.au/wp-content/uploads/2021/02/safe-work-training-favicon-1-300x300.png" type="image/x-icon">
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <!-- [Tabler Icons] -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">
</head>
<!-- [Head] end -->
<!-- [Body] Start -->
<body>
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-track">
        <div class="loader-fill"></div>
    </div>
</div>
<!-- [ Pre-loader ] End -->

<div class="auth-main">
    <div class="auth-wrapper v3">
        <div class="auth-form">
            <div class="auth-header text-start mb-3">
                <a href="{{ route('login') }}">
                    <img  class="w-50" src="https://safeworktraining.on-forge.com/assets/safeworktraining-logo.png" alt="Learner Survey logo">
                </a>
            </div>
            <div class="card my-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <h3 class="mb-0"><strong>Admin login</strong></h3>
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

                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label class="form-label" for="email">Email address</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="Email address"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Password"
                                required
                            >
                        </div>

                        <div class="d-flex mt-1 justify-content-between align-items-center">

                            <span class="text-secondary f-w-400 small">
                                Contact your administrator if you forget your password.
                            </span>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="auth-footer row">
                <div class="col my-1">
                    <p class="m-0">Safe Work Training &copy; {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

<!-- Required Js -->
<script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

<script>layout_change('light');</script>
<script>change_box_container('false');</script>
<script>layout_rtl_change('false');</script>
<script>preset_change("preset-1");</script>
<script>font_change("Public-Sans");</script>
</body>
<!-- [Body] end -->
</html>
