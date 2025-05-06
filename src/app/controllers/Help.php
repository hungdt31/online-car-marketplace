<?php
class Help extends Controller
{
    public function sendQuestion() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $question = trim($_POST['question'] ?? '');

        if (empty($name) || empty($email) || empty($question)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin']);
            exit;
        }

        // Gọi model đúng chuẩn
        $model = $this->model('HelpModel');
        $success = $model->saveQuestion($name, $email, $question);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Câu hỏi đã được gửi']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Lưu thất bại']);
        }
        exit;
    }
}