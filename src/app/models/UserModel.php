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
        $sql = "SELECT * FROM $this->_table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->execute($sql, $params, true);
        return $result['data'];
    }
    public function findAll() {
        $sql = "SELECT * FROM $this->_table";
        $result = $this->db->execute($sql);
        return $result['data'];
    }
    public function createOne($data) {
        $hashedPassword = '';
        if (isset($data['password'])) {
            $hashedPassword = $this->hashPassword($data['password']);
        }
        $sql = "INSERT INTO $this->_table (email, username, password, role, provider, fname, lname) VALUES (:email, :username, :password, :role, :provider, :fname, :lname)";
        $params = [
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':password' => $hashedPassword,
            ':role' => $data['role'],
            ':provider' => $data['provider'],
            ':fname' => $data['fname'],
            ':lname' => $data['lname'],
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
}