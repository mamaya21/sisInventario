-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para sisinventario
DROP DATABASE IF EXISTS `sisinventario`;
CREATE DATABASE IF NOT EXISTS `sisinventario` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sisinventario`;

-- Volcando estructura para tabla sisinventario.materiales
DROP TABLE IF EXISTS `materiales`;
CREATE TABLE IF NOT EXISTS `materiales` (
  `id_material` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci,
  `fecha_crea` datetime NOT NULL,
  `usuario_crea` int(10) unsigned zerofill NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `usuario_modifica` int(10) unsigned zerofill DEFAULT NULL,
  `estado` int NOT NULL,
  `id_tipo` int DEFAULT NULL,
  `id_unidad` int DEFAULT NULL,
  PRIMARY KEY (`id_material`),
  KEY `id_tipo` (`id_tipo`),
  KEY `id_unidad` (`id_unidad`),
  CONSTRAINT `materiales_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos_material` (`id_tipo`),
  CONSTRAINT `materiales_ibfk_2` FOREIGN KEY (`id_unidad`) REFERENCES `unidades_medida` (`id_unidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sisinventario.materiales: ~0 rows (aproximadamente)
DELETE FROM `materiales`;
INSERT INTO `materiales` (`id_material`, `nombre`, `descripcion`, `fecha_crea`, `usuario_crea`, `fecha_modifica`, `usuario_modifica`, `estado`, `id_tipo`, `id_unidad`) VALUES
	('MAT001482', 'Cable THW Calibre 12', 'Cable para instalaciones eléctricas en interiores.', '2025-04-11 01:14:42', 0000000001, NULL, NULL, 1, 61, 75),
	('MAT009876', 'Caja de Paso 10x10', 'Caja plástica para derivaciones eléctricas.', '2025-04-11 01:14:42', 0000000001, NULL, NULL, 1, 56, 80),
	('MAT088045', 'Bandeja Perforada 100mm', 'Estructura metálica para cableado.', '2025-04-11 01:14:42', 0000000002, NULL, NULL, 1, 66, 82),
	('MAT090713', 'Conector Tipo Banana', 'Conector utilizado en pruebas eléctricas.', '2025-04-11 01:14:42', 0000000002, NULL, NULL, 1, 59, 74),
	('MAT120394', 'Cable de Datos Trenzado', 'Cable usado para transmisión de datos.', '2025-04-11 01:14:42', 0000000001, NULL, NULL, 1, 64, 86),
	('MAT213650', 'Cable Coaxial RG6', 'Cable usado para CCTV y TV.', '2025-04-11 01:14:42', 0000000001, NULL, NULL, 1, 63, 73),
	('MAT334211', 'Canaleta PVC 20x10', 'Sistema de conducción externa para cableado.', '2025-04-11 01:14:42', 0000000003, NULL, NULL, 1, 68, 81),
	('MAT369122', 'Conector BNC', 'Conector para cable coaxial.', '2025-04-11 01:14:42', 0000000003, NULL, NULL, 1, 59, 83),
	('MAT450607', 'Empalme Rápido UTP', 'Conector para unión de cables de red.', '2025-04-11 01:14:42', 0000000001, NULL, NULL, 1, 69, 84),
	('MAT481276', 'Fibra Óptica Monomodo', 'Cable ideal para largas distancias de transmisión.', '2025-04-11 01:14:42', 0000000002, NULL, NULL, 1, 65, 87),
	('MAT652378', 'Tubo Conduit EMT', 'Tubo metálico para canalización eléctrica.', '2025-04-11 01:14:42', 0000000004, NULL, NULL, 1, 67, 77),
	('MAT700835', 'Cinta Aislante Azul', 'Cinta plástica para aislamiento eléctrico.', '2025-04-11 01:14:42', 0000000001, NULL, NULL, 1, 60, 76),
	('MAT778031', 'Accesorios para Conduit', 'Codos, uniones y abrazaderas metálicas.', '2025-04-11 01:14:42', 0000000002, NULL, NULL, 1, 66, 79),
	('MAT872190', 'Cable de Red FTP Cat6', 'Cable blindado para redes Ethernet.', '2025-04-11 01:14:42', 0000000002, NULL, NULL, 1, 62, 85);

