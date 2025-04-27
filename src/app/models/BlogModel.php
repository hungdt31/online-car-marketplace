<?php
class BlogModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'blogs';
    }

    public function getList($limit = null, $offset = null)
    {
        $sql = "SELECT 
                b.id, b.title, b.content, b.views, b.created_at, b.updated_at,
                u.username as author_name, 
                f.url as cover_image_url
            FROM $this->_table b
            LEFT JOIN users u ON b.author_id = u.id
            LEFT JOIN files f ON b.cover_image_id = f.id
            ORDER BY b.created_at DESC";
        
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }
        
        $params = [];
        if ($limit !== null) {
            $params[':limit'] = $limit;
            if ($offset !== null) {
                $params[':offset'] = $offset;
            }
        }
        
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }

    public function getRecentPosts($limit = 3)
    {
        $sql = "SELECT 
                b.id, b.title, b.created_at,
                f.url as cover_image_url
            FROM $this->_table b
            LEFT JOIN files f ON b.cover_image_id = f.id
            ORDER BY b.created_at DESC
            LIMIT :limit";
        
        $params = [':limit' => $limit];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }

    public function getBlogsByCategoryId($categoryId, $limit = 10)
    {
        $sql = "SELECT 
                b.id, b.title, b.content, b.views, b.created_at, b.updated_at,
                u.username as author_name, 
                f.url as cover_image_url
            FROM $this->_table b
            LEFT JOIN users u ON b.author_id = u.id
            LEFT JOIN files f ON b.cover_image_id = f.id
            LEFT JOIN category_mappings cm ON b.id = cm.entity_id AND cm.entity_type = 'blogs'
            WHERE cm.category_id = :category_id
            ORDER BY b.created_at DESC
            LIMIT :limit";
        
        $params = [
            ':category_id' => $categoryId,
            ':limit' => $limit
        ];
        
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }

    public function getBlogCategories()
    {
        $sql = "SELECT 
                c.id, c.name, COUNT(cm.entity_id) as post_count
            FROM categories c
            LEFT JOIN category_mappings cm ON c.id = cm.category_id AND cm.entity_type = 'blogs'
            GROUP BY c.id, c.name
            HAVING post_count > 0
            ORDER BY post_count DESC";
        
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    public function getBlogById($id)
    {
        $sql = "SELECT 
                b.id, b.title, b.content, b.views, b.created_at, b.updated_at,
                u.username as author_name, u.id as author_id,
                f.url as cover_image_url
            FROM $this->_table b
            LEFT JOIN users u ON b.author_id = u.id
            LEFT JOIN files f ON b.cover_image_id = f.id
            WHERE b.id = :id";
        
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        
        if ($result['success'] && isset($result['data'])) {
            // Increment views
            $this->incrementViews($id);
            
            // Get categories for this blog
            $categoriesSql = "SELECT 
                    c.id, c.name
                FROM categories c
                JOIN category_mappings cm ON c.id = cm.category_id
                WHERE cm.entity_id = :blog_id AND cm.entity_type = 'blogs'";
            
            $categoriesResult = $this->db->execute($categoriesSql, [':blog_id' => $id]);
            $result['data']['categories'] = $categoriesResult['data'] ?? [];
            
            return $result['data'];
        }
        
        return null;
    }

    private function incrementViews($id)
    {
        $sql = "UPDATE $this->_table SET views = views + 1 WHERE id = :id";
        $this->db->execute($sql, [':id' => $id]);
    }

    public function searchBlogs($keyword)
    {
        $sql = "SELECT 
                b.id, b.title, b.content, b.views, b.created_at, b.updated_at,
                u.username as author_name, 
                f.url as cover_image_url
            FROM $this->_table b
            LEFT JOIN users u ON b.author_id = u.id
            LEFT JOIN files f ON b.cover_image_id = f.id
            WHERE b.title LIKE :keyword OR b.content LIKE :keyword
            ORDER BY b.created_at DESC";
        
        $params = [':keyword' => '%' . $keyword . '%'];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }
    
    public function getPostsByIds(array $ids)
    {
        if (empty($ids)) {
            return [];
        }
        
        // Create placeholders for IDs
        $placeholders = implode(',', array_map(function($i) { 
            return ':id' . $i; 
        }, array_keys($ids)));
        
        $sql = "SELECT 
                b.id, b.title, b.created_at,
                f.url as cover_image_url
            FROM $this->_table b
            LEFT JOIN files f ON b.cover_image_id = f.id
            WHERE b.id IN ($placeholders)";
        
        // Prepare parameters
        $params = [];
        foreach ($ids as $key => $id) {
            $params[':id' . $key] = $id;
        }
        
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }
    
    /**
     * Get blogs filtered by multiple category IDs - must have ALL categories
     * 
     * @param array $categoryIds Array of category IDs to filter by
     * @param int|null $limit Maximum number of blogs to return
     * @param int|null $offset Starting offset for pagination
     * @return array The filtered blog posts
     */
    public function getBlogsByCategories(array $categoryIds, $limit = null, $offset = null)
    {
        error_log('Getting blogs for categories: ' . json_encode($categoryIds));
        
        if (empty($categoryIds)) {
            error_log('No category IDs provided, returning all blogs');
            return $this->getList($limit, $offset);
        }
        
        // We use a different approach to find posts with ALL categories
        // For each category, we need a matching entry in category_mappings
        // Count these matches and ensure they equal the number of category IDs
        
        $categoryCount = count($categoryIds);
        
        // Create placeholders for category IDs
        $placeholders = implode(',', array_map(function($i) { 
            return ':cat_id' . $i; 
        }, array_keys($categoryIds)));
        
        $sql = "SELECT 
                b.id, b.title, b.content, b.views, b.created_at, b.updated_at,
                u.username as author_name, 
                f.url as cover_image_url
            FROM $this->_table b
            LEFT JOIN users u ON b.author_id = u.id
            LEFT JOIN files f ON b.cover_image_id = f.id
            WHERE b.id IN (
                SELECT cm.entity_id
                FROM category_mappings cm
                WHERE cm.entity_type = 'blogs' 
                AND cm.category_id IN ($placeholders)
                GROUP BY cm.entity_id
                HAVING COUNT(DISTINCT cm.category_id) = :category_count
            )
            ORDER BY b.created_at DESC";
        
        // Add limit and offset if provided
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }
        
        // Prepare parameters
        $params = [':category_count' => $categoryCount];
        foreach ($categoryIds as $key => $id) {
            $params[':cat_id' . $key] = $id;
        }
        
        if ($limit !== null) {
            $params[':limit'] = $limit;
            if ($offset !== null) {
                $params[':offset'] = $offset;
            }
        }
        
        error_log('SQL: ' . $sql);
        error_log('Params: ' . json_encode($params));
        
        $result = $this->db->execute($sql, $params);
        error_log('Found ' . count($result['data']) . ' blogs');
        return $result['data'];
    }

    /**
     * Search blogs by keyword and filter by categories
     * 
     * @param string $keyword The search keyword
     * @param array $categoryIds Array of category IDs to filter by
     * @param int|null $limit Maximum number of blogs to return
     * @param int|null $offset Starting offset for pagination
     * @return array The filtered blog posts matching both keyword and categories
     */
    public function searchBlogsByCategoriesAndKeyword($keyword, array $categoryIds, $limit = null, $offset = null)
    {
        if (empty($categoryIds)) {
            return $this->searchBlogs($keyword);
        }
        
        // Count the number of categories to filter by
        $categoryCount = count($categoryIds);
        
        // Create placeholders for category IDs
        $placeholders = implode(',', array_map(function($i) { 
            return ':cat_id' . $i; 
        }, array_keys($categoryIds)));
        
        $sql = "SELECT 
                b.id, b.title, b.content, b.views, b.created_at, b.updated_at,
                u.username as author_name, 
                f.url as cover_image_url
            FROM $this->_table b
            LEFT JOIN users u ON b.author_id = u.id
            LEFT JOIN files f ON b.cover_image_id = f.id
            WHERE (b.title LIKE :keyword OR b.content LIKE :keyword)
            AND b.id IN (
                SELECT cm.entity_id
                FROM category_mappings cm
                WHERE cm.entity_type = 'blogs' 
                AND cm.category_id IN ($placeholders)
                GROUP BY cm.entity_id
                HAVING COUNT(DISTINCT cm.category_id) = :category_count
            )
            ORDER BY b.created_at DESC";
        
        // Add limit and offset if provided
        if ($limit !== null) {
            $sql .= " LIMIT :limit";
            if ($offset !== null) {
                $sql .= " OFFSET :offset";
            }
        }
        
        // Prepare parameters
        $params = [
            ':keyword' => '%' . $keyword . '%',
            ':category_count' => $categoryCount
        ];
        
        foreach ($categoryIds as $key => $id) {
            $params[':cat_id' . $key] = $id;
        }
        
        if ($limit !== null) {
            $params[':limit'] = $limit;
            if ($offset !== null) {
                $params[':offset'] = $offset;
            }
        }
        
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }
}
