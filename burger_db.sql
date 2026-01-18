-- =========================================
-- DATABASE
-- =========================================
CREATE DATABASE IF NOT EXISTS burger_apps;
USE burger_apps;

-- =========================================
-- USERS
-- =========================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================================
-- MENU (DAFTAR BURGER)
-- =========================================
CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================================
-- ORDERS (HEADER TRANSAKSI)
-- =========================================
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    delivery_address TEXT NOT NULL,
    notes TEXT,
    total_price DECIMAL(10,2) NOT NULL,
    status ENUM('pending','confirmed','preparing','delivered','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- =========================================
-- ORDER ITEMS (DETAIL PESANAN)
-- =========================================
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menu(id)
);

-- =========================================
-- ORDER TRACKING (HISTORI STATUS)
-- =========================================
CREATE TABLE order_tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    status ENUM('pending','confirmed','preparing','delivered','cancelled') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

INSERT INTO users (name, email, password, phone, address, role) VALUES
('Admin Burger', 'admin@burgerapp.com', 'admin123', '0811111111', 'Head Office', 'admin'),
('Andi Saputra', 'andi@gmail.com', 'password123', '0822222222', 'Jl. Merdeka No.10', 'user'),
('Budi Santoso', 'budi@gmail.com', 'password123', '0833333333', 'Jl. Sudirman No.20', 'user');

INSERT INTO menu (name, description, price, image_url) VALUES
('Classic Beef Burger', 'Burger sapi klasik dengan keju dan saus spesial', 35000, 'https://img.burgerapp.com/classic.jpg'),
('Cheese Burger', 'Burger sapi dengan double keju', 40000, 'https://img.burgerapp.com/cheese.jpg'),
('Chicken Burger', 'Burger ayam crispy dengan mayo', 30000, 'https://img.burgerapp.com/chicken.jpg'),
('BBQ Beef Burger', 'Burger sapi saus BBQ', 45000, 'https://img.burgerapp.com/bbq.jpg');

INSERT INTO orders (user_id, delivery_address, notes, total_price, status) VALUES
(2, 'Jl. Merdeka No.10', 'Tanpa bawang', 75000, 'confirmed'),
(3, 'Jl. Sudirman No.20', 'Extra saus', 70000, 'preparing');

INSERT INTO order_items (order_id, menu_id, quantity, price) VALUES
-- Order #1 (Andi)
(1, 1, 1, 35000),
(1, 2, 1, 40000),

-- Order #2 (Budi)
(2, 3, 2, 30000),
(2, 1, 1, 35000);

INSERT INTO order_tracking (order_id, status) VALUES
(1, 'pending'),
(1, 'confirmed'),

(2, 'pending'),
(2, 'confirmed'),
(2, 'preparing');
