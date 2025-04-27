<?php
class Blog extends Controller
{
    public $blog_model;
    public $category_model;
    private $blog_session;
    
    public function __construct()
    {
        $this->blog_model = $this->model('BlogModel');
        $this->category_model = $this->model('CategoryModel');
        $this->blog_session = SessionFactory::createSession('blog');
        $this->blog_session->debugSession();
    }
    
    // Helper method to get recent blog posts (either from storage or database)
    private function getRecentBlogPosts()
    {
        // Check if we have recent blog IDs in session
        if ($this->blog_session->hasRecentPosts()) {
            // Get posts by stored IDs
            return $this->blog_model->getPostsByIds($this->blog_session->getRecentPostIds());
        }
        
        // Fallback to regular recent posts if no stored IDs
        return $this->blog_model->getRecentPosts(3);
    }
    
    // Helper method to get filtered blogs based on selected categories
    private function getFilteredBlogs()
    {
        // Check if we have selected categories
        if ($this->blog_session->hasSelectedCategories()) {
            // Get blogs filtered by selected categories
            return $this->blog_model->getBlogsByCategories($this->blog_session->getSelectedCategories());
        }
        
        // No categories selected, return all blogs
        return $this->blog_model->getList();
    }
    
    public function index()
    {
        $this->blog_session->debugSession();
        $blogs = $this->getFilteredBlogs();
        $categories = $this->blog_model->getBlogCategories();
        $recentPosts = $this->getRecentBlogPosts();
        $recentKeywords = $this->blog_session->getRecentKeywords();
        $currentKeyword = $this->blog_session->getCurrentKeyword();
        
        // Breadcrumb structure
        $breadcrumbs = [
            ['name' => 'Home', 'url' => _WEB_ROOT],
            ['name' => 'Blog', 'url' => '']
        ];
        
        $this->renderGeneral([
            'page_title' => 'Blog',
            'view' => 'public/blog/index',
            'content' => [
                'header' => [
                    'title' => 'Blogs',
                    'description' => $breadcrumbs
                ],
                'blogs' => $blogs,
                'categories' => $categories,
                'recentPosts' => $recentPosts,
                'hasRecentlyViewed' => $this->blog_session->hasRecentPosts(),
                'selectedCategories' => $this->blog_session->getSelectedCategories(),
                'recentKeywords' => $recentKeywords,
                'hasRecentKeywords' => $this->blog_session->hasRecentKeywords(),
                'currentKeyword' => $currentKeyword
            ]
        ]);
    }
    
    public function category($categoryId)
    {
        // If we're accessing this directly, just add this category to our filter
        $this->blog_session->addSelectedCategory((int)$categoryId);
        
        // Redirect back to index where filtering will happen
        header('Location: ' . _WEB_ROOT . '/blog');
        exit;
    }
    
    public function detail($id)
    {
        $blog = $this->blog_model->getBlogById($id);
        
        if (!$blog) {
            // Redirect to blog index or show error
            header('Location: ' . _WEB_ROOT . '/blog');
            exit;
        }
        
        // Store this blog ID in recently viewed posts
        $this->blog_session->saveRecentPostId($id);
        
        $categories = $this->blog_model->getBlogCategories();
        $recentPosts = $this->getRecentBlogPosts();
        $recentKeywords = $this->blog_session->getRecentKeywords();
        
        // Breadcrumb structure
        $breadcrumbs = [
            ['name' => 'Home', 'url' => _WEB_ROOT],
            ['name' => 'Blog', 'url' => _WEB_ROOT . '/blog'],
            ['name' => $blog['title'], 'url' => '']
        ];
        
        $this->renderGeneral([
            'page_title' => $blog['title'],
            'view' => 'public/blog/detail',
            'content' => [
                'header' => [
                    'title' => 'Blog Details',
                    'description' => $breadcrumbs
                ],
                'blog' => $blog,
                'categories' => $categories,
                'recentPosts' => $recentPosts,
                'hasRecentlyViewed' => $this->blog_session->hasRecentPosts(),
                'selectedCategories' => $this->blog_session->getSelectedCategories(),
                'recentKeywords' => $recentKeywords,
                'hasRecentKeywords' => $this->blog_session->hasRecentKeywords()
            ]
        ]);
    }
    
