# Host: localhost  (Version: 5.6.25)
# Date: 2015-10-29 12:00:02
# Generator: MySQL-Front 5.3  (Build 4.234)

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

REPLACE INTO `categoria` VALUES (1,'Carne'),(2,'Salada'),(3,'Legume'),(4,'Refrigerante'),(5,'Lanches');

#
# Structure for table "cidade"
#

CREATE TABLE `cidade` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) NOT NULL,
  `uf` char(2) NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

#
# Data for table "cidade"
#

REPLACE INTO `cidade` VALUES (1,'Campo Mourão','PR'),(2,'Cianorte','PR'),(3,'Maringá','PR'),(4,'Cascavel','PR'),(5,'Nova Cantu','PR');

#
# Structure for table "cliente"
#

CREATE TABLE `cliente` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `senha` varchar(45) NOT NULL DEFAULT '',
  `imagem` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Data for table "cliente"
#

REPLACE INTO `cliente` VALUES (1,'Edvaldo Szymonek :)','edvaldoszy@gmail.com','masterkey','http://192.168.25.14/integrado/tcc/api/http://192.168.25.14/integrado/tcc/api/http://192.168.25.14/integrado/tcc/api/http://192.168.25.14/integrado/tcc/api/http://192.168.25.14/integrado/tcc/api/http:'),(7,'Edson Szymonek :)','edsonwit@gmail.com','202cb962ac59075b964b07152d234b70','http://192.168.25.14/integrado/tcc/api/http://192.168.25.14/integrado/tcc/api/img/patins.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

#
# Data for table "contato"
#

REPLACE INTO `contato` VALUES (1,'(44) 9134-9788',1),(2,'(44) 9101-8838',1),(14,'(22) 2222-2222',1),(15,'(64) 4384-6484',1);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "endereco"
#

REPLACE INTO `endereco` VALUES (1,'Rua Loanda','137','Parigot de Souza',NULL,NULL,1,1),(2,'Rua Laurindo Borges','1936','Centro',NULL,NULL,1,1);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

#
# Data for table "produto"
#

REPLACE INTO `produto` VALUES (1,'Picanha',0.00,'1','1',1),(2,'Tomate',0.00,'1','1',3),(3,'Goku',14.50,'2','0',5),(5,'Darth Vader',20.23,'2','1',5),(6,'Bacon',0.00,'1','1',1);

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
  `produto` int(11) NOT NULL DEFAULT '0',
  `item` int(11) NOT NULL DEFAULT '0',
  `quantidade` decimal(8,2) DEFAULT NULL,
  `adicional` char(1) DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  PRIMARY KEY (`produto`,`item`),
  KEY `fk_produto_has_produto_produto2_idx` (`item`),
  KEY `fk_produto_has_produto_produto1_idx` (`produto`),
  CONSTRAINT `fk_produto_has_produto_produto1` FOREIGN KEY (`produto`) REFERENCES `produto` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_has_produto_produto2` FOREIGN KEY (`item`) REFERENCES `produto` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Data for table "produto_item"
#

REPLACE INTO `produto_item` VALUES (3,1,1.00,'0',0.00),(3,6,1.00,'0',0.00),(5,1,1.00,'0',0.00),(5,2,1.00,'0',0.00),(5,6,1.00,'0',0.00);

#
# Structure for table "usuario"
#

CREATE TABLE `usuario` (
  `codigo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `senha` varchar(64) DEFAULT NULL,
  `admin` char(1) DEFAULT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for table "usuario"
#

REPLACE INTO `usuario` VALUES (1,'Administrador','edvaldoszy@gmail.com','202cb962ac59075b964b07152d234b70','1');

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
  `usuario` int(11) DEFAULT '0',
  PRIMARY KEY (`codigo`),
  KEY `fk_pedido_cliente1_idx` (`cliente`),
  KEY `fk_pedido_usuario1_idx` (`usuario`),
  CONSTRAINT `fk_pedido_cliente1` FOREIGN KEY (`cliente`) REFERENCES `cliente` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "pedido"
#

REPLACE INTO `pedido` VALUES (1,50.00,'1',0.00,'0','0',1,NULL),(11,30.00,'1',0.00,'0','0',7,NULL);

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

REPLACE INTO `pedido_produto` VALUES (1,3,2,50.00),(11,3,1,30.00);

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

REPLACE INTO `pedido_item` VALUES (1,1,3,6,1.00,3.00);
