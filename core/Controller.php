<?php

namespace Core;

class Controller
{
    // Fungsi render view
    public function view($viewName, $data = [])
    {
        extract($data); // Mengubah data menjadi variabel yang dapat diakses di view
        require_once __DIR__ . '/../app/views/' . $viewName . '.php';
    }
}
