<?php
class Product extends Controller{
    protected $model_product;
    public $data = [];
    public function __construct() {
        $this->model_product = $this->model('ProductModel');
    }
    public function index(){
        $this->renderUser([
            'page_title' => 'Trang sản phẩm',
            'view' => 'products/index',
            'content' => [
                'title' => 'Danh mục sản phẩm'
            ]
        ]);
    }
    public function list_product()
    {
        $dataProduct = $this->model_product->getList();
        $this->renderUser([
            'page_title' => 'Trang sản phẩm',
            'view' => 'products/list',
            'data' => [
                'title' => 'Danh sách sản phẩm',
                'product_list' => $dataProduct
            ]
        ]);
    }
    public function detail($id='', $slug='') {
        // echo 'id: ',$id.'<br/>'.'slug: '.$slug. '<br/>';
        $this->renderUser([
            'page_title' => 'Trang sản phẩm',
            'view' => 'products/detail',
            'data' => [
                'title' => 'Chi tiết sản phẩm',
                'info' => $this->model_product->getDetail($id)
            ]
        ]);
    }
    public function sendMail() {
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        Mailer::send(
            [
                'address' => getenv('EMAIL_USERNAME'),
                'name' => 'Admin'
            ],
            [
                'address' => $email,
                'name' => 'User'
            ],
            [
                'address' => $email,
            ],
            $subject,
            $message
        );
    }
}
