-- -- mysql -u root -p < Database/schema.sql
-- -- php -S localhost:8000 -t public

-- -- Drop the database if it exists
DROP DATABASE IF EXISTS scandiweb;

CREATE DATABASE scandiweb;
USE scandiweb;


-- Categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Products table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    id VARCHAR(255),
    name VARCHAR(255) NOT NULL,
    in_stock TINYINT(1) DEFAULT 1,
    description TEXT,
    category_id INT,
    brand VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE galleries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_url TEXT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(product_id)
        ON DELETE CASCADE
);

-- Product attributes table
CREATE TABLE attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    name VARCHAR(255),
    type VARCHAR(50),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Attribute items table
CREATE TABLE attribute_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    attribute_id INT,
    value VARCHAR(255),
    display_value VARCHAR(255),
    FOREIGN KEY (attribute_id) REFERENCES attributes(id)
);

-- Prices table
CREATE TABLE prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    amount DECIMAL(10,2),
    currency VARCHAR(10),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- Orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order items table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    selected_options JSON,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);