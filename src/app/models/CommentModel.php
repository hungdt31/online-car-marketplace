<?php
class CommentModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'comments';
    }
    /**
     * Add a new comment to the database
     * 
     * @param array $data Comment data with required keys: car_id, user_id, rating, title, content, file_id
     * @return mixed The result of the database insert operation
     */
    public function addComment(array $data): mixed
    {
        $sql = "
            INSERT INTO {$this->_table} (car_id, user_id, rating, title, content, file_id) 
            VALUES (:car_id, :user_id, :rating, :title, :content, :file_id)
        ";
        $params = [
            ':car_id' => $data['car_id'],
            ':user_id' => $data['user_id'],
            ':rating' => $data['rating'],
            ':title' => $data['title'],
            ':content' => $data['content'],
            ':file_id' => $data['file_id'] ?? null,
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    /**
     * Get all car comments with user and car information
     * 
     * @return mixed An array of all comments with user and car information
     */
    public function getAll()
    {
        $sql = "
            SELECT 
                c.id AS comment_id,
                c.car_id,
                c.rating,
                c.title AS comment_title,
                c.content AS comment_content,
                c.created_at AS comment_created_at,
                c.status AS comment_status,
                c.reply AS comment_reply,
                c.reply_created_at AS comment_reply_created_at,
                u.id AS user_id,
                u.username,
                u.fname,
                u.lname,
                u.email,
                u.phone,
                u.address,
                u.bio,
                f.id AS file_id,
                f.name AS file_name,
                f.url AS file_url,
                f.size AS file_size,
                f.type AS file_type,
                fa.id AS avatar_id,
                fa.name AS avatar_name,
                fa.url AS avatar_url,
                fa.size AS avatar_size,
                fa.type AS avatar_type,
                car.name AS car_name
            FROM 
                comments c
                INNER JOIN users u ON c.user_id = u.id
                LEFT JOIN files f ON c.file_id = f.id
                LEFT JOIN files fa ON u.avatar_id = fa.id
                INNER JOIN cars car ON c.car_id = car.id;
        ";
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    /**
     * Get all comments for a specific car
     * 
     * @param int $carId The ID of the car
     * @return mixed An array of comments for the specified car
     */
    public function getCommentsById($carId)
    {
        $sql = "
            SELECT 
                c.id AS comment_id,
                c.car_id,
                car.name AS car_name,
                c.rating,
                c.title AS comment_title,
                c.content AS comment_content,
                c.created_at AS comment_created_at,
                c.status AS comment_status,
                c.reply AS comment_reply,
                c.reply_created_at AS comment_reply_created_at,
                u.id AS user_id,
                u.username,
                u.fname,
                u.lname,
                u.email,
                u.phone,
                u.address,
                u.bio,
                f.id AS file_id,
                f.name AS file_name,
                f.url AS file_url,
                f.size AS file_size,
                f.type AS file_type,
                fa.id AS avatar_id,
                fa.name AS avatar_name,
                fa.url AS avatar_url,
                fa.size AS avatar_size,
                fa.type AS avatar_type
            FROM 
                comments c
                INNER JOIN users u ON c.user_id = u.id
                LEFT JOIN files f ON c.file_id = f.id
                LEFT JOIN files fa ON u.avatar_id = fa.id
                LEFT JOIN cars car ON c.car_id = car.id
            WHERE 
                c.car_id = :car_id;
        ";
        $params = [':car_id' => $carId];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }

    /**
     * Approve a comment
     * 
     * @param int $id The ID of the comment to approve
     * @return mixed The result of the update operation
     */
    public function changeStatusComment($id, $status)
    {
        $sql = "UPDATE {$this->_table} SET status = :status WHERE id = :id";
        $params = [':id' => $id, ':status' => $status];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
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

    public function replyToComment($id, $reply)
    {
        $sql = "UPDATE {$this->_table} 
                SET reply = :reply, 
                    reply_created_at = NOW(), 
                    status = 'approved' 
                WHERE id = :id";
        $params = [
            ':id' => $id,
            ':reply' => $reply
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'] ?? false;
    }

    public function getComment($id)
    {
        $sql = "SELECT c.*, u.email AS email 
                FROM {$this->_table} c 
                INNER JOIN users u ON c.user_id = u.id 
                WHERE c.id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }
}
