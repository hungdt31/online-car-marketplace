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
    public function execute($sql, $params = [], $single = false)
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params); // Truyền tham số để tránh SQL Injection
            // Nếu là truy vấn SELECT
            if (stripos(trim($sql), 'SELECT') === 0) {
                return $single ? $stmt->fetch(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
    
            // Nếu là INSERT, UPDATE, DELETE -> Trả về số dòng bị ảnh hưởng
            return $stmt->rowCount();
        } catch (PDOException $exception) {
            error_log($exception->getMessage(), 3, "error.log"); // Ghi log lỗi vào file
            $data['error'] = $exception->getMessage();
            extract($data);
            include_once _DIR_ROOT. '/public/errors/db.php';
            return false;
        }
    }    
}
