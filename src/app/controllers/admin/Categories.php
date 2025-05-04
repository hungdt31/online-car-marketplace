<?php
class Categories extends Controller{
    public $category_model;
    public $jwt;
    public function __construct() {
        $this->category_model = $this->model('CategoryModel');
        $this->jwt = new JwtAuth();
    }
    public function index() {
        $categories = $this->category_model->getAllCategories();
        $this->renderAdmin([
            'page_title' => 'Categories',
            'view' => 'protected/categories/cateManager',
            'content' => [
                'title' => 'Categories',
                'categories' => $categories
            ]
        ]);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $type = $_POST['type'] ?? '';

            if (empty($name) || empty($type)) {
                echo json_encode(['success' => false, 'message' => 'Name and type are required']);
                return;
            }

            $result = $this->category_model->addCategory($name, $description, $type);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Category added successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add category']);
            }
        }
    }

    public function get($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $category = $this->category_model->getCategoryById($id);
            if ($category) {
                echo json_encode(['success' => true, 'data' => $category]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Category not found']);
            }
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $type = $_POST['type'] ?? '';

            if (empty($id) || empty($name) || empty($type)) {
                echo json_encode(['success' => false, 'message' => 'ID, name and type are required']);
                return;
            }

            $result = $this->category_model->updateCategory($id, $name, $description, $type);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Category updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update category']);
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'Category ID is required']);
                return;
            }

            $result = $this->category_model->deleteCategory($id);
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Category deleted successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete category']);
            }
        }
    }
}