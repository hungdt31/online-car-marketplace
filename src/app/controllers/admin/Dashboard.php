<?php
class Dashboard extends Controller{
    public $data = [];
    public function index() {
        $this->data['page_title'] = 'Dashboard';
        $this->data['content'] = 'admin/dashboard';
        $this->data['sub_content']['title'] = 'Dashboard';
        $this->render('layouts/admin_layout', $this->data);
    }
}