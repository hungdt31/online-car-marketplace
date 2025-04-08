<?php
/*
 * inheritance from class model
 */
class CarModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'cars';
    }

    public function getList()
    {
        $sql = "SELECT * FROM $this->_table";
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    public function addCar($data)
    {
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
        return $result['success'];
    }

    public function getCar($id)
    {
        $sql = "SELECT * FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        $result['data']['images'] = $this->getCarAssets($id);
        return $result['data'];
    }

    public function getCarAssets($id)
    {
        $sql = "SELECT f.* FROM files f INNER JOIN car_assets ca ON f.id = ca.file_id WHERE ca.car_id = :car_id";
        $params = [':car_id' => $id];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }

    public function editCar($id, $data)
    {
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
        return $result['success'];
    }

    public function deleteCar($id)
    {
        $sql = "DELETE FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    public function getCarsByCategories($categoryIds = [])
    {
        if (empty($categoryIds)) {
            // 🔹 Lấy tất cả xe, giới hạn 5 bản ghi
            $sql = "
                SELECT 
                    c.id, c.name, c.location, c.overview, c.fuel_type, c.mileage, 
                    c.drive_type, c.service_duration, c.body_weight, c.price, 
                    c.avg_rating, c.capabilities, c.created_at, c.updated_at,
                    f.id AS file_id, f.name AS file_name, f.fkey, f.url, f.reg_date, f.size, f.type
                FROM cars c
                LEFT JOIN car_assets ca ON c.id = ca.car_id
                LEFT JOIN files f ON ca.file_id = f.id
                WHERE f.type NOT LIKE '%video%' OR f.type IS NULL
                LIMIT 5;
            ";
            $result = $this->db->execute($sql);
        } else {
            // 🔹 Chỉ lấy xe thuộc đủ tất cả danh mục trong $categoryIds
            $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));

            $sql = "
                SELECT 
                    c.id, c.name, c.location, c.overview, c.fuel_type, c.mileage, 
                    c.drive_type, c.service_duration, c.body_weight, c.price, 
                    c.avg_rating, c.capabilities, c.created_at, c.updated_at, 
                    COUNT(DISTINCT cm.category_id) AS matched_categories,
                    f.id AS file_id, f.name AS file_name, f.fkey, f.url, f.reg_date, f.size, f.type
                FROM cars c
                INNER JOIN category_mappings cm ON c.id = cm.entity_id
                LEFT JOIN car_assets ca ON c.id = ca.car_id
                LEFT JOIN files f ON ca.file_id = f.id
                WHERE cm.entity_type = 'cars'
                AND cm.category_id IN ($placeholders)
                AND (f.type NOT LIKE '%video%' OR f.type IS NULL)
                GROUP BY c.id
                HAVING COUNT(DISTINCT cm.category_id) = ?;
            ";

            $result = $this->db->execute($sql, array_merge($categoryIds, [count($categoryIds)]));
        }
        // foreach ($result['data'] as &$car) {
        //     $car['capabilities'] = json_decode($car['capabilities'], true);
        // }
        return $result['data'];
    }
}
