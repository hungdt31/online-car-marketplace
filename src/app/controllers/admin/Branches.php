<?php

class Branches extends Controller
{
    public $branch_model;
    public $car_model;
    public $blog_model;
    public $user_model;
    public $jwt;

    public function __construct()
    {
        $this->branch_model = $this->model('BranchModel');
        $this->car_model = $this->model('CarModel');
        $this->blog_model = $this->model('BlogModel');
        $this->user_model = $this->model('UserModel');
        $this->jwt = new JwtAuth();
    }

    public function index()
    {
        $branches = $this->branch_model->findAll();
        $payload = SessionFactory::createSession('account')->getProfile();
        $this->renderAdmin([
            'page_title' => 'Branch Management',
            'view' => 'protected/branchManager',
            'content' => [
                'title' => 'Branch Management',
                'payload' => $payload,
                'branches' => $branches
            ]
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'description' => $_POST['description'] ?? ''
            ];

            $result = $this->branch_model->createOne($data);
            echo json_encode($result);
        }
    }

    public function info($id)
    {
        $branch = $this->branch_model->findById($id);
        if ($branch) {
            echo json_encode(['success' => true, 'branch' => $branch]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Branch not found']);
        }
    }
    
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'description' => $_POST['description'] ?? ''
            ];
            
            $result = $this->branch_model->updateById($id, $data);
            echo json_encode($result);
        }
    }
    
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->branch_model->deleteById($id);
            echo json_encode($result);
        }
    }
    
    public function all()
    {
        $branches = $this->branch_model->findAll();
        echo json_encode(['success' => true, 'branches' => $branches]);
    }
}