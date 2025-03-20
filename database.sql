-- Create database
CREATE DATABASE IF NOT EXISTS laceshop;
USE laceshop;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('customer', 'editor', 'admin') NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT NOT NULL,
    gender ENUM('male', 'female', 'unisex') NOT NULL,
    image_path VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Insert sample data
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', '$2y$10$GtOtpMeVX7mCVz6t.CSqS.ub.r5xLiLiXvBCXqOCY2tNrVxO4VyDe', 'admin'), -- password: admin123
('user', 'user@example.com', '$2y$10$GtOtpMeVX7mCVz6t.CSqS.ub.r5xLiLiXvBCXqOCY2tNrVxO4VyDe', 'customer'); -- password: admin123

INSERT INTO categories (name, slug) VALUES
('Běžecké boty', 'bezecke-boty'),
('Tenisky', 'tenisky'),
('Sandály', 'sandaly');

INSERT INTO products (name, description, price, category_id, gender, image_path) VALUES
('Nike Air Zoom', 'Pohodlné běžecké boty Nike Air Zoom', 2499.00, 1, 'male', 'img/products/nike-air-zoom.jpg'),
('Adidas Ultraboost', 'Běžecké boty Adidas Ultraboost', 3299.00, 1, 'female', 'img/products/adidas-ultraboost.jpg'),
('Converse Chuck Taylor', 'Klasické tenisky Converse Chuck Taylor', 1599.00, 2, 'unisex', 'img/products/converse-chuck-taylor.jpg');
