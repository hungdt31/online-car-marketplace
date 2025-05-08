<?php
class HelpModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'help_question';
    }

    public function saveQuestion($name, $email, $question)
    {
        $sql = "INSERT INTO $this->_table (name, email, question) VALUES (:name, :email, :question)";
        $params = [
            ':name' => $name,
            ':email' => $email,
            ':question' => $question
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'] ?? false;
    }

    public function getAllQuestions() {
        $sql = "SELECT * FROM $this->_table ORDER BY create_at DESC";
        $result = $this->db->execute($sql);
        if ($result['success']) return $result['data'];
        return [];
    }

    public function getQuestionById($id) {
        $sql = "SELECT * FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        if ($result['success']) return $result['data'];
        return null;
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE $this->_table SET status = :status WHERE id = :id";
        $params = [':id' => $id, ':status' => $status];
        $result = $this->db->execute($sql, $params);
        return $result['success'] ?? false;
    }
}