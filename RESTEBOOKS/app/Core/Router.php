<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, $handler, array $middleware = []): void
    {
        $this->routes['GET'][$path] = ['handler' => $handler, 'middleware' => $middleware];
    }

    public function post(string $path, $handler, array $middleware = []): void
    {
        $this->routes['POST'][$path] = ['handler' => $handler, 'middleware' => $middleware];
    }

    public function dispatch(string $method, string $uri)
    {
        $uri = strtok($uri, '?') ?: '/';
        $uri = rtrim($uri, '/');
        if ($uri === '') {
            $uri = '/';
        }

        foreach ($this->routes[$method] ?? [] as $path => $route) {
            $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $path);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                foreach ($route['middleware'] as $middlewareClass) {
                    $middleware = new $middlewareClass();
                    if ($middleware->handle() === false) {
                        return;
                    }
                }

                [$controllerClass, $action] = $route['handler'];
                $controller = new $controllerClass();
                return call_user_func_array([$controller, $action], $matches);
            }
        }

        http_response_code(404);
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>404</title>'
            . '<link rel="stylesheet" href="/assets/css/app.css"></head><body>'
            . '<div class="container" style="text-align:center;padding-top:120px;">'
            . '<h1 style="font-family:sans-serif;color:#fff;">404 — Route Not Found</h1>'
            . '<p><a href="/" style="color:#8B5CF6;">Back to Home</a></p></div></body></html>';
    }
}
