<?php
class App {
    private $__controller, $__action, $__params, $__routes;
    function __construct()
    {
        global $routes;

        $this->__routes = new Route();

        if (!empty($routes['default_controller'])) {
            $this->__controller = $routes['default_controller'];
        }
        // default action for controller
        $this->__action = 'index';
        $this->__params = [];
        $this->handleUrl();
    }
    public function getUrl()
    {
        if (!empty($_SERVER['PATH_INFO'])) {
            $url = $_SERVER['PATH_INFO'];
        }
        else {
            $url = '/';
        }
        return $url;
    }
    public function handleUrl() {
        $url = $this->getUrl();
        $url = $this->__routes->handleRoute($url);

//        echo $url;
        $urlArr = array_filter(explode('/', $url));
        $urlArr = array_values($urlArr);
//        echo '<pre>'.print_r($urlArr, true).'</pre>';

        $urlCheck = '';
        if (!empty($urlArr)) {
            for ($i = 0; $i < count($urlArr); $i++) {
                $urlCheck .= $urlArr[$i] . '/';
                // Loại bỏ dấu / cuối cùng
                $fileCheck = rtrim($urlCheck, '/');
                // Chia URL thành các phần tử
                $fileArr = explode('/', $fileCheck);
                // Viết hoa chữ cái đầu của phần tử cuối cùng
                $fileArr[count($fileArr) - 1] = ucfirst($fileArr[count($fileArr) - 1]);
                // Gộp các phần tử trong $fileArr thành một chuỗi, ngăn cách bởi dấu /
                $fileCheck = implode('/', $fileArr);

                if (!empty($urlArr[$i - 1])) {
                    unset($urlArr[$i - 1]);
                }

                if (file_exists('app/controllers/' . ($fileCheck) . '.php')) {
                    $urlCheck = $fileCheck;
                    break;
                }
            }
            $urlArr = array_values($urlArr);
        }

//        echo $urlCheck. '<br/>';
//        echo '<pre>'.print_r($urlArr, true).'</pre>';
        // handle controller
        if (!empty($urlArr[0])){
            // convert to lowercase string
            $this->__controller = ucfirst($urlArr[0]);
            // file_exists using for root directory, require_once using for current directory
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        if (file_exists('app/controllers/'.$urlCheck.'.php')) {
            // echo $this->__controller;
            require_once 'controllers/'.($urlCheck).'.php';
            // check class $this->__controller exist
            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller();
                unset($urlArr[0]);
            } else {
                $this->loadError();
            }
        } else {
            $this->loadError();
        }
        // handle action
        if (!empty($urlArr[1])){
            $this->__action = ucfirst($urlArr[1]);
            unset($urlArr[1]);
        }
        // handle params
        $this->__params = array_values($urlArr);

        // check method exist
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError();
        }
//        echo '<pre>';
//        print_r($this->__params);
//        echo '</pre>';
    }
    public function loadError($name='404')
    {
        require_once 'errors/'.$name.'.php';
    }
}
