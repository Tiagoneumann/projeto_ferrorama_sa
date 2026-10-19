CREATE DATABASE IF NOT EXISTS trackflow_sa;
USE trackflow_sa;

CREATE TABLE usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(100) NOT NULL CHECK (length(trim(nome_usuario)) >= 2),
    email_usuario VARCHAR(150) NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci UNIQUE,
    senha_usuario VARCHAR(255) NOT NULL,
    tipo_usuario ENUM('usuario', 'admin') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE linha (
    id_linha INT AUTO_INCREMENT PRIMARY KEY,
    nome_linha VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE trem (
    id_trem INT AUTO_INCREMENT PRIMARY KEY,
    prefixo_trem VARCHAR(100) NOT NULL,
    modelo_trem VARCHAR(100) NOT NULL,
    ano_trem INT NOT NULL CHECK(ano_trem BETWEEN 1800 AND 2100),
    status_trem ENUM('ativo', 'manutencao', 'parado') DEFAULT 'ativo' NOT NULL,
    imagem_trem VARCHAR(255) NULL;
    id_linha INT,

    FOREIGN KEY (id_linha) REFERENCES linha(id_linha) ON UPDATE CASCADE ON DELETE SET NULL
);

CREATE TABLE sensor (
    id_sensor INT AUTO_INCREMENT PRIMARY KEY,
    codigo_sensor VARCHAR(100) NOT NULL UNIQUE,
    tipo_sensor VARCHAR(100) NOT NULL,
    unidade_sensor VARCHAR(100) NOT NULL,

    id_trem INT NOT NULL,

    FOREIGN KEY (id_trem) REFERENCES trem(id_trem) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE leitura (
    id_leitura INT AUTO_INCREMENT PRIMARY KEY,
    id_sensor INT NOT NULL,
    valor_sensor REAL NOT NULL,
    registro_sensor DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_sensor) REFERENCES sensor(id_sensor) ON UPDATE CASCADE ON DELETE CASCADE
);
