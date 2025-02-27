<?php
class Dashboard extends Controller{
    public $car_model;
    public function __construct() {
        $this->car_model = $this->model('CarModel');
    }
    public function index() {
        $this->renderAdmin([
            'page_title' => 'Dashboard',
            'view' => 'admin/dashboard',
            'content' => [
                'title' => 'Dashboard'
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
            $details = $this->render('admin/carDetail', $data);
            echo $details;
        }
    }
}