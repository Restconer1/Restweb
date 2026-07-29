<?php

namespace App\Models;

use App\Core\Model;

class Book extends Model
{
    protected static string $table = 'books';

    public static function publishedQuery(): string
    {
        return "SELECT b.*, c.name AS category_name, a.name AS author_name
                FROM books b
                LEFT JOIN categories c ON c.id = b.category_id
                LEFT JOIN authors a ON a.id = b.author_id
                WHERE b.status = 'published'";
    }

    public static function browse(array $filters = [], int $limit = 12, int $offset = 0): array
    {
        $sql = self::publishedQuery();
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= ' AND (b.title LIKE :q OR a.name LIKE :q)';
            $params['q'] = '%' . $filters['q'] . '%';
        }
        if (!empty($filters['category'])) {
            $sql .= ' AND c.slug = :category';
            $params['category'] = $filters['category'];
        }
        if (!empty($filters['premium_only'])) {
            $sql .= ' AND b.is_premium = 1';
        }

        $sort = match ($filters['sort'] ?? 'newest') {
            'downloads' => 'b.downloads_count DESC',
            'rating' => 'b.rating_avg DESC',
            default => 'b.published_at DESC',
        };
        $sql .= " ORDER BY {$sort} LIMIT :limit OFFSET :offset";

        $stmt = static::db()->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = static::db()->prepare(self::publishedQuery() . ' AND b.slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch() ?: null;
    }

    public static function featured(int $limit = 8): array
    {
        $stmt = static::db()->prepare(self::publishedQuery() . ' AND b.is_featured = 1 ORDER BY b.published_at DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function incrementDownloads(int $id): void
    {
        $stmt = static::db()->prepare('UPDATE books SET downloads_count = downloads_count + 1 WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
