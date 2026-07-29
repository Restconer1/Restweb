<?php

namespace App\Middlewares;

use App\Core\Auth;

class AuthMiddleware
{
    public function handle(): bool
    {
        if (!Auth::checkUser()) {
            $_SESSION['flash']['error'] = 'Please log in to continue.';
            header('Location: /login');
            return false;
        }
        return true;
    }
}
