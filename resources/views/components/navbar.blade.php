<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar with Responsive Profile Image</title>
    <style>
        /* Avatar container */
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px; /* Ukuran default lebih kecil */
            height: 32px;
            border-radius: 50%; /* Membuat avatar berbentuk lingkaran */
            overflow: hidden; /* Memastikan gambar tidak keluar dari lingkaran */
            position: relative;
        }

        /* Avatar image */
        .avatar img {
            width: 100%; /* Skala gambar mengikuti kontainer */
            height: 100%; /* Skala gambar mengikuti kontainer */
            object-fit: cover; /* Menjaga proporsi gambar */
        }

        /* Status indicator */
        .avatar .status-indicator {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 8px; /* Sesuaikan ukuran indikator status */
            height: 8px; /* Sesuaikan ukuran indikator status */
            border-radius: 50%;
            background-color: green; /* Warna indikator online */
            border: 2px solid white; /* Batas putih untuk kontras */
        }

        /* Responsiveness for larger screens */
        @media (min-width: 768px) {
            .avatar {
                width: 36px; /* Sedikit lebih besar untuk layar lebih besar */
                height: 36px;
            }
        }

        @media (min-width: 1200px) {
            .avatar {
                width: 40px; /* Ukuran lebih besar di layar sangat lebar */
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <nav class="layout-navbar container-xxl zindex-5 navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <form action="{{ url()->current() }}">
                <div class="navbar-nav align-items-center">
                    <div class="nav-item d-flex align-items-center">
                        <i class="bx bx-search fs-4 lh-0"></i>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? '' }}"
                            class="form-control border-0 shadow-none"
                            placeholder="{{ __('navbar.search') }}"
                            aria-label="{{ __('navbar.search') }}"
                        />
                    </div>
                </div>
            </form>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{ auth()->user()->profile_picture }}" alt="User Profile Picture" class="rounded-circle" />
                            <!-- Online status indicator -->
                            <div class="status-indicator"></div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ auth()->user()->profile_picture }}" alt="User Profile Picture" class="rounded-circle" />
                                            <!-- Online status indicator -->
                                            <div class="status-indicator"></div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                        <small class="text-muted text-capitalize">{{ auth()->user()->role }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">{{ __('navbar.profile.profile') }}</span>
                            </a>
                        </li>
                        @if(auth()->user()->role == 'admin')
                        <!-- Admin-specific items can be placed here -->
                        @endif
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="dropdown-item cursor-pointer">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">{{ __('navbar.profile.logout') }}</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </nav>
</body>
</html>
