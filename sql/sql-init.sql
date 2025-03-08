-- create new table
CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(100) UNIQUE,
    role ENUM('admin', 'user') DEFAULT 'user',
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- insert records into table
INSERT INTO users (username, firstname, lastname, password, email, role) 
VALUES 
('admin', 'Anh', 'Nguyen The', 'admin123', 'admin@example.com', 'admin'),
('koikoi', 'Hung', 'Doan Tri', 'user123', 'koikoidth12@gmail.com', 'user'),
('jane_doe', 'Jane', 'Doe', 'user1234', 'jane@example.com', 'user');