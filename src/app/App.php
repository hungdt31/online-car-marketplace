<?php

class App
{
    private $__controller, $__action, $__params, $__routes;
    private $jwt;
    function __construct()
    {
        $this->jwt = new JwtAuth();
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
        } else {
            $url = '/';
        }
        return $url;
    }
    public function handleUrl()
    {
        $url = $this->getUrl();
        $url = $this->__routes->handleRoute($url);

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

        $this->protectRoute($url);
        // echo $urlCheck. '<br/>';
        // echo '<pre>'.print_r($urlArr, true).'</pre>';
        // handle controller
        if (!empty($urlArr[0])) {
            // convert to lowercase string
            $this->__controller = ucfirst($urlArr[0]);
            // file_exists using for root directory, require_once using for current directory
        } else {
            $this->__controller = ucfirst($this->__controller);
        }

        if (file_exists('app/controllers/' . $urlCheck . '.php')) {
            // echo $this->__controller;
            require_once 'controllers/' . ($urlCheck) . '.php';
            // check class $this->__controller exist
            if (class_exists($this->__controller)) {
                $this->__controller = new $this->__controller();
                unset($urlArr[0]);
            } else {
                $this->loadError('client/index', ['error_code' => '404', 'page_title' => 'Page Not Found']);
            }
        } else {
            $this->loadError('client/index', ['error_code' => '404', 'page_title' => 'Page Not Found']);
        }
        // handle action
        if (!empty($urlArr[1])) {
            $this->__action = ucfirst($urlArr[1]);
            unset($urlArr[1]);
        }
        // handle params
        $this->__params = array_values($urlArr);

        // check method exist
        if (method_exists($this->__controller, $this->__action)) {
            call_user_func_array([$this->__controller, $this->__action], $this->__params);
        } else {
            $this->loadError('client/index', ['error_code' => '404', 'page_title' => 'Page Not Found']);
        }
        //        echo '<pre>';
        //        print_r($this->__params);
        //        echo '</pre>';
    }
    public function loadError($path = 'client/index', $data = [])
    {
        extract($data);
        require_once _DIR_ROOT . '/app/views/pages/errors/' . $path . '.php';
    }
    public function protectRoute($url)
    {
        if (!in_array($url, $this->__routes->getPublicRoute())) {
            $folder = explode('/', $url)[0];
            $directory = _DIR_ROOT . '/app/controllers'; // Đường dẫn tới thư mục cần lấy danh sách
            $protected_folders = array_filter(scandir($directory), function ($item) use ($directory) {
                if (is_dir($directory . '/' . $item) && $item != '.' && $item != '..') {
                    return $item;
                }
            });
            if (isset($folder) && in_array($folder, $protected_folders)) {
                $response = $this->jwt->getTokenFromCookie();
                $accessToken = $response['access']['value'];
                if (!isset($accessToken)) {
                    $response = $this->jwt->generateAccessFromRefresh();
                    if ($response['success']) {
                        $role = $response['payload']['role'];
                        require_once _DIR_ROOT . '/app/models/UserModel.php';
                        $userModel = new UserModel();
                        $res = $userModel->findOne($response['payload']);
                        if ($res) {
                            $session = SessionFactory::createSession('account');
                            $session->setProfile($res['data']);
                        }
                        if ($role != $folder) {
                            $this->loadError('client/index', ['error_code' => '403', 'page_title' => 'Access Denied']);
                            // echo '<script>setTimeout(function(){window.location.href = "/";}, 2000);</script>';
                            exit();
                        }
                    } else {
                        $session = SessionFactory::createSession('account');
                        $session->destroy();
                        header('Location: /auth');
                    }
                } else {
                    $payload = $this->jwt->decodeTokenFromCookie('access')['payload'];
                    // echo '<pre>' . print_r($payload, true) . '</pre>';
                    if ($payload['role'] != $folder) {
                        $this->loadError('client/index', ['error_code' => '403', 'page_title' => 'Access Denied']);
                        // echo '<script>setTimeout(function(){window.location.href = "/";}, 2000);</script>';
                        exit();
                    }
                }
            }
        } else {
            $response = $this->jwt->getTokenFromCookie();
            // echo '<pre>' . print_r($response, true) . '</pre>';
            $accessToken = $response['access']['value'];
            $session = SessionFactory::createSession('account');
            if (!isset($accessToken)) {
                $response = $this->jwt->generateAccessFromRefresh();
                if (!$response['success']) {
                    $session->destroy();
                } else {
                    require_once _DIR_ROOT . '/app/models/UserModel.php';
                    $userModel = new UserModel();
                    $res = $userModel->findOne($response['payload']);
                    if ($res) {
                        $session = SessionFactory::createSession('account');
                        $session->setProfile($res['data']);
                    }
                }
            } else {
                if ($session->getProfile() == null) {
                    $payload = $this->jwt->decodeTokenFromCookie('access')['payload'];
                    // echo '<pre>' . print_r($payload, true) . '</pre>';
                    require_once _DIR_ROOT . '/app/models/UserModel.php';
                    $userModel = new UserModel();
                    $res = $userModel->findOne($payload);
                    if ($res) {
                        $session = SessionFactory::createSession('account');
                        $session->setProfile($res['data']);
                    }
                }
            }
        }
    }
}