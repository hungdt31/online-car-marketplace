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
    public function getCarsByCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrayIds = [];
            if (isset($_POST['category_id'])) {
                $arrayIds = [$_POST['category_id']];
            }
            $data = $this->car_model->getCarsByCategories($arrayIds);
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