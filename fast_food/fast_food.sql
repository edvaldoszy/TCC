# Host: localhost  (Version: 5.6.21)
# Date: 2015-10-29 10:39:25
# Generator: MySQL-Front 5.3  (Build 4.224)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "categoria"
#

CREATE TABLE `categoria` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(40) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "categoria"
#


#
# Structure for table "cidade"
#

CREATE TABLE `cidade` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `uf` char(2) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "cidade"
#


#
# Structure for table "cliente"
#

CREATE TABLE `cliente` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "cliente"
#


#
# Structure for table "contato"
#

CREATE TABLE `contato` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `telefone` varchar(45) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_contato_cliente1_idx` (`cliente`),
  CONSTRAINT `fk_contato_cliente1` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "contato"
#


#
# Structure for table "endereco"
#

CREATE TABLE `endereco` (
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
  KEY `fk_endereco_cliente1_idx` (`cliente`),
  CONSTRAINT `fk_endereco_cidade1` FOREIGN KEY (`cidade`) REFERENCES `cidade` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_endereco_cliente1` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "endereco"
#


#
# Structure for table "produto"
#

CREATE TABLE `produto` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `tipo` char(1) NOT NULL,
  `ativo` char(1) NOT NULL,
  `categoria` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_produto_categoria1_idx` (`categoria`),
  CONSTRAINT `fk_produto_categoria1` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "produto"
#


#
# Structure for table "classificacao"
#

CREATE TABLE `classificacao` (
  `cliente` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `nota` char(1) NOT NULL,
  `obs` text,
  PRIMARY KEY (`cliente`,`produto`),
  KEY `fk_classificacao_produto1_idx` (`produto`),
  KEY `fk_classificacao_cliente1_idx` (`cliente`),
  CONSTRAINT `fk_classificacao_cliente1` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_classificacao_produto1` FOREIGN KEY (`produto`) REFERENCES `produto` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "classificacao"
#


#
# Structure for table "produto_item"
#

CREATE TABLE `produto_item` (
  `produto1` int(11) NOT NULL,
  `produto2` int(11) NOT NULL,
  `quantidade` decimal(8,2) DEFAULT NULL,
  `adicional` char(1) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`produto1`,`produto2`),
  KEY `fk_produto_has_produto_produto2_idx` (`produto2`),
  KEY `fk_produto_has_produto_produto1_idx` (`produto1`),
  CONSTRAINT `fk_produto_has_produto_produto1` FOREIGN KEY (`produto1`) REFERENCES `produto` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_has_produto_produto2` FOREIGN KEY (`produto2`) REFERENCES `produto` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "produto_item"
#


#
# Structure for table "usuario"
#

CREATE TABLE `usuario` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `login` varchar(64) DEFAULT NULL,
  `senha` varchar(64) DEFAULT NULL,
  `admin` char(1) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "usuario"
#

INSERT INTO `usuario` VALUES (1,'Edvaldo Szymonek','edvaldoszy@gmail.com','edvaldo','202cb962ac59075b964b07152d234b70','1');

#
# Structure for table "pedido"
#

CREATE TABLE `pedido` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `valor` decimal(8,2) DEFAULT NULL,
  `pagamento` char(1) DEFAULT NULL,
  `troco` decimal(5,2) DEFAULT NULL,
  `lat` varchar(30) DEFAULT NULL,
  `lng` varchar(30) DEFAULT NULL,
  `cliente` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_pedido_cliente1_idx` (`cliente`),
  KEY `fk_pedido_usuario1_idx` (`usuario`),
  CONSTRAINT `fk_pedido_cliente1` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pedido"
#


#
# Structure for table "pedido_produto"
#

CREATE TABLE `pedido_produto` (
  `pedido` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`pedido`,`produto`),
  KEY `fk_pedido_has_produto_produto1_idx` (`produto`),
  KEY `fk_pedido_has_produto_pedido1_idx` (`pedido`),
  CONSTRAINT `fk_pedido_has_produto_pedido1` FOREIGN KEY (`pedido`) REFERENCES `pedido` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_has_produto_produto1` FOREIGN KEY (`produto`) REFERENCES `produto` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pedido_produto"
#


#
# Structure for table "pedido_item"
#

CREATE TABLE `pedido_item` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `pedido` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `quantidade` decimal(8,2) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `fk_pedido_item_produto1_idx` (`item`),
  KEY `fk_pedido_item_pedido_produto1_idx` (`pedido`,`produto`),
  CONSTRAINT `fk_pedido_item_pedido_produto1` FOREIGN KEY (`pedido`, `produto`) REFERENCES `pedido_produto` (`pedido`, `produto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_item_produto1` FOREIGN KEY (`item`) REFERENCES `produto` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "pedido_item"
#

