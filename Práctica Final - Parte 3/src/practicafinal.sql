/* PRÁCTICA 5 - BASES DE DATOS */
CREATE DATABASE samsung_developer COLLATE 'utf8mb4_general_ci';

USE samsung_developer;

CREATE TABLE alta_usuarios ( 
    id INTEGER AUTO_INCREMENT PRIMARY KEY, 
    nombre VARCHAR(100) NOT NULL, 
    primerApellido VARCHAR(100) NOT NULL, 
    segundoApellido VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL, 
    email VARCHAR(255) UNIQUE NOT NULL, 
    password VARCHAR(8) NOT NULL CHECK (LENGTH('password') BETWEEN 4 AND 8) 
);

INSERT INTO alta_usuarios ("nombre", "primerApellido", "segundoApellido", "username", "email", "password") 
    VALUES ("P1", "A1P1", "A2P1", "Persona1", "persona1@prueba.com", "12345678");
INSERT INTO alta_usuarios ("nombre", "primerApellido", "segundoApellido", "username", "email", "password") 
    VALUES ("P2", "A1P2", "A2P2", "Persona2", "persona2@prueba.com", "12345678");
INSERT INTO alta_usuarios ("nombre", "primerApellido", "segundoApellido", "username", "email", "password") 
    VALUES ("P3", "A1P3", "A2P3", "Persona3", "persona3@prueba.com", "12345678");
INSERT INTO alta_usuarios ("nombre", "primerApellido", "segundoApellido", "username", "email", "password") 
    VALUES ("P4", "A1P4", "A2P4", "Persona4", "persona4@prueba.com", "12345678");