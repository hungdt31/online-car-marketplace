<?php
class Product extends Controller{
    protected $model_product;
    public $data = [];
    public function __construct() {
        $this->model_product = $this->model('ProductModel');
    }
    public function index(){
        $this->data['sub_content']['title'] = 'Danh mục sản phẩm';
        $this->data['page_title'] = 'Trang sản phẩm';
        $this->data['content'] = 'products/index';
        // render view
        $this->render('layouts/client_layout', $this->data);
    }
    public function list_product()
    {
        $dataProduct = $this->model_product->getList();
        $this->data['sub_content']['product_list'] = $dataProduct;
        $this->data['sub_content']['title'] = 'Danh sách sản phẩm';
        $this->data['page_title'] = 'Trang sản phẩm';
        $this->data['content'] = 'products/list';
        // render view
        $this->render('layouts/client_layout', $this->data);
    }
    public function detail($id='', $slug='') {
//        echo 'id: ',$id.'<br/>'.'slug: '.$slug. '<br/>';
        $this->data['sub_content']['title'] = 'Chi tiết sản phẩm';
        $this->data['sub_content']['info'] = $this->model_product->getDetail($id);
        $this->data['content'] = 'products/detail';
        $this->data['page_title'] = 'Trang sản phẩm';
        // render view
        $this->render('layouts/client_layout', $this->data);
    }
}
