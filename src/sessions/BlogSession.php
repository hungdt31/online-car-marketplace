<?php
class BlogSession extends SessionRegistry {

    public function __construct() {
        parent::__construct();
        $this->keys = [
            'recent_posts' => 'recent_blog_ids',
            'selected_categories' => 'selected_blog_categories',
            'recent_keywords' => 'recent_blog_keywords',
            'current_keyword' => 'current_blog_keyword'
        ];
        
        // For debugging
        error_log('BlogSession initialized. Keys: ' . json_encode($this->keys));
    }

    /**
     * Get the IDs of recently viewed blog posts
     * 
     * @return array The array of blog post IDs
     */
    public function getRecentPostIds(): array {
        return $this->get($this->keys['recent_posts'], []);
    }
    
    /**
     * Save a blog ID to the recently viewed posts list
     * 
     * @param int $blogId The ID of the blog post that was viewed
     * @param int $limit The maximum number of recent posts to store (default: 3)
     * @return void
     */
    public function saveRecentPostId(int $blogId, int $limit = 3): void {
        // Get current stored IDs
        $recentIds = $this->getRecentPostIds();
        
        // Remove this ID if already in the array (to prevent duplicates)
        $recentIds = array_filter($recentIds, function($id) use ($blogId) {
            return $id != $blogId;
        });
        
        // Add this ID to the beginning
        array_unshift($recentIds, $blogId);
        
        // Keep only up to the limit
        $recentIds = array_slice($recentIds, 0, $limit);
        
        // Save back to session
        $this->set($this->keys['recent_posts'], $recentIds);
    }
    
    /**
     * Check if there are any recently viewed posts
     * 
     * @return bool True if there are recently viewed posts, false otherwise
     */
    public function hasRecentPosts(): bool {
        $recentIds = $this->getRecentPostIds();
        return !empty($recentIds);
    }
    
    /**
     * Clear the recently viewed posts list
     * 
     * @return void
     */
    public function clearRecentPosts(): void {
        $this->set($this->keys['recent_posts'], []);
    }
    
    /**
     * Debug function to dump session data to the error log
     */
    public function debugSession(): void {
        error_log('==== BlogSession Debug ====');
        error_log('Session ID: ' . session_id());
        error_log('Session Status: ' . session_status());
        error_log('Recent Posts Key: ' . $this->keys['recent_posts']);
        error_log('Selected Categories Key: ' . $this->keys['selected_categories']);
        error_log('Recent Posts: ' . json_encode($this->getRecentPostIds()));
        error_log('Selected Categories: ' . json_encode($this->getSelectedCategories()));
        error_log('Raw Session: ' . json_encode($_SESSION));
        $this->dumpSession();
        error_log('===========================');
    }
    
    /**
     * Debug helper to dump session data
     */
    public function dumpSession(): void {
        parent::dumpSession();
    }
    
    /**
     * Get the selected category IDs
     * 
     * @return array The array of selected category IDs
     */
    public function getSelectedCategories(): array {
        $key = $this->keys['selected_categories'];
        $value = $this->get($key, []);
        error_log('Getting selected categories with key: ' . $key . ', value: ' . json_encode($value));
        return $value;
    }
    
    /**
     * Check if there are any selected categories
     * 
     * @return bool True if there are selected categories, false otherwise
     */
    public function hasSelectedCategories(): bool {
        $selectedCategories = $this->getSelectedCategories();
        return !empty($selectedCategories);
    }
    
    /**
     * Add a category to the selected categories
     * 
     * @param int $categoryId The ID of the category to add
     * @return void
     */
    public function addSelectedCategory(int $categoryId): void {
        $key = $this->keys['selected_categories'];
        $selectedCategories = $this->getSelectedCategories();
        error_log('Adding category ' . $categoryId . ' with key: ' . $key . '. Current selection: ' . json_encode($selectedCategories));
        
        // Only add if not already in the array
        if (!in_array($categoryId, $selectedCategories)) {
            $selectedCategories[] = $categoryId;
            $this->set($key, $selectedCategories);
            $this->dumpSession();
            error_log('Category added. New selection: ' . json_encode($selectedCategories));
        } else {
            error_log('Category already in selection, not adding');
        }
    }
    
    /**
     * Remove a category from the selected categories
     * 
     * @param int $categoryId The ID of the category to remove
     * @return void
     */
    public function removeSelectedCategory(int $categoryId): void {
        $key = $this->keys['selected_categories'];
        $selectedCategories = $this->getSelectedCategories();
        error_log('Removing category ' . $categoryId . ' with key: ' . $key . '. Current selection: ' . json_encode($selectedCategories));
        
        // Filter out the specified category ID
        $selectedCategories = array_filter($selectedCategories, function($id) use ($categoryId) {
            return $id != $categoryId;
        });
        
        // Reindex array
        $selectedCategories = array_values($selectedCategories);
        
        $this->set($key, $selectedCategories);
        $this->dumpSession();
        error_log('Category removed. New selection: ' . json_encode($selectedCategories));
    }
    
