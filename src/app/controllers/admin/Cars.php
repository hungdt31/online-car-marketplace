<?php
class Cars extends Controller
{
    public $car_model;
    public $file_model;
    public $category_model;
    public $jwt;
    public $comment_model;
    public function __construct()
    {
        $this->car_model = $this->model('CarModel');
        $this->file_model = $this->model('FileModel');
        $this->category_model = $this->model('CategoryModel');
        $this->comment_model = $this->model('CommentModel');
        $this->jwt = new JwtAuth();
    }

    public function index()
    {
        $list_cars = $this->car_model->getList();
        $this->renderAdmin([
            'page_title' => 'Management',
            'view' => 'protected/cars/carManager',
            'content' => [
                'title' => 'Car Management',
                'list_cars' => $list_cars,
            ]
        ]);
    }

    public function assets($id)
    {
        $categories = $this->category_model->getAllCategories();
        $car = $this->car_model->getCar($id);
        $this->renderAdmin([
            'page_title' => 'Assets of ' . $car['name'],
            'view' => 'protected/cars/carAssets',
            'content' => [
                'car_assets' => $car['images'],
                'car_id' => $id,
                'car_name' => $car['name'],
                'car_overview' => $car['overview'],
                'car_capabilities' => json_decode($car['capabilities'], true),
                'car_categories' => $this->category_model->getCategoryForCar($id),
                'categories' => $categories,
            ]
        ]);
    }

    public function uploadAssets($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->file_model->uploadFileToCarAsset($id);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Assets uploaded successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to upload assets."]);
            }
        }
    }

    public function deleteAssets()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $rawBody = file_get_contents("php://input");
            $data = json_decode($rawBody, true); // true để trả về mảng
            $result = $this->file_model->deleteFileFromCarAsset($data['car_id'], $data['file_id']);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Assets deleted successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete assets."]);
            }
        }
    }

    public function addCar()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->car_model->addCar($_POST);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Car added successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add car."]);
            }
        }
    }

    public function getCar($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $data['car'] = $this->car_model->getCar($id);
            $data['getToUpdate'] = $_GET["getToUpdate"];
            extract($data);
            $details = $this->render('components/Cars/carDetail', $data);
            echo $details;
        }
    }

    public function editCar($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->car_model->editCar($id, $_POST);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Car updated successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to update car."]);
            }
        }
    }

    public function deleteCar($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->car_model->deleteCar($id);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Car deleted successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete car."]);
            }
        }
    }

    public function updateDetails($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get JSON data from request body
            $jsonData = json_decode(file_get_contents('php://input'), true);

            // Validate data
            if (!isset($jsonData['overview']) || !isset($jsonData['capabilities'])) {
                echo json_encode([
                    "success" => false,
                    "message" => "Invalid data provided"
                ]);
                return;
            }

            // Update car details
            $result = $this->car_model->updateCarDetails($id, $jsonData);

            if ($result) {
                echo json_encode([
                    "success" => true,
                    "message" => "Car details updated successfully!"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Failed to update car details."
                ]);
            }
        }
    }

    public function toggleCategory()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $car_id = $_POST['car_id'] ?? null;
            $category_id = $_POST['category_id'] ?? null;
            $action = $_POST['action'] ?? null;

            if (empty($car_id) || empty($category_id) || empty($action)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Car ID, Category ID and Action are required."
                ]);
                return;
            }

            $message = "Invalid action.";
            if ($action === 'add') {
                $result = $this->category_model->addCategoryForCar($car_id, $category_id);
                $result ? $message = "Category added to car successfully!" : $message = "Failed to add category to car.";
            } elseif ($action === 'remove') {
                $result = $this->category_model->removeCategoryFromCar($car_id, $category_id);
                $result ? $message = "Category removed from car successfully!" : $message = "Failed to remove category from car.";
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => $message
                ]);
                return;
            }

            if ($result) {
                echo json_encode([
                    "success" => true,
                    "message" => $message
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => $message
                ]);
            }
        }
    }

    public function comments()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $car_id = $_GET['id'];
            $car = $this->car_model->getCar($car_id);
            if (isset($car_id)) {
                $comments = $this->comment_model->getCommentsById($car_id);
            } else {
                $comments = $this->comment_model->getAll();
            }
            $this->renderAdmin([
                'page_title' => 'Car Comments',
                'view' => 'protected/cars/carComments',
                'content' => [
                    'title' => 'Car Reviews Management',
                    'comments' => $comments,
                    'car' => $car
                ]
            ]);
        }
    }

    public function changeStatusComment($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $status = $_POST['status'] ?? null;
            if (empty($status)) {
                echo json_encode(["success" => false, "message" => "Status is required."]);
                return;
            }
            $result = $this->comment_model->changeStatusComment($id, $status);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Comment approved successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to approve comment."]);
            }
        }
    }

    public function deleteComment($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $comment = $this->comment_model->getComment($id);
            if (isset($comment['file_key'])) {
                $aws = new AwsS3Service();
                $aws->deleteFile($comment['file_key']);
            }
            // Delete the file from the database
            if (isset($comment['file_id'])) {
                $this->file_model->deleteOne($comment['file_id']);
            }
            $result = $this->comment_model->deleteComment($id);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Comment deleted successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete comment."]);
            }
        }
    }

    public function replyToComment()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['comment_id']) && isset($_POST['reply_content'])) {
                $id = $_POST['comment_id'];
                $reply = $_POST['reply_content'];
                $result = $this->comment_model->replyToComment($id, $reply);
                if ($result) {
                    if ($_POST['notify_user'] == "on") {
                        $comment = $this->comment_model->getComment($id);
                        $subject = "Reply to your comment";
                        $message = $_POST['reply_content'];
                        // Notify user about the reply
                        $response = Mailer::send(
                            [
                                'address' => getenv('EMAIL_USERNAME'),
                                'name' => 'Admin'
                            ],
                            [
                                'address' => $comment['email'],
                                'name' => 'User'
                            ],
                            [
                                'address' => $comment['email'],
                            ],
                            $subject,
                            $message
                        );
                        if ($response['success']) {
                            echo json_encode(["success" => true, "message" => "Reply added and user notified successfully!"]);
                            return;
                        } else {
                            echo json_encode(["success" => false, "message" => "Reply added but failed to notify user."]);
                            return;
                        }
                    }
                    echo json_encode(["success" => true, "message" => "Reply added successfully!"]);
                } else {
                    echo json_encode(["success" => false, "message" => "Failed to add reply."]);
                }
            } else {
                echo json_encode(["success" => false, "message" => "Reply are required."]);
            }
        }
    }
}
