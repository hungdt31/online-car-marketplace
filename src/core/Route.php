<?php

class Route
{
    private $public_routes = [
        '/auth',
        '/',
    ];
    public function handleRoute($url)
    {
        global $routes;

        // Lấy controller mặc định nếu không có URL được cung cấp
        $defaultController = $routes['default_controller'] ?? 'home';

        // Xóa default_controller khỏi danh sách routes để không lặp qua
        unset($routes['default_controller']);

        // Loại bỏ dấu gạch chéo ở đầu và cuối URL
        $url = trim($url, '/');

        // Nếu URL rỗng, trả về controller mặc định
        if (empty($url)) {
            return $defaultController;
        }

        $handleUrl = $url;

        // Lặp qua các routes và so khớp
        if (!empty($routes)) {
            foreach ($routes as $key => $value) {
                // Kiểm tra khớp với pattern của route
                $pattern = '~^' . str_replace(['(:num)', '(:any)'], ['(\d+)', '(.+)'], $key) . '$~is';
                if (preg_match($pattern, $url)) {
                    // Thay thế URL dựa trên route
                    $handleUrl = preg_replace($pattern, $value, $url);
                    break; // Dừng khi đã tìm thấy route khớp
                }
            }
        }

        return $handleUrl;
    }
    public function getPublicRoute()
    {
        return $this->public_routes;
    }
}

