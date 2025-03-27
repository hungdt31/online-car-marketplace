<?php
class CategoryModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'categories';
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
}
