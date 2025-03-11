-- Tạo bảng users (sửa lỗi provider mặc định)
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    role ENUM('admin', 'user') DEFAULT 'user',
    provider ENUM('credential', 'google', 'facebook') DEFAULT 'credential',
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Chèn dữ liệu vào bảng users (hash password bằng bcrypt trong thực tế)
INSERT INTO users (username, firstname, lastname, password, email, role, provider) 
VALUES 
('admin', 'Anh', 'Nguyen The', MD5('admin123'), 'admin@example.com', 'admin', 'credential'),
('koikoi', 'Hung', 'Doan Tri', MD5('user123'), 'koikoidth12@gmail.com', 'user', 'credential'),
('jane_doe', 'Jane', 'Doe', MD5('user1234'), 'jane@example.com', 'user', 'credential');