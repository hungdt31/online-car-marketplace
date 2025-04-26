<?php
class Shop extends Controller{
    protected $car_model;
    protected $comment_model;
    protected $file_model;
    protected $user_model;
    public $data = [];
    public function __construct() {
        $this->car_model = $this->model('CarModel');
        $this->comment_model = $this->model('CommentModel');
        $this->file_model = $this->model('FileModel');
        $this->user_model = $this->model('UserModel');
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
        $this->renderGeneral([
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
            $data = $_POST;
            // Check user existence
            $user = $this->user_model->getDetail($data['user_id']);
            if (!$user) {
                echo json_encode([
                    "success" => false,
                    "message" => "User not found!"
                ]);
                return;
            }
            $aws = new AwsS3Service();
            // Upload file to S3
            $uploadFile = $aws->uploadFile($_FILES['commentFile'], 'comments');
            if ($uploadFile) {
                // tạo record mới cho bảng files
                $addFileStatus = $this->file_model->addFile([
                    'name' => $_FILES['commentFile']['name'],
                    'fkey' => $uploadFile['fileKey'],
                    'path' => $uploadFile['fileUrl'],
                    'size' => $_FILES['commentFile']['size'],
                    'type' => $_FILES['commentFile']['type']
                ]);
                if ($addFileStatus) {
                    $file = $this->file_model->getFile(['fkey' => $uploadFile['fileKey']]);
                    // tạo record mới cho bảng comments
                    $data['file_id'] = $file['id'];
                    $addCmtStatus = $this->comment_model->addComment($data);
                    if ($addCmtStatus) {
                        echo json_encode([
                            "success" => true,
                            "message" => "Comment added successfully!",
                            "data" => $data
                        ]);
                    } else {
                        echo json_encode([
                            "success" => false,
                            "message" => "Comment creation failed!"
                        ]);
                    }
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Fail to add file!"
                    ]);
                }
                return;
            } 
            echo json_encode([
                "success" => false,
                "message" => "File upload failed!"
            ]);
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
