<?php

class Account extends Controller
{
    private $jwt;
    private $user_model;
    private $appointments_model;
    private $blog_comments_model;
    public function __construct()
    {
        $this->jwt = new JwtAuth();
        $this->user_model = $this->model('UserModel');
        $this->appointments_model = $this->model('AppointmentModel');
        $this->blog_comments_model = $this->model('BlogCommentsModel');
    }
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Home', 'url' => _WEB_ROOT],
            ['name' => 'Account', 'url' => '']
        ];
        $profile = SessionFactory::createSession('account')->getProfile();
        $appointments = $this->appointments_model->getAll($profile['id']);
        $this->renderGeneral([
            'page_title' => 'Account',
            'view' => 'protected/account',
            'content' => [
                'profile' => $profile,
                'appointments' => $appointments,
                'header' => [
                    'title' => $profile ? $profile['fname']. ' '. $profile['lname'] : 'My account',
                    'description' => $breadcrumbs
                ]
            ]
        ]);
    }
    public function updateProfile()
    {
        $profile = SessionFactory::createSession('account')->getProfile();
        // lấy ra các trường không null trong $_POST
        $data = array_filter($_POST, function ($value) {
            return !is_null($value);
        });
        $status = $this->user_model->updateOne($profile['id'], $data);
        if ($status) {
            $user = $this->user_model->findById($profile['id']);
            SessionFactory::createSession('account')->setProfile($user);
            echo json_encode([
                'success' => true,
                'message' => 'Update profile successfully!',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Update profile failed!',
            ]);
        }
    }
    public function cancelAppointment()
    {
        $appointmentId = $_POST['appointment_id'];
        $status = $this->appointments_model->updateStatus($appointmentId, 'cancelled');
        if ($status) {
            echo json_encode([
                'success' => true,
                'message' => 'Cancel appointment successfully!',
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Cancel appointment failed!',
            ]);
        }
    }
    public function addComment()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get current user
            $session = SessionFactory::createSession('account');
            $user = $session->getProfile();
            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'message' => 'User not found'
                ]);
                return;
            }

            $data = [
                'blog_id' => $_POST['blog_id'],
                'user_id' => $user['id'],
                'content' => $_POST['content']
            ];

            $result = $this->blog_comments_model->addComment($data);
            if ($result) {
                echo json_encode([
                    "success" => true,
                    "message" => "Comment added successfully!"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Failed to add comment."
                ]);
            }
        }
    }
    
    public function changePassword()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
            return;
        }
        
        // Lấy thông tin người dùng hiện tại
        $session = SessionFactory::createSession('account');
        $user = $session->getProfile();
        if (!$user) {
            echo json_encode([
                'success' => false,
                'message' => 'User not found'
            ]);
            return;
        }
        
        // Kiểm tra dữ liệu đầu vào
        if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Please fill in all required fields'
            ]);
            return;
        }
        
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        
        // Kiểm tra xác nhận mật khẩu mới
        if ($newPassword !== $confirmPassword) {
            echo json_encode([
                'success' => false,
                'message' => 'Confirm password does not match new password'
            ]);
            return;
        }
        
        // Kiểm tra mật khẩu hiện tại
        $hashedCurrentPassword = $this->user_model->hashPassword($currentPassword);
        $userDetail = $this->user_model->findById($user['id']);
        
        if (!$userDetail || !hash_equals($hashedCurrentPassword, $userDetail['password'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Current password is incorrect'
            ]);
            return;
        }
        
        // Kiểm tra độ phức tạp của mật khẩu mới
        if (strlen($newPassword) < 8) {
            echo json_encode([
                'success' => false,
                'message' => 'New password must be at least 8 characters long'
            ]);
            return;
        }
        
        // Các điều kiện khác về mật khẩu mạnh
        $uppercase = preg_match('/[A-Z]/', $newPassword);
        $lowercase = preg_match('/[a-z]/', $newPassword);
        $number = preg_match('/[0-9]/', $newPassword);
        $specialChars = preg_match('/[!@#$%^&*]/', $newPassword);
        
        if (!$uppercase || !$lowercase || !$number || !$specialChars) {
            echo json_encode([
                'success' => false,
                'message' => 'New password must include uppercase, lowercase, number and special character'
            ]);
            return;
        }
        
        // Cập nhật mật khẩu mới
        $status = $this->user_model->updatePassword([
            'email' => $user['email'],
            'password' => $newPassword
        ]);
        
        if ($status) {
            echo json_encode([
                'success' => true,
                'message' => 'Password has been updated successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Could not update password. Please try again'
            ]);
        }
    }
    
    /**
     * Upload and update user avatar
     */
    public function uploadAvatar()
    {
        // Check request method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method'
            ]);
            return;
        }
        
        // Get current user
        $session = SessionFactory::createSession('account');
        $user = $session->getProfile();
        if (!$user) {
            echo json_encode([
                'success' => false,
                'message' => 'User not found'
            ]);
            return;
        }
        
        // Check if file was uploaded
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode([
                'success' => false,
                'message' => 'No file uploaded or upload error'
            ]);
            return;
        }
        
        // Validate file
        $file = $_FILES['avatar'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        
        // Check file type
        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid file type. Please upload an image (JPEG, PNG, GIF, WEBP)'
            ]);
            return;
        }
        
        // Check file size
        if ($file['size'] > $maxSize) {
            echo json_encode([
                'success' => false,
                'message' => 'File is too large. Maximum size is 2MB'
            ]);
            return;
        }
        
        // Upload file to AWS S3 or server storage
        $aws = new AwsS3Service();
        $uploadResult = $aws->uploadFile($file, 'avatars');
        
        if (!$uploadResult) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to upload file'
            ]);
            return;
        }
        
        // Save file information to database
        $fileModel = $this->model('FileModel');
        $fileData = [
            'name' => $file['name'],
            'fkey' => $uploadResult['fileKey'],
            'path' => $uploadResult['fileUrl'],
            'size' => $file['size'],
            'type' => $file['type']
        ];
        
        $fileStatus = $fileModel->addFile($fileData);
        
        if (!$fileStatus) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to save file information'
            ]);
            return;
        }
        
        // Get the file ID
        $newFile = $fileModel->getFile(['fkey' => $uploadResult['fileKey']]);
        
        if (!$newFile) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to retrieve file information'
            ]);
            return;
        }
        
        // Delete old avatar if exists
        if (!empty($user['avatar_id'])) {
            // The file delete would typically happen here if needed
            // $fileModel->deleteFile($user['avatar_id']);
        }
        
        // Update user's avatar
        $updateData = [
            'avatar_id' => $newFile['id']
        ];
        
        $updateStatus = $this->user_model->updateUserAvatar($user['id'], $updateData);
        
        if (!$updateStatus) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update user avatar'
            ]);
            return;
        }
        
        // Get updated user profile
        $updatedUser = $this->user_model->findById($user['id']);
        
        // Update session
        $session->setProfile($updatedUser);
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Avatar updated successfully',
            'avatar_url' => $uploadResult['fileUrl']
        ]);
    }
}