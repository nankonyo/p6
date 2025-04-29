<?php

namespace Core;

class Route
{
    private static $routes = [];

    // Menambahkan rute GET
    public function get($uri, $action)
    {
        self::$routes['GET'][$uri] = $action;
    }

    // Menangani rute
    public static function start()
    {
        $url = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];

        // Mencari rute yang sesuai
        foreach (self::$routes[$method] as $route => $action) {
            if ($route === $url) {
                // Menangani controller dan method
                list($controller, $method) = $action;
                $controller = new $controller();
                $controller->$method();
                return;
            }
        }

        // Jika tidak ditemukan, tampilkan error 404
        self::error('404 Not Found');
    }

    private static function error($message)
    {
        http_response_code(404);
        echo "<h1>404 Not Found</h1><p>$message</p>";
        exit;
    }
}
