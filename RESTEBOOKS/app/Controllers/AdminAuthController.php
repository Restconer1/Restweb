<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Helpers\Csrf;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLogin(): void
    {
        $this->view('admin/login', ['title' => 'Admin Login — RESTEBOOKS'], 'layouts/blank');
    }

    public function login(): void
    {
        if (!Csrf::verify($this->input('csrf_token'))) {
            $this->flash('error', 'Your session expired. Please try again.');
            $this->redirect('/admin/login');
            return;
        }

        $throttleKey = 'admin_login:' . ($_SERVER['REMOTE_ADDR'] ?? '');
        if (Auth::tooManyAttempts($throttleKey)) {
            $this->flash('error', 'Too many attempts. Please wait a few minutes.');
            $this->redirect('/admin/login');
            return;
        }

        $email = trim((string) $this->input('email', ''));
        $password = (string) $this->input('password', '');
        $admin = Admin::findByEmail($email);

        if (!$admin || !password_verify($password, $admin['password_hash'])) {
            Auth::hit($throttleKey);
            $this->flash('error', 'Incorrect email or password.');
            $this->redirect('/admin/login');
            return;
        }

        Auth::clearAttempts($throttleKey);
        Auth::loginAdmin($admin);
        $this->redirect('/admin/dashboard');
    }

    public function logout(): void
    {
        Auth::logoutAdmin();
        $this->redirect('/admin/login');
    }
}
