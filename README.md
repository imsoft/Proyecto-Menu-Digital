# Menu App

## Iniciar proyecto

php -S localhost:8080

## Crear una base de datos

```
CREATE DATABASE IF NOT EXISTS dbaucwkxjvtpaq;
USE dbaucwkxjvtpaq;
```

## Crear tabla de usuarios

```
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    birthdate DATE NOT NULL,
    gender ENUM('masculino', 'femenino', 'otro') NOT NULL,
    password VARCHAR(255) NOT NULL,
    userType ENUM('cliente', 'empleado', 'negocio') NOT NULL
);
```

## Crear tabla de clientes

```
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    birthdate DATE NOT NULL,
    gender ENUM('masculino', 'femenino', 'otro') NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

## Crear tabla de empleados

```
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL,
    lastName VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    birthdate DATE NOT NULL,
    gender ENUM('masculino', 'femenino', 'otro') NOT NULL,
    password VARCHAR(255) NOT NULL
);
```

## Crear tabla de Menú

```
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_image VARCHAR(255) NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category_name ENUM('comida', 'bebida', 'extras') NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);
```

## Crear tabla de Sucursales

```
CREATE TABLE branches (
    id INT AUTO_INCREMENT PRIMARY KEY,
    branch_name VARCHAR(255) NOT NULL,
    branch_manager VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    postal_code CHAR(5) NOT NULL,
    cellphone CHAR(10) NOT NULL,
    website VARCHAR(255)
);
```

## Crear tabla de Datos fiscales

```
CREATE TABLE tax_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(100) NOT NULL,
    lastName VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    rfc CHAR(13) NOT NULL,
    socialName VARCHAR(255) NOT NULL,
    tradeName VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    curp CHAR(18) NOT NULL
);
```

## Crear tabla Cart

```
CREATE TABLE IF NOT EXISTS carts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);
```

## Crear tabla Cart Items

```
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES carts(id),
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id)
);
```

## Crear tabla de ordenes

```
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    state ENUM('waiting', 'in_preparation', 'ready') NOT NULL DEFAULT 'waiting',
    FOREIGN KEY (cart_id) REFERENCES carts(id)
);
```
