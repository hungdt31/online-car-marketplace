<?php
class BlogCommentsModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'blog_comments';
    }

    /**
     * Add a new comment to a blog post
     * 
     * @param array $data Comment data with required keys: blog_id, user_id, content, file_id (optional)
     * @return mixed The result of the database insert operation
     */
    public function addComment(array $data): mixed
    {
        $sql = "
            INSERT INTO {$this->_table} (blog_id, user_id, content) 
            VALUES (:blog_id, :user_id, :content)
        ";
        $params = [
            ':blog_id' => $data['blog_id'],
            ':user_id' => $data['user_id'],
            ':content' => $data['content']
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    /**
     * Get all blog comments with user and blog information
     * 
     * @return mixed An array of all comments with user and blog information
     */
    public function getAll()
    {
        $sql = "
            SELECT 
                bc.id AS comment_id,
                bc.blog_id,
                bc.content AS comment_content,
                bc.created_at AS comment_created_at,
                bc.updated_at AS comment_updated_at,
                u.id AS user_id,
                u.username,
                u.fname,
                u.lname,
                u.email,
                fa.id AS avatar_id,
                fa.name AS avatar_name,
                fa.url AS avatar_url,
                b.title AS blog_title
            FROM 
                blog_comments bc
                INNER JOIN users u ON bc.user_id = u.id
                LEFT JOIN files fa ON u.avatar_id = fa.id
                INNER JOIN blogs b ON bc.blog_id = b.id
            ORDER BY bc.created_at DESC;
        ";
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    /**
     * Get all comments for a specific blog post
     * 
     * @param int $blogId The ID of the blog post
     * @return mixed An array of comments for the specified blog post
     */
    public function getCommentsByBlogId($blogId)
    {
        $sql = "
            SELECT 
                bc.id AS comment_id,
                bc.blog_id,
                bc.content AS comment_content,
                bc.created_at AS comment_created_at,
                bc.updated_at AS comment_updated_at,
                u.id AS user_id,
                u.username,
                u.fname,
                u.lname,
                u.email,
                fa.name AS avatar_name,
                fa.url AS avatar_url
            FROM 
                blog_comments bc
                INNER JOIN users u ON bc.user_id = u.id
                LEFT JOIN files fa ON u.avatar_id = fa.id
            WHERE 
                bc.blog_id = :blog_id
            ORDER BY bc.created_at DESC;
        ";
        $params = [':blog_id' => $blogId];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }

    /**
     * Delete a comment
     * 
     * @param int $id The ID of the comment to delete
     * @return mixed The result of the delete operation
     */
    public function deleteComment($id)
    {
        $sql = "DELETE FROM {$this->_table} WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    /**
     * Get a single comment by ID
     * 
     * @param int $id The ID of the comment to get
     * @return mixed The comment data
     */
    public function getComment($id)
    {
        $sql = "SELECT bc.*, u.email AS email
        FROM {$this->_table} bc 
        INNER JOIN users u ON bc.user_id = u.id 
        WHERE bc.id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }

    /**
     * Count comments for each blog post
     * 
     * @return mixed An array with blog_id and comment_count
     */
    public function getCommentCountsByBlog()
    {
        $sql = "
            SELECT 
                blog_id,
                COUNT(*) as comment_count
            FROM 
                {$this->_table}
            GROUP BY 
                blog_id
        ";
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    /**
     * Get recent comments
     * 
     * @param int $limit Number of comments to return
     * @return mixed Recent comments data
     */
    public function getRecentComments($limit = 5)
    {
        $sql = "
            SELECT 
                bc.id AS comment_id,
                bc.blog_id,
                bc.content AS comment_content,
                bc.created_at AS comment_created_at,
                u.username,
                b.title AS blog_title
            FROM 
                {$this->_table} bc
                INNER JOIN users u ON bc.user_id = u.id
                INNER JOIN blogs b ON bc.blog_id = b.id
            ORDER BY 
                bc.created_at DESC
            LIMIT :limit
        ";
        $params = [':limit' => $limit];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }
} 