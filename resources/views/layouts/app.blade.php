<!DOCTYPE html>
<html lang="en">
    <!-- [Head] start -->

    <head>
        <title>SWT Learner Survey</title>
        <!-- [Meta] -->
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"
            name="viewport">
        <meta content="IE=edge"
            http-equiv="X-UA-Compatible">
        <meta
            content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project."
            name="description">
        <meta
            content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template"
            name="keywords">
        <meta content="CodedThemes"
            name="author">

        <!-- [Favicon] icon -->
        <link
            href="https://www.safeworktraining.com.au/wp-content/uploads/2021/02/safe-work-training-favicon-1-300x300.png"
            rel="icon"
            type="image/x-icon"> <!-- [Google Font] Family -->
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
            id="main-font-link"
            rel="stylesheet">
        <!-- [Tabler Icons] https://tablericons.com -->
        <link href="{{ asset('assets/fonts/tabler-icons.min.css') }}"
            rel="stylesheet">
        <!-- [Feather Icons] https://feathericons.com -->
        <link href="{{ asset('assets/fonts/feather.css') }}"
            rel="stylesheet">
        <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
        <link href="{{ asset('assets/fonts/fontawesome.css') }}"
            rel="stylesheet">
        <!-- [Material Icons] https://fonts.google.com/icons -->
        <link href="{{ asset('assets/fonts/material.css') }}"
            rel="stylesheet">
        <!-- [Template CSS Files] -->
        <link href="{{ asset('assets/css/style.css') }}"
            id="main-style-link"
            rel="stylesheet">
        <link href="{{ asset('assets/css/style-preset.css') }}"
            rel="stylesheet">

        @stack('styles')

    </head>
    <!-- [Head] end -->
    <!-- [Body] Start -->

    <body data-pc-direction="ltr"
        data-pc-preset="preset-1"
        data-pc-theme="light">
        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->
        <!-- [ Sidebar Menu ] start -->
        <nav class="pc-sidebar">
            <div class="navbar-wrapper">
                <div class="m-header d-flex align-items-center">

                    <a class="b-brand text-primary"
                        href="{{ url('/') }}">
                        <!-- ========   Change your logo from here   ============ -->
                        <img alt="logo"
                            class="img-fluid w-100"
                            src="https://safeworktraining.on-forge.com/assets/safeworktraining-logo.png"> <br>

                    </a>
                </div>
                <div class="navbar-content">
                    <ul class="pc-navbar">
                        <li class="pc-item">
                            <a class="pc-link"
                                href="{{ url('/feedback') }}">
                                <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
                                <span class="pc-mtext">AQTF Surveys</span>
                            </a>
                        </li>

                        <li class="pc-item pc-caption">
                            <label>Settings</label>
                            <i class="ti ti-dashboard"></i>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link"
                                href="{{ route('courses.index') }}">
                                <span class="pc-micon"><i class="ti ti-typography"></i></span>
                                <span class="pc-mtext">Courses</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link"
                                href="{{ route('questions.index') }}">
                                <span class="pc-micon"><i class="ti ti-help"></i></span>
                                <span class="pc-mtext">Questions</span>
                            </a>
                        </li>
                        <li class="pc-item">
                            <a class="pc-link"
                                href="{{ route('users.index') }}">
                                <span class="pc-micon"><i class="ti ti-users"></i></span>
                                <span class="pc-mtext">Users</span>
                            </a>
                        </li>

                </div>
            </div>
        </nav>
        <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
        <header class="pc-header">
            <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
                <div class="me-auto pc-mob-drp">
                    <ul class="list-unstyled">
                        <!-- ======= Menu collapse Icon ===== -->
                        <li class="pc-h-item pc-sidebar-collapse">
                            <a class="pc-head-link ms-0"
                                href="#"
                                id="sidebar-hide">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                        <li class="pc-h-item pc-sidebar-popup">
                            <a class="pc-head-link ms-0"
                                href="#"
                                id="mobile-collapse">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>

                    </ul>

                    <small class="text-muted d-inline-flex align-items-center">
                        <span> Version {{ config('app.version') }} ({{ config('app.stage') }})</span>
                        <span class="ms-1"
                            data-bs-placement="bottom"
                            data-bs-toggle="tooltip"
                            title="This system is still in beta (development). If you find an issue or would like to suggest a feature, please email lonard@safetysystems.net.au.">
                            <i class="ti ti-info-circle text-primary fs-6"></i>
                        </span>
                    </small>

                </div>
                <!-- [Mobile Media Block end] -->
                <div class="ms-auto">
                    <ul class="list-unstyled">
                        @auth
                            <li class="dropdown pc-h-item header-user-profile">
                                <a aria-expanded="false"
                                    aria-haspopup="false"
                                    class="pc-head-link dropdown-toggle arrow-none me-0"
                                    data-bs-auto-close="outside"
                                    data-bs-toggle="dropdown"
                                    href="#"
                                    role="button">
                                    <img alt="user-image"
                                        class="user-avtar"
                                        src="{{ asset('assets/images/user/avatar-2.jpg') }}">
                                    <span>{{ auth()->user()->name }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                                    <div class="dropdown-header">
                                        <div class="d-flex mb-1">
                                            <div class="flex-shrink-0">
                                                <img alt="user-image"
                                                    class="user-avtar wid-35"
                                                    src="{{ asset('assets/images/user/avatar-2.jpg') }}">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                                                <span class="text-muted small">{{ auth()->user()->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-3 py-3">
                                        <a class="btn btn-light-primary w-100 mb-2 d-flex align-items-center justify-content-center"
                                            href="{{ route('profile.edit') }}">
                                            <i class="ti ti-user-cog me-2"></i>
                                            <span>Profile settings</span>
                                        </a>
                                        <form action="{{ route('logout') }}"
                                            method="POST">
                                            @csrf
                                            <button
                                                class="btn btn-light-danger w-100 d-flex align-items-center justify-content-center"
                                                type="submit">
                                                <i class="ti ti-power me-2"></i>
                                                <span>Logout</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </header>
        <!-- [ Header ] end -->

        <!-- [ Main Content ] start -->

        <div class="pc-container">
            <div class="pc-content">

                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- [Page Specific JS] end -->
        <!-- Required Js -->
        <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
        <script src="{{ asset('assets/js/pcoded.js') }}"></script>
        <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

        <script>
            layout_change('light');
        </script>
        <script>
            change_box_container('false');
        </script>
        <script>
            layout_rtl_change('false');
        </script>
        <script>
            preset_change("preset-1");
        </script>
        <script>
            font_change("Public-Sans");
        </script>

        @stack('scripts')

        <!-- QR Code modal -->
        <div aria-hidden="true"
            aria-labelledby="qrCodeModalLabel"
            class="modal fade"
            id="qrCodeModal"
            tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="qrCodeModalLabel">Survey QR code</h5>
                        <button aria-label="Close"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            type="button"></button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="d-inline-block"
                            id="qrCodeContainer"></div>
                        <p class="small text-muted mt-3 mb-0"
                            id="qrCodeSubtitle"></p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-outline-secondary btn-sm"
                            id="qrDownloadButton"
                            type="button">
                            Download QR code
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copy link + QR logic -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('qrCodeContainer');
                const subtitle = document.getElementById('qrCodeSubtitle');
                const modalElement = document.getElementById('qrCodeModal');
                const downloadButton = document.getElementById('qrDownloadButton');
                let qrModal = null;
                let currentQrSrc = null;

                if (modalElement && typeof bootstrap !== 'undefined') {
                    qrModal = new bootstrap.Modal(modalElement);
                }

                document.body.addEventListener('click', function(event) {
                    const copyButton = event.target.closest('.copy-link-btn');
                    const qrButton = event.target.closest('.show-qr-btn');

                    if (copyButton) {
                        const link = copyButton.getAttribute('data-link');
                        if (!link) return;

                        const markCopied = function() {
                            const originalText = copyButton.dataset.originalText || copyButton.textContent;
                            const originalClass = copyButton.dataset.originalClass || copyButton.className;

                            copyButton.dataset.originalText = originalText;
                            copyButton.dataset.originalClass = originalClass;

                            copyButton.textContent = 'Copied';
                            copyButton.className = originalClass + ' btn-success';

                            setTimeout(function() {
                                copyButton.textContent = originalText;
                                copyButton.className = originalClass;
                            }, 1500);
                        };

                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(link)
                                .then(markCopied)
                                .catch(function() {
                                    const textarea = document.createElement('textarea');
                                    textarea.value = link;
                                    textarea.style.position = 'fixed';
                                    textarea.style.top = '-1000px';
                                    document.body.appendChild(textarea);
                                    textarea.focus();
                                    textarea.select();
                                    try {
                                        document.execCommand('copy');
                                        markCopied();
                                    } catch (e) {
                                        console.error('Copy failed', e);
                                    }
                                    document.body.removeChild(textarea);
                                });
                        } else {
                            const textarea = document.createElement('textarea');
                            textarea.value = link;
                            textarea.style.position = 'fixed';
                            textarea.style.top = '-1000px';
                            document.body.appendChild(textarea);
                            textarea.focus();
                            textarea.select();
                            try {
                                document.execCommand('copy');
                                markCopied();
                            } catch (e) {
                                console.error('Copy failed', e);
                            }
                            document.body.removeChild(textarea);
                        }
                    }

                    if (qrButton && container && qrModal) {
                        const link = qrButton.getAttribute('data-link');
                        const label = qrButton.getAttribute('data-label') || '';
                        if (!link) return;

                        container.innerHTML = '';
                        const img = document.createElement('img');
                        img.src = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' +
                            encodeURIComponent(link);
                        img.alt = 'Survey QR code';
                        img.className = 'img-fluid';
                        container.appendChild(img);
                        currentQrSrc = img.src;
                        subtitle.textContent = label;
                        qrModal.show();
                    }
                });

                if (downloadButton) {
                    downloadButton.addEventListener('click', function() {
                        if (!currentQrSrc) return;

                        const linkEl = document.createElement('a');
                        linkEl.href = currentQrSrc;
                        linkEl.download = 'survey-qr-code.png';
                        linkEl.target = '_blank';
                        document.body.appendChild(linkEl);
                        linkEl.click();
                        document.body.removeChild(linkEl);
                    });
                }
            });
        </script>

    </body>
    <!-- [Body] end -->

</html>
