<?php
class HelpModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'help_question';
    }

    public function saveQuestion($email, $name, $phone, $address, $city, $date, $time, $message)
    {
        $sql = "INSERT INTO $this->_table (name, email, phone, address, city, date, time, message) VALUES (:name, :email, :phone, :address, :city, :date, :time, :message)";
        $params = [
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':city' => $city,
            ':date' => $date,
            ':time' => $time,
            ':message' => $message
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'] ?? false;
    }
}