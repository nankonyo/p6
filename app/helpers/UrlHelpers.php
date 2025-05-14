<?php

namespace App\Helpers;

class UrlHelpers
{
    /**
     * Menghasilkan URL redirect yang telah di-*encode*,
     * tanpa parameter `redir`, dan menyertakan query string lainnya.
     *
     * @return string
     */
    public static function getRedirSource(): string
    {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $queryParams = $_GET;
        unset($queryParams['redir']);

        $url = "{$scheme}://{$host}{$path}";

        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        return urlencode($url);
    }

    public static function getHost(): string
    {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $requestUri = $_SERVER['REQUEST_URI'];
        return "{$scheme}://{$host}";
    }

    public static function getFullUrl(): string
    {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $requestUri = $_SERVER['REQUEST_URI'];

        return "{$scheme}://{$host}{$requestUri}";
    }

    /**
     * Menghasilkan hanya path dari URL saat ini, tanpa query string.
     *
     * @return string
     */
    public static function getPathOnly(): string
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}
