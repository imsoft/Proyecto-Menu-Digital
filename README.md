# Menu App

## Iniciar proyecto

php -S localhost:8080

## Crear una base de datos

```
CREATE DATABASE IF NOT EXISTS dbaucwkxjvtpaq;
USE dbaucwkxjvtpaq;
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
    gender ENUM('male', 'female', 'other') NOT NULL,
    password VARCHAR(255) NOT NULL
);
```
