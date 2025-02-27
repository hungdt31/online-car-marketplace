<?php
class ProductModel {
    protected $_data = [];
    public function __construct() {
        $this->_data = [
            'Product 1',
            'Product 2',
            'Product 3',
        ];
    }
    public function getList() {
        return $this->_data;
    }
    public function getDetail($id) {
        if (!isset($this->_data[$id])) return 'Product not found';
        return $this->_data[$id];
    }
}
