<?php

namespace App\Models;

use App\Core\Model;

class Payment extends Model
{
    protected static string $table = 'payments';

    public static function findByReference(string $reference): ?array
    {
        $stmt = static::db()->prepare('SELECT * FROM payments WHERE reference = :reference LIMIT 1');
        $stmt->execute(['reference' => $reference]);
        return $stmt->fetch() ?: null;
    }

    public static function historyFor(int $userId): array
    {
        $stmt = static::db()->prepare('SELECT * FROM payments WHERE user_id = :user_id ORDER BY created_at DESC');
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
