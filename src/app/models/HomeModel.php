<?php
/*
 * inheritance from class model
 */
class HomeModel extends Model {
    protected $_data = [
        'Item 1',
        'Item 2',
        'Item 3',
    ];
    public function __construct()
    {
        parent::__construct();
        $this->_table = 'users';
    }
    public function getList() {
        $sql = "SELECT * FROM $this->_table";
        $result = $this->db->execute($sql);
        return $result;
    }
    public function getDetail($id) {
        // check ID valid
        if (isset($this->_data[$id])) {
            return $this->_data[$id];
        }
        // handle if invalid
        return "Invalid ID";
    }
}