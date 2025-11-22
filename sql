CREATE DATABASE streamhub;
USE streamhub;

CREATE TABLE Plano (
    id_plano INT AUTO_INCREMENT PRIMARY KEY,
    nome_plano VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    limite_telas INT NOT NULL,
    qualidade_video ENUM('SD','HD','FULLHD','4K') NOT NULL
);

CREATE TABLE Usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL,
    id_plano INT,
    data_assinatura DATE,
    ativo TINYINT(1) DEFAULT 1,

    FOREIGN KEY (id_plano) REFERENCES Plano(id_plano)
);


CREATE TABLE Conteudo (
    id_conteudo INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    categoria VARCHAR(50),
    tipo ENUM('filme','serie') NOT NULL,
    classificacao_indicativa INT NOT NULL,
    duracao INT NULL, -- apenas para filmes
    ano_lancamento INT,
    capa_url VARCHAR(255)
);

CREATE TABLE Episodio (
    id_episodio INT AUTO_INCREMENT PRIMARY KEY,
    id_conteudo INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    numero_temporada INT NOT NULL,
    numero_episodio INT NOT NULL,
    duracao INT NOT NULL,
    video_url VARCHAR(255) NOT NULL,

    FOREIGN KEY (id_conteudo) REFERENCES Conteudo(id_conteudo)
);

ALTER TABLE Episodio 
ADD UNIQUE (id_conteudo, numero_temporada, numero_episodio);

CREATE TABLE Historico (
    id_historico INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_conteudo INT NOT NULL,
    id_episodio INT NULL,
    data_visualizacao DATETIME NOT NULL,
    progresso INT CHECK(progresso >= 0 AND progresso <= 100),

    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_conteudo) REFERENCES Conteudo(id_conteudo),
    FOREIGN KEY (id_episodio) REFERENCES Episodio(id_episodio)
);
