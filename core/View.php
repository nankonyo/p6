<?php
namespace Core;

class View
{
    protected static $globalData = [];

    public static function setGlobalData(array $data)
    {
        self::$globalData = $data;
    }

    public static function render($viewName, $data = [])
    {
        self::setGlobalData($data); // <-- Tambah baris ini
        $viewPath = __DIR__ . '/../app/views/' . $viewName . '.php';

        if (!file_exists($viewPath)) {
            echo "View file not found: " . $viewName;
            return;
        }

        extract($data);

        ob_start();
        include $viewPath;
        $content = ob_get_clean();

        if (isset($layout)) {
            $layoutPath = __DIR__ . '/../app/views/' . $layout . '.php';
            if (file_exists($layoutPath)) {
                include $layoutPath;
            } else {
                echo "Layout file not found: " . $layout;
            }
        } else {
            echo $content;
        }
    }

    public static function component($componentPath, $data = [])
    {
        $path = __DIR__ . '/../app/views/' . $componentPath . '.php';

        if (file_exists($path)) {
            $mergedData = array_merge(self::$globalData, $data); // <-- Gabungkan
            extract($mergedData);
            include $path;
        } else {
            echo "Component not found: $componentPath";
        }
    }
}

?>