<?php
class Users extends Controller
{
    public $user_model;
    public $file_model;
    public function __construct()
    {
        $this->user_model = $this->model('UserModel');
        $this->file_model = $this->model('FileModel');
    }

    public function index()
    {
        $users = $this->user_model->findAll();
        $payload = SessionFactory::createSession('account')->getProfile();
        $this->renderAdmin([
            'page_title' => 'User Management',
            'view' => 'protected/userManager',
            'content' => [
                'title' => 'User Management',
                'payload' => $payload,
                'users' => $users
            ]
        ]);
    }

    // Get user details
    public function info($id)
    {
        $user = $this->user_model->findById($id);
        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found']);
        }
    }

    // Add new user
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone'],
                'role' => $_POST['role'] ?? 'user',
                'provider' => 'credential',
                'fname' => $_POST['fname'] ?? '',
                'lname' => $_POST['lname'] ?? '',
                'bio' => $_POST['bio'] ?? '',
                'address' => $_POST['address'] ?? '',
                'avatar_id' => null
            ];

            $result = $this->user_model->createOne($data);
            echo json_encode($result);
        }
    }

    // Update user
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'] ?? '',
                'role' => $_POST['role'] ?? '',
                'status' => $_POST['status'] ?? 'active',
            ];

            $result = $this->user_model->updateByAdmin($id, $data);
            if ($result) {
                $user = $this->user_model->findById($id);
                echo json_encode(['success' => true, 'user' => $user]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user']);
            }
        }
    }

    // Delete user
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->user_model->findById($id);
            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'User not found']);
                return;
            }

            // Delete user avatar if exists
            if (isset($user['avatar_id'])) {
                $this->file_model->deleteOne($user['avatar_id']);
            }
 
            if (isset($user['avatar_key'])) {
                $aws = new AwsS3Service();
                $aws->deleteFile($user['avatar_key']);
            }
            $result = $this->user_model->deleteOne($id);
            echo json_encode($result);
        }
    }

    // Update user status
    public function updateUserStatus($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            $result = $this->user_model->updateStatus($id, $status);
            if ($result) {
                $user = $this->user_model->findById($id);
                echo json_encode(['success' => true, 'user' => $user]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user status']);
            }
        }
    }
}
