CREATE DATABASE literie3000;

USE literie3000;

CREATE TABLE lits (
    id TINYINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prix DECIMAL(4,2) NOT NULL,
    promo DECIMAL(4,2)
);

CREATE TABLE marques (
    id TINYINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(30) NOT NULL
);

CREATE TABLE lits_marques (
    lit_id TINYINT,
    marque_id TINYINT,
    PRIMARY KEY (lit_id, marque_id),
    FOREIGN KEY (lit_id) REFERENCES lits(id),
    FOREIGN KEY (marque_id) REFERENCES marques(id)
);

CREATE TABLE tailles (
    id TINYINT PRIMARY KEY AUTO_INCREMENT,
    valeur VARCHAR(30) NOT NULL
);

CREATE TABLE lits_tailles (
    lit_id TINYINT,
    taille_id TINYINT,
    PRIMARY KEY (lit_id, taille_id),
    FOREIGN KEY (lit_id) REFERENCES lits(id),
    FOREIGN KEY (taille_id) REFERENCES tailles(id)
);

INSERT INTO marques (nom)
VALUES 
('Epeda'),
('Dreamway'),
('Bultex'),
('Dorsoline'),
('MemoryLine');

INSERT INTO tailles (valeur)
VALUES 
('90x190'),
('140x190'),
('160x200'),
('180x200'),
('200x200');

