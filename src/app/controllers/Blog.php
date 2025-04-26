<?php
class Blog extends Controller
{
    public $blog_model;
    public $category_model;
    
    public function __construct()
    {
        $this->blog_model = $this->model('BlogModel');
        $this->category_model = $this->model('CategoryModel');
    }
    
    public function index()
    {
        $blogs = $this->blog_model->getList();
        $categories = $this->blog_model->getBlogCategories();
        $recentPosts = $this->blog_model->getRecentPosts(3);
        
        $this->renderGeneral([
            'page_title' => 'Blog',
            'view' => 'public/blog/index',
            'content' => [
                'header' => [
                    'title' => 'Blogs',
                    'description' => '//'
                ],
                'blogs' => $blogs,
                'categories' => $categories,
                'recentPosts' => $recentPosts
            ]
        ]);
    }
    
    public function category($categoryId)
    {
        $blogs = $this->blog_model->getBlogsByCategoryId($categoryId);
        $categories = $this->blog_model->getBlogCategories();
        $recentPosts = $this->blog_model->getRecentPosts(3);
        $currentCategory = null;
        
        foreach ($categories as $category) {
            if ($category['id'] == $categoryId) {
                $currentCategory = $category;
                break;
            }
        }
        
        $this->renderGeneral([
            'page_title' => 'Blog - ' . ($currentCategory ? $currentCategory['name'] : 'Category'),
            'view' => 'public/blog/index',
            'content' => [
                'blogs' => $blogs,
                'categories' => $categories,
                'recentPosts' => $recentPosts,
                'currentCategory' => $currentCategory
            ]
        ]);
    }
    
    public function detail($id)
    {
        $blog = $this->blog_model->getBlogById($id);
        
        if (!$blog) {
            // Redirect to blog index or show error
            header('Location: ' . _WEB_ROOT . '/blog');
            exit;
        }
        
        $categories = $this->blog_model->getBlogCategories();
        $recentPosts = $this->blog_model->getRecentPosts(3);
        
        $this->renderGeneral([
            'page_title' => $blog['title'],
            'view' => 'public/blog/detail',
            'content' => [
                'header' => [
                    'title' => $blog['title'],
                    'description' => 'Home/Blog - ' . $blog['title']
                ],
                'blog' => $blog,
                'categories' => $categories,
                'recentPosts' => $recentPosts
            ]
        ]);
    }
    
    public function search()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $blogs = $this->blog_model->searchBlogs($keyword);
        $categories = $this->blog_model->getBlogCategories();
        $recentPosts = $this->blog_model->getRecentPosts(3);
        
        $this->renderGeneral([
            'page_title' => 'Search: ' . $keyword,
            'view' => 'public/blog/index',
            'content' => [
                'blogs' => $blogs,
                'categories' => $categories,
                'recentPosts' => $recentPosts,
                'keyword' => $keyword
            ]
        ]);
    }
}
