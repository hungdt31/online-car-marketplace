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
                   f.url AS car_image,
                   b.name AS branch_name, b.address AS branch_address, b.phone AS branch_phone
            FROM {$this->_table} a
            LEFT JOIN cars c ON a.car_id = c.id
            LEFT JOIN (
                SELECT ca.car_id, MIN(f.url) as url
                FROM car_assets ca
                JOIN files f ON ca.file_id = f.id
                GROUP BY ca.car_id
            ) f ON c.id = f.car_id
            LEFT JOIN branches b ON a.branch_id = b.id
            WHERE " . ($user_id ? "a.user_id = :user_id" : "1=1") . "
            ORDER BY a.created_at DESC
        ";
        
        $params = $user_id ? [':user_id' => $user_id] : [];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
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
    public function getById($id) {
        $sql = "SELECT * FROM {$this->_table} WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }
    public function create($data) {
        $sql = "INSERT INTO {$this->_table} (user_id, car_id, date, purpose, notes, branch_id) VALUES (:user_id, :car_id, :date, :purpose, :notes, :branch_id)";
         // Prepare the SQL statement
        $params = [
            ':user_id' => $data['user_id'],
            ':car_id' => $data['car_id'],
            ':date' => $data['date'],
            ':purpose' => $data['purpose'],
            ':notes' => $data['notes'],
            ':branch_id' => $data['branch_id']
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
    public function updateStatus($id, $status) {
        $sql = "UPDATE {$this->_table} SET status = :status WHERE id = :id";
        $params = [
            ':status' => $status,
            ':id' => $id,
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
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
    public function createContact($data) {
        // Build note text with proper concatenation and null coalescing
        $name = $data['name'] ?? 'Unknown';
        $email = $data['email'] ?? 'no email';
        $phone = $data['phone'] ?? 'no phone';
        $message = $data['message'] ?? 'no message';
        
        $notes = 'Customer name ' . $name . ' with ' . $email . ' - ' . $phone . ' said: ' . $message;
        $purpose = $data['subject'] ?? 'Contact';
        
        $sql = "INSERT INTO {$this->_table} (date, purpose, status, notes) VALUES (NOW(), :purpose, 'pending', :notes)";
        
        // Prepare the SQL statement
        $params = [
            ':purpose' => $purpose,
            ':notes' => $notes
        ];
        
        $result = $this->db->execute($sql, $params);
        return $result['success'] ?? false;
    }
}