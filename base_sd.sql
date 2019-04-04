-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 04-Abr-2019 às 20:53
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `base_sd`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `demanda`
--

CREATE TABLE `demanda` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `id_dep` int(10) NOT NULL,
  `id_usr_criador` int(10) NOT NULL,
  `id_usr_destino` int(10) NOT NULL,
  `data_criacao` datetime NOT NULL,
  `prioridade` int(10) NOT NULL,
  `mensagem` varchar(256) NOT NULL,
  `status` varchar(100) NOT NULL,
  `anexo` varchar(256) NOT NULL,
  `data_fechamento` datetime NOT NULL,
  `ordem_servico` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `demanda`
--

INSERT INTO `demanda` (`id`, `titulo`, `id_dep`, `id_usr_criador`, `id_usr_destino`, `data_criacao`, `prioridade`, `mensagem`, `status`, `anexo`, `data_fechamento`, `ordem_servico`) VALUES
(3, 'COMUNICADO FERIADO', 2, 9, 9, '2019-02-04 18:11:01', 1, 'teste', 'Em atendimento', '8b3d9bd7509170f1c7a4e982e7a0b469.jpg', '0000-00-00 00:00:00', ''),
(8, 'teste', 1, 8, 8, '2019-04-04 15:43:44', 2, 'teste', 'Aberto', 'b68bcf8e74d0c1e4a1dc21597ad840dd.png', '0000-00-00 00:00:00', '1545jk');

-- --------------------------------------------------------

--
-- Estrutura da tabela `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(10) NOT NULL,
  `nome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `departamentos`
--

INSERT INTO `departamentos` (`id`, `nome`) VALUES
(1, 'TI'),
(2, 'COMPRAS'),
(3, 'CONTABILIDADE'),
(4, 'FINANCEIRO'),
(5, 'DIRETORIA'),
(6, 'RH'),
(7, 'LOGÍSTICA'),
(8, 'SECRETARIA'),
(9, 'VENDAS'),
(11, 'MARKETING');

-- --------------------------------------------------------

--
-- Estrutura da tabela `hst_mensagens`
--

CREATE TABLE `hst_mensagens` (
  `id_mensagem` int(10) NOT NULL,
  `cod_demanda` int(10) NOT NULL,
  `cod_usr_msg` int(5) NOT NULL,
  `mensagem` varchar(500) NOT NULL,
  `msg_data` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `hst_mensagens`
--

INSERT INTO `hst_mensagens` (`id_mensagem`, `cod_demanda`, `cod_usr_msg`, `mensagem`, `msg_data`) VALUES
(1, 1, 8, 'gdgfgf', '06/09/2018 - 16:40'),
(2, 1, 8, 'gsgdsgd', '06/09/2018 - 16:40');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tbl_sla`
--

CREATE TABLE `tbl_sla` (
  `id` int(11) NOT NULL,
  `descricao` varchar(40) NOT NULL,
  `tempo` int(20) NOT NULL,
  `unitempo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tbl_sla`
--

INSERT INTO `tbl_sla` (`id`, `descricao`, `tempo`, `unitempo`) VALUES
(2, 'Verificação simples', 15, 'Minutos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nivel` int(1) NOT NULL,
  `id_dep` int(10) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `nivel`, `id_dep`, `status`) VALUES
(8, 'Administrador', 'admin@email.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, 1, 'Ativo'),
(9, 'teste', 'teste@email.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 1, 1, 'Ativo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `demanda`
--
ALTER TABLE `demanda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hst_mensagens`
--
ALTER TABLE `hst_mensagens`
  ADD PRIMARY KEY (`id_mensagem`);

--
-- Indexes for table `tbl_sla`
--
ALTER TABLE `tbl_sla`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `demanda`
--
ALTER TABLE `demanda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `hst_mensagens`
--
ALTER TABLE `hst_mensagens`
  MODIFY `id_mensagem` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_sla`
--
ALTER TABLE `tbl_sla`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
