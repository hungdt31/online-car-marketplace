<?php
class Route
{
    private $routes = [];

    public function __construct()
    {
        global $routes;
        $this->routes = $routes['routes'] ?? [];
    }

    public function handleRoute($url)
    {
        // Remove trailing slash
        $url = rtrim($url, '/');
        
        // Check if URL matches any defined routes
        foreach ($this->routes as $key => $value) {
            if ($url === '/' . $key) {
                return $value;
            }
        }

        return $url;
    }
} 