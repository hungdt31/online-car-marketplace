<?php
class Home extends Controller{
    public $model_home;
    public $category_model;
    public $car_model;
    public $data;
    public function __construct() {
        $this->model_home = $this->model('HomeModel');
        $this->category_model = $this->model('CategoryModel');
        $this->car_model = $this->model('CarModel');
    }
    public function index() {
        $this->renderUser([
            'page_title' => 'Home',
            'view' => 'public/home',
            'content' => [
                'user' => $this->model_home->getList(),
                'top_category' => $this->category_model->getTopCategory()
            ]
        ]);
    }
    public function about() {
        $this->renderUser([
            'page_title' => 'About Us',
            'view' => 'public/about'
        ]);
    }
    public function help() {
        $this->renderUser([
            'page_title' => 'Help Center',
            'view' => 'public/help'
        ]);
    }
    public function getCarsByCategory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrayIds = [];
            if (isset($_POST['category_id'])) {
                $arrayIds = [ $_POST['category_id'] ];
            }
            $data = $this->car_model->getCarsByCategories($arrayIds);
            foreach ($data as $value) {
                RenderSystem::renderOne('components', 'Home/carCard', $value);
            }
        }
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
            'view' => 'public/contact'
        ]);
    }
}