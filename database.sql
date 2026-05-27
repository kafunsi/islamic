-- Create database
CREATE DATABASE IF NOT EXISTS islamic_sms;
USE islamic_sms;

-- Members table
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    city VARCHAR(50),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_phone (phone),
    INDEX idx_status (status)
);

-- Groups table
CREATE TABLE IF NOT EXISTS groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

-- Member-Group relationship
CREATE TABLE IF NOT EXISTS member_groups (
    member_id INT,
    group_id INT,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE,
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    PRIMARY KEY (member_id, group_id)
);

-- Announcements table with index for auto-delete
CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('msiba', 'harusi') NOT NULL,
    title VARCHAR(200),
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_created_at (created_at)
);

-- SMS History with indexes
CREATE TABLE IF NOT EXISTS sms_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    phone VARCHAR(20) NOT NULL,
    name VARCHAR(100),
    message TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    request_id VARCHAR(100) DEFAULT NULL,
    delivery_status VARCHAR(50) DEFAULT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_request_id (request_id),
    INDEX idx_status (status),
    INDEX idx_delivery_status (delivery_status),
    INDEX idx_sent_at (sent_at)
);

-- Insert sample data
INSERT INTO groups (name) VALUES 
('Jumuiya Yote'), 
('Wanawake'), 
('Wanaume'), 
('Vijana');

INSERT INTO members (name, phone, city) VALUES
('Ahmed Hassan', '0712837307', 'KIBAONI'),
('Fatima Said', '0712837307', 'CHAKULU'),
('Mohamed Juma', '0712837307', 'UVINZA');