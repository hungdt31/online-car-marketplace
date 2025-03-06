<?php

class Auth extends Controller
{
    private $jwt;
    public function __construct()
    {
        $this->jwt = new JwtAuth();
    }
    public function index()
    {
        $rs = $this->jwt->decodeTokenFromCookie('access');
        // echo '<pre>'. print_r($rs, true) .'</pre>';
        if ($rs['success']) {
            header('Location: /');
        } else {
            $this->renderAuth([
                'page_title' => 'Sign in - Sign up',
                'view' => 'auth/index'
            ]);
        }
    }
    public function signIn()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rs = $this->jwt->decodeTokenFromCookie('access');
            if ($rs['success']) {
                echo json_encode($rs);
                exit();
            }
            $email = $_POST['email'];
            $password = $_POST['password'];
            global $config;
            foreach ($config['fake-user-data'] as $user) {
                if ($user['email'] == $email && $user['password'] == $password) {
                    $payload = [
                        "email" => $email,
                        "password" => $password,
                        "role" => $user['role'],
                    ];
                    $this->jwt->encodeDataToCookie($payload);
                    $token = $this->jwt->getTokenFromCookie();
                    // Đợi cookie được lưu bằng cách kiểm tra nó trong vòng lặp
                    $maxWaitTime = 3; // Thời gian tối đa chờ (giây)
                    $startTime = time();
                    while (!isset($token['access']['value']) && !isset($token['refresh']['value']) && (time() - $startTime) < $maxWaitTime) {
                        usleep(50000); // Chờ 50ms rồi kiểm tra lại
                    }
                    echo json_encode([
                        'success' => true,
                        'message' => 'Successfully logged in',
                    ]);
                    exit();
                }
            }
            echo json_encode([
                'success' => false,
                'message' => 'Invalid email or password'
            ]);
        }
    }
    public function signup()
    {
        echo 'Sign up';
    }
    public function logout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->jwt->deleteTokenFromCookie();
            echo json_encode([
                'success' => true,
                'message' => 'Successfully logged out'
            ]);
        }
    }
}