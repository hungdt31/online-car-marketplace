<?php

use Google\Service\Oauth2;

class Auth extends Controller
{
    private $jwt;
    private $user_model;
    private $file_model;
    public function __construct()
    {
        $this->jwt = new JwtAuth();
        $this->user_model = $this->model('UserModel');
        $this->file_model = $this->model('FileModel');
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
            if (empty($email) || empty($password)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Email and password are required'
                ]);
                exit();
            }
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
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Username, email and password are required'
                ]);
                exit();
            }
            // kiểm tra xem password có đủ 8 ký tự và có ít nhất 1 ký tự đặc biệt không, có số không
            if (!preg_match('/^(?=.*[!@#$%^&*])(?=.*[0-9]).{8,}$/', $_POST['password'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Password must be at least 8 characters long and contain at least one special character and one number'
                ]);
                exit();
            }
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
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $user = $this->user_model->findOne(['email' => $email]);

            if ($user['success']) {
                // Generate reset token
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Save token to database
                $this->user_model->updateResetPasswordToken(
                    [
                        'email' => $email,
                        'token' => $token,
                        'expires_at' => $expires
                    ]
                );

                // Send reset email
                $resetLink = _WEB_ROOT . "/reset-password?token=" . $token;
                $subject = "Password Reset Request";
                $message = "Click the following link to reset your password: " . $resetLink . "\n\n";
                $message .= "This link will expire in 1 hour.";

                $response = Mailer::send(
                    [
                        'address' => getenv('EMAIL_USERNAME'),
                        'name' => 'Admin'
                    ],
                    [
                        'address' => $email,
                        'name' => 'User'
                    ],
                    [
                        'address' => $email,
                    ],
                    $subject,
                    $message
                );
                if ($response['success']) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Password reset link has been sent to your email.'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to send password reset link: ' . $response['message']
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'User with email ' . $email . ' does not exist.'
                ]);
            }
        } else {
            $this->renderAuth([
                'page_title' => 'Forgot password',
                'view' => 'auth/forgotPassword'
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
            $this->file_model->addFile([
                'name' => $userinfo['id'] . '-google-avatar',
                'fkey' => $userinfo['id'],
                'path' => $userinfo['picture'],
                'type' => 'image'
            ]);
            $file = $this->file_model->getFile(['fkey' => $userinfo['id']]);
            $response = $this->user_model->createOne([
                'username' => $userinfo->name,
                'email' => $userinfo->email,
                'fname' => $userinfo->givenName,
                'lname' => $userinfo->familyName,
                'provider' => 'google',
                'role' => 'user',
                'avatar_id' => $file['id']
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
    public function facebookAuth()
    {
        $fb = new FacebookClient();
        $helper = $fb->getHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (! isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        echo '<pre>' . print_r($tokenMetadata, true) . '</pre>';

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId(getenv('FACEBOOK_APP_ID')); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (! $accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        // Lấy thông tin người dùng
        $user = $fb->getUserInfo();
        echo '<pre>' . print_r($user, true) . '</pre>';
        // User is logged in with a long-lived access token.
        // You can redirect them to a members-only page.
        //header('Location: https://example.com/members.php');          
    }
    public function resetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = $_POST['token'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            // Validate passwords match
            if ($password !== $confirm_password) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Passwords do not match.'
                ]);
                return;
            }

            // Find user by token
            $user = $this->user_model->getUserByResetToken($token);

            if ($user) {
                // Update password and clear reset token
                $rs = $this->user_model->updatePassword([
                    'email' => $user['email'],
                    'password' => $password
                ]);

                if ($rs) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Password has been reset successfully.'
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Failed to reset password: ' . $rs['message']
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Invalid or expired reset token.'
                ]);
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // Show reset form
            $token = $_GET['token'] ?? '';
            if (empty($token)) {
                header('Location: /forgot-password');
                exit;
            }

            $user = $this->user_model->getUserByResetToken($token);

            if ($user) {
                $this->renderAuth([
                    'page_title' => 'Reset password',
                    'view' => 'auth/resetPassword',
                    'content' => [
                        'success' => 'Please enter your new password.',
                    ]
                ]);
            } else {
                $this->renderAuth([
                    'page_title' => 'Reset password',
                    'view' => 'auth/resetPassword',
                    'content' => [
                        'error' => 'Invalid or expired reset token. Please request a new password reset link.'
                    ]
                ]);
            }
        }
    }
    public function githubAuth()
    {
        $github = new GitHubClient();

        if (!isset($_GET['code'])) {
            exit("Login failed");
        }

        $token = $github->getAccessToken($_GET['code']);
        if (!isset($token['access_token'])) {
            header('Location: /auth?code=cannot_link_provider');
            exit;
        }

        $userInfo = $github->getUserInfo($token['access_token']);
        $email = $github->getUserEmail($token['access_token']);

        if (!$email) {
            header('Location: /auth?code=cannot_link_provider');
            exit;
        }

        $isCreated = $this->user_model->findOne(['email' => $email]);
        if (!$isCreated['data']) {
            $this->file_model->addFile([
                'name' => $userInfo['login'] . '-github-avatar',
                'fkey' => $userInfo['id'],
                'path' => $userInfo['avatar_url'],
                'type' => 'image'
            ]);
            $file = $this->file_model->getFile(['fkey' => $userInfo['id']]);
            $names = explode(' ', $userInfo['name']);
            $fname = $names[0] ?? null;
            array_shift($names);
            $lname = implode(' ', $names) ?? null;
            $response = $this->user_model->createOne([
                'username' => $userInfo['login'],
                'email' => $email,
                'provider' => 'github',
                'role' => 'user',
                'fname' => $fname,
                'lname' => $lname,
                'bio' => $userInfo['bio'],
                'address' => $userInfo['location'],
                'avatar_id' => $file['id'],
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
                    if ($provider == 'github') {
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