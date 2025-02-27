<?php
/*
 * inheritance from class model
 */
class CarModel extends Model {
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'cars';
    }
    public function getList() {
        $sql = "SELECT * FROM $this->_table";
        $result = $this->db->execute($sql);
        return $result;
    }
    public function addCar($data) {
        $sql = "INSERT INTO $this->_table (name, location, fuel_type, mileage, drive_type, service_duration, body_weight, price) 
                VALUES (:name, :location, :fuel_type, :mileage, :drive_type, :service_duration, :body_weight, :price)";
        
        $params = [
            ':name' => $data['name'],
            ':location' => $data['location'],
            ':fuel_type' => $data['fuel_type'],
            ':mileage' => $data['mileage'],
            ':drive_type' => $data['drive_type'],
            ':service_duration' => $data['service_duration'],
            ':body_weight' => $data['body_weight'],
            ':price' => $data['price']
        ];
    
        $result = $this->db->execute($sql, $params);
        return $result;
    }
    public function getCar($id) {
        $sql = "SELECT * FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        return $result;
    }
    public function editCar($id, $data) {
        $sql = "UPDATE $this->_table SET name = :name, location = :location, fuel_type = :fuel_type, mileage = :mileage, drive_type = :drive_type, service_duration = :service_duration, body_weight = :body_weight, price = :price WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':location' => $data['location'],
            ':fuel_type' => $data['fuel_type'],
            ':mileage' => $data['mileage'],
            ':drive_type' => $data['drive_type'],
            ':service_duration' => $data['service_duration'],
            ':body_weight' => $data['body_weight'],
            ':price' => $data['price']
        ];
    
        $result = $this->db->execute($sql, $params);
        return $result;
    }
    public function deleteCar($id) {
        $sql = "DELETE FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return $result;
    }
}