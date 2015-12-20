
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 08/12/2015 às 20:44:03
-- Versão do Servidor: 10.0.20-MariaDB
-- Versão do PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `u366610268_food`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`codigo`, `nome`) VALUES
(2, 'Salada'),
(3, 'Legume'),
(4, 'Refrigerante'),
(5, 'Lanches');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidade`
--

CREATE TABLE IF NOT EXISTS `cidade` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `uf` char(2) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `cidade`
--

INSERT INTO `cidade` (`codigo`, `nome`, `uf`) VALUES
(1, 'Campo Mourão', 'PR'),
(2, 'Cianorte', 'PR'),
(3, 'Maringá', 'PR'),
(4, 'Cascavel', 'PR'),
(5, 'Nova Cantu', 'PR');

-- --------------------------------------------------------

--
-- Estrutura da tabela `classificacao`
--

CREATE TABLE IF NOT EXISTS `classificacao` (
  `cliente` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `nota` char(1) NOT NULL,
  `obs` text,
  PRIMARY KEY (`cliente`,`produto`),
  KEY `fk_classificacao_produto1_idx` (`produto`),
  KEY `fk_classificacao_cliente1_idx` (`cliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

CREATE TABLE IF NOT EXISTS `cliente` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) NOT NULL DEFAULT '',
  `imagem` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`codigo`, `nome`, `email`, `senha`, `imagem`) VALUES
