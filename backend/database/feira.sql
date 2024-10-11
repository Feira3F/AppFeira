-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10-Out-2024 às 21:58
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `feira`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliadores`
--

CREATE TABLE `avaliadores` (
  `id_avaliador` int(11) NOT NULL,
  `avaliador` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliadores_projetos`
--

CREATE TABLE `avaliadores_projetos` (
  `id_avaliador` int(11) NOT NULL,
  `id_estande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fotos_mural`
--

CREATE TABLE `fotos_mural` (
  `id_foto` int(11) NOT NULL,
  `id_enviador` int(11) NOT NULL,
  `id_estande` int(11) NOT NULL,
  `url_foto` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios_estande`
--

CREATE TABLE `horarios_estande` (
  `id_horario` int(11) NOT NULL,
  `id_estande` int(11) NOT NULL,
  `id_otario` int(11) NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas`
--

CREATE TABLE `notas` (
  `id_nota` int(11) NOT NULL,
  `id_otario` int(11) NOT NULL,
  `id_avaliador` int(11) NOT NULL,
  `nota1` decimal(3,1) NOT NULL,
  `nota2` decimal(3,1) NOT NULL,
  `nota3` decimal(3,1) NOT NULL,
  `nota4` decimal(3,1) NOT NULL,
  `nota5` decimal(3,1) NOT NULL,
  `nota6` decimal(3,1) NOT NULL,
  `nota7` decimal(3,1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `otarios`
--

CREATE TABLE `otarios` (
  `id_otario` int(11) NOT NULL,
  `nome_otario` varchar(50) NOT NULL,
  `email_otario` varchar(50) NOT NULL,
  `pass_otario` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
--

CREATE TABLE `projetos` (
  `id_estande` int(11) NOT NULL,
  `sala` varchar(10) NOT NULL,
  `orientador` varchar(30) NOT NULL,
  `nome_proj` varchar(100) NOT NULL,
  `ods` varchar(10) NOT NULL,
  `resumo` text NOT NULL,
  `objetivos` text NOT NULL,
  `metodologia` varchar(100) NOT NULL,
  `rede_social` varchar(20) DEFAULT NULL,
  `site` varchar(30) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `projetos`
--

INSERT INTO `projetos` (`id_estande`, `sala`, `orientador`, `nome_proj`, `ods`, `resumo`, `objetivos`, `metodologia`, `rede_social`, `site`, `created_at`, `updated_at`) VALUES
(1, '1º I', 'Juliana', 'Água Furiosa', '6', 'Experimento que mistura glicose', ' hidróxido de sódio e azul de metileno. A cor muda ao agitar e volta ao repouso.', 'Mostrar a mudança de cor da mistura agitada e explicar o fenômeno.', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(2, '1º I', 'Juliana', 'Indicador de pH', '6, 14 e 15', 'Indicadores que mudam de cor em soluções ácidas ou básicas', ' utilizados para identificar pH.', 'Identificar ácidos e bases usando azul de bromotimol e explicar diferentes tipos.', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(3, '1º I', 'Paulo', 'Torre de Densidade', '3, 6, 11, ', 'Coluna usada para separar misturas líquidas pela volatilidade. Utilizada na indústria petroquímica e de bebidas.', 'Demonstrar visualmente a densidade de diferentes líquidos e elementos químicos.', 'Experimento com líquidos de diferentes densidades em camadas', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(4, '1º I', 'Paulo', 'Tensão Superficial da Água', '14', 'Demonstra como as moléculas de água se comportam na interface líquido-ar. A tensão superficial resiste à ruptura.', 'Medir como diferentes substâncias (sabão', ' álcool', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(5, '2º I', 'Antônio Marcos', 'Creme', '3 e 12', 'Criação de creme corporal e esfoliante a partir de substâncias hidratantes.', 'Hidratar e acalmar a pele', ' tratando peles irritadas.', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(6, '2º I', 'Antônio Marcos', 'Colônia', '3, 9 e 12', 'Colônia repelente de mosquitos', ' com odor agradável e feito a partir de óleos naturais.', 'Afastar mosquitos com um cheiro natural e agradável.', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(7, '2º I', 'Antônio Marcos', 'Perfume', '3 e 12', 'Perfumaria com fragrâncias agradáveis e duradouras para uso feminino e masculino.', 'Proporcionar perfumes com boas fragrâncias.', 'Coleta de amostras', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(8, '2º I', 'Antônio Marcos', 'Óleo', '3 e 12', 'Óleos essenciais para tratamento de ressecamento e cuidados capilares.', 'Criar óleos calmantes e terapêuticos com baixo custo.', 'Destilação a vapor e maceração de compostos naturais', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(9, '2º I', 'Antônio Marcos', 'Argila', '3 e 12', 'Argiloterapia e sabonete esfoliante para tratar foliculite e clarear manchas.', 'Criar argila com propriedades calmantes e antibacterianas.', 'Desenvolvimento de argila utilizando óleos de rosa mosqueta e maracujá', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41'),
(10, '2º I', 'Antônio Marcos', 'Vela Aromática', '3 e 12', 'Velas aromáticas fitoterapêuticas a partir de extratos de plantas.', 'Criar velas aromáticas destinadas a tratar diferentes problemáticas.\r', '', NULL, NULL, '2024-10-10 19:51:41', '2024-10-10 19:51:41');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos_otarios`
--

CREATE TABLE `projetos_otarios` (
  `id_estande` int(11) NOT NULL,
  `id_otario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `avaliadores`
--
ALTER TABLE `avaliadores`
  ADD PRIMARY KEY (`id_avaliador`);

--
-- Índices para tabela `avaliadores_projetos`
--
ALTER TABLE `avaliadores_projetos`
  ADD PRIMARY KEY (`id_avaliador`,`id_estande`),
  ADD KEY `id_estande` (`id_estande`);

--
-- Índices para tabela `fotos_mural`
--
ALTER TABLE `fotos_mural`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_estande` (`id_estande`);

--
-- Índices para tabela `horarios_estande`
--
ALTER TABLE `horarios_estande`
  ADD PRIMARY KEY (`id_horario`),
  ADD UNIQUE KEY `idx_horarios_unique` (`id_estande`,`id_otario`,`horario_inicio`,`horario_fim`),
  ADD KEY `id_otario` (`id_otario`);

--
-- Índices para tabela `notas`
--
ALTER TABLE `notas`
  ADD PRIMARY KEY (`id_nota`),
  ADD KEY `id_otario` (`id_otario`),
  ADD KEY `id_avaliador` (`id_avaliador`);

--
-- Índices para tabela `otarios`
--
ALTER TABLE `otarios`
  ADD PRIMARY KEY (`id_otario`),
  ADD UNIQUE KEY `email_otario` (`email_otario`);

--
-- Índices para tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id_estande`);

--
-- Índices para tabela `projetos_otarios`
--
ALTER TABLE `projetos_otarios`
  ADD PRIMARY KEY (`id_estande`,`id_otario`),
  ADD KEY `id_otario` (`id_otario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `avaliadores`
--
ALTER TABLE `avaliadores`
  MODIFY `id_avaliador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fotos_mural`
--
ALTER TABLE `fotos_mural`
  MODIFY `id_foto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `horarios_estande`
--
ALTER TABLE `horarios_estande`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notas`
--
ALTER TABLE `notas`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `otarios`
--
ALTER TABLE `otarios`
  MODIFY `id_otario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id_estande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `avaliadores_projetos`
--
ALTER TABLE `avaliadores_projetos`
  ADD CONSTRAINT `avaliadores_projetos_ibfk_1` FOREIGN KEY (`id_avaliador`) REFERENCES `avaliadores` (`id_avaliador`) ON DELETE CASCADE,
  ADD CONSTRAINT `avaliadores_projetos_ibfk_2` FOREIGN KEY (`id_estande`) REFERENCES `projetos` (`id_estande`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `fotos_mural`
--
ALTER TABLE `fotos_mural`
  ADD CONSTRAINT `fotos_mural_ibfk_1` FOREIGN KEY (`id_estande`) REFERENCES `projetos` (`id_estande`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `horarios_estande`
--
ALTER TABLE `horarios_estande`
  ADD CONSTRAINT `horarios_estande_ibfk_1` FOREIGN KEY (`id_estande`) REFERENCES `projetos` (`id_estande`) ON DELETE CASCADE,
  ADD CONSTRAINT `horarios_estande_ibfk_2` FOREIGN KEY (`id_otario`) REFERENCES `otarios` (`id_otario`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`id_otario`) REFERENCES `otarios` (`id_otario`) ON DELETE CASCADE,
  ADD CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`id_avaliador`) REFERENCES `avaliadores` (`id_avaliador`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `projetos_otarios`
--
ALTER TABLE `projetos_otarios`
  ADD CONSTRAINT `projetos_otarios_ibfk_1` FOREIGN KEY (`id_estande`) REFERENCES `projetos` (`id_estande`) ON DELETE CASCADE,
  ADD CONSTRAINT `projetos_otarios_ibfk_2` FOREIGN KEY (`id_otario`) REFERENCES `otarios` (`id_otario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