    /**
     * Toggle a category in the selected categories (add if not present, remove if present)
     * 
     * @param int $categoryId The ID of the category to toggle
     * @return bool True if the category was added, false if it was removed
     */
    public function toggleSelectedCategory(int $categoryId): bool {
        $selectedCategories = $this->getSelectedCategories();
        error_log('Toggle category ' . $categoryId . '. Current selection: ' . json_encode($selectedCategories));
        
        if (in_array($categoryId, $selectedCategories)) {
            // Category exists, remove it
            error_log('Category ' . $categoryId . ' exists, removing it');
            $this->removeSelectedCategory($categoryId);
            return false;
        } else {
            // Category doesn't exist, add it
            error_log('Category ' . $categoryId . ' does not exist, adding it');
            $this->addSelectedCategory($categoryId);
            return true;
        }
    }
    
    /**
     * Clear all selected categories
     * 
     * @return void
     */
    public function clearSelectedCategories(): void {
        $this->set($this->keys['selected_categories'], []);
    }
    
    /**
     * Check if a category is selected
     * 
     * @param int $categoryId The ID of the category to check
     * @return bool True if the category is selected, false otherwise
     */
    public function isCategorySelected(int $categoryId): bool {
        $selectedCategories = $this->getSelectedCategories();
        return in_array($categoryId, $selectedCategories);
    }
    
    /**
     * Get the current search keyword
     * 
     * @return string|null The current search keyword or null
     */
    public function getCurrentKeyword(): ?string {
        $key = $this->keys['current_keyword'];
        $value = $this->get($key, null);
        error_log('Getting current keyword with key: ' . $key . ', value: ' . ($value ?? 'null'));
        return $value;
    }
    
    /**
     * Set the current search keyword
     * 
     * @param string|null $keyword The keyword to set
     * @return void
     */
    public function setCurrentKeyword(?string $keyword): void {
        $key = $this->keys['current_keyword'];
        error_log('Setting current keyword: ' . ($keyword ?? 'null') . ' with key: ' . $key);
        $this->set($key, $keyword);
        
        // If keyword is not null and not empty, add to recent keywords
        if ($keyword !== null && trim($keyword) !== '') {
            $this->addRecentKeyword($keyword);
        }
    }
    
    /**
     * Clear the current search keyword
     * 
     * @return void
     */
    public function clearCurrentKeyword(): void {
        $key = $this->keys['current_keyword'];
        error_log('Clearing current keyword with key: ' . $key);
        $this->set($key, null);
    }
    
    /**
     * Get the recent search keywords
     * 
     * @param int $limit The maximum number of keywords to return
     * @return array The array of recent search keywords
     */
    public function getRecentKeywords(int $limit = 5): array {
        $key = $this->keys['recent_keywords'];
        $value = $this->get($key, []);
        
        // Limit the number of keywords
        $value = array_slice($value, 0, $limit);
        
        error_log('Getting recent keywords with key: ' . $key . ', value: ' . json_encode($value));
        return $value;
    }
    
    /**
     * Add a keyword to the recent search keywords
     * 
     * @param string $keyword The keyword to add
     * @param int $limit The maximum number of keywords to store
     * @return void
     */
    public function addRecentKeyword(string $keyword, int $limit = 5): void {
        $key = $this->keys['recent_keywords'];
        $recentKeywords = $this->getRecentKeywords();
        $keyword = trim($keyword);
        
        error_log('Adding keyword: ' . $keyword . ' with key: ' . $key . '. Current keywords: ' . json_encode($recentKeywords));
        
        // Only add if not empty and not already at the top
        if (!empty($keyword) && ($recentKeywords === [] || $recentKeywords[0] !== $keyword)) {
            // Remove the keyword if it exists elsewhere in the array
            $recentKeywords = array_filter($recentKeywords, function($k) use ($keyword) {
                return strcasecmp($k, $keyword) !== 0;
            });
            
            // Add at the beginning
            array_unshift($recentKeywords, $keyword);
            
            // Keep only up to the limit
            $recentKeywords = array_slice($recentKeywords, 0, $limit);
            
            $this->set($key, $recentKeywords);
            $this->dumpSession();
            error_log('Keyword added. New keywords: ' . json_encode($recentKeywords));
        } else {
            error_log('Keyword empty or already at top, not adding');
        }
    }
    
    /**
     * Clear all recent search keywords
     * 
     * @return void
     */
    public function clearRecentKeywords(): void {
        $key = $this->keys['recent_keywords'];
        error_log('Clearing recent keywords with key: ' . $key);
        $this->set($key, []);
    }
    
    /**
     * Check if there are any recent search keywords
     * 
     * @return bool True if there are recent search keywords, false otherwise
     */
    public function hasRecentKeywords(): bool {
        $recentKeywords = $this->getRecentKeywords();
        return !empty($recentKeywords);
    }
} 