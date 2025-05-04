<?php
class CategoryModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'categories';
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM $this->_table";
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }

    public function addCategory($name, $description, $type) {
        $sql = "INSERT INTO $this->_table (name, description, type) VALUES (:name, :description, :type)";
        $params = [
            ':name' => $name,
            ':description' => $description,
            ':type' => $type
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    public function updateCategory($id, $name, $description, $type) {
        $sql = "UPDATE $this->_table SET name = :name, description = :description, type = :type WHERE id = :id";
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':description' => $description,
            ':type' => $type
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    public function deleteCategory($id) {
        $sql = "DELETE FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    public function getTopCategory()
    {
        $sql = "
            SELECT 
                cat.id AS category_id,
                cat.name AS category_name,
                cat.description AS category_description,
                cat.type AS category_type,
                COUNT(cm.category_id) AS reference_count
            FROM categories cat
            LEFT JOIN category_mappings cm ON cat.id = cm.category_id AND cm.entity_type = 'cars'
            GROUP BY cat.id, cat.name, cat.description, cat.type
            ORDER BY reference_count DESC
            LIMIT 3;
        ";
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    public function getCategoryTypeBlog()
    {
        $sql = "
            SELECT 
                cat.id,
                cat.name,
                cat.description,
                cat.type,
                COUNT(cm.category_id) AS reference_count
            FROM categories cat
            LEFT JOIN category_mappings cm ON cat.id = cm.category_id AND cm.entity_type = 'blogs'
            GROUP BY cat.id, cat.name, cat.description, cat.type
            ORDER BY reference_count DESC
        ";
        // LIMIT 3;
        $result = $this->db->execute($sql);
        return $result['data'];
    }

    function getCategoryForCar($car_id)
    {
        $sql = "SELECT * FROM $this->_table WHERE id IN (SELECT category_id FROM category_mappings WHERE entity_type = 'cars' AND entity_id = :car_id)";
        $params = [':car_id' => $car_id];
        $result = $this->db->execute($sql, $params);
        return $result['data'];
    }

    function addCategoryForCar($car_id, $category_id)
    {
        $sql = "INSERT INTO category_mappings (entity_type, entity_id, category_id) VALUES ('cars', :car_id, :category_id)";
        $params = [
            ':car_id' => $car_id,
            ':category_id' => $category_id
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }

    function removeCategoryFromCar($car_id, $category_id)
    {
        $sql = "DELETE FROM category_mappings WHERE entity_type = 'cars' AND entity_id = :car_id AND category_id = :category_id";
        $params = [
            ':car_id' => $car_id,
            ':category_id' => $category_id
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
}
