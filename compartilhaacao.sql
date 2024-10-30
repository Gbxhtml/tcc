-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 31/10/2024 às 00:58
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `compartilhaacao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_doa`
--

CREATE TABLE `tb_doa` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `responsavel` int(11) NOT NULL,
  `obs` varchar(30) NOT NULL,
  `id_doacao` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_doacao`
--

CREATE TABLE `tb_doacao` (
  `id` int(11) NOT NULL,
  `descricao` varchar(300) NOT NULL,
  `condicao` varchar(70) NOT NULL,
  `publico_alvo` varchar(50) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `validade` date NOT NULL,
  `obs` varchar(300) NOT NULL,
  `id_instituicao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_endereco`
--

CREATE TABLE `tb_endereco` (
  `id` int(11) NOT NULL,
  `estado` varchar(30) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `rua` varchar(30) NOT NULL,
  `cep` int(8) NOT NULL,
  `numero` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tb_endereco`
--

INSERT INTO `tb_endereco` (`id`, `estado`, `cidade`, `bairro`, `rua`, `cep`, `numero`) VALUES
(1, '42', 'Sombrio', '', '', 88960000, 211),
(4, '42', 'Sombrio', '', '', 88960000, 211),
(5, '42', 'Sombrio', '', '', 88960000, 211),
(6, '42', 'Sombrio', '', '', 88960000, 211),
(8, '26', 'Barreiros', 'Raizera', 'Rua Mário Sant Helena ', 88960000, 211),
(9, '26', 'Barreiros', 'Raizera', 'Rua Mário Sant Helena ', 88960000, 211),
(10, '26', 'Barreiros', 'Raizera', 'Rua Mário Sant Helena ', 88960000, 211),
(11, '42', 'Sombrio', 'Raizera', 'Rua Mário Sant Helena ', 88960000, 211);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_instituicao`
--

CREATE TABLE `tb_instituicao` (
  `id` int(11) NOT NULL,
  `endereco` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `nome_fantasia` varchar(30) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `cnpj` varchar(20) NOT NULL,
  `fone` varchar(11) NOT NULL,
  `obs` varchar(100) NOT NULL,
  `img` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_recebe`
--

CREATE TABLE `tb_recebe` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `entrega` date NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_doacao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuario`
--

CREATE TABLE `tb_usuario` (
  `id` int(11) NOT NULL,
  `endereco` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(30) NOT NULL,
  `fone` varchar(11) NOT NULL,
  `cpf` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `tb_doa`
--
ALTER TABLE `tb_doa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_doacao` (`id_doacao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `tb_doacao`
--
ALTER TABLE `tb_doacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_instituicao` (`id_instituicao`);

--
-- Índices de tabela `tb_endereco`
--
ALTER TABLE `tb_endereco`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tb_instituicao`
--
ALTER TABLE `tb_instituicao`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `tb_recebe`
--
ALTER TABLE `tb_recebe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_doacao` (`id_doacao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `tb_usuario_ibfk_1` (`endereco`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_doa`
--
ALTER TABLE `tb_doa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_doacao`
--
ALTER TABLE `tb_doacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_endereco`
--
ALTER TABLE `tb_endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `tb_instituicao`
--
ALTER TABLE `tb_instituicao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_recebe`
--
ALTER TABLE `tb_recebe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `tb_doa`
--
ALTER TABLE `tb_doa`
  ADD CONSTRAINT `tb_doa_ibfk_1` FOREIGN KEY (`id_doacao`) REFERENCES `tb_doacao` (`id`),
  ADD CONSTRAINT `tb_doa_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id`);

--
-- Restrições para tabelas `tb_doacao`
--
ALTER TABLE `tb_doacao`
  ADD CONSTRAINT `tb_doacao_ibfk_1` FOREIGN KEY (`id_instituicao`) REFERENCES `tb_instituicao` (`id`);

--
-- Restrições para tabelas `tb_recebe`
--
ALTER TABLE `tb_recebe`
  ADD CONSTRAINT `tb_recebe_ibfk_1` FOREIGN KEY (`id_doacao`) REFERENCES `tb_doacao` (`id`),
  ADD CONSTRAINT `tb_recebe_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `tb_usuario` (`id`);

--
-- Restrições para tabelas `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`endereco`) REFERENCES `tb_endereco` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
