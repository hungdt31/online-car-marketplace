CREATE TABLE IF NOT EXISTS help_question (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    question TEXT NOT NULL,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'replied') DEFAULT 'pending'
); 