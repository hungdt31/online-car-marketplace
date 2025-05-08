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
}