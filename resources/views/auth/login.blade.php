<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('public/sneat/') }}" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ __('menu.auth.login') }} | {{ config('app.name') }}</title>
    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{asset('sneat/img/favicon/favicon.ico')}}" />

    <!-- Tambahkan FontAwesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('sneat/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" class="template-customizer-core-css" href="{{asset('sneat/vendor/css/core.css')}}" />
    <link rel="stylesheet" class="template-customizer-theme-css"
        href="{{asset('sneat/vendor/css/theme-default.css')}}" />
    <link rel="stylesheet" href="{{asset('sneat/css/demo.css')}}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{asset('sneat/vendor/css/pages/page-auth.css')}}" />

    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db, #9b59b6);
            border: none;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #9b59b6, #3498db);
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .form-control {
            border-radius: 30px;
            padding: 0.75rem 1.25rem;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.5);
            outline: none;
        }

        .card-footer p {
            margin-bottom: 0;
        }

        .text-gradient {
            background: linear-gradient(45deg, #3498db, #2980b9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .app-brand img {
            width: 80px;
            margin-bottom: 1rem;
        }

        .card-body {
            padding: 2rem;
        }

        .authentication-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .authentication-inner {
            max-width: 450px;
            width: 100%;
        }

        .input-group .input-group-text {
            border-radius: 30px 0 0 30px;
            background-color: #f0f4f8;
        }

        h4 {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="mt-5">
                            <center>
                                <h4>E-ARSIP</h4>
                            </center>
                        </div>
                        <div>
                            <p>Login</p>
                        </div>
                        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="email" placeholder="Masukan Email Anda" required>
                            </div>


                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password Anda" required>
                                <span class="input-group-text" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                                    <i class="fa fa-eye" id="togglePasswordIcon"></i>
                                </span>
                            </div>




                            <div class="mt-2">
                                <button class="btn btn-primary d-grid w-100"
                                    type="submit">{{ __('menu.auth.login') }}</button>
                            </div>

                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <br>
                                {{-- <p class="mb-4 text-sm mx-auto">
                                    Belum punya akun? <a href="{{ url('register') }}"
                                        class="text-info text-gradient font-weight-bold">Register</a>
                                </p>  --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    <div>
        @if (session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: "{{ session('error') }}",
                confirmButtonText: 'OK'
            });
        </script>
        @endif
    </div>
    <script>
        const passwordInput = document.getElementById('password');

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const togglePasswordIcon = document.getElementById('togglePasswordIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePasswordIcon.classList.remove('fa-eye-slash');
                togglePasswordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
