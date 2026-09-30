CREATE DATABASE IF NOT EXISTS trackflow_sa;
USE trackflow_sa;

CREATE TABLE usuario (
    id_usuario BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(100) NOT NULL,
    email_usuario VARCHAR(150) NOT NULL UNIQUE,
    senha_usuario VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('usuario', 'admin') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE trem (
    id_trem BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_trem VARCHAR(100) NOT NULL,
    modelo_trem VARCHAR(100) NOT NULL,
    status_trem ENUM('ativo', 'manutencao', 'parado') NOT NULL
);

CREATE TABLE sensor (
    id_sensor BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome_sensor VARCHAR(100) NOT NULL,
    localizacao_sensor VARCHAR(100) NOT NULL,
    id_trem BIGINT NOT NULL,

    FOREIGN KEY (id_trem)
        REFERENCES trem(id_trem)
);

CREATE TABLE dados (
    id_dados BIGINT AUTO_INCREMENT PRIMARY KEY,
    velocidade_dados DECIMAL(6, 2) NOT NULL,
    temperatura_dados DECIMAL(5, 2) NOT NULL,
    leitura_data DATETIME NOT NULL,
    id_sensor BIGINT NOT NULL,

    FOREIGN KEY (id_sensor)
        REFERENCES sensor(id_sensor)
);

CREATE TABLE relatorios (
    id_relatorios BIGINT AUTO_INCREMENT PRIMARY KEY,
    titulo_relatorio VARCHAR(100) NOT NULL,
    data_inicio DATETIME NOT NULL,
    data_fim DATETIME NOT NULL,
    tipo_falha VARCHAR(100) NOT NULL,
    data_geracao DATETIME NOT NULL
);

CREATE TABLE linhas_trem (
    id_linhas_trem BIGINT AUTO_INCREMENT PRIMARY KEY,
    hora_saida DATETIME NOT NULL,
    hora_chegada DATETIME NOT NULL,
    quantidade_passageiros INT NOT NULL,
    id_trem BIGINT NOT NULL,
    id_usuario BIGINT NOT NULL,

    FOREIGN KEY (id_trem)
        REFERENCES trem(id_trem),

    FOREIGN KEY (id_usuario)
        REFERENCES usuario(id_usuario)
);