(1, 'Edvaldo Szymonek', 'edvaldoszy@gmail.com', '202cb962ac59075b964b07152d234b70', '/upload/clientes/20151113032628.png'),
(15, 'Edvaldo Szymonek', 'edvaldoszy@gmail.com.br', '202cb962ac59075b964b07152d234b70', NULL),
(7, 'Edson Szymonek', 'edsonwit@gmail.com', '202cb962ac59075b964b07152d234b70', '/upload/clientes/201511100806000.png'),
(14, 'Fagner Gabriel', 'fgco@gmail.com', '202cb962ac59075b964b07152d234b70', '/upload/clientes/20151205120259.jpg'),
(12, 'Edvino Szymonek', 'edvinoszy@gmail.com', '202cb962ac59075b964b07152d234b70', NULL),
(13, 'Juraci Szymonek', 'juraciszy@gmail.com', '202cb962ac59075b964b07152d234b70', '/upload/clientes/20151113043306.png'),
(17, 'Edvaldo Teste', 'edvaldoszy@gmail.com.co', 'abe6db4c9f5484fae8d79f2e868a673c', NULL),
(18, 'Edson Szymonek', 'edson@acessonet.net.br', '202cb962ac59075b964b07152d234b70', NULL),
(20, 'Felipe Guilherme', 'feelipegr@gmail.com', '202cb962ac59075b964b07152d234b70', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `contato`
--

CREATE TABLE IF NOT EXISTS `contato` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `telefone` varchar(45) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_contato_cliente1_idx` (`cliente`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Extraindo dados da tabela `contato`
--

INSERT INTO `contato` (`codigo`, `telefone`, `cliente`) VALUES
(20, '(44)9734-9788', 1),
(19, '(44)9134-9788', 1),
(18, '(44)9135-0983', 7),
(21, '(44)9133-2211', 1),
(24, '(44)9134-9788', 15),
(26, '(44)9134-9788', 17),
(27, '(44)9894-1010', 18),
(28, '(44)9881-3543', 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `endereco`
--

CREATE TABLE IF NOT EXISTS `endereco` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(90) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(60) DEFAULT NULL,
  `lat` varchar(30) DEFAULT NULL,
  `lng` varchar(30) DEFAULT NULL,
  `cidade` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_endereco_cidade1_idx` (`cidade`),
  KEY `fk_endereco_cliente1_idx` (`cliente`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Extraindo dados da tabela `endereco`
--

INSERT INTO `endereco` (`codigo`, `logradouro`, `numero`, `bairro`, `lat`, `lng`, `cidade`, `cliente`) VALUES
(6, 'R. Eng. Mercer', '3010', 'Cidade nova', NULL, NULL, 1, 7),
(2, 'Av. Guilherme de Paula Xavier', '30', 'Centro', '-24.04173', '-52.38681', 1, 1),
(10, 'Rua Loanda', '200', 'Parigot de Souza', NULL, NULL, 1, 1),
(11, 'Rua do Fagner', '24', 'Centric', NULL, NULL, 3, 14),
(12, 'sd', 'das', 'da', NULL, NULL, 1, 15),
(14, 'Teste', '20', 'TEste', NULL, NULL, 1, 17),
(15, 'Rua Engenheiro Mercer', '1559', 'Cidade Alta', NULL, NULL, 1, 18),
(16, 'Abhah', '2411', 'Centro', NULL, NULL, 1, 20);

-- --------------------------------------------------------

--
-- Estrutura da tabela `midia`
--

CREATE TABLE IF NOT EXISTS `midia` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `caminho` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `produto` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_midia_produto1_idx` (`produto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Extraindo dados da tabela `midia`
--

INSERT INTO `midia` (`codigo`, `titulo`, `caminho`, `produto`) VALUES
(1, NULL, '/upload/produtos/2015_11_06-01_02_37-0.jpg', 3),
(10, NULL, '/upload/produtos/20151124112519-0.png', 5),
(3, NULL, '/upload/produtos/2015_11_06_14_00_23-1.jpg', 20),
(4, NULL, '/upload/produtos/20151120090829-0.png', 5),
(5, NULL, '/upload/produtos/20151120092104-0.png', 5),
(6, NULL, '/upload/produtos/20151120092129-0.png', 5),
(7, NULL, '/upload/produtos/20151120092148-0.png', 5),
(8, NULL, '/upload/produtos/20151120092148-1.png', 5),
(9, NULL, '/upload/produtos/20151120094914-0.png', 5),
(11, NULL, '/upload/produtos/20151128073305-0.png', 23),
(12, NULL, '/upload/produtos/20151128105035-0.png', 11),
(13, NULL, '/upload/produtos/20151128105220-0.png', 24);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE IF NOT EXISTS `pedido` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(8,2) DEFAULT NULL,
  `pagamento` char(1) DEFAULT NULL,
  `troco` decimal(5,2) DEFAULT NULL,
  `endereco` text,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `situacao` char(1) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  `usuario` int(11) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_pedido_usuario1_idx` (`usuario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`codigo`, `valor`, `pagamento`, `troco`, `endereco`, `lat`, `lng`, `situacao`, `cliente`, `usuario`) VALUES
(26, '74.00', '1', '0.00', '{"bairro":"Parigot de Souza","cidade":{"nome":"Campo Mour\\u00e3o","uf":"PR","codigo":1},"logradouro":"Rua Loanda","numero":"200","codigo":10}', NULL, NULL, '1', 1, NULL),
(25, '14.50', '1', '50.00', '{"bairro":"Centro","cidade":{"codigo":1,"nome":"Campo Mour\\u00e3o","uf":"PR"},"codigo":16,"logradouro":"Abhah","numero":"2411"}', NULL, NULL, '1', 20, NULL),
(24, '129.00', '1', '150.00', '{"bairro":"Centro","cidade":{"uf":"PR","nome":"Campo Mour\\u00e3o","codigo":1},"numero":"30","logradouro":"Av. Guilherme de Paula Xavier","lat":"-24.04173","lng":"-52.38681","codigo":2}', -24.04173, -52.38681, '1', 1, NULL),
(23, '14.50', '2', '0.00', '{"bairro":"Parigot de Souza","cidade":{"uf":"PR","nome":"Campo Mour\\u00e3o","codigo":1},"numero":"200","logradouro":"Rua Loanda","codigo":10}', NULL, NULL, '2', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_item`
--

CREATE TABLE IF NOT EXISTS `pedido_item` (
  `codigo` int(11) NOT NULL,
  `pedido` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `quantidade` decimal(8,2) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `adicional` char(1) NOT NULL,
  PRIMARY KEY (`codigo`,`pedido`,`produto`,`item`),
  KEY `fk_pedido_item_produto1_idx` (`item`),
  KEY `fk_pedido_item_pedido_produto1_idx` (`pedido`,`produto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `pedido_item`
--

INSERT INTO `pedido_item` (`codigo`, `pedido`, `produto`, `item`, `quantidade`, `valor`, `adicional`) VALUES
(18, 25, 3, 6, '1.00', '1.00', ''),
(18, 25, 3, 1, '1.00', '1.00', ''),
(17, 24, 3, 6, '2.00', '1.00', ''),
(17, 24, 3, 1, '2.00', '1.00', ''),
(16, 24, 5, 6, '2.00', '1.00', ''),
(16, 24, 5, 2, '1.00', '0.30', ''),
(16, 24, 5, 1, '1.00', '1.00', ''),
(15, 24, 11, 6, '2.00', '1.00', ''),
(15, 24, 11, 1, '2.00', '2.00', ''),
(14, 23, 3, 6, '1.00', '1.00', ''),
(14, 23, 3, 1, '1.00', '1.00', ''),
(19, 26, 11, 1, '0.00', '2.00', '0'),
(19, 26, 11, 6, '0.00', '1.00', '0'),
(19, 26, 11, 2, '0.00', '0.30', '1'),
(20, 26, 3, 1, '1.00', '1.00', '0'),
(20, 26, 3, 6, '1.00', '1.00', '0');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido_produto`
--

CREATE TABLE IF NOT EXISTS `pedido_produto` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `pedido` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`codigo`,`pedido`,`produto`),
  KEY `fk_pedido_has_produto_produto1_idx` (`produto`),
  KEY `fk_pedido_has_produto_pedido1_idx` (`pedido`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Extraindo dados da tabela `pedido_produto`
--

INSERT INTO `pedido_produto` (`codigo`, `pedido`, `produto`, `quantidade`, `valor`) VALUES
(20, 26, 3, 2, '0.00'),
(19, 26, 11, 3, '0.00'),
(18, 25, 3, 1, '0.00'),
(17, 24, 3, 2, '0.00'),
(16, 24, 5, 3, '0.00'),
(15, 24, 11, 3, '0.00'),
(14, 23, 3, 1, '0.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `tipo` char(1) NOT NULL,
  `ativo` char(1) NOT NULL,
  `categoria` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_produto_categoria1_idx` (`categoria`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`codigo`, `nome`, `valor`, `tipo`, `ativo`, `categoria`) VALUES
(1, 'Picanha', '1.00', '1', '1', 2),
(2, 'Tomate', '0.30', '1', '1', 3),
(3, 'X Picanha', '14.50', '2', '0', 5),
(5, 'X Tudo', '22.00', '2', '1', 5),
(6, 'Bacon', '1.00', '1', '1', 2),
(11, 'X Bacon', '15.00', '2', '1', 5),
(24, 'X Calabresa', '20.00', '2', '1', 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_item`
--

CREATE TABLE IF NOT EXISTS `produto_item` (
  `produto` int(11) NOT NULL DEFAULT '0',
  `item` int(11) NOT NULL DEFAULT '0',
  `quantidade` decimal(8,2) DEFAULT NULL,
  `adicional` char(1) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`produto`,`item`),
  KEY `fk_produto_has_produto_produto2_idx` (`item`),
  KEY `fk_produto_has_produto_produto1_idx` (`produto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `produto_item`
--

INSERT INTO `produto_item` (`produto`, `item`, `quantidade`, `adicional`, `valor`) VALUES
(3, 1, '1.00', '0', '1.00'),
(3, 6, '1.00', '0', '1.00'),
(5, 1, '1.00', '0', '1.00'),
(5, 2, '1.00', '0', '0.30'),
(5, 6, '0.00', '1', '1.00'),
(11, 1, '1.00', '0', '2.00'),
(11, 6, '1.00', '0', '1.00'),
(24, 2, '1.00', '0', '0.20'),
(24, 6, '1.00', '0', '1.00'),
(11, 2, '0.00', '1', '0.30'),
(24, 1, '0.00', '1', '0.80');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `senha` varchar(64) DEFAULT NULL,
  `admin` char(1) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `nome`, `email`, `senha`, `admin`) VALUES
(1, 'Edvaldo Szymonek', 'edvaldoszy@gmail.com', '202cb962ac59075b964b07152d234b70', '1'),
(2, 'José da Silva', 'jose@fastfood.edvaldotsi.com', '202cb962ac59075b964b07152d234b70', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
