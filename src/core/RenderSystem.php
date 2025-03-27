<?php
class RenderSystem
{
    public static function renderOne($folder, $path, $data = [])
    {
        if ($folder == 'components') {
            $_path = _DIR_ROOT . '/app/views/components/' . $path . '.php';
        } else if ($folder == 'assets') {
            $_path = _DIR_ROOT . '/assets/' . $path;
        }
        if (file_exists($_path)) {
            extract($data);
            require_once $_path;
        }
    }
    // render multiple components: mỗi component sẽ có data và name riêng truyền vào
    public static function render($folder, $components = [])
    {
        if (!empty($components)) {
            foreach ($components as $component) {
                self::renderOne($folder, $component['name'], $component['data']);
            }
        }
    }
}
