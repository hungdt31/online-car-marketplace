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
}