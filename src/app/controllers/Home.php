<?php
class Home extends Controller{
    public $model_home;
    public $data;
    public function __construct() {
        $this->model_home = $this->model('HomeModel');
    }
    public function index() {
        $this->renderUser([
            'page_title' => 'Home',
            'view' => 'home/index',
            'content' => [
                'user' => $this->model_home->getList()
            ]
        ]);
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
    public function contact() {
        $this->renderUser([
            'page_title' => 'Contact us',
            'view' => 'home/contact'
        ]);
    }
}