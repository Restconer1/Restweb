<?php

namespace App\Middlewares;

use App\Core\Auth;

/** Blocks already-logged-in users from re-visiting login/register pages. */
class GuestMiddleware
{
    public function handle(): bool
    {
        if (Auth::checkUser()) {
            header('Location: /dashboard');
            return false;
        }
        return true;
    }
}
