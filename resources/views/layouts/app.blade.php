<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>SWT Learner Survey</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <!-- [Favicon] icon -->
  <link rel="icon" href="https://www.safeworktraining.com.au/wp-content/uploads/2021/02/safe-work-training-favicon-1-300x300.png" type="image/x-icon"> <!-- [Google Font] Family -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css')}}" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="{{ asset('assets/fonts/feather.css')}}" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="{{ asset('assets/fonts/material.css')}}" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" id="main-style-link" >
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css')}}" >

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
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


      <a href="{{ url('/') }}" class="b-brand text-primary">
        <!-- ========   Change your logo from here   ============ -->
        <img src="https://safeworktraining.on-forge.com/assets/safeworktraining-logo.png" class="img-fluid w-100" alt="logo"> <br>

      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="{{ url('/feedback') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
            <span class="pc-mtext">AQTF Surveys</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
          <label>Settings</label>
          <i class="ti ti-dashboard"></i>
        </li>
        <li class="pc-item">
          <a href="{{ route('courses.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-typography"></i></span>
            <span class="pc-mtext">Courses</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('questions.index') }}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-help"></i></span>
            <span class="pc-mtext">Questions</span>
          </a>
        </li>
        <li class="pc-item">
          <a href="{{ route('users.index') }}" class="pc-link">
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
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>

  </ul>

      <small class="text-muted">
    Version {{ config('app.version') }}
</small>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    @auth
      <li class="dropdown pc-h-item header-user-profile">
        <a
          class="pc-head-link dropdown-toggle arrow-none me-0"
          data-bs-toggle="dropdown"
          href="#"
          role="button"
          aria-haspopup="false"
          data-bs-auto-close="outside"
          aria-expanded="false"
        >
          <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar">
          <span>{{ auth()->user()->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
          <div class="dropdown-header">
            <div class="d-flex mb-1">
              <div class="flex-shrink-0">
                <img src="{{ asset('assets/images/user/avatar-2.jpg') }}" alt="user-image" class="user-avtar wid-35">
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1">{{ auth()->user()->name }}</h6>
                <span class="text-muted small">{{ auth()->user()->email }}</span>
              </div>
            </div>
          </div>
          <div class="px-3 py-3">
            <a href="{{ route('profile.edit') }}" class="btn btn-light-primary w-100 mb-2 d-flex align-items-center justify-content-center">
              <i class="ti ti-user-cog me-2"></i>
              <span>Profile settings</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="btn btn-light-danger w-100 d-flex align-items-center justify-content-center">
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
  <script src="{{  asset('assets/js/plugins/popper.min.js')}}"></script>
  <script src="{{  asset('assets/js/plugins/simplebar.min.js')}}"></script>
  <script src="{{  asset('assets/js/plugins/bootstrap.min.js')}}"></script>
  <script src="{{  asset('assets/js/fonts/custom-font.js')}}"></script>
  <script src="{{  asset('assets/js/pcoded.js')}}"></script>
  <script src="{{  asset('assets/js/plugins/feather.min.js')}}"></script>

  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>

  @stack('scripts')

  <!-- QR Code modal -->
  <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="qrCodeModalLabel">Survey QR code</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <div id="qrCodeContainer" class="d-inline-block"></div>
          <p class="small text-muted mt-3 mb-0" id="qrCodeSubtitle"></p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-outline-secondary btn-sm" id="qrDownloadButton">
            Download QR code
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Copy link + QR logic -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const container = document.getElementById('qrCodeContainer');
      const subtitle = document.getElementById('qrCodeSubtitle');
      const modalElement = document.getElementById('qrCodeModal');
      const downloadButton = document.getElementById('qrDownloadButton');
      let qrModal = null;
      let currentQrSrc = null;

      if (modalElement && typeof bootstrap !== 'undefined') {
        qrModal = new bootstrap.Modal(modalElement);
      }

      document.body.addEventListener('click', function (event) {
        const copyButton = event.target.closest('.copy-link-btn');
        const qrButton = event.target.closest('.show-qr-btn');

        if (copyButton) {
          const link = copyButton.getAttribute('data-link');
          if (!link) return;

          const markCopied = function () {
            const original = copyButton.textContent;
            copyButton.textContent = 'Copied';
            copyButton.classList.remove('btn-outline-secondary');
            copyButton.classList.add('btn-success');
            setTimeout(function () {
              copyButton.textContent = original;
              copyButton.classList.remove('btn-success');
              copyButton.classList.add('btn-outline-secondary');
            }, 1500);
          };

          if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(link)
              .then(markCopied)
              .catch(function () {
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
          img.src = 'https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=' + encodeURIComponent(link);
          img.alt = 'Survey QR code';
          img.className = 'img-fluid';
          container.appendChild(img);
          currentQrSrc = img.src;
          subtitle.textContent = label;
          qrModal.show();
        }
      });

      if (downloadButton) {
        downloadButton.addEventListener('click', function () {
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
