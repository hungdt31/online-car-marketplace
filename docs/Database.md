# Kết nối Database với PHP

## 1. PDO

PHP Data Objects extension là một Database Abstraction Layer phục vụ như một interface phía máy chủ để tương tác với MySQL databases.

### 1.1. Database Abstraction Layer

- Lớp trừu tượng hóa cơ sở dữ liệu là lớp trung gian nằm giữa mã PHP và cơ sở dữ liệu, đảm bảo rằng mã PHP của bạn không phụ thuộc vào đặc điểm cụ thể của hệ thống cơ sở dữ liệu (như MySQL, PostgreSQL, SQLite, v.v.).
- Điều này cho phép bạn chuyển từ hệ thống cơ sở dữ liệu này sang hệ thống cơ sở dữ liệu khác (ví dụ: từ MySQL sang PostgreSQL) mà không cần thay đổi nhiều hoặc bất kỳ mã PHP nào của bạn.

### 1.2. Cách sử dụng

```php
$stmt = $conn->query($sql);
// lấy tất cả records từ câu lệnh truy vấn
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
// lấy dần dần thì dùng:
if ($stmt->rowCount() > 0) {
  // Duyệt qua từng bản ghi và in ra
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo '<pre>'.print_r($row).'</pre>';
  }
}
```

## Tài liệu tham khảo

[https://www.cloudways.com/blog/connect-mysql-with-php/](https://www.cloudways.com/blog/connect-mysql-with-php/)
