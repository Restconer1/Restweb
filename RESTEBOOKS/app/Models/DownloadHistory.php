<?php

namespace App\Models;

use App\Core\Model;

class DownloadHistory extends Model
{
    protected static string $table = 'download_history';

    public static function forUser(int $userId): array
    {
        $stmt = static::db()->prepare(
            "SELECT d.*, b.title, b.cover_path, b.slug FROM download_history d
             JOIN books b ON b.id = d.book_id
             WHERE d.user_id = :user_id ORDER BY d.downloaded_at DESC"
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
}
