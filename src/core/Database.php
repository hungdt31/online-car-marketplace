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
            $data['message'] = "Can\'t connect to Database: ". $exception->getMessage();
            $data['type'] = 'error';
            extract($data);
            include_once _DIR_ROOT. '/public/errors/index.php';
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
            $response = [
                'success' => true,
                'message' => 'Execute successfully!'
            ];
            if ($single) {
                $response['data'] = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $response['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            // if (stripos(trim($sql), 'SELECT') === 0) {
            // } else {
                // Nếu là INSERT, UPDATE, DELETE -> Trả về số dòng bị ảnh hưởng
            $response['rowCount'] = $stmt->rowCount();
            $response['lastInsertId'] = $this->conn->lastInsertId();
            // }

            return $response; 
        } catch (PDOException $exception) {
            // Tạo nội dung log chi tiết
            $errorLog = sprintf(
                "[%s] SQL Error\n" .
                "SQL Query: %s\n" .
                "Parameters: %s\n" .
                "Error Code: %s\n" .
                "Error Message: %s\n" .
                "Stack Trace:\n%s\n" .
                "----------------------------------------\n",
                date('Y-m-d H:i:s'),
                $sql,
                json_encode($params, JSON_PRETTY_PRINT),
                $exception->getCode(),
                $exception->getMessage(),
                $exception->getTraceAsString()
            );
            // Tạo thư mục logs nếu chưa tồn tại
            $logDir = _DIR_ROOT . '/logs';
            if (!file_exists($logDir)) {
                mkdir($logDir, 0777, true);
            }

            // Ghi log vào file theo ngày
            $logFile = $logDir . '/sql_errors_' . date('Y-m-d') . '.log';
            error_log($errorLog, 3, $logFile);
            return [
                'message' => $exception->getMessage(),
                'success' => false,
                'errorCode' => $exception->getCode()
            ];
        }
    }    
}
