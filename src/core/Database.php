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
            error_log($exception->getMessage(), 3, "error.log"); // Ghi log lỗi vào file
            echo "Không thể kết nối cơ sở dữ liệu, vui lòng thử lại sau";
            print_r($exception->getMessage());
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
    public function execute($sql)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $exception) {
            error_log($exception->getMessage(), 3, "error.log"); // Ghi log lỗi vào file
            include_once 'app/errors/disconnect_db.php';
            return false;
        }
    }
}
