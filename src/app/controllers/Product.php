<?php
class Product extends Controller
{
    public function sendMail()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }
        $name = trim(string: $_POST['name'] ?? '');
        $email = trim(string: $_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim(string: $_POST['address'] ?? '');
        $city = trim(string: $_POST['city'] ?? '');
        $date = trim($_POST['date'] ?? '');
        $time = trim(string: $_POST['time'] ?? '');
        $message = trim(string: $_POST['message'] ?? '');

        if (empty($name) || empty($email) || empty($message) || empty($phone) || empty($address) || empty($city) || empty($date) || empty($time)) {
            // Trả về mã lỗi 400 (Bad Request) nếu thiếu thông tin
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
            exit;
        }

        // Gọi model đúng chuẩn
        $model = $this->model('ContactModel');
        $success = $model->saveQuestion($email, $name, $phone, $address, $city, $date, $time, $message);
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Email Sent Successfully!']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to send mail!']);
        }
        exit;
    }
}