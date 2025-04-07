<?php
class Dashboard extends Controller{
    public $car_model;
    public $jwt;
    public function __construct() {
        $this->car_model = $this->model('CarModel');
        $this->jwt = new JwtAuth();
    }
    public function index() {
        $payload = SessionFactory::createSession('account')->getProfile();
        $this->renderAdmin([
            'page_title' => 'Dashboard',
            'view' => 'protected/dashboard',
            'content' => [
                'title' => 'Dashboard',
                'payload' => $payload
            ]
        ]);
    }
}