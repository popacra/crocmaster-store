-- Crear base de datos y tablas
CREATE DATABASE IF NOT EXISTS pet_store;
USE pet_store;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255) NOT NULL,
    categoria ENUM('comedero', 'alimento') NOT NULL,
    stock INT DEFAULT 0,
    activo BOOLEAN DEFAULT TRUE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar productos de ejemplo
INSERT INTO productos (nombre, descripcion, precio, imagen, categoria, stock) VALUES
('Comedero Automático Premium', 'Comedero automático con programación de horarios, capacidad para 2kg de alimento, ideal para perros medianos y grandes.', 89.99, 'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?w=400&h=300&fit=crop', 'comedero', 15),
('Comedero Automático Básico', 'Comedero automático simple con temporizador, perfecto para perros pequeños, capacidad 1kg.', 45.99, 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=400&h=300&fit=crop', 'comedero', 25),
('Comedero Inteligente WiFi', 'Comedero con conectividad WiFi, control desde app móvil, cámara integrada y dispensador automático.', 149.99, 'https://images.unsplash.com/photo-1548199973-03cce0bbc87b?w=400&h=300&fit=crop', 'comedero', 8),
('Alimento Premium Adulto', 'Alimento balanceado premium para perros adultos, 15kg, con proteínas de alta calidad.', 32.99, 'https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=400&h=300&fit=crop', 'alimento', 50),
('Alimento Cachorro', 'Alimento especial para cachorros de 2-12 meses, 10kg, rico en DHA y calcio.', 28.99, 'https://images.unsplash.com/photo-1605568427561-40dd23c2acea?w=400&h=300&fit=crop', 'alimento', 35),
('Alimento Senior', 'Alimento formulado para perros mayores de 7 años, 12kg, fácil digestión.', 35.99, 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=400&h=300&fit=crop', 'alimento', 20);
