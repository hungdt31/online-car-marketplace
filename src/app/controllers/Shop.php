<?php
class Shop extends Controller{
    protected $car_model;
    protected $comment_model;
    protected $file_model;
    protected $user_model;
    protected $shop_session;
    protected $appointment_model;
    protected $branch_model;
    public $data = [];
    
    public function __construct() {
        $this->car_model = $this->model('CarModel');
        $this->comment_model = $this->model('CommentModel');
        $this->file_model = $this->model('FileModel');
        $this->user_model = $this->model('UserModel');
        $this->appointment_model = $this->model('AppointmentModel');
        $this->branch_model = $this->model('BranchModel');
        $this->shop_session = SessionFactory::createSession('shop');
    }
    
    public function index(){
        // Get filter parameters from query string
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
        $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';
        
        // Get selected categories from session if not explicitly provided
        $selectedCategories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : [];
        
        // Store parameters in session for later use
        if (!empty($keyword)) {
            $this->shop_session->setCurrentKeyword($keyword);
        }
        
        // Pagination parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        
        // Get filtered cars
        $cars = $this->car_model->searchCars(
            $keyword,
            $selectedCategories,
            $minPrice,
            $maxPrice,
            $perPage,
            $offset
        );
        
        // Get total count for pagination
        $totalCars = $this->car_model->getSearchCount(
            $keyword,
            $selectedCategories,
            $minPrice,
            $maxPrice
        );
        
        // Get categories for filter
        $categories = $this->car_model->getCarCategories();
        
        // Get price range for the slider
        $priceRange = $this->car_model->getPriceRange();
        
        // Calculate pagination info
        $totalPages = ceil($totalCars / $perPage);
        $showing = [
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $totalCars),
            'total' => $totalCars
        ];
        
        // Breadcrumb structure
        $breadcrumbs = [
            ['name' => 'Home', 'url' => _WEB_ROOT],
            ['name' => 'Shop', 'url' => '']
        ];
        
        // Show search results in breadcrumb if searching
        if (!empty($keyword)) {
            $breadcrumbs = [
                ['name' => 'Home', 'url' => _WEB_ROOT],
                ['name' => 'Shop', 'url' => _WEB_ROOT . '/shop'],
                ['name' => 'Search: ' . $keyword, 'url' => '']
            ];
        }
        
        $this->renderGeneral([
            'page_title' => !empty($keyword) ? 'Search: ' . $keyword : 'Shop',
            'view' => 'public/shop/index',
            'content' => [
                'header' => [
                    'title' => !empty($keyword) ? 'Search Results for: ' . $keyword : 'Shop',
                    'description' => $breadcrumbs
                ],
                'cars' => $cars,
                'categories' => $categories,
                'selectedCategories' => $selectedCategories,
                'keyword' => $keyword,
                'priceRange' => $priceRange,
                'minPrice' => $minPrice,
                'maxPrice' => $maxPrice,
                'recentCars' => [],
                'hasRecentCars' => false,
                'pagination' => [
                    'current' => $page,
                    'total' => $totalPages
                ],
                'showing' => $showing,
                'sort' => $sort
            ]
        ]);
    }
    
    public function detail($id='') {
        if (empty($id)) {
            header('Location: ' . _WEB_ROOT . '/shop');
            exit;
        }
        
        $car = $this->car_model->getAdvancedCar($id);
        $branches = $this->branch_model->findAll();
        
        if (!$car) {
            header('Location: ' . _WEB_ROOT . '/shop');
            exit;
        }
        
        // Store this car ID in recently viewed
        // Note: When ShopSession is fully implemented, uncomment this:
        // $this->shop_session->saveRecentCarId($id);
        
        // Breadcrumb structure
        $breadcrumbs = [
            ['name' => 'Home', 'url' => _WEB_ROOT],
            ['name' => 'Shop', 'url' => _WEB_ROOT . '/shop'],
            ['name' => $car['name'], 'url' => '']
        ];
        
        $this->renderGeneral([
            'page_title' => $car['name'],
            'view' => 'public/shop/detail',
            'content' => [
                'header' => [
                    'title' => $car['name'],
                    'description' => $breadcrumbs
                ],
                'info' => $car,
                'branches' => $branches
            ]
        ]);
    }
    
    /**
     * Toggle a category in the filter
     * 
     * @param int $categoryId The ID of the category to toggle
     * @return void
     */
    public function toggleCategory($categoryId)
    {
        // For now, just redirect back to shop since we don't have full category functionality yet
        header('Location: ' . _WEB_ROOT . '/shop');
        exit;
        
        /* 
        // Enable this code when ShopSession is fully implemented
        // Toggle category selection in session
        $this->shop_session->toggleSelectedCategory((int)$categoryId);
        
        // If this is an AJAX request, return JSON response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $isSelected = $this->shop_session->isCategorySelected($categoryId);
            $selectedCategories = $this->shop_session->getSelectedCategories();
            
            echo json_encode([
                'success' => true,
                'isSelected' => $isSelected,
                'selectedCategories' => $selectedCategories
            ]);
            exit;
        }
        
        // Otherwise redirect back to shop index
        header('Location: ' . _WEB_ROOT . '/shop');
        exit;
        */
    }
    
    /**
     * Clear all selected categories
     * 
     * @return void
     */
    public function clearCategories()
    {
        // For now, just redirect back to shop since we don't have full category functionality yet
        header('Location: ' . _WEB_ROOT . '/shop');
        exit;
        
        /*
        // Enable this code when ShopSession is fully implemented
        $this->shop_session->clearSelectedCategories();
        
        // If this is an AJAX request, return JSON response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode([
                'success' => true
            ]);
            exit;
        }
        
        // Otherwise redirect back to shop index
        header('Location: ' . _WEB_ROOT . '/shop');
        exit;
        */
    }
    
    /**
     * Clear the search history
     */
    public function clearSearchHistory()
    {
        // For now, just redirect back to shop
        header('Location: ' . _WEB_ROOT . '/shop');
        exit;
        
        /*
        // Enable this code when ShopSession is fully implemented
        $this->shop_session->clearCurrentKeyword();
        
        // If this is an AJAX request, return JSON response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode([
                'success' => true
            ]);
            exit;
        }
        
        // Otherwise redirect back to shop index
        header('Location: ' . _WEB_ROOT . '/shop');
        exit;
        */
    }

    public function replyCarPost()
    {
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
            if (isset($_FILES['commentFile'])) {
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
            } else {
                $addCmtStatus = $this->comment_model->addComment($data);
                if ($addCmtStatus) {
                    echo json_encode([
                        "success" => true,
                        "message" => "Comment added successfully!"
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Comment creation failed!"
                    ]);
                }
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

    public function schedule() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['user_id'] == '') {
                echo json_encode([
                    'success' => false,
                    'message' => 'Please login to schedule an appointment.'
                ]);
                return;
            }
            // Save appointment to database
            $result = $this->appointment_model->create($_POST);
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Appointment scheduled successfully!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to schedule appointment.'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid request method.'
            ]);
        }
    }
}
