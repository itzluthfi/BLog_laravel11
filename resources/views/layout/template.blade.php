<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Go Blog | @yield('title')</title>
    <!-- [Meta] -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/style.css') }}" />

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Sistem Forum Blog Informative" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- [Favicon] icon -->
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
    <link rel="shortcut icon" href="/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
    {{-- <link rel="manifest" href="/site.webmanifest" />    --}}

    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css') }}" id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dataTables.bootstrap5.min.css') }}" />
    @yield('head')
    <style>
        .swal2-container {
            z-index: 1080 !important;
        }
    </style>

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-layout="vertical" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">

    <!-- [ Pre-loader ] start -->
    @yield('pre-loader')
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
            <div class="m-header">
                <a href="{{ route('admin.dashboard') }}" class="b-brand text-primary d-flex justify-content-center mt-3">
                    <img src="{{ asset('assets/images/logo/logo_music.png') }}" class="logo-lg w-50" alt="logo" />
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">

                    <li class="pc-item pc-caption">
                        <label data-i18n="Admin Panel">Admin Panel</label>
                        <svg class="pc-icon">
                            <use xlink:href="#custom-layer"></use>
                        </svg>
                    </li>

                    <!-- Dashboard -->
                    <li class="pc-item">
                        <a href="{{ route('admin.dashboard') }}" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-fatrows"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>

                    <!-- Dashboard Template -->
                    <li class="pc-item">
                        <a href="{{ route('admin.template.dashboard') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-th-large"></i>
                            </span>
                            <span class="pc-mtext">Dashboard Template</span>
                        </a>
                    </li>

                    <!-- Content Management -->
                    <li class="pc-item pc-caption">
                        <label data-i18n="Content">Content</label>
                        <svg class="pc-icon">
                            <use xlink:href="#custom-book"></use>
                        </svg>
                    </li>

                    <!-- Manage Blogs -->
                    <li class="pc-item">
                        <a href="{{ route('admin.blogs.list') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <span class="pc-mtext">Manage Blogs</span>
                        </a>
                    </li>
                    <!-- Manage Blogs -->
                    <li class="pc-item">
                        <a href="{{ route('profile.blogs.listTemplate') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-paper-plane"></i>
                            </span>
                            <span class="pc-mtext">Manage Blogs Template</span>
                        </a>
                    </li>

                    <!-- Manage Categories -->
                    <li class="pc-item">
                        <a href="{{ route('admin.categories.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-tags"></i>
                            </span>
                            <span class="pc-mtext">Manage Categories</span>
                        </a>
                    </li>

                    <!-- Media Library -->
                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-image"></use>
                                </svg>
                            </span>
                            <span class="pc-mtext">Media Library</span>
                        </a>
                    </li>

                    <!-- Comments -->
                    <li class="pc-item">
                        <a href="{{ route('admin.comments.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-comments"></i>
                            </span>
                            <span class="pc-mtext">Comments</span>
                        </a>
                    </li>

                    <!-- User Management (Hanya untuk Admin) -->
                    @if (Auth::user()->role === 'Admin')
                        <li class="pc-item pc-caption">
                            <label data-i18n="User">User Management</label>
                            <svg class="pc-icon">
                                <use xlink:href="#custom-users"></use>
                            </svg>
                        </li>

                        <li class="pc-item">
                            <a href="{{ route('admin.users') }}" class="pc-link">
                                <span class="pc-micon">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-user"></use>
                                    </svg>
                                </span>
                                <span class="pc-mtext">Manage Users</span>
                            </a>
                        </li>
                    @endif

                    <!-- System Settings -->
                    <li class="pc-item pc-caption">
                        <label data-i18n="System">System</label>
                        <svg class="pc-icon">
                            <use xlink:href="#custom-settings"></use>
                        </svg>


                    </li>

                    <li class="pc-item">
                        <a href="{{ route('admin.setting') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-cog"></i>
                            </span>
                            <span class="pc-mtext">Setting</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="#" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-cogs"></i>
                            </span>
                            <span class="pc-mtext">System Status</span>
                        </a>
                    </li>

                    <!-- Logout -->
                    <li class="pc-item">
                        <a href="#" class="pc-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="pc-micon">
                                <i class="fas fa-door-open"></i>
                            </span>
                            <span class="pc-mtext">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>


                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end -->


    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper">
            <!-- [Mobile Media Block] start -->
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
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <svg class="pc-icon">
                                <use xlink:href="#custom-sun-1"></use>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-moon"></use>
                                </svg>
                                <span>Dark</span>
                            </a>
                            <a href="#!" class="dropdown-item" onclick="layout_change('light')">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-sun-1"></use>
                                </svg>
                                <span>Light</span>
                            </a>
                            <a href="#!" class="dropdown-item" onclick="layout_change_default()">
                                <svg class="pc-icon">
                                    <use xlink:href="#custom-setting-2"></use>
                                </svg>
                                <span>Default</span>
                            </a>
                        </div>
                    </li>
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                            <img src="{{ asset('assets/images/logo/logo_music.png') }}" alt="user-image" class="user-avtar" width="100" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="ti ti-power"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    @yield('content')
    <!-- [ Main Content ] end -->

    <!-- [ Footer ] start -->
    @yield('footer')
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">
                <div class="col my-1">
                    <p class="m-0">Go Blog^_^ &#9829; crafted by One Man Standing <a href="https://themeforest.net/user/phoenixcoded" target="_blank">Itzluthfi</a></p>
                </div>
                <div class="col-auto my-1">
                    <ul class="list-inline footer-link mb-0">
                        <li class="list-inline-item"><a href="../index.html">Home</a></li>
                        <li class="list-inline-item"><a href="https://phoenixcoded.gitbook.io/able-pro/" target="_blank">Documentation</a></li>
                        <li class="list-inline-item"><a href="https://phoenixcoded.authordesk.app/" target="_blank">Support</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- [ Footer ] end -->

    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/icon/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/notifier.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>


   
    <script>
        $(document).ready(function() {
            let status = "{{ session('status') }}";
            let message = "{{ session('message') }}";
            let label = "{{ session('label') }}";
            let type = "{{ session('type') }}";
            let image = "{{ session('image') }}";
            let time = "{{ session('time', 5000) }}";

            if (message) {
                notifier.show(label, message, type, image, time);
            }
        });

        function getRandomBadgeColor() {
            const badgeColors = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-dark'];
            return badgeColors[Math.floor(Math.random() * badgeColors.length)];
        }
        $.swalLoading = function(title = 'Loading…', html = 'Silakan tunggu') {
            Swal.fire({
                title: title,
                html: html,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        };

        /**
         * Tutup SweetAlert.
         */
        $.swalClose = function() {
            Swal.close();
        };

        function formatTanggalManusiawi(isoDate) {
            const date = new Date(isoDate);
            const formatter = new Intl.DateTimeFormat('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false,
                timeZone: 'Asia/Jakarta'
            });
            return formatter.format(date) + ' WIB';
        }
    </script>

    @yield('script')

</body>
<!-- [Body] end -->

</html>
