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

-- Volcando estructura para tabla sisinventario.tipos_material
DROP TABLE IF EXISTS `tipos_material`;
CREATE TABLE IF NOT EXISTS `tipos_material` (
  `id_tipo` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_crea` date NOT NULL,
  `fecha_modifica` date DEFAULT NULL,
  `estado` int NOT NULL,
  PRIMARY KEY (`id_tipo`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla sisinventario.tipos_material: ~30 rows (aproximadamente)
DELETE FROM `tipos_material`;
INSERT INTO `tipos_material` (`id_tipo`, `nombre`, `descripcion`, `fecha_crea`, `fecha_modifica`, `estado`) VALUES
	(41, 'Cable Eléctrico', 'Cable para instalaciones eléctricas residenciales e industriales.', '2025-04-07', NULL, 1),
	(42, 'Cable de Red', 'Cables UTP o FTP para redes de datos.', '2025-04-07', NULL, 1),
	(43, 'Cable Coaxial', 'Cable utilizado en sistemas de televisión por cable y CCTV.', '2025-04-07', NULL, 1),
	(44, 'Cable de Datos', 'Cables para transmisión de información entre dispositivos.', '2025-04-07', NULL, 1),
	(45, 'Cable de Fibra Óptica', 'Alta velocidad y transmisión por luz, ideal para telecomunicaciones.', '2025-04-07', NULL, 1),
	(46, 'Accesorios', 'Conectores, sujetadores y componentes adicionales para cables.', '2025-04-07', NULL, 1),
	(47, 'Tubos Conduit', 'Tubería para canalizar cableado eléctrico.', '2025-04-07', NULL, 1),
	(48, 'Canaletas', 'Sistemas de conducción externa de cables.', '2025-04-07', NULL, 1),
	(49, 'Conectores', 'Conectores de diversos tipos para empalmes de cable.', '2025-04-07', NULL, 1),
	(50, 'Cintas Aislantes', 'Aislantes para cableado, de colores y alta tensión.', '2025-04-07', NULL, 1),
	(51, 'Cable Eléctrico #11', 'Cable para instalaciones eléctricas residenciales e industriales.', '2025-04-07', NULL, 1),
	(52, 'Cable de Red #12', 'Cables UTP o FTP para redes de datos.', '2025-04-07', NULL, 1),
	(53, 'Cable Coaxial #13', 'Cable utilizado en sistemas de televisión por cable y CCTV.', '2025-04-07', NULL, 1),
	(54, 'Cable de Datos #14', 'Cables para transmisión de información entre dispositivos.', '2025-04-07', NULL, 1),
	(55, 'Cable de Fibra Óptica #15', 'Alta velocidad y transmisión por luz, ideal para telecomunicaciones.', '2025-04-07', NULL, 1),
	(56, 'Accesorios #16', 'Conectores, sujetadores y componentes adicionales para cables.', '2025-04-07', NULL, 1),
	(57, 'Tubos Conduit #17', 'Tubería para canalizar cableado eléctrico.', '2025-04-07', NULL, 1),
	(58, 'Canaletas #18', 'Sistemas de conducción externa de cables.', '2025-04-07', NULL, 1),
	(59, 'Conectores #19', 'Conectores de diversos tipos para empalmes de cable.', '2025-04-07', NULL, 1),
	(60, 'Cintas Aislantes #20', 'Aislantes para cableado, de colores y alta tensión.', '2025-04-07', NULL, 1),
	(61, 'Cable Eléctrico #21', 'Cable para instalaciones eléctricas residenciales e industriales.', '2025-04-07', NULL, 1),
	(62, 'Cable de Red #22', 'Cables UTP o FTP para redes de datos.', '2025-04-07', NULL, 1),
	(63, 'Cable Coaxial #23', 'Cable utilizado en sistemas de televisión por cable y CCTV.', '2025-04-07', NULL, 1),
	(64, 'Cable de Datos #24', 'Cables para transmisión de información entre dispositivos.', '2025-04-07', NULL, 1),
	(65, 'Cable de Fibra Óptica #25', 'Alta velocidad y transmisión por luz, ideal para telecomunicaciones.', '2025-04-07', NULL, 1),
	(66, 'Accesorios #26', 'Conectores, sujetadores y componentes adicionales para cables.', '2025-04-07', NULL, 1),
	(67, 'Tubos Conduit #27', 'Tubería para canalizar cableado eléctrico.', '2025-04-07', NULL, 1),
	(68, 'Canaletas #28', 'Sistemas de conducción externa de cables.', '2025-04-07', NULL, 1),
	(69, 'Conectores #29', 'Conectores de diversos tipos para empalmes de cable.', '2025-04-07', NULL, 1),
	(70, 'Cintas Aislantes #30', 'Aislantes para cableado, de colores y alta tensión.', '2025-04-07', NULL, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=ascii;

-- Volcando datos para la tabla sisinventario.usuarios: ~0 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id_usuario`, `usuario`, `pass`, `fecha_caduca`, `usuario_crea`, `fecha_crea`, `usuario_modifica`, `fecha_modifica`, `facilidad`, `n_login`, `email`) VALUES
	(0000000001, 'admin', 'WVdSdGFXND0=', '2030-12-31', 0, '2025-04-07', 0, '2025-04-07', 'Administrador', 0, NULL),
	(0000000006, 'sistemas', 'YzJsemRHVnRZWE09', '2025-04-07', 0, '2025-04-07', 0, '2025-04-07', 'Administrador', 0, 'admin@gmail.com');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
