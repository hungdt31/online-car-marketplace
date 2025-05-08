<?php
class Faq extends Controller
{
    private $faq_model;

    public function __construct()
    {
        $this->faq_model = $this->model('FaqModel');
    }

    public function index()
    {
        $faqs = $this->faq_model->getAllFaqs();
        $this->renderAdmin([
            'page_title' => 'FAQ Management',
            'view' => 'admin/faq/index',
            'content' => [
                'faqs' => $faqs
            ]
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = trim($_POST['question'] ?? '');
            $answer = trim($_POST['answer'] ?? '');

            if (empty($question) || empty($answer)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Please fill in all required fields.'
                ]);
                return;
            }

            $result = $this->faq_model->addFaq($question, $answer);
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'FAQ added successfully.' : 'Failed to add FAQ.'
            ]);
            return;
        }

        $this->renderAdmin([
            'page_title' => 'Add New FAQ',
            'view' => 'admin/faq/add'
        ]);
    }

    public function edit($id = null)
    {
        if (!$id) {
            header('Location: ' . _WEB_ROOT . '/admin/faq');
            exit;
        }

        $faq = $this->faq_model->getFaqById($id);
        if (!$faq) {
            header('Location: ' . _WEB_ROOT . '/admin/faq');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $question = trim($_POST['question'] ?? '');
            $answer = trim($_POST['answer'] ?? '');
            $status = $_POST['status'] ?? 'active';

            if (empty($question) || empty($answer)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Please fill in all required fields.'
                ]);
                return;
            }

            $result = $this->faq_model->updateFaq($id, $question, $answer, $status);
            echo json_encode([
                'success' => $result,
                'message' => $result ? 'FAQ updated successfully.' : 'Failed to update FAQ.'
            ]);
            return;
        }

        $this->renderAdmin([
            'page_title' => 'Edit FAQ',
            'view' => 'admin/faq/edit',
            'content' => [
                'faq' => $faq
            ]
        ]);
    }

    public function delete($id = null)
    {
        if (!$id) {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid FAQ ID.'
            ]);
            return;
        }

        $result = $this->faq_model->deleteFaq($id);
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'FAQ deleted successfully.' : 'Failed to delete FAQ.'
        ]);
    }
} 