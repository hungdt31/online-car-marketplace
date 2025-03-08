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
    public function findOne($data) {
        $sql = "SELECT * FROM $this->_table WHERE email = :email";
        $params = [':email' => $data['email']];
        $result = $this->db->execute($sql, $params, true);
        if ($result) {
            $hashedPassword = hash_hmac($this->algo, $data['password'], $this->secret_key);
            if (hash_equals($hashedPassword, $result['password'])) {
                return $result;
            }
        }
        return false;
    }
    public function createOne($data) {
        $hashedPassword = hash_hmac($this->algo, $data['password'], $this->secret_key);
        $sql = "INSERT INTO $this->_table (email, username, password, role) VALUES (:email, :username, :password, :role)";
        $params = [
            ':email' => $data['email'],
            ':username' => $data['username'],
            ':password' => $hashedPassword,
            ':role' => $data['role']
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
    public function updateUser($id, $email, $password, $role) {
        $sql = "UPDATE $this->_table SET email = '$email', password = '$password', role = '$role' WHERE id = $id";
        $result = $this->db->execute($sql);
        return $result;
    }
    public function deleteUser($id) {
        $sql = "DELETE FROM $this->_table WHERE id = $id";
        $result = $this->db->execute($sql);
        return $result;
    }
    public function getList() {
        $sql = "SELECT * FROM $this->_table";
        $result = $this->db->execute($sql);
        return $result;
    }
    public function getDetail($id) {
        $sql = "SELECT * FROM $this->_table WHERE id = $id";
        $result = $this->db->execute($sql);
        return $result;
    }
}