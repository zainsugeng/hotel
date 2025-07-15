<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $judul ?? 'Admin Dashboard' }} - Aplikasi Hotel</title>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        /* === DEFINISI PALET WARNA BARU === */
        :root {
            --primary-dark: #2D5AB8;
            --primary-light: #83c3e5;
            --white: #ffffff;
        }

        /* === SIDEBAR CUSTOM === */
        /* Mengganti latar belakang sidebar dengan gradasi baru */
        .sidebar.bg-gradient-primary {
            background-color: var(--primary-dark);
            background-image: linear-gradient(180deg, var(--primary-dark) 10%, var(--primary-light) 100%);
            background-size: cover;
        }

        /* Mengganti warna link aktif di sidebar */
        .sidebar.sidebar-dark .nav-item.active .nav-link {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
        }

        .sidebar.sidebar-dark .nav-item .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
        }

        /* === TOMBOL & AKSEn CUSTOM === */
        /* Mengganti warna tombol primary di seluruh aplikasi */
        .btn-primary {
            background-color: var(--primary-light) !important;
            border-color: var(--primary-light) !important;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        /* Mengganti warna tombol close di modal */
        .modal-header .btn-close {
            background-color: #ddd;
        }

        .modal-footer .btn-primary {
            background-color: var(--primary-light) !important;
            border-color: var(--primary-light) !important;
        }

        .modal-footer .btn-primary:hover {
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        /* Mengganti warna tombol scroll-to-top */
        a.scroll-to-top {
            background-color: var(--primary-light);
        }

        a.scroll-to-top:hover {
            background-color: var(--primary-dark);
        }

        /* Mengganti warna shadow topbar agar lebih halus */
        .topbar {
            box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .05) !important;
        }
    </style>
</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('backend.dashboard') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="bi bi-building"></i>
                </div>
                <div class="sidebar-brand-text mx-3">
                    @if(auth()->user()->role === 'admin')
                    Administrator
                    @else
                    Resepsionis
                    @endif
                </div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item {{ request()->routeIs('backend.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('backend.dashboard') }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            @if(Auth::user()->role === 'admin')
            <li class="nav-item {{ request()->routeIs('backend.user.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('backend.user.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Pengguna</span>
                </a>
            </li>
            @endif

            <li class="nav-item {{ request()->routeIs('backend.kamar.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('backend.kamar.index') }}">
                    <i class="bi bi-door-open-fill"></i>
                    <span>Kamar</span>
                </a>
            </li>

            <li class="nav-item {{ request()->routeIs('backend.pemesanan.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('backend.pemesanan.index') }}">
                    <i class="bi bi-card-list"></i>
                    <span>Pemesanan</span>
                </a>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="bi bi-list"></i>
                    </button>
                    <ul class="navbar-nav ms-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="me-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->nama ?? 'Guest' }}</span>
                                <img class="img-profile rounded-circle"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->nama ?? 'G') }}&background=5B94E8&color=fff">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="bi bi-box-arrow-right fa-sm fa-fw me-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Kelompok 5 WP2: Manajemen Pemesanan Hotel</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="bi bi-arrow-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda Yakin Ingin Keluar?</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" href="{{ route('backend.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('backend.logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')

</body>

</html>