<?php

class Account extends Controller
{
    public function index()
    {
        $this->renderUser([
            'page_title' => 'Tài khoản người dùng',
            'view' => 'user/account/index',
            'data' => [
                'title' => 'Account'
            ]
        ]);
    }
}