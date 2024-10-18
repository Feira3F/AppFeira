CREATE DATABASE IF NOT EXISTS feira;
USE feira;

CREATE TABLE IF NOT EXISTS alunos (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(60) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projetos (
	id_estande CHAR(5) PRIMARY KEY,
	sala VARCHAR(10) NOT NULL,
	orientador VARCHAR(30) NOT NULL,
	nome_proj VARCHAR(100) NOT NULL,
	ods VARCHAR(20) NOT NULL,
	resumo TEXT NOT NULL,
	objetivos TEXT NOT NULL,
	metodologia VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS alunos_projetos (
    id_aluno INT NOT NULL,
    id_estande CHAR(4) NOT NULL,
    PRIMARY KEY (id_aluno, id_estande), 
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno) ON DELETE CASCADE,
    FOREIGN KEY (id_estande) REFERENCES projetos(id_estande) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS professores (
    id_professor INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(60) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS profavalia (
    id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
    id_professor INT NOT NULL,
    id_estande CHAR(4) NOT NULL,
    FOREIGN KEY (id_professor) REFERENCES professores(id_professor) ON DELETE CASCADE,
    FOREIGN KEY (id_estande) REFERENCES projetos(id_estande) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY,
    id_professor INT NOT NULL,
    id_estande CHAR(4) NOT NULL,
    oralidade DECIMAL(3, 1) NOT NULL,
    postura  DECIMAL(3, 1) NOT NULL,
    organizacao DECIMAL(3, 1) NOT NULL,
    criatividade DECIMAL(3, 1) NOT NULL,
	capricho DECIMAL(3, 1) NOT NULL,
    dominio DECIMAL(3, 1) NOT NULL,
    abordagem DECIMAL(3, 1) NOT NULL,
    comentario TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_professor) REFERENCES professores(id_professor) ON DELETE CASCADE,
    FOREIGN KEY (id_estande) REFERENCES projetos(id_estande) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS horarios_estande (
    id_horario INT AUTO_INCREMENT PRIMARY KEY,
    id_estande CHAR(4) NOT NULL,
    id_aluno INT NOT NULL,
    horario_inicio TIME NOT NULL,
    horario_fim TIME NOT NULL,
    FOREIGN KEY (id_estande) REFERENCES projetos(id_estande) ON DELETE CASCADE,
    FOREIGN KEY (id_aluno) REFERENCES alunos(id_aluno) ON DELETE CASCADE 
);

CREATE TABLE IF NOT EXISTS fotos_mural (
    id_foto INT AUTO_INCREMENT PRIMARY KEY,
    id_estande CHAR(4) NOT NULL,
    id_aluno; -- fazer
    url_foto VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_estande) REFERENCES projetos(id_estande) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE 
);

INSERT INTO profavalia (id_professor, id_estande)VALUES(12, 'A001');

INSERT INTO projetos (id_estande, sala, orientador, nome_proj, ods, resumo, objetivos, metodologia) VALUES 
('A001', 'Sala 1', 'Dr. Carlos', 'Projeto de Sustentabilidade', 'ODS 12', 'Resumo do projeto A001', 'Objetivos do projeto A001', 'Metodologia do projeto A001'),
('A002', 'Sala 2', 'Profa. Ana', 'Inovação Tecnológica', 'ODS 9', 'Resumo do projeto A002', 'Objetivos do projeto A002', 'Metodologia do projeto A002'),
('A003', 'Sala 3', 'Dr. João', 'Educação Inclusiva', 'ODS 4', 'Resumo do projeto A003', 'Objetivos do projeto A003', 'Metodologia do projeto A003');

INSERT INTO alunos (nome, email, senha) VALUES 
('João Silva', 'joao.silva@example.com', 'senha123'),
('Maria Oliveira', 'maria.oliveira@example.com', 'senha456'),
('Pedro Santos', 'pedro.santos@example.com', 'senha789');

INSERT INTO alunos_projetos (id_aluno, id_estande) VALUES 
(1, 'A001'),
(2, 'A002'),
(3, 'A003'),
(1, 'A003');



INSERT INTO professores (nome, email, senha) VALUES
('ADRIELLEN NEVES DA SILVA', 'adriellen.silva01@etec.sp.gov.br', '83243'),
('AGDA APARECIDA MILARE DOS SANTOS', 'agda.santos01@etec.sp.gov.br', '44552'),
('AMABILE VITORIA ALBINO FERREIRA', 'amabile.ferreira@etec.sp.gov.br', '81847'),
('AMANDA APARECIDA CHAGAS', 'amanda.chagas3@etec.sp.gov.br', '30488'),
('ANA LUCIA SARTORELLI', 'ana.sartorelli@etec.sp.gov.br', '18124'),
('ANDERSON SILVA VANIN', 'anderson.vanin@etec.sp.gov.br', '18394'),
('ANTONIO CARLOS DO CARMO', 'antonio.carmo01@etec.sp.gov.br', '82403'),
('ANTONIO MARCOS DE OLIVEIRA', 'antonio.oliveira70@etec.sp.gov.br', '27912'),
('ARGUS CECIL NERY MONTEIRO', 'argus.monteiro@etec.sp.gov.br', '79181'),
('BRUNO GREC LIBERATO', 'bruno.liberato@etec.sp.gov.br', '61537'),
('BRUNO ZOLOTAREFF DOS SANTOS', 'bruno.santos312@etec.sp.gov.br', '37110'),
('CARLA FABIANE CALIXTO DA SILVA SOARES', 'carla.soares11@etec.sp.gov.br', '49380'),
('CAROLINA ESTEFANO', 'carolina.estefano@etec.sp.gov.br', '75561'),
('CÉSAR ROCHA LIMA', 'cesar.lima37@etec.sp.gov.br', '82268'),
('CINTIA MARIA DE ARAUJO PINHO', 'cintia.pinho3@etec.sp.gov.br', '36140'),
('CRISTIANE FONTES', 'cristiane.fontes2@etec.sp.gov.br', '39963'),
('DANIEL DIAS PERES', 'daniel.peres3@etec.sp.gov.br', '75956'),
('DENIS ALBERTO CONTE', 'denis.conte@etec.sp.gov.br', '76166'),
('DIOGO DOS SANTOS SILVA', 'diogo.silva328@etec.sp.gov.br', '70572'),
('DOUGLAS LEONARDO DE LIMA', 'douglas.lima91@etec.sp.gov.br', '55761'),
('EDILMA BINDÁ HUNGRIA MELO', 'edilma.hungria@etec.sp.gov.br', '72321'),
('EMMANUELE SILVA SALVADOR', 'emmanuele.salvador@etec.sp.gov.br', '82006'),
('FERNANDA CRISTINA FLAMINIO SE', 'fernanda.se01@etec.sp.gov.br', '13741'),
('HEIDI ALVES DORES', 'heidi.dores01@etec.sp.gov.br', '30489'),
('HOENDER LUVIZOTTO', 'hoender.luvizotto01@etec.sp.gov.br', '21164'),
('IVAN CARLOS BONADIO', 'ivan.bonadio@etec.sp.gov.br', '37198'),
('JULIANA SOUZA DA CRUZ', 'juliana.cruz85@etec.sp.gov.br', '79442'),
('KATIA REGINA MARTINS CALCHI', 'katia.martins9@etec.sp.gov.br', '21168'),
('KELI CRISTINA SILVA CEOLA', 'keli.ceola@etec.sp.gov.br', '24260'),
('LUANA LOURENCO', 'luana.lourenco5@etec.sp.gov.br', '71312'),
('LUCIOLA DE ALMEIDA PEREIRA', 'luciola.pereira@etec.sp.gov.br', '80488'),
('LUIS FRANCISCO DA SILVA', 'luis.silva1135@etec.sp.gov.br', '80918'),
('LUIZ FERNANDO LEONARDI', 'luiz.leonardi@etec.sp.gov.br', '38508'),
('MARCELO NERY PETRI', 'marcelo.petri@etec.sp.gov.br', '81384'),
('MARCOS GARCIA PALMA', 'marcos.palma@etec.sp.gov.br', '76241'),
('MARCOS PEDRO', 'marcos.pedro@etec.sp.gov.br', '19762'),
('MARCOS VINICIUS DA SILVA', 'marcos.silva1633@etec.sp.gov.br', '83233'),
('MARIA DA CONCEICAO MEDEIROS', 'maria.medeiros4@etec.sp.gov.br', '37115'),
('MATHEUS FURLAN', 'matheus.furlan7@etec.sp.gov.br', '76357'),
('NATALI WITKOVSKI DOS SANTOS DE BONA', 'natali.bona@etec.sp.gov.br', '64766'),
('NICOLAU KARDASH SALVADOR', 'nicolau.salvador01@etec.sp.gov.br', '21169'),
('PÂMELA DE OLIVEIRA SOARES', 'pamela.soares19@etec.sp.gov.br', '51424'),
('PAULO ALEXANDRE PEREIRA', 'paulo.pereira191@etec.sp.gov.br', '72926'),
('PAULO CESAR DE SOUZA CANDIDO', 'paulo.candido01@etec.sp.gov.br', '46138'),
('PRISCILA TROMBINI', 'priscila.trombini@etec.sp.gov.br', '77114'),
('RAFAEL ALJONA ORTEGA', 'rafael.ortega@etec.sp.gov.br', '61814'),
('RAILON MENDES DE MOURA', 'railon.moura@etec.sp.gov.br', '79281'),
('RICARDO LIOCHI FERREIRA SILVA PELLARO', 'ricardo.silva165@etec.sp.gov.br', '20371'),
('RICARDO MOREIRA', 'ricardo.moreira36@etec.sp.gov.br', '78110'),
('ROBERTO ALJONA ORTEGA', 'roberto.ortega01@etec.sp.gov.br', '21166'),
('ROSALINA JULIO', 'rosalina.julio@etec.sp.gov.br', '19273'),
('SIMONE APARECIDA TORRES DE SOUZA CUNEGUNDES', 'simone.cunegundes@etec.sp.gov.br', '68664'),
('SINESIO DELPOIO', 'sinesio.delpoio@etec.sp.gov.br', '21157'),
('SUELY DOS SANTOS SOUSA', 'suely.sousa2@etec.sp.gov.br', '46136'),
('VALDEMIR PEZZO', 'valdemir.pezzo@etec.sp.gov.br', '46137'),
('VALQUIRIA BENEDITO BASSALOBRE', 'valquiria.bassalobre01@etec.sp.gov.br', '19272'),
('VANESSA FONTES DE QUEIROS ANASTACIO', 'vanessa.anastacio@etec.sp.gov.br', '46126'),
('VINICIUS MOREIRA DAS NEVES', 'vinicius.neves32@etec.sp.gov.br', '82059');

SELECT # profavalia = projetos + prof, qual prof vai dar nota para qual projeto
    pa.id_avaliacao,
    p.id_professor,
    p.nome AS nome_professor,
    pr.id_estande,
    pr.sala,
    pr.orientador,
    pr.nome_proj,
    pr.ods,
    pr.resumo,
    pr.objetivos,
    pr.metodologia
FROM 
    profavalia pa
JOIN 
    professores p ON pa.id_professor = p.id_professor
JOIN 
    projetos pr ON pa.id_estande = pr.id_estande
ORDER BY 
    p.nome;