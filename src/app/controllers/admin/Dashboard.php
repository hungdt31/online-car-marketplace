<?php
class Dashboard extends Controller{
    public $car_model;
    public $jwt;
    public function __construct() {
        $this->car_model = $this->model('CarModel');
        $this->jwt = new JwtAuth();
    }
    public function index() {
        $payload = SessionFactory::createSession('account')->getProfile();
        $this->renderAdmin([
            'page_title' => 'Dashboard',
            'view' => 'admin/dashboard',
            'content' => [
                'title' => 'Dashboard',
                'payload' => $payload
            ]
        ]);
    }
    public function carManager() {
        $list_cars = $this->car_model->getList();
        $this->renderAdmin([
            'page_title' => 'Manage Cars',
            'view' => 'admin/carManager',
            'content' => [
                'title' => 'Car Management',
                'list_cars' => $list_cars
            ]
        ]);
    }
    public function addCar() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->car_model->addCar($_POST);
    
            if ($result) {
                echo json_encode(["success" => true, "message" => "Car added successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add car."]);
            }
        }
    }
    public function getCar($id) {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $data['car'] = $this->car_model->getCar($id);
            $data['getToUpdate'] = $_GET["getToUpdate"];
            extract($data);
            $details = $this->render('admin/carDetail', $data);
            echo $details;
        }
    }
    public function editCar($id) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->car_model->editCar($id, $_POST);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Car updated successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to update car."]);
            }
        }
    }
    public function deleteCar($id) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->car_model->deleteCar($id);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Car deleted successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete car."]);
            }
        }
    }
}