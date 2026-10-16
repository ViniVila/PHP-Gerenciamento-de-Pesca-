-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 16/10/2026 às 19:11
-- Versão do servidor: 8.0.40
-- Versão do PHP: 8.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pesca`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `embarcacoes`
--

CREATE TABLE `embarcacoes` (
  `id` int NOT NULL,
  `pescador_id` int NOT NULL,
  `modelo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marca` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registro` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cor` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ano` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `embarcacoes`
--

INSERT INTO `embarcacoes` (`id`, `pescador_id`, `modelo`, `marca`, `registro`, `cor`, `ano`) VALUES
(1, 1, 'Traineira 30', 'Marujo', 'BR-1001', 'Azul', 2018),
(2, 2, 'Bote 18', 'Náutica Sul', 'BR-2002', 'Branco', 2021);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pescador`
--

CREATE TABLE `pescador` (
  `id` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cpf` varbinary(255) NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pescador`
--

INSERT INTO `pescador` (`id`, `nome`, `cpf`, `telefone`, `email`) VALUES
(1, 'João da Silva', 0x8d62033c2b46c000dbfde755388398f4, '(13) 99999-0001', 'joao@pesca.com'),
(2, 'Maria Souza', 0x20e0cb1bb77a1aee6b9cdaac98f7c308, '(13) 99999-0002', 'maria@pesca.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pescarias`
--

CREATE TABLE `pescarias` (
  `id` int NOT NULL,
  `embarcacao_id` int NOT NULL,
  `data` date NOT NULL,
  `descricao` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `pescarias`
--

INSERT INTO `pescarias` (`id`, `embarcacao_id`, `data`, `descricao`, `valor`) VALUES
(1, 1, '2026-10-05', 'Tainha - Baía de Santos', 850.00),
(2, 2, '2026-10-09', 'Robalo - Estuário', 420.50);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `senha`) VALUES
(1, 'admin', '$2y$10$SClxz1OlxWCRT4oXs3jWauj.TvTWySSjzpb1vRo23btoxXZyq0szu');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `embarcacoes`
--
ALTER TABLE `embarcacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_embarcacoes_pescador` (`pescador_id`);

--
-- Índices de tabela `pescador`
--
ALTER TABLE `pescador`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pescarias`
--
ALTER TABLE `pescarias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pescarias_embarcacao` (`embarcacao_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `embarcacoes`
--
ALTER TABLE `embarcacoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pescador`
--
ALTER TABLE `pescador`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `pescarias`
--
ALTER TABLE `pescarias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `embarcacoes`
--
ALTER TABLE `embarcacoes`
  ADD CONSTRAINT `fk_embarcacoes_pescador` FOREIGN KEY (`pescador_id`) REFERENCES `pescador` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `pescarias`
--
ALTER TABLE `pescarias`
  ADD CONSTRAINT `fk_pescarias_embarcacao` FOREIGN KEY (`embarcacao_id`) REFERENCES `embarcacoes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
