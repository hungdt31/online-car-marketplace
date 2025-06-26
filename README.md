# Carvan - Hệ thống thuê xe

## Giới thiệu

Đây là hệ thống quản lý thuê xe trực tuyến được phát triển như bài tập lớn môn Lập trình web HK242. Dự án được xây dựng dựa trên kiến trúc MVC (Model-View-Controller) sử dụng PHP thuần và Docker.

## Giới thiệu mô hình MVC

| Name          | Model-View-Controller                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
|---------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Description   | Tách riêng phần thể hiện (presentation) và tương tác (interaction) khỏi hệ thống dữ liệu. Hệ thống được chia thành ba thành phần logic tương tác lẫn nhau.<br/> <ul> <li> Model component: quản lý dữ liệu hệ thống và các thao tác liên quan trên tập dữ liệu đặc thù. </li> <li>View component: định nghĩa và quản lý cách dữ liệu được trình bày phía người dùng. </li> <li>Controller component: quản lý tương tác người dùng (key presses, mouse clicks, etc.) và chuyển các tương tác đó đến View và Model.</li> </ul> |
| Organization  | ![mvc](docs/img/img.png)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| When used     | Được sử dụng khi có nhiều cách để xem và tương tác với dữ liệu. Khuyến khích khi các yêu cầu sắp tới về tương tác và thể hiện của dữ liệu không rõ ràng.                                                                                                                                                                                                                                                                                                                                                                 |
| Advantages    | Cho phép dữ liệu thay đổi độc lập với cách thể hiện (presentation) và ngược lại cũng đúng. Hỗ trợ trình bày cùng một dữ liệu theo nhiều cách khác nhau, với những thay đổi được thực hiện trong một thể hiện được hiển thị trong tất cả chúng.                                                                                                                                                                                                                                                                           |
| Disadvantages | Có thể dẫn đến việc phải viết thêm mã và tăng độ phức tạp của mã khi mô hình dữ liệu và các tương tác còn đơn giản.

## Cấu trúc dự án

Dự án được tổ chức theo cấu trúc sau:

```
src/
├── app/                   # Mã nguồn chính của ứng dụng
│   ├── App.php            # Class khởi động ứng dụng
│   ├── controllers/       # Controllers xử lý logic
│   ├── models/            # Models xử lý dữ liệu
│   └── views/             # Views hiển thị giao diện
├── assets/                # Tài nguyên tĩnh (CSS, JS, images)
├── bootstrap.php          # File khởi tạo môi trường
├── configs/               # Cấu hình ứng dụng
├── core/                  # Các lớp cốt lõi của framework
├── index.php              # Entry point
├── libs/                  # Các thư viện bổ sung
└── sessions/              # Xử lý phiên làm việc
```

## Tính năng chính

- **Xác thực người dùng**: Đăng nhập, đăng ký, quên mật khẩu
- **Đăng nhập OAuth**: Tích hợp đăng nhập qua Google, Facebook, GitHub
- **Quản lý xe**: Thêm, sửa, xóa thông tin xe
- **Quản lý lịch hẹn**: Đặt lịch thuê xe, quản lý lịch hẹn
- **Quản lý danh mục**: Phân loại xe theo danh mục
- **Blog**: Quản lý bài viết và bình luận
- **Quản lý chi nhánh**: Thông tin các chi nhánh của hệ thống
- **Quản lý người dùng**: Phân quyền admin và user thông thường
- **FAQ & Hỗ trợ**: Câu hỏi thường gặp và hệ thống hỗ trợ

## Cài đặt và sử dụng

### Yêu cầu hệ thống

- Docker và Docker Compose
- Composer (PHP package manager)

### Cài đặt

1. Clone dự án về máy:
   ```
   git clone <repository-url>
   cd docker-php-sample
   ```

2. Tạo file cấu hình:
   ```
   cp default.env.example default.env
   ```

3. Tạo thư mục `db/password.txt` để lưu mật khẩu của database.

4. Cài đặt các package cần thiết:
   ```
   composer install
   ```

5. Khởi động dự án với Docker:
   ```
   docker compose up -d
   ```

6. Theo dõi các thay đổi file trong quá trình phát triển:
   ```
   docker compose watch
   ```

7. Dừng và loại bỏ các container:
   ```
   docker compose down
   ```

### Truy cập ứng dụng

- Ứng dụng web: http://localhost:9000
- phpMyAdmin: http://localhost:8080

## Cơ sở dữ liệu

- Database backup: liên hệ qua email [koikoidth12@gmail.com](koikoidth12@gmail.com)
- MySQL: đăng nhập phpadmin với tài khoản username `example` và password (lấy từ folder db)
- Tài khoản mẫu để đăng nhập theo phương thức credential:
    - Admin: charlie@example.com (admin123)
    - User: 
        - bob@example.com (user123$D)
        - koikoidth12@gmail.com (abc123$D)

## Các công nghệ sử dụng

- **Backend**: PHP 8.2
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap
- **Database**: MariaDB
- **Containerization**: Docker
- **Authentication**: JWT, OAuth (Google, Facebook, GitHub)
- **Khác**: AWS S3 (lưu trữ file)

## Tài liệu tham khảo

- A simple PHP web application example for [Docker's PHP Language Guide](https://docs.docker.com/language/php/).
- [https://topdev.vn/blog/mo-hinh-mvc-trong-php/](https://topdev.vn/blog/mo-hinh-mvc-trong-php/)
- Playlist tham khảo: [Hoàng An Unicode](https://www.youtube.com/watch?v=5lyugYFJXzk&list=PL8y3hWbcppt0nl_IU1-PbRxKm69dn_Nix)
