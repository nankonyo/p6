<?php
namespace Core;

class View
{
    public static function render($viewName, $data = [])
    {
        $viewPath = __DIR__ . '/../app/views/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            echo "View file not found: " . $viewName;
            return;
        }

        extract($data);

        // Simpan hasil view ke buffer
        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        // Jika ada layout, render layout dan sisipkan $content
        if (isset($layout)) {
            $layoutPath = __DIR__ . '/../app/views/' . $layout . '.php';
            if (file_exists($layoutPath)) {
                include $layoutPath;
            } else {
                echo "Layout file not found: " . $layout;
            }
        } else {
            // Kalau tidak ada layout, langsung echo content
            echo $content;
        }
    }
}

?>