<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.exists' => 'Email tidak ditemukan.',
            'password.required' => 'Password harus diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Log::info('Attempting login for email: ' . $request->get('email'));

        // Attempt login
        if ($this->attemptLogin($request)) {
         
            session()->flash('success', 'Login berhasil! Selamat datang kembali.');
            return $this->sendLoginResponse($request);
        } else {
           
            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        Log::info('Attempting login', [
            'email' => $credentials['email'],
            'is_active' => $credentials['is_active'] ?? null,
        ]);

        return Auth::attempt($credentials, $request->filled('remember'));
    }

    /**
     * Get the login credentials and include email and password.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'is_active' => true, // Only allow login for active users
        ];
    }

    /**
     * Send the response after the user failed to login.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        Log::warning('Login failed', [
            'email' => $request->get('email'),
            'reason' => 'Invalid credentials or inactive user',
        ]);

        // Set error message for SweetAlert
        session()->flash('error', 'Kombinasi email dan password salah.');

        return redirect()->back()
            ->withInput($request->only('email', 'remember'));
    }
}
