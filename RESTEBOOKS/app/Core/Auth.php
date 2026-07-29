<?php

namespace App\Core;

class Auth
{
    // ---- User (subscriber) guard -----------------------------------

    public static function loginUser(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
    }

    public static function user(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }
        return \App\Models\User::find($_SESSION['user_id']);
    }

    public static function checkUser(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function logoutUser(): void
    {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);
        session_regenerate_id(true);
    }

    // ---- Admin guard --------------------------------------------------

    public static function loginAdmin(array $admin): void
    {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
    }

    public static function admin(): ?array
    {
        if (empty($_SESSION['admin_id'])) {
            return null;
        }
        return \App\Models\Admin::find($_SESSION['admin_id']);
    }

    public static function checkAdmin(): bool
    {
        return !empty($_SESSION['admin_id']);
    }

    public static function logoutAdmin(): void
    {
        unset($_SESSION['admin_id'], $_SESSION['admin_name']);
        session_regenerate_id(true);
    }

    // ---- Brute-force throttling ----------------------------------------

    public static function tooManyAttempts(string $key, int $maxAttempts = 5, int $decaySeconds = 300): bool
    {
        $bucket = $_SESSION['login_attempts'][$key] ?? ['count' => 0, 'first' => time()];

        if (time() - $bucket['first'] > $decaySeconds) {
            $bucket = ['count' => 0, 'first' => time()];
        }

        return $bucket['count'] >= $maxAttempts;
    }

    public static function hit(string $key): void
    {
        $bucket = $_SESSION['login_attempts'][$key] ?? ['count' => 0, 'first' => time()];
        $bucket['count']++;
        $_SESSION['login_attempts'][$key] = $bucket;
    }

    public static function clearAttempts(string $key): void
    {
        unset($_SESSION['login_attempts'][$key]);
    }
}
