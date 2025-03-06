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
        $payload = $this->jwt->decodeTokenFromCookie('access')['payload'];
        $this->renderUser([
            'page_title' => 'My account',
            'view' => 'user/account',
            'content' => [
                'payload' => $payload
            ]
        ]);
    }
}