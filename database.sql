CREATE DATABASE IF NOT EXISTS dove_bakes_db;
USE dove_bakes_db;

CREATE TABLE IF NOT EXISTS cakes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    availability BOOLEAN DEFAULT 1
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    cake_id INT,
    quantity INT,
    price DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (cake_id) REFERENCES cakes(id) ON DELETE SET NULL
);

-- Insert default admin: username 'admin', password 'admin123'
INSERT INTO admins (username, password_hash) VALUES ('admin', '$2y$10$e.wXyI5xWwR5D/8o6b4/f.oO.M3mQ.HhR0/r7T8hPjE.fO/m3v6H6');

-- Insert initial products
INSERT INTO cakes (name, description, price, image, availability) VALUES 
('Chocolate Fudge Cake', 'Rich layers of dark chocolate cake covered in smooth fudge frosting.', 2900.00, 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=600&q=80', 1),
('Vanilla Dream Cake', 'Light and fluffy vanilla sponge with Madagascar vanilla bean buttercream.', 2600.00, 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?auto=format&fit=crop&w=600&q=80', 1),
('Red Velvet Delight', 'Classic moist red velvet with signature tangy cream cheese frosting.', 3100.00, 'https://images.unsplash.com/photo-1616541823729-00fe0aacd32c?auto=format&fit=crop&w=600&q=80', 1);
