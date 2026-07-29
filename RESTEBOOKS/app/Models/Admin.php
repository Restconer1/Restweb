<?php

namespace App\Models;

use App\Core\Model;

class Admin extends Model
{
    protected static string $table = 'admins';

    public static function findByEmail(string $email): ?array
    {
        $stmt = static::db()->prepare('SELECT * FROM admins WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() ?: null;
    }
}
