 <!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
      data-assets-path="{{ asset('public/sneat/') }}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>{{ __('menu.auth.register') }} | {{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{asset('sneat/img/favicon/favicon.ico')}}"/>
    <link rel="stylesheet" href="{{asset('sneat/vendor/fonts/boxicons.css')}}"/>
    <link rel="stylesheet" class="template-customizer-core-css" href="{{asset('sneat/vendor/css/core.css')}}"/>
    <link rel="stylesheet" class="template-customizer-theme-css" href="{{asset('sneat/vendor/css/theme-default.css')}}"/>
    <link rel="stylesheet" href="{{asset('sneat/css/demo.css')}}"/>
    <link rel="stylesheet" href="{{asset('sneat/vendor/css/pages/page-auth.css')}}"/>

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
            background-color: #3498db;
            border-color: #3498db;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        .form-control {
            border-radius: 30px;
            padding: 0.75rem 1.25rem;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        .card-body {
            padding: 2rem;
        }
    </style>
</head>

<body>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        <center><h4>E-ARSIP</h4></center>
                    </div>
                    <div>
                        <p>Register</p>
                    </div>
                    <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Name" aria-label="Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email" aria-label="Email" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" aria-label="Confirm Password" required>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Register') }}</button>
                        </div>
                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                            <p class="mb-4 text-sm mx-auto">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-info text-gradient font-weight-bold">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>  
