-- CREATE USER 'bate_user'@'localhost' identified by 'bate_pass';
-- GRANT ALL on bate_ponto to 'bate_user'@'localhost';

DROP DATABASE IF EXISTS bate_ponto;
CREATE DATABASE bate_ponto;

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

INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-01 08:00:00', 'entrada');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-01 12:00:00', 'pausa');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-01 13:00:00', 'retorno');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-01 18:00:00', 'saida');


INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (2, '2023-01-01 08:01:00', 'entrada');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (2, '2023-01-01 12:01:00', 'pausa');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (2, '2023-01-01 13:00:00', 'retorno');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (2, '2023-01-01 18:00:00', 'saida');

INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-02 08:02:00', 'entrada');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-02 12:02:00', 'pausa');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-02 13:00:00', 'retorno');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-02 18:00:00', 'saida');

INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-03 08:03:00', 'entrada');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-03 12:03:00', 'pausa');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-03 13:00:00', 'retorno');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-01-03 18:00:00', 'saida');

INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-02-04 08:00:00', 'entrada');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-02-04 17:00:00', 'saida');


INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-02-05 07:00:00', 'entrada');
INSERT INTO ponto(id_funcionario, data_ponto, tipo) VALUES (1, '2023-02-05 17:30:00', 'saida');

-- SELEÇÃO DE DIAS TRABALHADOS
CREATE VIEW dias_trabalhados AS
SELECT
    f.nome,
    f.registro,
    DATE(p.data_ponto) as data,
    MIN(CASE WHEN p.tipo = 'entrada' THEN p.data_ponto END) as entrada,
    MAX(CASE WHEN p.tipo = 'saida' THEN p.data_ponto END) as saida,
    MIN(CASE WHEN p.tipo = 'pausa' THEN p.data_ponto END) as pausa,
    MAX(CASE WHEN p.tipo = 'retorno' THEN p.data_ponto END) as retorno
FROM
    ponto p
    INNER JOIN funcionario f ON f.id = p.id_funcionario
WHERE
    f.id = p.id_funcionario
GROUP BY f.nome,f.registro, DATE(p.data_ponto);

-- SELEÇÃO DE DIAS TRABALHADOS COM HORAS BRUTAS E PAUSAS
CREATE VIEW dias_trabalhados_horas_brutas AS
SELECT
    nome,
    registro,
    data,
    timediff(saida, entrada) as horas_brutas,
    timediff(retorno, pausa) as horas_pausa
FROM dias_trabalhados;

-- SELEÇÃO DE DIAS TRABALHADOS COM HORAS LIQUIDAS
CREATE VIEW dias_trabalhados_horas_liquidas AS
SELECT 
  nome,
  registro,
  data, 
  timediff(horas_brutas, IFNULL(horas_pausa, 0)) as horas_liquidas 
FROM dias_trabalhados_horas_brutas
ORDER BY data;

