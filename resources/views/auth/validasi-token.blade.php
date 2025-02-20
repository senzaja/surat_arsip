<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('public/sneat/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ __('menu.auth.forgot') }} | {{ config('app.name') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('sneat/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" class="template-customizer-core-css" href="{{ asset('sneat/vendor/css/core.css') }}" />
    <link rel="stylesheet" class="template-customizer-theme-css" href="{{ asset('sneat/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/css/demo.css') }}" />

    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('sneat/vendor/css/pages/page-auth.css') }}" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ route('home') }}" class="app-brand-link gap-2">
                                <img src="{{ asset('sneat/img/ss.png') }}" alt="{{ config('app.name') }}" srcset=""
                                    width="75px">
                            </a>
                        </div>
                        <div>
                            <center><h4>E-ARSIP</h4></center>
                        </div>
                        <form id="formAuthentication" class="mb-3" action="{{ route('validasi-forgot-password_act') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <p>Masukkan Password Baru Kamu</p>
                            <div class="mb-3">
                                <input type="password" class="form-control" name="password" placeholder="password"
                                    aria-label="password" required>
                            </div>
                            @error('password')
                            <small>{{ $message }}</small>
                            @enderror
                            <div class="row">
                                <div class='col-12'>
                                    <button type="submit" class="btn btn-primary d-grid w-100">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- Script to show notifications based on session flash data -->
    <div class="">
        <!-- Form content, dll. -->

        <!-- Notifikasi SweetAlert -->
        @if(session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
        @endif

        @if(session('failed'))
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('failed') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
        @endif
    </div>
</body>

</html>
