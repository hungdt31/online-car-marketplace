<?php

class Account extends Controller
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
        $breadcrumbs = [
            ['name' => 'Home', 'url' => _WEB_ROOT],
            ['name' => 'Account', 'url' => '']
        ];
        $profile = SessionFactory::createSession('account')->getProfile();
        $this->renderGeneral([
            'page_title' => 'Account',
            'view' => 'protected/account',
            'content' => [
                'profile' => $profile,
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
}