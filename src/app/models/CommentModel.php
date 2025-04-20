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
            ':file_id' => $data['file_id'],
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
}
