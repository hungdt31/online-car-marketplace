<?php
class Database
{
    // Hold the class instance.
    private static $instance = null;
    private $conn = null;
    // The constructor is private
    // to prevent initiation with outer code.
    private function __construct()
    {
        // The expensive process (e.g.,db connection) goes here.
        $db_config = self::getConfig();
        try {
            // Cấu hình dsn
            $dsn = 'mysql:dbname=' . $db_config['db'] . ';host=' . $db_config['host'];

            // Cấu hình $options
            // - Cấu hình utf8
            // - Cấu hình ngoại lệ khi truy vấn bị lỗi
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            // Câu lệnh kết nối
            $pass = $db_config['pass'] ?? ''; // Dùng toán tử null coalescing để tránh lỗi
            $this->conn = new PDO($dsn, $db_config['user'], $pass, $options);
            // $this->conn = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['db']);
        } catch (Exception $exception) {
            $data['message'] = "Can\'t connect to Database: " . $exception->getMessage();
            $data['type'] = 'error';
            extract($data);
            include_once _DIR_ROOT . '/public/errors/index.php';
        }
    }

    // The object is created from within the class itself
    // only if the class has no instance.
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }
    public static function getConfig()
    {
        global $config;
        $db_config = array_filter($config['database']);
        return $db_config;
    }
    public function execute($sql, $params = [], $fetchRow = false)
    {
        try {
            $stmt = $this->conn->prepare($sql);

            // Handle both named and positional parameters
            if (!empty($params)) {
                foreach ($params as $key => $value) {
                    // If key is numeric, use positional parameter binding
                    if (is_int($key)) {
                        $stmt->bindValue($key + 1, $value, $this->getPDOType($value));
                    }
                    // Otherwise use named parameter binding
                    else {
                        $stmt->bindValue($key, $value, $this->getPDOType($value));
                    }
                }
            }

            $stmt->execute();

            if ($stmt->columnCount() > 0) {
                $data = $fetchRow ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
                return [
                    'data' => $data,
                    'success' => true
                ];
            }

            return [
                'success' => true
            ];

        } catch (Exception $exception) {
            return [
                'message' => $exception->getMessage(),
                'success' => false,
                'errorCode' => $exception->getCode()
            ];
        }
    }

    private function getPDOType($value)
    {
        switch (true) {
            case is_int($value):
                return PDO::PARAM_INT;
            case is_bool($value):
                return PDO::PARAM_BOOL;
            case is_null($value):
                return PDO::PARAM_NULL;
            default:
                return PDO::PARAM_STR;
        }
    }
}