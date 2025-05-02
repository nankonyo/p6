<?php

namespace Core;

class Middleware
{
    /**
     * Jalankan satu atau beberapa middleware.
     *
     * @param array $middlewareList Daftar nama class middleware
     * @return void
     */
    public static function handle(array $middlewareList)
    {
        foreach ($middlewareList as $middlewareClass) {
            if (!class_exists($middlewareClass)) {
                throw new \Exception("Middleware class '$middlewareClass' tidak ditemukan.");
            }

            $middleware = new $middlewareClass;

            if (!method_exists($middleware, 'handle')) {
                throw new \Exception("Middleware '$middlewareClass' harus punya method handle().");
            }

            $middleware->handle();
        }
    }
}
