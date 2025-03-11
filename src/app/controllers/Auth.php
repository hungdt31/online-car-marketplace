<?php

use Google\Service\Oauth2;

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
                    : 'Failed to sign up: ' . $response['message']
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
    public function googleAuth()
    {
        global $oauth_notice;
        $instance = new GoogleClient();
        $client = $instance->getClient();

        if (! isset($_GET["code"])) {
            exit("Login failed");
        }

        $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

        $client->setAccessToken($token["access_token"]);

        $oauth = new Oauth2($client);

        $userinfo = $oauth->userinfo->get();

        // echo "Email: " . $userinfo->email . "<br>";
        // echo "Family Name: " . $userinfo->familyName . "<br>";
        // echo "Given Name: " . $userinfo->givenName . "<br>";
        // echo "Name: " . $userinfo->name . "<br>";
        // echo "Gender: " . $userinfo->gender . "<br>";
        // echo "Locale: " . $userinfo->locale . "<br>";
        // echo "Picture: <img src='" . $userinfo->picture . "' alt='Profile Picture'><br>";

        $isCreated = $this->user_model->findOne(['email' => $userinfo->email]);
        if (!$isCreated['data']) {
            $response = $this->user_model->createOne([
                'username' => $userinfo->name,
                'email' => $userinfo->email,
                'firstname' => $userinfo->givenName,
                'lastname' => $userinfo->familyName,
                'provider' => 'google',
                'role' => 'user'
            ]);
            if ($response['success']) {
                header('Location: /auth?code=account_created');
            } else {
                header('Location: /auth?code=cannot_link_provider');
            }
        } else {
            if (isset($_COOKIE['authType'])) {
                $authType = $_COOKIE['authType'];
                if ($authType == 'signin') {
                    $provider = $isCreated['data']['provider'];
                    if ($provider == 'google') {
                        $accountSession = SessionFactory::createSession('account');
                        $accountSession->setProfile($isCreated['data']);
                        $payload = [
                            "email" => $isCreated['data']['email'],
                            "role" => $isCreated['data']['role']
                        ];
                        $this->jwt->encodeDataToCookie($payload);
                        $role = $isCreated['data']['role'];
                        if ($role == 'admin') {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /account');
                        }
                    } else {
                        header('Location: /auth?code=login_method_mismatch');
                    }
                } else {
                    header('Location: /auth?code=account_already_registered');
                }
            }
        }
    }
}