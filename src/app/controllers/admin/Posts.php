<?php
class Posts extends Controller
{
    public $blog_model;
    public $file_model;
    public $category_model;
    public $jwt;
    
    public function __construct()
    {
        $this->blog_model = $this->model('BlogModel');
        $this->file_model = $this->model('FileModel');
        $this->category_model = $this->model('CategoryModel');
        $this->jwt = new JwtAuth();
    }

    public function index()
    {
        $list_posts = $this->blog_model->getList();
        $list_cates = $this->category_model->getCategoryTypeBlog();
        $this->renderAdmin([
            'page_title' => 'Blog Management',
            'view' => 'protected/posts/postManager',
            'content' => [
                'title' => 'Blog Posts Management',
                'list_posts' => $list_posts,
                'categories' => $list_cates
            ]
        ]);
    }

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            // Get all categories for the select dropdown
            $categories = $this->category_model->getTopCategory();
            
            $this->renderAdmin([
                'page_title' => 'Add New Blog Post',
                'view' => 'protected/posts/postAdd',
                'content' => [
                    'title' => 'Add New Blog Post',
                    'categories' => $categories
                ]
            ]);
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get current user as author
            $session = SessionFactory::createSession('account');
            $user = $session->getProfile();
            $_POST['author_id'] = $user['id'];
            
            $result = $this->blog_model->addBlog($_POST);
            if ($result) {
                // Handle category mappings if categories were selected
                if (isset($_POST['categories']) && is_array($_POST['categories'])) {
                    foreach ($_POST['categories'] as $categoryId) {
                        $this->blog_model->addBlogCategory($result, $categoryId);
                    }
                }
                
                echo json_encode(["success" => true, "message" => "Blog post added successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add blog post."]);
            }
        }
    }

    public function edit($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $post = $this->blog_model->getBlogById($id);
            $categories = $this->category_model->getTopCategory();
            
            $this->renderAdmin([
                'page_title' => 'Edit Blog Post',
                'view' => 'protected/posts/postEdit',
                'content' => [
                    'title' => 'Edit Blog Post',
                    'post' => $post,
                    'categories' => $categories
                ]
            ]);
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->blog_model->updateBlog($id, $_POST);
            if ($result) {
                // Handle category mappings
                if (isset($_POST['categories'])) {
                    // First delete all existing category mappings
                    $this->blog_model->deleteAllBlogCategories($id);
                    
                    // Then add new ones
                    foreach ($_POST['categories'] as $categoryId) {
                        $this->blog_model->addBlogCategory($id, $categoryId);
                    }
                }
                
                echo json_encode(["success" => true, "message" => "Blog post updated successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to update blog post."]);
            }
        }
    }

    public function delete($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // First delete all category mappings
            $this->blog_model->deleteAllBlogCategories($id);
            
            // Then delete the blog post
            $result = $this->blog_model->deleteBlog($id);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Blog post deleted successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete blog post."]);
            }
        }
    }

    public function uploadCoverImage()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->file_model->uploadFile('blog_covers');
            if ($result) {
                echo json_encode([
                    "success" => true, 
                    "message" => "Cover image uploaded successfully!",
                    "file_id" => $result,
                    "file_url" => $this->file_model->getFileUrl($result)
                ]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to upload cover image."]);
            }
        }
    }

    public function categories()
    {
        $categories = $this->category_model->getTopCategory();
        $this->renderAdmin([
            'page_title' => 'Blog Categories',
            'view' => 'protected/posts/categories',
            'content' => [
                'title' => 'Blog Categories Management',
                'categories' => $categories
            ]
        ]);
    }

    public function addCategory()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $_POST['type'] = 'blogs'; // Set the category type to blogs
            $result = $this->category_model->addCategory($_POST);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Category added successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add category."]);
            }
        }
    }

    public function deleteCategory($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->category_model->deleteCategory($id);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Category deleted successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete category."]);
            }
        }
    }

    public function comments()
    {
        $comments = $this->blog_model->getAllBlogComments();
        $this->renderAdmin([
            'page_title' => 'Blog Comments',
            'view' => 'protected/posts/comments',
            'content' => [
                'title' => 'Blog Comments Management',
                'comments' => $comments
            ]
        ]);
    }

    public function approveComment($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->blog_model->approveComment($id);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Comment approved successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to approve comment."]);
            }
        }
    }

    public function deleteComment($id)
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $result = $this->blog_model->deleteComment($id);
            if ($result) {
                echo json_encode(["success" => true, "message" => "Comment deleted successfully!"]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to delete comment."]);
            }
        }
    }

    public function detail($id)
    {
        $post = $this->blog_model->getBlogById($id);
        $categories = $this->category_model->getTopCategory();
        $this->renderAdmin([
            'page_title' => 'Blog Detail',
            'view' => 'protected/posts/postDetail',
            'content' => [
                'title' => 'Blog Post Detail',
                'post' => $post,
                'categories' => $categories
            ]
        ]);
    }
}
