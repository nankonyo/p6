<?php

// Fungsi Global

// Fungsi untuk menyisipkan komponen view
if (!function_exists('component')) {
    function component(string $path, array $data = [])
    {
        \Core\View::component($path, $data);
    }
}

function getFullUrl() {
    $http = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://";
    $host = $_SERVER['HTTP_HOST']; // Dapatkan nama host
    $uri = $_SERVER['REQUEST_URI']; // Dapatkan URI

    return $http . $host . $uri;
}


function getPathOnly() {
    // Dapatkan protocol (http/https)
    $http = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://";
    
    // Dapatkan nama host
    $host = $_SERVER['HTTP_HOST'];
    
    // Dapatkan URI yang hanya berisi path (tanpa query string)
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    return $http . $host . $uri;
}

