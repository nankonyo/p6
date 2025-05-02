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

    // Ambil nilai dari session
    public static function get($key)
    {
        self::start(); // Pastikan session dimulai sebelum mengambil data
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    // Set nilai ke session
    public static function set($key, $value)
    {
        self::start(); // Pastikan session dimulai sebelum menyimpan data
        $_SESSION[$key] = $value;
    }

    // Hapus nilai dari session
    public static function remove($key)
    {
        self::start(); // Pastikan session dimulai sebelum menghapus data
        unset($_SESSION[$key]);
    }

    // Hapus semua data session
    public static function destroy()
    {
        self::start(); // Pastikan session dimulai sebelum menghancurkan session
        session_destroy();
        session_write_close(); // <- Tambahan aman
    }
}
