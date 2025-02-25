<?php
class Dashboard extends Controller{
    public $data = [];
    public function index() {
        $this->renderAdmin([
            'page_title' => 'Dashboard',
            'view' => 'admin/dashboard',
            'content' => [
                'title' => 'Dashboard'
            ]
        ]);
    }
}