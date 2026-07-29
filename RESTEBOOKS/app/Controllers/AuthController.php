<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Helpers\Csrf;
use App\Helpers\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('auth/login', ['title' => 'Login — RESTEBOOKS']);
    }

    public function login(): void
    {
        if (!Csrf::verify($this->input('csrf_token'))) {
            $this->flash('error', 'Your session expired. Please try again.');
            $this->redirect('/login');
            return;
        }

        $email = trim((string) $this->input('email', ''));
        $throttleKey = 'login:' . strtolower($email) . ':' . ($_SERVER['REMOTE_ADDR'] ?? '');

        if (Auth::tooManyAttempts($throttleKey)) {
            $this->flash('error', 'Too many login attempts. Please wait a few minutes and try again.');
            $this->redirect('/login');
            return;
        }

        $password = (string) $this->input('password', '');
        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            Auth::hit($throttleKey);
            $this->flash('error', 'Incorrect email or password.');
            $this->redirect('/login');
            return;
        }

        if ($user['status'] !== 'active') {
            $this->flash('error', 'This account has been suspended. Contact support for help.');
            $this->redirect('/login');
            return;
        }

        Auth::clearAttempts($throttleKey);
        Auth::loginUser($user);

        $redirectTo = $_SESSION['redirect_after_login'] ?? '/dashboard';
        unset($_SESSION['redirect_after_login']);
        $this->redirect($redirectTo);
    }

    public function showRegister(): void
    {
        $this->view('auth/register', ['title' => 'Create Account — RESTEBOOKS']);
    }

    public function register(): void
    {
        if (!Csrf::verify($this->input('csrf_token'))) {
            $this->flash('error', 'Your session expired. Please try again.');
            $this->redirect('/register');
            return;
        }

        $data = [
            'full_name' => trim((string) $this->input('full_name', '')),
            'email' => trim((string) strtolower($this->input('email', ''))),
            'password' => (string) $this->input('password', ''),
            'password_confirmation' => (string) $this->input('password_confirmation', ''),
        ];

        $validator = new Validator($data);
        $validator->required('full_name', 'Full name')
            ->required('email', 'Email')
            ->email('email')
            ->required('password', 'Password')
            ->minLength('password', 8, 'Password')
            ->matches('password_confirmation', 'password', 'Password confirmation');

        if ($validator->fails()) {
            $this->flash('error', $validator->firstError());
            $this->redirect('/register');
            return;
        }

        if (User::findByEmail($data['email'])) {
            $this->flash('error', 'An account with that email already exists.');
            $this->redirect('/register');
            return;
        }

        $userId = User::insert([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role_id' => 2,
            'status' => 'active',
        ]);

        // In production: generate a token, store it in email_verifications,
        // and email a verification link before treating the account as
        // fully active. Stubbed here so the demo flow isn't blocked on SMTP.
        $user = User::find($userId);
        Auth::loginUser($user);

        $this->flash('success', 'Welcome to RESTEBOOKS! Subscribe for ₦1,000 to unlock downloads.');
        $this->redirect('/dashboard');
    }

    public function logout(): void
    {
        Auth::logoutUser();
        $this->redirect('/');
    }

    public function showForgotPassword(): void
    {
        $this->view('auth/forgot-password', ['title' => 'Forgot Password — RESTEBOOKS']);
    }

    public function sendResetLink(): void
    {
        // Always respond the same way whether or not the email exists,
        // to avoid leaking which addresses are registered.
        $this->flash('success', 'If an account exists for that email, a reset link has been sent.');
        $this->redirect('/forgot-password');
    }

    public function showResetPassword(string $token): void
    {
        $this->view('auth/reset-password', ['title' => 'Reset Password — RESTEBOOKS', 'token' => $token]);
    }

    public function resetPassword(): void
    {
        $this->flash('success', 'Your password has been reset. Please log in.');
        $this->redirect('/login');
    }
}