    public function search()
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        // Store the keyword in session if it's not empty
        if (!empty($keyword)) {
            $this->blog_session->setCurrentKeyword($keyword);
        }
        
        // Get filtered blogs based on keyword and selected categories
        $blogs = [];
        if ($this->blog_session->hasSelectedCategories()) {
            // Search with both keyword and category filters
            $blogs = $this->blog_model->searchBlogsByCategoriesAndKeyword(
                $keyword, 
                $this->blog_session->getSelectedCategories()
            );
        } else {
            // Search with just keyword
            $blogs = $this->blog_model->searchBlogs($keyword);
        }
        
        $categories = $this->blog_model->getBlogCategories();
        $recentPosts = $this->getRecentBlogPosts();
        $recentKeywords = $this->blog_session->getRecentKeywords();
        
        // Breadcrumb structure
        $breadcrumbs = [
            ['name' => 'Home', 'url' => _WEB_ROOT],
            ['name' => 'Blog', 'url' => _WEB_ROOT . '/blog'],
            ['name' => 'Search: ' . $keyword, 'url' => '']
        ];
        
        $this->renderGeneral([
            'page_title' => 'Search: ' . $keyword,
            'view' => 'public/blog/index',
            'content' => [
                'header' => [
                    'title' => 'Search Results for: ' . $keyword,
                    'description' => $breadcrumbs
                ],
                'blogs' => $blogs,
                'categories' => $categories,
                'recentPosts' => $recentPosts,
                'keyword' => $keyword,
                'hasRecentlyViewed' => $this->blog_session->hasRecentPosts(),
                'selectedCategories' => $this->blog_session->getSelectedCategories(),
                'recentKeywords' => $recentKeywords,
                'hasRecentKeywords' => $this->blog_session->hasRecentKeywords(),
                'currentKeyword' => $keyword
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
        // Log session state before changes
        $this->blog_session->debugSession();
        
        // Convert to integer and toggle
        $categoryId = (int)$categoryId;
        $result = $this->blog_session->toggleSelectedCategory($categoryId);
        
        // Log session state after changes
        $this->blog_session->debugSession();
        
        // Check and log current state
        $selectedCategories = $this->blog_session->getSelectedCategories();
        error_log('Category ' . $categoryId . ' toggled. Selected: ' . ($result ? 'Yes' : 'No'));
        error_log('Current selected categories: ' . json_encode($selectedCategories));
        
        // If this is an AJAX request, return JSON response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            $isSelected = $this->blog_session->isCategorySelected($categoryId);
            $blogs = $this->getFilteredBlogs();
            
            echo json_encode([
                'success' => true,
                'isSelected' => $isSelected,
                'selectedCategories' => $selectedCategories,
                'blogCount' => count($blogs)
            ]);
            exit;
        }
        
        // Otherwise redirect back to blog index
        header('Location: ' . _WEB_ROOT . '/blog');
        exit;
    }
    
    /**
     * Clear all selected categories
     * 
     * @return void
     */
    public function clearCategories()
    {
        $this->blog_session->clearSelectedCategories();
        
        // If this is an AJAX request, return JSON response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode([
                'success' => true
            ]);
            exit;
        }
        
        // Otherwise redirect back to blog index
        header('Location: ' . _WEB_ROOT . '/blog');
        exit;
    }
    
    /**
     * Clear the search history
     */
    public function clearSearchHistory()
    {
        $this->blog_session->clearRecentKeywords();
        $this->blog_session->clearCurrentKeyword();
        
        // If this is an AJAX request, return JSON response
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            echo json_encode([
                'success' => true
            ]);
            exit;
        }
        
        // Otherwise redirect back to blog index
        header('Location: ' . _WEB_ROOT . '/blog');
        exit;
    }
}
