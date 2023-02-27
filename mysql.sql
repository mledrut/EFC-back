CREATE DATABASE literie3000;

USE literie3000;

CREATE TABLE lits (
    id TINYINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prix DECIMAL(6,2) NOT NULL,
    promo DECIMAL(6,2),
    image VARCHAR(200)
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

INSERT INTO lits (nom, prix, promo, image)
VALUES
('Matelas Transition', 759.00, 529.00, "transition.jpeg"),
('Matelas Stan', 809.00, 709.00, "stan.jpeg"),
('Matelas Teamasse', 759.00, 529.00, 'teamasse.jpeg'),
('Matelas Coup de boule', 1019.00, 509.00, 'boule.jpeg');

INSERT INTO lits_marques (lit_id, marque_id)
VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 1);

INSERT INTO lits_tailles (lit_id, taille_id)
VALUES
(1, 1),
(2, 1),
(3, 2),
(4, 3);

