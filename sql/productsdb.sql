CREATE DATABASE productsdb;
USE productsdb;

CREATE TABLE USERS (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    user_pwd VARCHAR(200) NOT NULL,
    user_name VARCHAR(50) NOT NULL
);

CREATE TABLE PRODUCTS (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(50) NOT NULL,
    product_description VARCHAR(100),
    product_price FLOAT,
    product_image VARCHAR(255)
);