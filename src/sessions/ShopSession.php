<?php
class ShopSession extends SessionRegistry {

    public function __construct() {
        parent::__construct();
        $this->keys = [
            'recent_cars' => 'recent_car_ids',
            'selected_categories' => 'selected_shop_categories',
            'current_keyword' => 'current_shop_keyword'
        ];
    }

    /**
     * Get the IDs of recently viewed cars
     * 
     * @return array The array of car IDs
     */
    public function getRecentCarIds(): array {
        return $this->get($this->keys['recent_cars'], []);
    }
    
    /**
     * Save a car ID to the recently viewed cars list
     * 
     * @param int $carId The ID of the car that was viewed
     * @param int $limit The maximum number of recent cars to store (default: 3)
     * @return void
     */
    public function saveRecentCarId(int $carId, int $limit = 3): void {
        // Get current stored IDs
        $recentIds = $this->getRecentCarIds();
        
        // Remove this ID if already in the array (to prevent duplicates)
        $recentIds = array_filter($recentIds, function($id) use ($carId) {
            return $id != $carId;
        });
        
        // Add this ID to the beginning
        array_unshift($recentIds, $carId);
        
        // Keep only up to the limit
        $recentIds = array_slice($recentIds, 0, $limit);
        
        // Save back to session
        $this->set($this->keys['recent_cars'], $recentIds);
    }
    
    /**
     * Check if there are any recently viewed cars
     * 
     * @return bool True if there are recently viewed cars, false otherwise
     */
    public function hasRecentCars(): bool {
        $recentIds = $this->getRecentCarIds();
        return !empty($recentIds);
    }
    
    /**
     * Clear the recently viewed cars list
     * 
     * @return void
     */
    public function clearRecentCars(): void {
        $this->set($this->keys['recent_cars'], []);
    }
    
    /**
     * Get the selected category IDs
     * 
     * @return array The array of selected category IDs
     */
    public function getSelectedCategories(): array {
        return $this->get($this->keys['selected_categories'], []);
    }
    
    /**
     * Set the selected categories
     * 
     * @param array $categoryIds The array of category IDs to set
     * @return void
     */
    public function setSelectedCategories(array $categoryIds): void {
        $this->set($this->keys['selected_categories'], $categoryIds);
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
        $selectedCategories = $this->getSelectedCategories();
        
        // Only add if not already in the array
        if (!in_array($categoryId, $selectedCategories)) {
            $selectedCategories[] = $categoryId;
            $this->set($this->keys['selected_categories'], $selectedCategories);
        }
    }
    
    /**
     * Remove a category from the selected categories
     * 
     * @param int $categoryId The ID of the category to remove
     * @return void
     */
    public function removeSelectedCategory(int $categoryId): void {
        $selectedCategories = $this->getSelectedCategories();
        
        // Filter out the specified category ID
        $selectedCategories = array_filter($selectedCategories, function($id) use ($categoryId) {
            return $id != $categoryId;
        });
        
        // Reindex array
        $selectedCategories = array_values($selectedCategories);
        
        $this->set($this->keys['selected_categories'], $selectedCategories);
    }
    
    /**
     * Toggle a category in the selected categories (add if not present, remove if present)
     * 
     * @param int $categoryId The ID of the category to toggle
     * @return bool True if the category was added, false if it was removed
     */
    public function toggleSelectedCategory(int $categoryId): bool {
        $selectedCategories = $this->getSelectedCategories();
        
        if (in_array($categoryId, $selectedCategories)) {
            // Category exists, remove it
            $this->removeSelectedCategory($categoryId);
            return false;
        } else {
            // Category doesn't exist, add it
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
        return $this->get($this->keys['current_keyword'], null);
    }
    
    /**
     * Set the current search keyword
     * 
     * @param string|null $keyword The keyword to set
     * @return void
     */
    public function setCurrentKeyword(?string $keyword): void {
        $this->set($this->keys['current_keyword'], $keyword);
    }
    
    /**
     * Clear the current search keyword
     * 
     * @return void
     */
    public function clearCurrentKeyword(): void {
        $this->set($this->keys['current_keyword'], null);
    }
} 