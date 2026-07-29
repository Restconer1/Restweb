<?php

/**
 * Minimal PSR-4 autoloader for the App\ namespace so this scaffold runs
 * even before `composer install`. Once you run composer install, the
 * generated vendor/autoload.php (loaded first, see public/index.php)
 * takes over autoloading and this becomes a harmless no-op fallback.
 */
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $path = BASE_PATH . '/app/' . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($path)) {
        require $path;
    }
});
