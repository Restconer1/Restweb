<?php

namespace App\Models;

use App\Core\Model;

class Subscription extends Model
{
    protected static string $table = 'subscriptions';

    public static function activeFor(int $userId): ?array
    {
        $stmt = static::db()->prepare(
            "SELECT * FROM subscriptions
             WHERE user_id = :user_id AND status = 'active' AND expires_at > NOW()
             ORDER BY expires_at DESC LIMIT 1"
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch() ?: null;
    }

    public static function isActive(int $userId): bool
    {
        return self::activeFor($userId) !== null;
    }

    public static function activate(int $userId, int $durationDays): int
    {
        $startsAt = date('Y-m-d H:i:s');
        $expiresAt = date('Y-m-d H:i:s', strtotime("+{$durationDays} days"));

        return self::insert([
            'user_id' => $userId,
            'plan' => 'premium',
            'status' => 'active',
            'starts_at' => $startsAt,
            'expires_at' => $expiresAt,
        ]);
    }
}
