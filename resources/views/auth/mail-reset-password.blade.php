<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f7;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #4CAF50;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .email-body {
            padding: 30px;
        }
        h4 {
            font-size: 20px;
            color: #333333;
        }
        .email-body p {
            font-size: 16px;
            color: #555555;
            line-height: 1.5;
        }
        .btn-reset {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            font-size: 16px;
            color: white;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .email-footer {
            padding: 20px;
            text-align: center;
            background-color: #f9f9f9;
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>SELAMAT DATANG DI RESET PASSWORD KAMI </h2>
        </div>
        <div class="email-body">
            <h4>Hai,</h4>
            <p>Anda telah meminta untuk mereset password akun Anda. Silakan klik tombol di bawah ini untuk melakukan reset password:</p>
            <a href="{{ route('validasi-forgot-password', ['token' => $token]) }}" class="btn-reset">Reset Password</a>
            <p>Jika Anda tidak meminta reset password ini, Anda dapat mengabaikan email ini.</p>
        </div>
        <div class="email-footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>

    <div class="container">
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
