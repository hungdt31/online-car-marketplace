<?php
class AppointmentModel extends Model {
    public function __construct() {
        parent::__construct();
        $this->_table = 'appointments';
    }
    public function getAllAppointments() {
        $sql = "SELECT a.*, u.username as user_name, c.name as car_name 
                FROM $this->_table a 
                LEFT JOIN users u ON a.user_id = u.id 
                LEFT JOIN cars c ON a.car_id = c.id 
                ORDER BY a.created_at DESC";
        $result = $this->db->execute($sql);
        return $result['success'] ? $result['data'] : [];
    }
    public function getActiveUsers() {
        $sql = "SELECT id, username FROM users WHERE role = 'user'";
        $result = $this->db->execute($sql);
        return $result['success'] ? $result['data'] : [];
    }
    public function getAvailableCars() {
        $sql = "SELECT id, name FROM cars";
        $result = $this->db->execute($sql);
        return $result['success'] ? $result['data'] : [];
    }
    public function addAppointment($data) {
    $sql = "INSERT INTO $this->_table (user_id, car_id, date, purpose, status, notes) 
            VALUES (:user_id, :car_id, :appointment_date, :purpose, 'pending', :notes)";
    $params = [
        ':user_id' => $data['user_id'],
        ':car_id' => $data['car_id'],
        ':appointment_date' => $data['appointment_date'], 
        ':purpose' => $data['purpose'],
        ':notes' => $data['notes'] ?? ''
    ];

    $result = $this->db->execute($sql, $params);  // 

    return $result['success'] ?? false;
}
    public function confirmAppointment($id) {
        $sql = "UPDATE $this->_table SET status = 'confirmed' WHERE id = :id AND status = 'pending'";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return $result['success'] ?? false;
    }
    public function cancelAppointment($id) {
        $sql = "UPDATE $this->_table SET status = 'cancelled' WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return $result['success'] ?? false;
    }
}