<?php
class Model {
    public $db;
    protected $_table;
    public function __construct() {
        $this->db = Database::getInstance();
    }
}