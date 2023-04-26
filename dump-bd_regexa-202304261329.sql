-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: bd_regexa
-- ------------------------------------------------------
-- Server version	5.7.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `areas`
--

DROP TABLE IF EXISTS `areas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `areas` (
  `idarea` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '0',
  `fecha_reg` datetime NOT NULL,
  `fecha_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idarea`),
  UNIQUE KEY `areas_un` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='contiene los datos de las areas u dependencias.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pacientes`
--

DROP TABLE IF EXISTS `pacientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pacientes` (
  `idpaciente` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(8) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `fecha_reg` datetime NOT NULL,
  `fecha_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpaciente`),
  UNIQUE KEY `pacientes_un` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COMMENT='contine los datos del paciente';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `profesionales`
--

DROP TABLE IF EXISTS `profesionales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesionales` (
  `idprofesional` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(8) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `profesion` varchar(250) NOT NULL,
  `cmp` varchar(100) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '0',
  `fecha_reg` datetime NOT NULL,
  `fecha_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idprofesional`),
  UNIQUE KEY `profesionales_un1` (`dni`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Contine los datos de los profesionales';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reg_atenciones`
--

DROP TABLE IF EXISTS `reg_atenciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reg_atenciones` (
  `idatencion` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_atencion` date NOT NULL,
  `turno` varchar(100) NOT NULL,
  `n_solicitud` varchar(100) NOT NULL,
  `profecional_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `cantidad_ex` int(11) NOT NULL,
  `observaciones` varchar(1000) DEFAULT NULL,
  `fecha_reg` datetime NOT NULL,
  `fecha_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paciente_id` int(11) NOT NULL,
  PRIMARY KEY (`idatencion`),
  KEY `reg_atenciones_FK` (`profecional_id`),
  KEY `reg_atenciones_FK_1` (`paciente_id`),
  KEY `reg_atenciones_FK_2` (`area_id`),
  CONSTRAINT `reg_atenciones_FK` FOREIGN KEY (`profecional_id`) REFERENCES `profesionales` (`idprofesional`),
  CONSTRAINT `reg_atenciones_FK_1` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`idpaciente`),
  CONSTRAINT `reg_atenciones_FK_2` FOREIGN KEY (`area_id`) REFERENCES `areas` (`idarea`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='contine todos los registros de atencion de los pacientes y el profesional que los atendio, incluyendo examenes y la cantidad misma de estas.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `dni` varchar(8) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `celular` varchar(9) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  `foto` varchar(500) DEFAULT NULL,
  `rol` varchar(100) NOT NULL,
  `fecha_reg` datetime NOT NULL,
  `fecha_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `usuarios_un1` (`dni`),
  UNIQUE KEY `usuarios_un2` (`correo`),
  UNIQUE KEY `usuarios_un3` (`usuario`),
  UNIQUE KEY `usuarios_un4` (`celular`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Contine los datos de los usuarios que podran acceder al sistema.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'bd_regexa'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-26 13:29:39
