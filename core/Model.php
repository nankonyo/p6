<?php

namespace Core;

class Model
{
    // Implementasi dasar Model di sini
    protected $db;

    public function __construct()
    {
        // Koneksi DB atau pengaturan lainnya
        $this->db = new Database(); // Misalnya ini adalah koneksi DB
    }
}
