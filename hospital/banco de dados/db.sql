-- senha
INSERT INTO usuarios_admin (login, senha) VALUES ('admin', 'admin');


ALTER SEQUENCE avaliacoes_id_avaliacao_seq RESTART WITH 1;
ALTER SEQUENCE setores_id_setor_seq RESTART WITH 1;
ALTER SEQUENCE perguntas_id_pergunta_seq RESTART WITH 1;
ALTER SEQUENCE dispositivos_id_dispositivo_seq RESTART WITH 1;



-- Tabela para setores
CREATE TABLE setores (
    id_setor SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    status VARCHAR(10) CHECK (status IN ('ativo', 'inativo')) DEFAULT 'ativo'
);

-- Tabela para dispositivos
CREATE TABLE dispositivos (
    id_dispositivo SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    status VARCHAR(10) CHECK (status IN ('ativo', 'inativo')),
    id_setor INT REFERENCES setores(id_setor)
);

-- Tabela para perguntas
CREATE TABLE perguntas (
    id_pergunta SERIAL PRIMARY KEY,
    texto TEXT NOT NULL,
    status VARCHAR(10) CHECK (status IN ('ativa', 'inativa')),
    id_dispositivo INT REFERENCES dispositivos(id_dispositivo)
);

-- Tabela para avaliações
CREATE TABLE avaliacoes (
    id_avaliacao SERIAL PRIMARY KEY,
    id_setor INT REFERENCES setores(id_setor),
    id_pergunta INT REFERENCES perguntas(id_pergunta),
    id_dispositivo INT REFERENCES dispositivos(id_dispositivo),
    resposta INT CHECK (resposta BETWEEN 0 AND 10) NOT NULL,
    feedback_textual TEXT,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- Tabela para usuários administrativos
CREATE TABLE usuarios_admin (
    id_usuario SERIAL PRIMARY KEY,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL -- Lembre-se de usar hash para senhas!
);


-- Adicionando a coluna status na tabela setores
ALTER TABLE setores
ADD COLUMN status VARCHAR(10) CHECK (status IN ('ativo', 'inativo')) DEFAULT 'ativo';

ALTER TABLE dispositivos
ADD COLUMN id_setor INT REFERENCES setores(id_setor);
ALTER TABLE perguntas
ADD COLUMN id_dispositivo INT REFERENCES dispositivos(id_dispositivo);