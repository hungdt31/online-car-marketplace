<?php
class Home extends Controller
{
    public $model_home;
    public $category_model;
    public $car_model;
    public $data;
    public function __construct()
    {
        $this->model_home = $this->model('HomeModel');
        $this->category_model = $this->model('CategoryModel');
        $this->car_model = $this->model('CarModel');
    }
    public function index()
    {
        $this->renderHome([
            'page_title' => 'Home',
            'view' => 'public/home',
            'content' => [
                'user' => $this->model_home->getList(),
                'top_category' => $this->category_model->getTopCategory()
            ]
        ]);
    }
    public function about()
    {
        $this->renderUser([
            'page_title' => 'About Us',
            'view' => 'public/about'
        ]);
    }
    public function help()
    {
        $this->renderUser([
            'page_title' => 'Help Center',
            'view' => 'public/help'
        ]);
    }
    public function searchCars()
    {
        // Get search parameters
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $fuelType = isset($_GET['fuel_type']) ? trim($_GET['fuel_type']) : '';
        $location = isset($_GET['location']) ? trim($_GET['location']) : '';

        // Search using CarModel
        $conditions = [];
        $params = [];

        if (!empty($keyword)) {
            $conditions[] = "(name LIKE :keyword OR overview LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if (!empty($fuelType)) {
            $conditions[] = "fuel_type = :fuel_type";
            $params[':fuel_type'] = $fuelType;
        }

        if (!empty($location)) {
            $conditions[] = "location LIKE :location";
            $params[':location'] = '%' . $location . '%';
        }

        $sql = "SELECT c.*, 
                (SELECT url FROM files f 
                 JOIN car_assets ca ON f.id = ca.file_id 
                 WHERE ca.car_id = c.id AND (f.type NOT LIKE '%video%' OR f.type IS NULL)
                 LIMIT 1) as url
                FROM cars c";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $this->car_model->db->execute($sql, $params);
        $cars = $result['data'] ?? [];

        $html = '';
        if (!empty($cars)) {
            ob_start();
            foreach ($cars as $car) {
                RenderSystem::renderOne('components', 'Home/carCard', $car);
            }
            $html = ob_get_clean();
        }

        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $cars,
            'html' => $html
        ]);
        exit;
    }
    public function getCarsByCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrayIds = [];
            if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
                $arrayIds = [$_POST['category_id']];
            }
            $data = $this->car_model->getCarsByCategories($arrayIds);

            if (empty($data)) {
                echo '<div class="text-center py-5">
                        <div class="text-muted">No cars found in this category</div>
                      </div>';
                return;
            }

            foreach ($data as $value) {
                RenderSystem::renderOne('components', 'Home/carCard', $value);
            }
        }
    }
    public function detail($id = '', $slug = '')
    {
        echo 'id: ', $id . '<br/>' . 'slug: ' . $slug . '<br/>';
        $detail = $this->model_home->getDetail($id);
        echo '<pre>';
        print_r($detail);
        echo '</pre>';
    }
    public function search()
    {
        $keyword = $_GET['keyword'];
        echo 'Keyword: ' . $keyword;
    }
    public function contact()
    {
        $this->renderHome([
            'page_title' => 'Contact us',
            'view' => 'public/contact'
        ]);
    }
    public function sendQuestion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Debug: Log POST data
                error_log('POST data: ' . print_r($_POST, true));

                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $question = trim($_POST['question'] ?? '');

                // Debug: Log processed data
                error_log("Processed data - Name: $name, Email: $email, Question: $question");

                if (empty($name) || empty($email) || empty($question)) {
                    error_log('Validation failed: Empty fields');
                    echo json_encode([
                        'success' => false,
                        'message' => 'Please fill in all required fields.'
                    ]);
                    return;
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    error_log('Validation failed: Invalid email');
                    echo json_encode([
                        'success' => false,
                        'message' => 'Please enter a valid email address.'
                    ]);
                    return;
                }

                // Initialize HelpModel
                $help_model = $this->model('HelpModel');
                if (!$help_model) {
                    error_log('Failed to initialize HelpModel');
                    throw new Exception('Failed to initialize HelpModel');
                }

                // Save to database
                $result = $help_model->saveQuestion([
                    'name' => $name,
                    'email' => $email,
                    'question' => $question
                ]);

                // Debug: Log save result
                error_log('Save result: ' . print_r($result, true));

                if ($result) {
                    // Send email to admin
                    Mailer::send(
                        [
                            'address' => getenv('EMAIL_USERNAME'),
                            'name' => 'Admin'
                        ],
                        [
                            'address' => getenv('EMAIL_USERNAME'),
                            'name' => 'Admin'
                        ],
                        [
                            'address' => $email,
                            'name' => $name
                        ],
                        'New Help Question from ' . $name,
                        "Name: $name<br>Email: $email<br><br>Question:<br>$question"
                    );

                    // Send confirmation email to user
                    Mailer::send(
                        [
                            'address' => getenv('EMAIL_USERNAME'),
                            'name' => 'Admin'
                        ],
                        [
                            'address' => $email,
                            'name' => $name
                        ],
                        [
                            'address' => getenv('EMAIL_USERNAME'),
                            'name' => 'Admin'
                        ],
                        'Thank you for your question',
                        "Dear $name,<br><br>Thank you for contacting us. We have received your question and will get back to you as soon as possible.<br><br>Your question:<br>$question<br><br>Best regards,<br>Car Rental Team"
                    );

                    echo json_encode([
                        'success' => true,
                        'message' => 'Your question has been sent successfully. We will get back to you soon.'
                    ]);
                } else {
                    error_log('Failed to save question to database');
                    throw new Exception('Failed to save question to database');
                }
            } catch (Exception $e) {
                error_log('Error in sendQuestion: ' . $e->getMessage());
                error_log('Stack trace: ' . $e->getTraceAsString());
                echo json_encode([
                    'success' => false,
                    'message' => 'An error occurred while processing your request. Please try again.'
                ]);
            }
        }
    }

}