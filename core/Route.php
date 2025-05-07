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
                    if (is_string($middleware)) {
                        $middleware = [$middleware, 'handle'];
                    }
                
                    if (!is_array($middleware) || count($middleware) !== 2) {
                        throw new \Exception("Format middleware harus array [class, method].");
                    }
                
                    [$middlewareClass, $middlewareMethod] = $middleware;
                
                    if (!class_exists($middlewareClass)) {
                        throw new \Exception("Middleware class '$middlewareClass' tidak ditemukan.");
                    }
                
                    $middlewareInstance = new $middlewareClass();
                
                    if (!method_exists($middlewareInstance, $middlewareMethod)) {
                        throw new \Exception("Middleware method '$middlewareMethod' tidak ada di class '$middlewareClass'.");
                    }
                
                    $middlewareInstance->$middlewareMethod();
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

        $errorPage ='../public/errors/404.php';
        if (file_exists($errorPage)) {
            // Variable $message bisa dikirim ke view jika ingin ditampilkan
            include $errorPage;
        } else {
            // Fallback jika file tidak ditemukan
            echo "<h1>404 Not Found</h1><p>$message</p>";
        }

        exit;
    }
}
