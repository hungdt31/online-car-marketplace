<?php
class Dashboard extends Controller{
    public $car_model;
    public $blog_model;
    public $user_model;
    public $jwt;
    public function __construct() {
        $this->car_model = $this->model('CarModel');
        $this->blog_model = $this->model('BlogModel');
        $this->user_model = $this->model('UserModel');
        $this->jwt = new JwtAuth();
    }
    public function index() {
        $blogStatsView = $this->blog_model->getStatsView();
        $blogCount = $this->blog_model->getCount();
        $userCount = $this->user_model->getCount();
        $recentUsers = $this->user_model->getRecentUsers();
        $recentBlogs = $this->blog_model->getRecentBlogs();
        $payload = SessionFactory::createSession('account')->getProfile();
        $this->renderAdmin([
            'page_title' => 'Dashboard',
            'view' => 'protected/dashboard',
            'content' => [
                'blogStatsView' => $blogStatsView,
                'blogCount' => $blogCount,
                'payload' => $payload,
                'userCount' => $userCount,
                'recentUsers' => $recentUsers,
                'recentBlogs' => $recentBlogs,
            ]
        ]);
    }
    public function settings() {
        $payload = SessionFactory::createSession('account')->getProfile();
        $this->renderAdmin([
            'page_title' => 'Settings',
            'view' => 'protected/settings',
            'content' => [
                'title' => 'Settings',
                'payload' => $payload
            ]
        ]);
    }
    public function userManagement() {
        $payload = SessionFactory::createSession('account')->getProfile();
        $this->renderAdmin([
            'page_title' => 'User Management',
            'view' => 'protected/userManager',
            'content' => [
                'title' => 'User Management',
                'payload' => $payload
            ]
        ]);
    }
}