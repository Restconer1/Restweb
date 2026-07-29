<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected static string $table = '';

    protected static function db(): PDO
    {
        return Database::connection();
    }

    public static function find(int $id): ?array
    {
        $stmt = static::db()->prepare('SELECT * FROM ' . static::$table . ' WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function all(int $limit = 100, int $offset = 0): array
    {
        $stmt = static::db()->prepare('SELECT * FROM ' . static::$table . ' ORDER BY id DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function where(string $column, $value): array
    {
        $stmt = static::db()->prepare('SELECT * FROM ' . static::$table . " WHERE {$column} = :value");
        $stmt->execute(['value' => $value]);
        return $stmt->fetchAll();
    }

    public static function insert(array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($c) => ":{$c}", array_keys($data)));
        $stmt = static::db()->prepare('INSERT INTO ' . static::$table . " ({$columns}) VALUES ({$placeholders})");
        $stmt->execute($data);
        return (int) static::db()->lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $set = implode(', ', array_map(fn($c) => "{$c} = :{$c}", array_keys($data)));
        $data['id'] = $id;
        $stmt = static::db()->prepare('UPDATE ' . static::$table . " SET {$set} WHERE id = :id");
        return $stmt->execute($data);
    }

    public static function delete(int $id): bool
    {
        $stmt = static::db()->prepare('DELETE FROM ' . static::$table . ' WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}
