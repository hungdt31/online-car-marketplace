<?php

class Account extends Controller
{
    private $jwt;
    public function __construct()
    {
        $this->jwt = new JwtAuth();
    }
    public function index()
    {
        $profile = SessionFactory::createSession('account')->getProfile();
        $this->renderUser([
            'page_title' => 'My account',
            'view' => 'user/account',
            'content' => [
                'profile' => $profile
            ]
        ]);
    }
}