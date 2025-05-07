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

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $blog = $this->blog_model->getBlogById($id);
            
            if (!$blog) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Blog not found'
                ]);
                return;
            }

            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $aws = new AwsS3Service();
                $uploadFile = $aws->uploadFile($_FILES['cover_image'], 'blog_covers');
                if ($uploadFile) {
                    // tạo record mới cho bảng files
                    $addFileStatus = $this->file_model->addFile([
                        'name' => $_FILES['cover_image']['name'],
                        'fkey' => $uploadFile['fileKey'],
                        'path' => $uploadFile['fileUrl'],
                        'size' => $_FILES['cover_image']['size'],
                        'type' => $_FILES['cover_image']['type']
                    ]);
                    if ($addFileStatus) {
                        $file = $this->file_model->getFile(['fkey' => $uploadFile['fileKey']]);
                        // Cập nhật lại blog với file mới và xóa file cũ
                        if ($blog['cover_image_id']) {
                            $aws->deleteFile($blog['cover_image_key']);
                            $this->file_model->deleteOne($blog['cover_image_id']);
                        }
                        $data['cover_image_id'] = $file['id'];
                        $updateStatus = $this->blog_model->updateOne($id, $data);
                        if ($updateStatus) {
                            echo json_encode([
                                "success" => true,
                                "message" => "Blog post updated successfully!"
                            ]);
                        } else {
                            echo json_encode([
                                "success" => false,
                                "message" => "Fail to update blog!"
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
                $updateStatus = $this->blog_model->updateOne($id, $data);
                if ($updateStatus) {
                    echo json_encode([
                        "success" => true,
                        "message" => "Blog updated successfully!"
                    ]);
                } else {
                    echo json_encode([
                        "success" => false,
                        "message" => "Fail to update blog!"
                    ]);
                }
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
        $categories = $this->category_model->getAllCategories();
        $blog_categories = $this->category_model->getCategoryForBlog($id);
        $this->renderAdmin([
            'page_title' => $post['title'],
            'view' => 'protected/posts/postDetail',
            'content' => [
                'post' => $post,
                'categories' => $categories,
                'blog_categories' => $blog_categories,
            ]
        ]);
    }

    public function toggleCategory()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $blog_id = $_POST['blog_id'] ?? null;
            $category_id = $_POST['category_id'] ?? null;
            $action = $_POST['action'] ?? null;

            if (empty($blog_id) || empty($category_id) || empty($action)) {
                echo json_encode([
                    "success" => false,
                    "message" => "Blog ID, Category ID and Action are required."
                ]);
                return;
            }

            $message = "Invalid action.";
            if ($action === 'add') {
                $result = $this->category_model->addCategoryForBlog($blog_id, $category_id);
                $result ? $message = "Category added to blog successfully!" : $message = "Failed to add category to blog.";
            } elseif ($action === 'remove') {
                $result = $this->category_model->removeCategoryFromBlog($blog_id, $category_id);
                $result ? $message = "Category removed from blog successfully!" : $message = "Failed to remove category from blog.";
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => $message
                ]);
                return;
            }

            if ($result) {
                echo json_encode([
                    "success" => true,
                    "message" => $message
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => $message
                ]);
            }
        }
    }
}
