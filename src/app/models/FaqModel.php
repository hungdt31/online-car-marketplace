<?php
class FaqModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'faq_questions';
    }

    public function getAllFaqs()
    {
        $sql = "SELECT * FROM $this->_table ORDER BY created_at DESC";
        $result = $this->db->execute($sql);
        if ($result['success']) {
            return $result['data'];
        }
        return [];
    }

    public function getFaqById($id)
    {
        $sql = "SELECT * FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        if ($result['success']) {
            return $result['data'];
        }
        return null;
    }

    public function addFaq($question, $answer)
    {
        $sql = "INSERT INTO $this->_table (question, answer) VALUES (:question, :answer)";
        $params = [
            ':question' => $question,
            ':answer' => $answer
        ];
        return $this->db->execute($sql, $params);
    }

    public function updateFaq($id, $question, $answer, $status)
    {
        $sql = "UPDATE $this->_table SET question = :question, answer = :answer, status = :status WHERE id = :id";
        $params = [
            ':id' => $id,
            ':question' => $question,
            ':answer' => $answer,
            ':status' => $status
        ];
        return $this->db->execute($sql, $params);
    }

    public function deleteFaq($id)
    {
        $sql = "DELETE FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        return $this->db->execute($sql, $params);
    }
} 