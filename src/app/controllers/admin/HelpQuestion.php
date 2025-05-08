<?php
class HelpQuestion extends Controller {
    private $helpModel;
    public function __construct() {
        $this->helpModel = $this->model('HelpModel');
    }
    public function index() {
        $questions = $this->helpModel->getAllQuestions();
        $this->renderAdmin([
            'page_title' => 'Customer Questions',
            'view' => 'admin/help_question/index',
            'content' => [
                'questions' => $questions
            ]
        ]);
    }
    public function edit($id = null) {
         if (!$id) {
            header('Location: ' . _WEB_ROOT . '/admin/help-question');
            exit;
        }

        $question = $this->helpModel->getQuestionById($id);
        if (!$question) {
            header('Location: ' . _WEB_ROOT . '/admin/help-question');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->helpModel->updateStatus($id, 'replied');
            echo json_encode(['success' => $result]);
            return;
        }
    }
} 