-- Volcando estructura para tabla sisinventario.movimientos
DROP TABLE IF EXISTS `movimientos`;
CREATE TABLE IF NOT EXISTS `movimientos` (
  `id_movimiento` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `id_material` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `nota` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_crea` datetime NOT NULL,
  `usuario_crea` int(10) unsigned zerofill NOT NULL,
  `fecha_modifica` datetime DEFAULT NULL,
  `usuario_modifica` int(10) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id_movimiento`),
  KEY `id_material` (`id_material`),
  CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id_material`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sisinventario.movimientos: ~0 rows (aproximadamente)
DELETE FROM `movimientos`;
INSERT INTO `movimientos` (`id_movimiento`, `tipo`, `id_material`, `cantidad`, `nota`, `fecha_crea`, `usuario_crea`, `fecha_modifica`, `usuario_modifica`) VALUES
	(6, 'ingreso', 'MAT700835', 5.00, '', '2025-04-11 08:38:13', 0000000001, NULL, NULL),
	(7, 'ingreso', 'MAT700835', 5.00, '', '2025-04-11 08:41:38', 0000000001, NULL, NULL),
	(8, 'ingreso', 'MAT700835', 10.00, '', '2025-04-11 08:41:55', 0000000001, NULL, NULL),
	(9, 'salida', 'MAT700835', 8.00, '', '2025-04-11 09:12:45', 0000000001, NULL, NULL),
	(10, 'salida', 'MAT700835', 10.00, '', '2025-04-11 09:13:21', 0000000001, NULL, NULL),
	(11, 'ingreso', 'MAT700835', 50.00, 'prueba', '2025-04-11 09:20:09', 0000000001, NULL, NULL),
	(12, 'salida', 'MAT700835', 23.00, '', '2025-04-11 09:28:33', 0000000001, NULL, NULL),
	(13, 'ingreso', 'MAT369122', 500.00, '', '2025-04-11 11:44:55', 0000000001, NULL, NULL),
	(14, 'ingreso', 'MAT369122', 52.00, '', '2025-04-11 11:45:17', 0000000001, NULL, NULL);

-- Volcando estructura para tabla sisinventario.stock
DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id_material` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `cantidad_actual` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_movimiento` int DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `usuario` int(10) unsigned zerofill DEFAULT NULL,
  PRIMARY KEY (`id_material`),
  KEY `id_movimiento` (`id_movimiento`),
  CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id_material`),
  CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`id_movimiento`) REFERENCES `movimientos` (`id_movimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sisinventario.stock: ~0 rows (aproximadamente)
DELETE FROM `stock`;
INSERT INTO `stock` (`id_material`, `cantidad_actual`, `id_movimiento`, `fecha`, `usuario`) VALUES
	('MAT369122', 552.00, 14, '2025-04-11 11:45:17', 0000000001),
	('MAT700835', 40.00, 12, '2025-04-11 09:28:33', 0000000001);

-- Volcando estructura para tabla sisinventario.stock_historico
DROP TABLE IF EXISTS `stock_historico`;
CREATE TABLE IF NOT EXISTS `stock_historico` (
  `id_material` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cantidad_actual` decimal(10,2) NOT NULL DEFAULT '0.00',
  `id_movimiento` int DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `usuario` int(10) unsigned zerofill DEFAULT NULL,
  KEY `id_material` (`id_material`),
  KEY `id_movimiento` (`id_movimiento`),
  CONSTRAINT `stock_historico_ibfk_1` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id_material`),
  CONSTRAINT `stock_historico_ibfk_2` FOREIGN KEY (`id_movimiento`) REFERENCES `movimientos` (`id_movimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sisinventario.stock_historico: ~0 rows (aproximadamente)
DELETE FROM `stock_historico`;
INSERT INTO `stock_historico` (`id_material`, `cantidad_actual`, `id_movimiento`, `fecha`, `usuario`) VALUES
	('MAT700835', 50.00, 11, '2025-04-11 09:20:09', 0000000001),
	('MAT700835', 63.00, 11, '2025-04-11 09:26:58', 0000000001),
	('MAT700835', 40.00, 12, '2025-04-11 09:28:33', 0000000001),
	('MAT369122', 500.00, 13, '2025-04-11 11:44:55', 0000000001),
	('MAT369122', 552.00, 14, '2025-04-11 11:45:17', 0000000001);

-- Volcando estructura para tabla sisinventario.tipos_material
DROP TABLE IF EXISTS `tipos_material`;
CREATE TABLE IF NOT EXISTS `tipos_material` (
  `id_tipo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_crea` date NOT NULL,
  `usuario_crea` int(10) unsigned zerofill NOT NULL,
  `fecha_modifica` date DEFAULT NULL,
  `usuario_modifica` int(10) unsigned zerofill DEFAULT NULL,
  `estado` int NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sisinventario.tipos_material: ~8 rows (aproximadamente)
DELETE FROM `tipos_material`;
INSERT INTO `tipos_material` (`id_tipo`, `nombre`, `descripcion`, `fecha_crea`, `usuario_crea`, `fecha_modifica`, `usuario_modifica`, `estado`) VALUES
	(41, 'Cable Eléctrico', 'Cable para instalaciones eléctricas residenciales e industriales.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(42, 'Cable de Red', 'Cables UTP o FTP para redes de datos.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(43, 'Cable Coaxial', 'Cable utilizado en sistemas de televisión por cable y CCTV.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(44, 'Cable de Datos', 'Cables para transmisión de información entre dispositivos.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(45, 'Cable de Fibra Óptica', 'Alta velocidad y transmisión por luz, ideal para telecomunicaciones.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(46, 'Accesorios', 'Conectores, sujetadores y componentes adicionales para cables.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(47, 'Tubos Conduit', 'Tubería para canalizar cableado eléctrico.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(48, 'Canaletas', 'Sistemas de conducción externa de cables.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(49, 'Conectores', 'Conectores de diversos tipos para empalmes de cable.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(50, 'Cintas Aislantes', 'Aislantes para cableado, de colores y alta tensión.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(51, 'Cable Eléctrico #11', 'Cable para instalaciones eléctricas residenciales e industriales.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(52, 'Cable de Red #12', 'Cables UTP o FTP para redes de datos.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(53, 'Cable Coaxial #13', 'Cable utilizado en sistemas de televisión por cable y CCTV.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(54, 'Cable de Datos #14', 'Cables para transmisión de información entre dispositivos.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(55, 'Cable de Fibra Óptica #15', 'Alta velocidad y transmisión por luz, ideal para telecomunicaciones.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(56, 'Accesorios #16', 'Conectores, sujetadores y componentes adicionales para cables.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(57, 'Tubos Conduit #17', 'Tubería para canalizar cableado eléctrico.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(58, 'Canaletas #18', 'Sistemas de conducción externa de cables.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(59, 'Conectores #19', 'Conectores de diversos tipos para empalmes de cable.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(60, 'Cintas Aislantes #20', 'Aislantes para cableado, de colores y alta tensión.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(61, 'Cable Eléctrico #21', 'Cable para instalaciones eléctricas residenciales e industriales.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(62, 'Cable de Red #22', 'Cables UTP o FTP para redes de datos.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(63, 'Cable Coaxial #23', 'Cable utilizado en sistemas de televisión por cable y CCTV.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(64, 'Cable de Datos #24', 'Cables para transmisión de información entre dispositivos.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(65, 'Cable de Fibra Óptica #25', 'Alta velocidad y transmisión por luz, ideal para telecomunicaciones.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(66, 'Accesorios #26', 'Conectores, sujetadores y componentes adicionales para cables.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(67, 'Tubos Conduit #27', 'Tubería para canalizar cableado eléctrico.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(68, 'Canaletas #28', 'Sistemas de conducción externa de cables.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(69, 'Conectores #29', 'Conectores de diversos tipos para empalmes de cable.', '2025-04-07', 0000000001, NULL, NULL, 1),
	(70, 'Cintas Aislantes #30', 'Aislantes para cableado, de colores y alta tensión.', '2025-04-07', 0000000001, NULL, NULL, 1);

-- Volcando estructura para tabla sisinventario.unidades_medida
DROP TABLE IF EXISTS `unidades_medida`;
CREATE TABLE IF NOT EXISTS `unidades_medida` (
  `id_unidad` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_crea` date NOT NULL,
  `usuario_crea` int(10) unsigned zerofill NOT NULL,
  `fecha_modifica` date DEFAULT NULL,
  `usuario_modifica` int(10) unsigned zerofill DEFAULT NULL,
  `estado` int NOT NULL,
  PRIMARY KEY (`id_unidad`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sisinventario.unidades_medida: ~0 rows (aproximadamente)
DELETE FROM `unidades_medida`;
INSERT INTO `unidades_medida` (`id_unidad`, `nombre`, `descripcion`, `fecha_crea`, `usuario_crea`, `fecha_modifica`, `usuario_modifica`, `estado`) VALUES
	(73, 'Kilogramo', 'Unidad de masa equivalente a mil gramos', '2025-04-07', 0000000001, NULL, NULL, 1),
	(74, 'Gramo', 'Unidad básica de masa', '2025-04-07', 0000000001, NULL, NULL, 1),
	(75, 'Litro', 'Unidad de volumen para líquidos', '2025-04-07', 0000000002, NULL, NULL, 1),
	(76, 'Metro', 'Unidad básica de longitud', '2025-04-07', 0000000002, NULL, NULL, 1),
	(77, 'Centímetro', 'Unidad de medida de longitud menor al metro', '2025-04-07', 0000000001, NULL, NULL, 1),
	(78, 'Milímetro', 'Unidad de medida muy pequeña de longitud', '2025-04-07', 0000000002, NULL, NULL, 1),
	(79, 'Tonelada', 'Unidad de masa equivalente a 1000 kg', '2025-04-07', 0000000001, NULL, NULL, 1),
	(80, 'Galón', 'Unidad de volumen utilizada comúnmente en líquidos', '2025-04-07', 0000000001, NULL, NULL, 1),
	(81, 'Pulgada', 'Unidad de longitud usada en algunos países', '2025-04-07', 0000000001, NULL, NULL, 1),
	(82, 'Pie', 'Unidad de longitud equivalente a 30.48 cm', '2025-04-07', 0000000002, NULL, NULL, 1),
	(83, 'Unidad', 'Contador para piezas individuales', '2025-04-07', 0000000002, NULL, NULL, 1),
	(84, 'Caja', 'Agrupación de varias unidades', '2025-04-07', 0000000001, NULL, NULL, 1),
	(85, 'Paquete', 'Conjunto empaquetado de productos', '2025-04-07', 0000000001, NULL, NULL, 1),
	(86, 'Docena', 'Conjunto de doce unidades', '2025-04-07', 0000000001, NULL, NULL, 1),
	(87, 'Par', 'Conjunto de dos unidades relacionadas', '2025-04-07', 0000000002, '2025-04-11', 0000000001, 1);

-- Volcando estructura para tabla sisinventario.usuarios
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `fecha_caduca` date DEFAULT NULL,
  `usuario_crea` int DEFAULT NULL,
  `fecha_crea` date NOT NULL,
  `usuario_modifica` int DEFAULT NULL,
  `fecha_modifica` date DEFAULT NULL,
  `facilidad` varchar(15) DEFAULT NULL,
  `n_login` int DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=ascii;

-- Volcando datos para la tabla sisinventario.usuarios: ~2 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id_usuario`, `usuario`, `pass`, `fecha_caduca`, `usuario_crea`, `fecha_crea`, `usuario_modifica`, `fecha_modifica`, `facilidad`, `n_login`, `email`) VALUES
	(0000000001, 'admin', 'WVdSdGFXND0=', '2030-12-31', 0, '2025-04-07', 0, '2025-04-07', 'Administrador', 0, NULL),
	(0000000006, 'sistemas', 'YzJsemRHVnRZWE09', '2025-04-07', 0, '2025-04-07', 0, '2025-04-07', 'Administrador', 0, 'admin@gmail.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
