<?php
class Home extends Controller{
    public $model_home;
    public $data;
    public function __construct() {
        $this->model_home = $this->model('HomeModel');
    }
    public function index() {
        $this->data['sub_content']['user'] = $this->model_home->getList();
        $this->data['page_title'] = 'Trang chủ';
        $this->data['content'] = 'home/index';
        $this->render('layouts/client_layout', $this->data);
    }
    public function detail($id='', $slug='') {
        echo 'id: ',$id.'<br/>'.'slug: '.$slug. '<br/>';
        $detail = $this->model_home->getDetail($id);
        echo '<pre>';
        print_r($detail);
        echo '</pre>';
    }
    public function search() {
        $keyword = $_GET['keyword'];
        echo 'Keyword: '.$keyword;
    }
}