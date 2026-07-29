<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

// Composer autoload if available, our fallback autoloader either way.
if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require BASE_PATH . '/vendor/autoload.php';
}
require BASE_PATH . '/app/autoload.php';

// ---- Environment ----------------------------------------------------------
$envFile = BASE_PATH . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
            continue;
        }
        [$key, $value] = array_map('trim', explode('=', $line, 2));
        $_ENV[$key] = $value;
        putenv("{$key}={$value}");
    }
}

// ---- Secure session configuration -----------------------------------------
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

// ---- Error visibility (never expose stack traces in production) -----------
$appConfig = require BASE_PATH . '/config/app.php';
if ($appConfig['env'] === 'local') {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(0);
}

// ---- API branch -------------------------------------------------------
if (str_starts_with($_SERVER['REQUEST_URI'], '/api')) {
    require BASE_PATH . '/routes/api.php';
    exit;
}

// ---- Web branch --------------------------------------------------------
$router = new App\Core\Router();
require BASE_PATH . '/routes/web.php';

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
