<?php
class AppointmentModel extends Model {
    public function __construct() {
        parent::__construct();
        $this->_table = 'appointments';
    }
    public function getAll($user_id = null) {
        $sql = "
            SELECT a.*, 
                   c.name, c.location, c.overview, c.fuel_type, c.mileage, 
                   c.drive_type, c.price, c.avg_rating,
                   f.url AS car_image
            FROM {$this->_table} a
            LEFT JOIN cars c ON a.car_id = c.id
            LEFT JOIN (
                SELECT ca.car_id, MIN(f.url) as url
                FROM car_assets ca
                JOIN files f ON ca.file_id = f.id
                GROUP BY ca.car_id
            ) f ON c.id = f.car_id
            WHERE " . ($user_id ? "a.user_id = :user_id" : "1=1") . "
            ORDER BY a.created_at DESC
        ";
        
        $params = $user_id ? [':user_id' => $user_id] : [];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }
    public function getById($id) {
        $sql = "SELECT * FROM {$this->_table} WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }
    public function create($data) {
        $sql = "INSERT INTO {$this->_table} (user_id, car_id, date, purpose, notes) VALUES (:user_id, :car_id, :date, :purpose, :notes)";
        $params = [
            ':user_id' => $data['user_id'],
            ':car_id' => $data['car_id'],
            ':date' => $data['date'],
            ':purpose' => $data['purpose'],
            ':notes' => $data['notes'],
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

}