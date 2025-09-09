CREATE DATABASE IF NOT EXISTS php_tutor;
USE php_tutor;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'analista', 'admin') DEFAULT 'usuario',
    analista_aprobado TINYINT(1) DEFAULT 0
);

CREATE TABLE consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    consulta TEXT NOT NULL,
    respuesta TEXT NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
