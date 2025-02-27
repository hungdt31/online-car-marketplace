CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    fuel_type ENUM('Petrol', 'Diesel', 'Electric', 'Hybrid') NOT NULL,
    mileage VARCHAR(50),
    drive_type ENUM('Self', 'Automatic', 'Manual') NOT NULL,
    service_duration VARCHAR(50),
    body_weight VARCHAR(50),
    price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- insert records into table
INSERT INTO cars (name, location, fuel_type, mileage, drive_type, service_duration, body_weight, price)
VALUES
('Toyota Camry', 'USA', 'Petrol', '90km - 100km', 'Automatic', '5 years', '1500 kg', 2500),
('Honda Accord', 'Japan', 'Electric', '80km - 90km', 'Self', '1 year', '1400 kg', 2000),
('Hyundai Sonata', 'Korea', 'Petrol', '85km - 95km', 'Automatic', '1 year', '1450 kg', 2200),
('Ford Fusion', 'USA', 'Hybrid', '95km - 105km', 'Manual', '3 years', '1550 kg', 2300);