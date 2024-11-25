-- Creation of database
CREATE DATABASE Hotel_reservation;
USE Hotel_reservation;

--  users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(15)
);

--  rooms table
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_type VARCHAR(50) NOT NULL,
    price_per_night DECIMAL(10, 2) NOT NULL,
    availability INT DEFAULT 5 -- Allow up to 5 rooms of each type
);

--  the reservations table
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    room_id INT,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_cost DECIMAL(10, 2),
    quantity INT NOT NULL, -- Number of rooms booked
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- Insert room data with availability for up to 5 rooms per type
INSERT INTO rooms (room_type, price_per_night, availability)
VALUES 
('Single', 100.00, 5),
('Double', 150.00, 5),
('Suite', 250.00, 5);
