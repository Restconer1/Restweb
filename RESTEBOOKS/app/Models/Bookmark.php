<?php

namespace App\Models;

use App\Core\Model;

class Bookmark extends Model
{
    protected static string $table = 'bookmarks';

    public static function forUser(int $userId): array
    {
        $stmt = static::db()->prepare(
            "SELECT bm.*, b.title, b.cover_path, b.slug FROM bookmarks bm
             JOIN books b ON b.id = bm.book_id
             WHERE bm.user_id = :user_id ORDER BY bm.created_at DESC"
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
