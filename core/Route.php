<?php

namespace Core;

use Core\Middleware;

class Route
{
    private static $routes = [];

    // Menambahkan rute GET
    public function get($uri, $action, $middleware = [])
    {
        self::$routes['GET'][$uri] = [
            'action' => $this->normalizeAction($action),
            'middleware' => $middleware
        ];
    }

    // Menambahkan rute POST
    public function post($uri, $action, $middleware = [])
    {
        self::$routes['POST'][$uri] = [
            'action' => $this->normalizeAction($action),
            'middleware' => $middleware
        ];
    }

    // Menormalkan format action
    private function normalizeAction($action)
    {
        if (is_string($action)) {
            if (strpos($action, '@') === false) {
                throw new \Exception("Format action string harus 'Controller@method'");
            }

            list($controller, $method) = explode('@', $action);
            $controller = "App\\Controllers\\" . $controller;

            return [$controller, $method];
        }

        if (is_array($action) && count($action) === 2) {
            return $action;
        }

        throw new \Exception("Format action tidak valid.");
    }

    // Menjalankan rute yang sesuai dengan request
    public static function start()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset(self::$routes[$method][$url])) {
            $route = self::$routes[$method][$url];
            $action = $route['action'];
            $middlewareList = $route['middleware'];

            // Jalankan middleware jika ada
            if (!empty($middlewareList)) {
                foreach ($middlewareList as $middleware) {
                    // Pastikan class middleware ada dan dapat dijalankan
                    if (!class_exists($middleware)) {
                        throw new \Exception("Middleware class '$middleware' tidak ditemukan.");
                    }

                    // Pastikan middleware memiliki metode handle()
                    $middlewareInstance = new $middleware();
                    if (!method_exists($middlewareInstance, 'handle')) {
                        throw new \Exception("Middleware class '$middleware' tidak memiliki method 'handle'.");
                    }

                    $middlewareInstance->handle();
                }
            }

            // Jalankan controller
            list($controller, $methodName) = $action;
            $controllerInstance = new $controller();
            $controllerInstance->$methodName();
            return;
        }

        self::error('404 Not Found');
    }

    // Jika rute tidak ditemukan
    private static function error($message)
    {
        http_response_code(404);
        echo "<h1>404 Not Found</h1><p>$message</p>";
        exit;
    }
}
