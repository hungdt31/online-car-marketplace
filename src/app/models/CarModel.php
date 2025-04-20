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

    public function getAdvancedCar($id)
    {
        // Truy vấn chính để lấy thông tin xe
        $sql = "SELECT 
                    c.*
                FROM $this->_table c
                WHERE c.id = :id";

        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);

        // Kiểm tra nếu không có dữ liệu
        if (!$result || empty($result['data'])) {
            return null; // Hoặc throw exception tùy yêu cầu
        }

        $carData = $result['data'];

        // Giải mã JSON cho capabilities
        $carData['capabilities'] = !empty($carData['capabilities']) ? json_decode($carData['capabilities'], true) : [];

        // Lấy danh sách hình ảnh cho xe chính
        $carData['images'] = $this->getCarAssets($id) ?: [];

        // Truy vấn categories
        $categorySql = "SELECT 
                            cat.id, cat.name
                        FROM categories cat
                        INNER JOIN category_mappings cm ON cat.id = cm.category_id
                        WHERE cm.entity_id = :id AND cm.entity_type = 'cars'";

        $categoriesResult = $this->db->execute($categorySql, $params)['data'];
        $categories = [];
        if ($categoriesResult && is_array($categoriesResult)) {
            foreach ($categoriesResult as $cat) {
                $categories[] = [
                    'id' => $cat['id'],
                    'name' => $cat['name']
                ];
            }
        }
        $carData['categories'] = $categories;

        // // Truy vấn xe liên quan (related_cars)
        $relatedCarsSql = "SELECT 
                            c2.id, c2.name, c2.price, c2.location
                        FROM $this->_table c
                        INNER JOIN category_mappings cm ON c.id = cm.entity_id AND cm.entity_type = 'cars'
                        INNER JOIN category_mappings cm2 ON cm.category_id = cm2.category_id AND cm2.entity_type = 'cars'
                        INNER JOIN $this->_table c2 ON cm2.entity_id = c2.id AND c2.id != c.id
                        WHERE c.id = :id
                        GROUP BY c2.id
                        LIMIT 3";

        $relatedCarsResult = $this->db->execute($relatedCarsSql, $params)['data'];
        $relatedCars = [];
        if ($relatedCarsResult && is_array($relatedCarsResult)) {
            // Nếu chỉ có 1 bản ghi, chuyển thành mảng
            $relatedCarsResult = isset($relatedCarsResult['id']) ? [$relatedCarsResult] : $relatedCarsResult;
            foreach ($relatedCarsResult as $car) {
                $relatedCar = [
                    'id' => $car['id'],
                    'name' => $car['name'],
                    'price' => $car['price'],
                    'location' => $car['location'],
                    'image' => null,
                    'video' => null
                ];

                // Lấy ảnh hoặc video cho xe liên quan
                $assets = $this->getCarAssets($car['id']);
                $trigger = isset($assets[0]['url']) ? $assets[0]['url'] : null;
                if ($trigger && strpos($trigger, 'video') !== false) {
                    $relatedCar['video'] = $trigger;
                } else {
                    $relatedCar['image'] = $trigger;
                }

                $relatedCars[] = $relatedCar;
            }
        }
        $carData['related_cars'] = $relatedCars;

        // Truy vấn comments
        $commentsSql = "SELECT 
                            com.id, com.title, com.content, com.rating, com.created_at,
                            u.username, f.url AS avatar
                        FROM comments com
                        LEFT JOIN users u ON com.user_id = u.id
                        LEFT JOIN files f ON u.avatar_id = f.id
                        WHERE com.car_id = :id";

        $commentsResult = $this->db->execute($commentsSql, $params)['data'];
        $comments = [];
        if ($commentsResult && is_array($commentsResult)) {
            // Nếu chỉ có 1 bản ghi, chuyển thành mảng
            $commentsResult = isset($commentsResult['id']) ? [$commentsResult] : $commentsResult;
            foreach ($commentsResult as $comment) {
                $comments[] = [
                    'id' => $comment['id'],
                    'title' => $comment['title'],
                    'content' => $comment['content'],
                    'rating' => $comment['rating'],
                    'created_at' => $comment['created_at'],
                    'username' => $comment['username'],
                    'avatar' => $comment['avatar'] ?: 'https://ui.shadcn.com/avatars/05.png'
                ];
            }
        }
        $carData['comments'] = $comments;

        return $carData;
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
                LEFT JOIN (
                    SELECT ca.car_id, f.id, f.name, f.fkey, f.url, f.reg_date, f.size, f.type
                    FROM car_assets ca
                    LEFT JOIN files f ON ca.file_id = f.id
                    WHERE f.type NOT LIKE '%video%' OR f.type IS NULL
                    GROUP BY ca.car_id
                ) f ON c.id = f.car_id
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

    public function updateCarDetails($id, $data)
    {
        try {
            // Validate capabilities structure
            if (
                !isset($data['capabilities']['engine']) ||
                !isset($data['capabilities']['seats']) ||
                !isset($data['capabilities']['features'])
            ) {
                return false;
            }

            // Convert capabilities to JSON
            $capabilities = json_encode($data['capabilities']);

            $sql = "UPDATE $this->_table 
                    SET overview = :overview, 
                        capabilities = :capabilities,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = :id";

            $params = [
                ':id' => $id,
                ':overview' => $data['overview'],
                ':capabilities' => $capabilities
            ];

            $result = $this->db->execute($sql, $params);
            return $result['success'];
        } catch (Exception $e) {
            // Log error if needed
            return false;
        }
    }
}
