<?php

class Auth extends Controller
{
    private $jwt;
    private $user_model;
    public function __construct()
    {
        $this->jwt = new JwtAuth();
        $this->user_model = $this->model('UserModel');
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
    public function signin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $rs = $this->jwt->decodeTokenFromCookie('access');
            if ($rs['success']) {
                echo json_encode($rs);
                exit();
            }
            $email = $_POST['email'];
            $password = $_POST['password'];
            $payload = [
                "email" => $email,
                "password" => $password
            ];
            // Kiểm tra email và password
            $result = $this->user_model->findOne($payload);
            if ($result) {
                $accountSession = SessionFactory::createSession('account');
                $accountSession->setProfile($result['data']);
                $payload['role'] = $result['data']['role'];
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
                    'role' => $result['data']['role']
                ]);
                exit();
            }
            echo json_encode([
                'success' => false,
                'message' => 'Invalid email or password'
            ]);
        }
    }
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $response = $this->user_model->createOne([
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => 'user'
            ]);
            echo json_encode([
                'success' => !empty($response['success']),
                'message' => !empty($response['success']) 
                    ? 'Successfully signed up, ' . $_POST['email'] 
                    : 'Failed to sign up: '. $response['message']
            ]);
        }
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