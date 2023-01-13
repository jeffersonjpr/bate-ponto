CREATE DATABASE bate_ponto;

CREATE USER 'bate_user'@'localhost' identified by 'bate_pass';
GRANT ALL on bate_ponto to 'bate_user'@'localhost';

USE bate_ponto;

CREATE TABLE funcionario (
    id int NOT NULL AUTO_INCREMENT,
    nome varchar(255) NOT NULL,
    registro int NOT NULL UNIQUE,
    PRIMARY KEY (id)
);

CREATE TABLE ponto (
    id int NOT NULL AUTO_INCREMENT,
    id_funcionario int NOT NULL,
    data_ponto datetime NOT NULL,
    tipo enum('entrada', 'saida', 'pausa', 'retorno') NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_funcionario) REFERENCES funcionario (id)
);

CREATE TABLE admin(
    id int NOT NULL AUTO_INCREMENT,
    usuario varchar(255) NOT NULL,
    senha varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO funcionario (nome, registro) VALUES ('Fulano', 1000);
INSERT INTO funcionario (nome, registro) VALUES ('Ciclano', 1001);
INSERT INTO funcionario (nome, registro) VALUES ('Beltrano', 1002);
