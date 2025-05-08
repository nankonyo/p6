<?php

namespace Core;

class Session
{
    // Mulai session jika belum dimulai
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function get($key)
    {
        self::start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    // Hapus nilai dari session
    public static function remove($key)
    {
        self::start();
        unset($_SESSION[$key]);
    }

    // Hapus semua data session
    public static function destroy()
    {
        self::start();
        session_destroy();
        session_write_close();
    }
    
}
