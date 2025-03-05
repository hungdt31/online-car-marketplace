<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
// setcookie(name, value, expire, path, domain, secure, httponly);

//     name: Tên của cookie.
//     value: Giá trị của cookie.
//     expire (tùy chọn): Thời gian hết hạn (tính bằng giây kể từ thời điểm hiện tại). Nếu không đặt, cookie sẽ hết hạn khi đóng trình duyệt.
//     path (tùy chọn): Đường dẫn trong domain mà cookie có hiệu lực. Mặc định là / (toàn bộ trang web).
//     domain (tùy chọn): Domain mà cookie có hiệu lực (ví dụ: .example.com để dùng cho tất cả các subdomain).
//     secure (tùy chọn): Nếu đặt là true, cookie chỉ được gửi qua HTTPS.
//     httponly (tùy chọn): Nếu đặt là true, cookie không thể truy cập bằng JavaScript (chỉ dùng trong HTTP).
class Auth extends Controller{
    private $key;
    private $algo;
    private $name_token_for_access = 'access_token';
    private $name_token_for_refresh = 'refresh_token';
    private $access_token_expire = 3600;
    private $refresh_token_expire = 86400;
    public function __construct() {
        $this->key = getenv('KEY_JWT');
        $this->algo = 'HS256';
    }
    public function index() {
        $this->renderAuth([
            'page_title' => 'Sign in',
            'view' => 'auth/index'
        ]);
    }
    public function signIn() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_COOKIE[$this->name_token_for_access])) {
                try {
                    $decoded = JWT::decode($_COOKIE[$this->name_token_for_access], new Key($this->key, $this->algo));
                    echo json_encode([
                        'success' => true,
                        'message' => 'Token is valid',
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Token is invalid. Please login again.'
                    ]);
                }
            } else {
                $email = $_POST['email'];
                $password = $_POST['password'];
                global $config;
                foreach ($config['fake-user-data'] as $user) {
                    if ($user['email'] == $email && $user['password'] == $password) {
                        $payload = [
                            "email" => $email,
                            "password" => $password
                        ];
                        $jwt = JWT::encode($payload, $this->key, $this->algo);
                        setcookie('access_token', $jwt, time() + $this->access_token_expire, '/', '', false, true);
                        // Đợi cookie được lưu bằng cách kiểm tra nó trong vòng lặp
                        $maxWaitTime = 3; // Thời gian tối đa chờ (giây)
                        $startTime = time();
                        while (!isset($_COOKIE['access_token']) && (time() - $startTime) < $maxWaitTime) {
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
    }
    public function signup() {
        echo 'Sign up';
    }
}