<?php
class BlogComments extends Controller
{
    public $blog_model;
    public $blog_comments_model;
    public $file_model;
    public $jwt;

    public function __construct()
    {
        $this->blog_model = $this->model('BlogModel');
        $this->blog_comments_model = $this->model('BlogCommentsModel');
        $this->file_model = $this->model('FileModel');
        $this->jwt = new JwtAuth();
    }

    public function index()
    {
        $comments = $this->blog_comments_model->getAll();
        $this->renderAdmin([
            'page_title' => 'Blog Comments',
            'view' => 'protected/posts/commentManager',
            'content' => [
                'title' => 'Blog Comments Management',
                'comments' => $comments
            ]
        ]);
    }

    public function delete($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $comment = $this->blog_comments_model->getComment($id);
            if (!$comment) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Comment not found'
                ]);
                return;
            }

            $result = $this->blog_comments_model->deleteComment($id);
            if ($result) {
                echo json_encode([
                    "success" => true,
                    "message" => "Comment deleted successfully!"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Failed to delete comment."
                ]);
            }
        }
    }
} 