<?php

namespace App\Middlewares;

use App\Core\Auth;

class AdminMiddleware
{
    public function handle(): bool
    {
        if (!Auth::checkAdmin()) {
            header('Location: /admin/login');
            return false;
        }
        return true;
    }
}
