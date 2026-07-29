<?php

/**
 * REST API surface (JWT-authenticated), for future mobile-app clients.
 * Loaded only when the request path starts with /api — see public/index.php.
 *
 * These endpoints intentionally reuse the same Models as the web app so
 * business rules (paywall, RBAC) stay in one place.
 */

use App\Core\Jwt;
use App\Models\Book;
use App\Models\User;

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

function api_bearer_token(): ?string
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (preg_match('/Bearer\s+(\S+)/', $header, $m)) {
        return $m[1];
    }
    return null;
}

function api_auth_user(): ?array
{
    $token = api_bearer_token();
    if (!$token) {
        return null;
    }
    $payload = Jwt::decode($token);
    if (!$payload) {
        return null;
    }
    return User::find($payload['sub']);
}

if ($path === '/api/auth/login' && $method === 'POST') {
    $body = json_decode(file_get_contents('php://input'), true) ?? [];
    $user = User::findByEmail($body['email'] ?? '');

    if (!$user || !password_verify($body['password'] ?? '', $user['password_hash'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid credentials']);
        exit;
    }

    $token = Jwt::encode(['sub' => $user['id'], 'role' => 'user']);
    echo json_encode(['token' => $token, 'expires_in' => 86400]);
    exit;
}

if ($path === '/api/books' && $method === 'GET') {
    $books = Book::browse(['sort' => $_GET['sort'] ?? 'newest'], (int) ($_GET['limit'] ?? 12));
    echo json_encode(['data' => $books]);
    exit;
}

if ($path === '/api/me' && $method === 'GET') {
    $user = api_auth_user();
    if (!$user) {
        http_response_code(401);
        echo json_encode(['error' => 'Unauthenticated']);
        exit;
    }
    unset($user['password_hash']);
    echo json_encode(['data' => $user]);
    exit;
}

http_response_code(404);
echo json_encode(['error' => 'Not found']);
