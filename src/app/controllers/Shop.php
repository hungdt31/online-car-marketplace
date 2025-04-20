<?php
class Shop extends Controller{
    protected $car_model;
    protected $comment_model;
    public $data = [];
    public function __construct() {
        $this->car_model = $this->model('CarModel');
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
        $dataProduct = $this->car_model->getList();
        $this->renderUser([
            'page_title' => 'Trang sản phẩm',
            'view' => 'products/list',
            'data' => [
                'title' => 'Danh sách sản phẩm',
                'product_list' => $dataProduct
            ]
        ]);
    }
    public function detail($id='') {
        $car = $this->car_model->getAdvancedCar($id);
        $this->renderShop([
            'page_title' => $car['name'],
            'view' => 'public/shop/detail',
            'content' => [
                'header' => [
                    'title' => $car['name'],
                    'description' => $car['description']
                ],
                'info' => $car
            ]
        ]);
    }
    public function replyCarPost() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $rawBody = file_get_contents("php://input");
            $data = json_decode($rawBody, true); // true để trả về mảng
            $result = $this->comment_model->addComment($data);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Comment added successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add comment."]);
            }
        }
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
