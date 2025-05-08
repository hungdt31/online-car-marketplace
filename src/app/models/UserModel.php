<?php
class UserModel extends Model {
    private $secret_key;
    private $algo;
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'users';
        $this->secret_key = getenv('SECRET_KEY');
        $this->algo = 'sha256';
    }
    public function hashPassword($password) {
        return hash_hmac($this->algo, $password, $this->secret_key);
    }
    public function findOne($data) {
        $sql = "
        SELECT u.*, f.url AS avatar 
        FROM $this->_table u
        LEFT JOIN files f ON u.avatar_id = f.id
        WHERE u.email = :email
        ";
        $params = [':email' => $data['email']];
        $result = $this->db->execute($sql, $params, true);
        if ($result['success'] && $result['data']) {
            if ($data['password']) {
                // dùng để trả thông tin đăng nhập thành công
                $hashedPassword = $this->hashPassword($data['password']);
                if (hash_equals($hashedPassword, $result['data']['password'])) {
                    unset($result['data']['password']);
                    return $result;
                }
            } else {
                // dùng để kiểm tra email tồn tại
                unset($result['data']['password']);
                return $result;
            }
        }
        return false;
    }
    public function findById($id) {
        $sql = "
        SELECT u.*, f.url AS avatar, f.fkey AS avatar_key, f.id AS avatar_id
        FROM $this->_table u
        LEFT JOIN files f ON u.avatar_id = f.id
        WHERE u.id = :id
        ";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }
    public function findAll() {
        $sql = "
        SELECT u.*, f.url as avatar_url 
        FROM $this->_table u 
        LEFT JOIN files f ON f.id = u.avatar_id 
        WHERE u.role = 'user'
        ORDER BY u.created_at DESC
        ";
        $result = $this->db->execute($sql);
        return $result['data'];
    }
    public function createOne($data) {
        $hashedPassword = '';
        if (isset($data['password'])) {
            $hashedPassword = $this->hashPassword($data['password']);
        }
        $sql = "INSERT INTO $this->_table (email, username, password, role, provider, fname, lname, phone, bio, address, avatar_id) VALUES (:email, :username, :password, :role, :provider, :fname, :lname, :phone, :bio, :address, :avatar_id)";
        $params = [
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':password' => $hashedPassword,
            ':role' => $data['role'],
            ':provider' => $data['provider'],
            ':fname' => $data['fname'],
            ':lname' => $data['lname'],
            ':phone' => $data['phone'],
            ':bio' => $data['bio'],
            ':address' => $data['address'],
            ':avatar_id' => $data['avatar_id'],
        ];
        $result = $this->db->execute($sql, $params);
        if (isset($result['errorCode'])) {
            switch ($result['errorCode']) {
                case '23000':
                    $result['message'] = 'Email already exists';
                    break;
                default:
                    $result['message'] = 'Something went wrong';
                    break;
            }
        }
        return $result;
    }
    public function updateOne($id, $data) {
        $sql = "
        UPDATE $this->_table
        SET email = :email, username = :username, fname = :fname, 
        lname = :lname, bio = :bio, phone = :phone, 
        address = :address, gender = :gender
        WHERE id = :id
        ";
        $params = [
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':fname' => $data['fname'],
            ':lname' => $data['lname'],
            ':bio' => $data['bio'],
            ':phone' => $data['phone'],
            ':address' => $data['address'],
            ':gender' => $data['gender'],
            ':id' => $id,
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
    public function updateByAdmin($id, $data) {
        $sql = "
        UPDATE $this->_table
        SET username = :username, email = :email, 
        phone = :phone, role = :role,
        status = :status
        WHERE id = :id
        ";
        $params = [
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':role' => $data['role'],
            ':status' => $data['status'],
            ':id' => $id,
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
    public function deleteOne($id) {
        $sql = "DELETE FROM $this->_table WHERE id = $id";
        $result = $this->db->execute($sql);
        return $result;
    }
    public function getList() {
        $sql = "SELECT * FROM $this->_table";
        $result = $this->db->execute($sql);
        return $result['data'];
    }
    public function getDetail($id) {
        $sql = "SELECT * FROM $this->_table WHERE id = $id";
        $result = $this->db->execute($sql);
        return $result['data'];
    }
    public function updateResetPasswordToken($data) {
        $sql = "UPDATE $this->_table SET reset_token = :token, reset_token_expires = :expires_at WHERE email = :email";
        $params = [
            ':token' => $data['token'],
            ':expires_at' => $data['expires_at'],
            ':email' => $data['email'],
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
    public function getUserByResetToken($token) {
        $sql = "SELECT * FROM $this->_table WHERE reset_token = :token AND reset_token_expires > NOW()";
        $params = [':token' => $token];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }
    public function updatePassword($data) {
        $hashedPassword = $this->hashPassword($data['password']);
        $sql = "UPDATE $this->_table SET password = :password, reset_token = NULL, reset_token_expires = NULL WHERE email = :email";
        $params = [
            ':password' => $hashedPassword,
            ':email' => $data['email'],
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
    public function updateStatus($id, $status) {
        $sql = "UPDATE $this->_table SET status = :status WHERE id = :id";
        $params = [
            ':status' => $status,
            ':id' => $id
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
    public function getCount() {
        $sql = "
        SELECT 
            COUNT(*) AS total_users,
            SUM(CASE WHEN status = 'active' THEN 1 ELSE 0 END) AS active_users,
            SUM(CASE WHEN YEAR(created_at) = YEAR(NOW())
                    AND MONTH(created_at) = MONTH(NOW()) THEN 1 ELSE 0 END) AS new_users
        FROM $this->_table;
        ";
        $result = $this->db->execute($sql, [], true);
        return $result['data'];
    }
    public function getRecentUsers($limit = 5) {
        $sql = "
        SELECT 
            u.id,
            u.username,
            u.email,
            u.created_at,
            f.url AS avatar_url
        FROM 
            $this->_table u
        LEFT JOIN 
            files f ON u.avatar_id = f.id
        ORDER BY 
            u.created_at DESC
        LIMIT $limit;
        ";
        $result = $this->db->execute($sql, []);
        return $result['data'];
    }
    
    /**
     * Update user's avatar
     * 
     * @param int $userId User ID
     * @param array $data Data containing avatar_id
     * @return bool Success status
     */
    public function updateUserAvatar($userId, $data) {
        $sql = "UPDATE $this->_table SET avatar_id = :avatar_id WHERE id = :id";
        $params = [
            ':avatar_id' => $data['avatar_id'],
            ':id' => $userId
        ];
        $result = $this->db->execute($sql, $params);
        return $result['success'];
    }
}