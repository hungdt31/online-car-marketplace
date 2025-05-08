<?php

class BranchModel extends Model {
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->_table = 'branches';
    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->_table}";
        $stmt = $this->db->execute($sql);
        return $stmt['data'];
    }
    public function createOne($data)
    {
        $sql = "INSERT INTO {$this->_table} (name, address, phone, email) VALUES (:name, :address, :phone, :email)";
        $result = $this->db->execute($sql, [
            ':name' => $data['name'],
            ':address' => $data['address'],
            ':phone' => $data['phone'],
            ':email' => $data['email']
        ]);
        return $result['success'];
    }
    public function findOne($id)
    {
        $sql = "SELECT * FROM {$this->_table} WHERE id = :id";
        $stmt = $this->db->execute($sql, [':id' => $id], true);
        return $stmt['data'];
    }
    public function updateOne($id, $data)
    {
        $sql = "UPDATE {$this->_table} SET name = :name, address = :address, phone = :phone, email = :email WHERE id = :id";
        $result = $this->db->execute($sql, [
            ':name' => $data['name'],
            ':address' => $data['address'],
            ':phone' => $data['phone'],
            ':email' => $data['email'],
            ':id' => $id
        ]);
        return $result['success'];
    }
    public function deleteOne($id)
    {
        $sql = "DELETE FROM {$this->_table} WHERE id = :id";
        $result = $this->db->execute($sql, [':id' => $id]);
        return $result['success'];
    }
}