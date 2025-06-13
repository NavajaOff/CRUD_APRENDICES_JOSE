CREATE DATABASE crud_aprendices;
USE crud_aprendices;

-- Tabla tipos de documento
CREATE TABLE tipos_documento (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla grupos sanguíneos
CREATE TABLE grupos_sanguineos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(5) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla sexos
CREATE TABLE sexos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(20) NOT NULL UNIQUE,
    codigo CHAR(1) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla programas de formación
CREATE TABLE programas_formacion (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla aprendices
CREATE TABLE aprendices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo_documento_id INT NOT NULL,
    numero_documento VARCHAR(20) NOT NULL UNIQUE,
    primer_nombre VARCHAR(50) NOT NULL,
    segundo_nombre VARCHAR(50),
    primer_apellido VARCHAR(50) NOT NULL,
    segundo_apellido VARCHAR(50),
    sexo_id INT NOT NULL,
    grupo_sanguineo_id INT NOT NULL,
    programa_formacion_id INT NOT NULL,
    estado ENUM('Activo', 'Inactivo') DEFAULT 'Activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_documento_id) REFERENCES tipos_documento(id),
    FOREIGN KEY (sexo_id) REFERENCES sexos(id),
    FOREIGN KEY (grupo_sanguineo_id) REFERENCES grupos_sanguineos(id),
    FOREIGN KEY (programa_formacion_id) REFERENCES programas_formacion(id)
);

-- Datos de prueba
INSERT INTO tipos_documento (nombre) VALUES 
('Cédula de Ciudadanía'),
('Tarjeta de Identidad'),
('Cédula de Extranjería'),
('Pasaporte');

INSERT INTO grupos_sanguineos (tipo) VALUES 
('O+'),
('O-'),
('A+'),
('A-'),
('B+'),
('B-'),
('AB+'),
('AB-');

INSERT INTO sexos (nombre, codigo) VALUES 
('Masculino', 'M'),
('Femenino', 'F'),
('Otro', 'O');

INSERT INTO programas_formacion (nombre) VALUES 
('Análisis y Desarrollo de Software'),
('Contabilidad y finanzas'),
('Talento Humano'),
('Manejo y aprovechamiento forestal');