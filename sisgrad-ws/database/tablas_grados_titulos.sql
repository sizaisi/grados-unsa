-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: siac_pruebas
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gt_archivo`
--

DROP TABLE IF EXISTS `gt_archivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_archivo` (
  `idrecurso` int(11) NOT NULL,
  `nombre_asignado` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_archivo` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `mime` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `data` longblob NOT NULL,
  PRIMARY KEY (`idrecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_archivo`
--

LOCK TABLES `gt_archivo` WRITE;
/*!40000 ALTER TABLE `gt_archivo` DISABLE KEYS */;
INSERT INTO `gt_archivo` VALUES (16,'Plan de tesis','plan de tesis.pdf','application/pdf','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WnEPPqQzNRfBRc0R4LDCjuCiJQE3obnoGS1p1HVRZgpOU2ej/rfmqe72Tdc2q2a3oW6RvVwknG6UvlivPmuQXr2FOHGE+ZCjt1BCd02rxUIHP26m76dKlUkndHdgK0auld5UITEA8bL5BBvs3p1tvzrZz5T5wESQOcFE9ByoCJ4EFUM5CFxECyIDb8oY+PNNmUiRKM+YIxeWiEhNLBEUNcEzUhM9KWpQOfPUoNVTeSKhxefFRKJ82O1rqP+Heruv+l2hWj/+uWW7+vFwvN7cwZZOXE/G4hJpicWFoCV6RlqiJ0HLUIQCLdGS0DJRlqJntKS5pt1L2/KCXEOtPhw6rBn7vunmZvjCafFqcfWf2V846QL+hiR15SXXcm5B689lhTudSF1mBWgnWIi65B7LDfrCyS0AzuXTF6QWDstQ2TXkaK5HvnBa/LfPquv+PpRq8t03HEphCIXJNHBAQXCe4bkjhmhBIJw+jKsnJl0vjrGgKsnxQjAGR9u+g6UrCQTRWATNSHCB9CWhhRkHaGgNVHzchwilVufjc/tvF55l98eq2fvvz3Y121T7rlke1kTA3Ls9yzVG5eVMoXLoRVEiVNGSoDovZ+QZLGmoXdMBhX4i1HaeDnORCVVcrEOfIUiH3kI0FmE+5OgtlIBdXlgs4Nx9qkl8oqgLd7sDz7omZuS7sXf1dtVsGtgvWlYtq9Uf7j5zpo4HCk5kM6Xj/rmBg+BJcHA6Q5pQk3OezIA8iTlPZ0DpT8x5OgPypHDGuhaCHS1JtCeEEz2jBXn2NQNULVWaEiK53v7cLPdj+6B7X2L42OvTu/vF99gBpsxd2mEHPAe7qpfrCloSV5H27apyX74024e22xy/qujqx2a37yr4n3rHPtedu1vqKvaFhU8noK652/S6W7dsA2Wt3dQuh/tvXncVNMftFjyXbdfVu6cWstx9vLrL8CqFcC9DNVPGvUUaO2DfvHu7YFfXb9jizYe3t3cJJ4BRgtwS5+TLh67+5dA8Vd9Cm+tW+/qwbtr+TYDkogxD/Q/m7AuYCmVuZHN0cmVhbQplbmRvYmoKeHJlZgowIDEyCjAwMDAwMDAwMDAgNjU1MzUgZiAKMDAwMDAwMDAwOSAwMDAwMCBuIAowMDAwMDAwMDc0IDAwMDAwIG4gCjAwMDAwMDAxMjAgMDAwMDAgbiAKMDAwMDAwMDI5MSAwMDAwMCBuIAowMDAwMDAwMzIwIDAwMDAwIG4gCjAwMDAwMDA1NTkgMDAwMDAgbiAKMDAwMDAwMDY2MiAwMDAwMCBuIAowMDAwMDA1OTMyIDAwMDAwIG4gCjAwMDAwMDYwMzkgMDAwMDAgbiAKMDAwMDAwNjE1MSAwMDAwMCBuIAowMDAwMDA2MjU2IDAwMDAwIG4gCnRyYWlsZXIKPDwKL1NpemUgMTIKL1Jvb3QgMSAwIFIKL0luZm8gNSAwIFIKL0lEWzwzMTcwZDQzNDBjNTg4MmJmOWJhMDVhNTY3ZGJiMTdlMT48MzE3MGQ0MzQwYzU4ODJiZjliYTA1YTU2N2RiYjE3ZTE+XQo+PgpzdGFydHhyZWYKODg5OAolJUVPRgo=');
/*!40000 ALTER TABLE `gt_archivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_expediente`
--

DROP TABLE IF EXISTS `gt_expediente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_expediente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idgrado_procedimiento` int(11) NOT NULL,
  `nues` char(3) COLLATE utf8_spanish_ci NOT NULL,
  `espe` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `codigo` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `titulo` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `url_repo` varchar(256) COLLATE utf8_spanish_ci DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `fing` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fact` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_expediente`
--

LOCK TABLES `gt_expediente` WRITE;
/*!40000 ALTER TABLE `gt_expediente` DISABLE KEYS */;
INSERT INTO `gt_expediente` VALUES (11,2,'446','0','GT-UNSA-0000011','Reconocimiento de patrones de deserción de estudiantes universitarios basados en modelos de clasificación','http://bibliotecas.unsa.edu.pe/bitstream/handle/UNSA/9419/ISzavaaj.pdf','2020-05-23 12:54:03','enviado','2020-05-23 18:07:44','2020-05-25 22:15:24'),(12,2,'450','0','GT-UNSA-0000012','Sistema de reconocimiento de rostros con covid19',NULL,'2020-04-09 00:00:00','En proceso','2020-05-23 18:07:44','2020-05-23 18:09:47');
/*!40000 ALTER TABLE `gt_expediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_grado_modalidad`
--

DROP TABLE IF EXISTS `gt_grado_modalidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_grado_modalidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idgrado_titulo` int(11) NOT NULL,
  `idmodalidad_obtencion` int(11) NOT NULL,
  `condicion` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_grado_modalidad`
--

LOCK TABLES `gt_grado_modalidad` WRITE;
/*!40000 ALTER TABLE `gt_grado_modalidad` DISABLE KEYS */;
INSERT INTO `gt_grado_modalidad` VALUES (1,1,5,1),(2,2,5,1),(3,3,1,1),(4,3,2,1),(5,3,3,1),(6,4,5,1),(7,5,1,1),(8,6,5,1),(9,7,1,1),(10,8,5,1),(11,9,1,1),(12,10,5,1),(13,7,5,1),(14,3,6,1);
/*!40000 ALTER TABLE `gt_grado_modalidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_grado_procedimiento`
--

DROP TABLE IF EXISTS `gt_grado_procedimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_grado_procedimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idgrado_modalidad` int(11) NOT NULL,
  `idprocedimiento` int(11) NOT NULL,
  `idrol_area` int(11) NOT NULL,
  `tipo_rol` enum('asesor','jurado') COLLATE utf8_spanish_ci DEFAULT NULL,
  `url_formulario` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `orden` tinyint(4) DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_grado_procedimiento`
--

LOCK TABLES `gt_grado_procedimiento` WRITE;
/*!40000 ALTER TABLE `gt_grado_procedimiento` DISABLE KEYS */;
INSERT INTO `gt_grado_procedimiento` VALUES (1,4,1,1,'','tp_st_registrar_proyecto_grado',1,1),(2,4,2,5,'','verificar_requisitos_grado',2,1),(3,4,3,2,'','verificar_pertinencia_tema',3,1),(4,4,4,2,'','designar_asesor_comision_calificacion',4,1),(5,4,5,4,'asesor','resolver_asignacion_asesoria_proyecto',5,1),(6,4,6,5,'','emitir_resolucion_asignacion_asesor_tema',6,1),(7,4,7,4,'asesor','dar_conformidad_asesoramiento_proyecto',7,1),(8,4,8,5,'','nombrar_jurado_adjuntar_resolucion',8,1),(9,4,9,4,'jurado','revisar_documentacion_proyecto',9,1),(10,4,10,1,'','tp_st_corregir_observaciones_jurado',10,1),(11,4,11,4,'jurado','dictaminar_aprobacion_proyecto',11,1),(12,4,12,5,'','verificar_pagos_adjuntar_documentos',12,1),(13,4,13,4,'jurado','emitir_acta_dictamen_sustentacion',13,1),(14,4,14,4,'jurado','dictaminar_resultado_sustentacion',14,1),(15,4,15,1,'','tp_st_corregir_observaciones_post_sustentacion',15,1),(16,4,16,4,'jurado','emitir_acta_conformidad_redaccion_trabajo',16,1),(17,4,17,7,'','tp_st_mostrar_tesis_pdf_copiar_url_repositorio',17,1),(18,4,18,5,'','aprobar_consejo_facultad_autorizar_emision_diploma',18,1),(19,4,19,6,'','generar_imprimir_diploma',19,1);
/*!40000 ALTER TABLE `gt_grado_procedimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_grado_titulo`
--

DROP TABLE IF EXISTS `gt_grado_titulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_grado_titulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `codigo` char(1) COLLATE utf8_spanish_ci NOT NULL,
  `idprereq` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `condicion` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_grado_titulo`
--

LOCK TABLES `gt_grado_titulo` WRITE;
/*!40000 ALTER TABLE `gt_grado_titulo` DISABLE KEYS */;
INSERT INTO `gt_grado_titulo` VALUES (1,'EGRESADO','Z',0,NULL,1),(2,'BACHILLER','Z',1,'',1),(3,'TÍTULO PROFESIONAL','Z',2,'',1),(4,'EGRESADO_MAG','X',0,NULL,1),(5,'MAGISTER','X',4,NULL,1),(6,'EGRESADO_DOC','X',0,NULL,1),(7,'DOCTOR','X',6,'',1),(8,'EGRESADO_2ESP','Y',0,'',1),(9,'SEGUNDA ESPECIALIDAD','Y',8,NULL,1),(10,'EGRESADO_COMP','W',0,NULL,1);
/*!40000 ALTER TABLE `gt_grado_titulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_graduando`
--

DROP TABLE IF EXISTS `gt_graduando`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_graduando` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cui` char(8) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_spanish_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL,
  `provider_id` varchar(191) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono_fijo` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono_movil` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL,
  `direccion` varchar(150) COLLATE utf8_spanish_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_spanish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gt_graduando_email_unique` (`email`),
  UNIQUE KEY `gt_graduando_cui_unique` (`cui`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_graduando`
--

LOCK TABLES `gt_graduando` WRITE;
/*!40000 ALTER TABLE `gt_graduando` DISABLE KEYS */;
INSERT INTO `gt_graduando` VALUES (22,'20002728','rsiza@unsa.edu.pe',NULL,NULL,'google','116820074797911167404','054418560','996961009','Calle J. C. Mariategui 509 - Alto Selva Alegre',NULL,'2020-04-07 18:34:17','2020-04-08 03:03:08'),(23,'20143489','cchavez@unsa.edu.pe',NULL,'$2y$10$HVCLr5/dPBJmm57pLH7euu2BHAaCTOwedez1f0PLi.UIMMGR82TmO',NULL,NULL,'414152','965339933','Calle los arces 104, Mariano Melgar',NULL,'2020-04-09 17:19:21','2020-04-09 17:20:46');
/*!40000 ALTER TABLE `gt_graduando` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`webmast`@`localhost`*/ /*!50003 TRIGGER tr_insertUsuario AFTER INSERT ON GT_GRADUANDO FOR EACH ROW BEGIN
 INSERT INTO GT_USUARIO(codi_usuario, idrol_area, tipo)
	VALUES(new.cui, 1, 'Estudiante');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `gt_graduando_expediente`
--

DROP TABLE IF EXISTS `gt_graduando_expediente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_graduando_expediente` (
  `idgraduando` int(11) NOT NULL,
  `idexpediente` int(11) NOT NULL,
  PRIMARY KEY (`idgraduando`,`idexpediente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_graduando_expediente`
--

LOCK TABLES `gt_graduando_expediente` WRITE;
/*!40000 ALTER TABLE `gt_graduando_expediente` DISABLE KEYS */;
INSERT INTO `gt_graduando_expediente` VALUES (22,11),(23,12);
/*!40000 ALTER TABLE `gt_graduando_expediente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_modalidad_obtencion`
--

DROP TABLE IF EXISTS `gt_modalidad_obtencion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_modalidad_obtencion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `condicion` tinyint(4) NOT NULL,
  `fing` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `fact` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_modalidad_obtencion`
--

LOCK TABLES `gt_modalidad_obtencion` WRITE;
/*!40000 ALTER TABLE `gt_modalidad_obtencion` DISABLE KEYS */;
INSERT INTO `gt_modalidad_obtencion` VALUES (1,'TRABAJO DE INVESTIGACIÓN',1,'2019-12-18 01:23:08','2019-12-18 01:23:11'),(2,'SUSTENTACIÓN DE TESIS',1,'2019-12-18 01:23:08','2019-12-18 01:23:11'),(3,'TRABAJO DE SUFICIENCIA PROFESIONAL',1,'2019-12-18 01:23:08','2019-12-18 01:23:11'),(4,'TRABAJO ACADÉMICO',1,'2019-12-18 01:23:08','2019-12-18 01:23:11'),(5,'AUTOMÁTICO',1,'2019-12-18 01:23:08','2019-12-18 01:23:11'),(6,'SERVICIOS PROFESIONALES',1,'2019-12-18 01:23:08','2019-12-18 01:23:11');
/*!40000 ALTER TABLE `gt_modalidad_obtencion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_movimiento`
--

DROP TABLE IF EXISTS `gt_movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_movimiento` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idexpediente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `idruta` int(11) NOT NULL,
  `idmov_anterior` bigint(20) NOT NULL,
  `aceptado` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_movimiento`
--

LOCK TABLES `gt_movimiento` WRITE;
/*!40000 ALTER TABLE `gt_movimiento` DISABLE KEYS */;
INSERT INTO `gt_movimiento` VALUES (181,11,1922,'2020-05-23 12:54:03',2,0,1);
/*!40000 ALTER TABLE `gt_movimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_observacion`
--

DROP TABLE IF EXISTS `gt_observacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_observacion` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(512) COLLATE utf8_spanish_ci NOT NULL,
  `idgrado_proc` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idexpediente` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_observacion`
--

LOCK TABLES `gt_observacion` WRITE;
/*!40000 ALTER TABLE `gt_observacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `gt_observacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_observaciones`
--

DROP TABLE IF EXISTS `gt_observaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_observaciones` (
  `idrecurso` int(11) NOT NULL,
  `descripcion` varchar(256) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`idrecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_observaciones`
--

LOCK TABLES `gt_observaciones` WRITE;
/*!40000 ALTER TABLE `gt_observaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `gt_observaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_persona`
--

DROP TABLE IF EXISTS `gt_persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_persona` (
  `idrecurso` int(11) NOT NULL,
  `iddocente` int(11) NOT NULL,
  `tipo` enum('asesor','presidente','secretario','vocal','suplente') COLLATE utf8_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idrecurso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_persona`
--

LOCK TABLES `gt_persona` WRITE;
/*!40000 ALTER TABLE `gt_persona` DISABLE KEYS */;
/*!40000 ALTER TABLE `gt_persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_procedimiento`
--

DROP TABLE IF EXISTS `gt_procedimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_procedimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8_spanish_ci DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_procedimiento`
--

LOCK TABLES `gt_procedimiento` WRITE;
/*!40000 ALTER TABLE `gt_procedimiento` DISABLE KEYS */;
INSERT INTO `gt_procedimiento` VALUES (1,'Registrar proyecto de grado','El graduando registra su proyecto de grado únicamente en formato pdf',1),(2,'Verificar requisitos de grado','La facultad se encarga de verificar los requisitos para optar por el grado',1),(3,'Verificar la pertinencia del tema','La Unidad de Investigación se encarga de verificar que el tema pertenezca a la competencia de la Escuela',1),(4,'Designar asesor y comisión de calificación de borrador','La Unidad de Investigación se encarga de designar el asesor y la comisión de evaluación del borrador',1),(5,'Resolver asignación de asesoría de proyecto','El asesor se encarga de la aceptación para la designación',1),(6,'Emitir resolución de asignación de asesor y tema','La facultad se encarga de emitir formalmente las designaciones para cada tema',1),(7,'Dar conformidad de asesoramiento de proyecto','El asesor se encarga de emitir su juicio de conformidad de la asesoria',1),(8,'Nombrar jurado y adjuntar resolución','La Facultad se encarga del nombramiento de la comisión de evaluación de tesis',1),(9,'Revisar documentación de proyecto','El jurado de sustentación se encarga de revisar la documentación del proyecto',1),(10,'Corregir observaciones del jurado','El graduando de encarga de corregir las observaciones hechas al borrador de tesis',1),(11,'Dictaminar aprobación del proyecto','El jurado dictamina la aprobación del borrador de tesis',1),(12,'Verificar pagos y adjuntar documentos, declaración jurada de','La facultad se encarga de verificar los pagos y requisitos necesarios para la acceder a la sustentación de tesis',1),(13,'Emitir acta de dictamen','El jurado se encarga de emitir el acta para ir a la sustentación',1),(14,'Dictaminar resultado de sustentación','El jurado debe dictaminar el resultado de la sustentación',1),(15,'Corregir observaciones post-sustentación','El graduando levanta las observaciones hechas en la sustentación',1),(16,'Emitir acta de conformidad de redacción del trabajo','El jurado se encarga de emitir el acta de conformidad de redacción del trabajo',1),(17,'Mostrar Tesis en PDF y copiar url repositorio','El área de repositorio institucional se encarga de generar y copiar la url de la tesis subida al repositorio digital',1),(18,'Aprobar en consejo de facultad y  autorizar de emisión de di','La facultad en su consejo se encarga de autorizar la emisión del diploma',1),(19,'Generar e imprimir diploma','La oficina de grados y títulos se encargar de generar e imprimir el diploma ',1);
/*!40000 ALTER TABLE `gt_procedimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_recurso`
--

DROP TABLE IF EXISTS `gt_recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_recurso` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `idexpediente` int(11) NOT NULL,
  `idgrado_proc` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idmovimiento` int(11) DEFAULT NULL,
  `idruta` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_recurso`
--

LOCK TABLES `gt_recurso` WRITE;
/*!40000 ALTER TABLE `gt_recurso` DISABLE KEYS */;
INSERT INTO `gt_recurso` VALUES (16,11,1,1922,181,1);
/*!40000 ALTER TABLE `gt_recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_rol_area`
--

DROP TABLE IF EXISTS `gt_rol_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_rol_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `condicion` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_rol_area`
--

LOCK TABLES `gt_rol_area` WRITE;
/*!40000 ALTER TABLE `gt_rol_area` DISABLE KEYS */;
INSERT INTO `gt_rol_area` VALUES (1,'Graduando','Activo'),(2,'Unidad de Investigación','Activo'),(3,'Escuela','Activo'),(4,'Asesor-Jurado','Activo'),(5,'Facultad','Activo'),(6,'Of. Grados y Títulos','Activo'),(7,'Repositorio Institucional','Activo');
/*!40000 ALTER TABLE `gt_rol_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_ruta`
--

DROP TABLE IF EXISTS `gt_ruta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_ruta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idgradproc_origen` int(11) NOT NULL,
  `idgradproc_destino` int(11) NOT NULL,
  `etiqueta` enum('iniciar','enviar','derivar','cambiar','devolver','denegar','observar','rechazar','aceptar','aprobar','finalizar') COLLATE utf8_spanish_ci NOT NULL,
  `condicion` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_ruta`
--

LOCK TABLES `gt_ruta` WRITE;
/*!40000 ALTER TABLE `gt_ruta` DISABLE KEYS */;
INSERT INTO `gt_ruta` VALUES (1,0,1,'iniciar',1),(2,1,2,'enviar',1),(3,2,1,'denegar',1),(4,2,3,'aprobar',1),(5,3,1,'denegar',1),(6,3,4,'aprobar',1),(7,4,5,'derivar',1),(8,5,4,'denegar',1),(9,5,6,'aceptar',1),(10,6,7,'derivar',1),(11,7,0,'rechazar',1),(12,7,8,'aprobar',1),(13,8,9,'derivar',1),(14,9,10,'observar',1),(15,9,11,'aprobar',1),(16,10,11,'enviar',1),(17,11,8,'denegar',1),(18,11,0,'rechazar',1),(19,11,12,'aprobar',1),(20,12,13,'derivar',1),(21,13,14,'derivar',1),(22,14,15,'observar',1),(23,14,16,'aprobar',1),(24,15,16,'enviar',1),(25,16,18,'derivar',1),(26,17,18,'derivar',1),(27,18,19,'derivar',1),(28,19,0,'finalizar',1);
/*!40000 ALTER TABLE `gt_ruta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_usuario`
--

DROP TABLE IF EXISTS `gt_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codi_usuario` varchar(16) COLLATE utf8_spanish_ci DEFAULT NULL,
  `idrol_area` int(11) NOT NULL COMMENT 'Graduando, Escuela, Unidad de nvestigación, Asesor - Jurado,\nFacultad',
  `tipo` enum('Administrativo','Docente','Estudiante') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Administrativo, Docente, Estudiante',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3972 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_usuario`
--

LOCK TABLES `gt_usuario` WRITE;
/*!40000 ALTER TABLE `gt_usuario` DISABLE KEYS */;
INSERT INTO `gt_usuario` VALUES (1922,'20002728',1,'Estudiante'),(1923,'fips',5,'Administrativo'),(1924,'4610',3,'Administrativo'),(1925,'5010',3,'Administrativo'),(1926,'uifips',2,'Administrativo'),(1927,'grad3',6,'Administrativo'),(1928,'0003_1',4,'Docente'),(1929,'0004_1',4,'Docente'),(1930,'0005_1',4,'Docente'),(1931,'0016_1',4,'Docente'),(1932,'0020_1',4,'Docente'),(1933,'0021_1',4,'Docente'),(1934,'0024_1',4,'Docente'),(1935,'0025_1',4,'Docente'),(1936,'0030_1',4,'Docente'),(1937,'0036_1',4,'Docente'),(1938,'0037_1',4,'Docente'),(1939,'0040_1',4,'Docente'),(1940,'0048_1',4,'Docente'),(1941,'0051_1',4,'Docente'),(1942,'0056_1',4,'Docente'),(1943,'0057_1',4,'Docente'),(1944,'0059',4,'Docente'),(1945,'0062_1',4,'Docente'),(1946,'0072_1',4,'Docente'),(1947,'0073',4,'Docente'),(1948,'0077_1',4,'Docente'),(1949,'0079_1',4,'Docente'),(1950,'0083_1',4,'Docente'),(1951,'0088_1',4,'Docente'),(1952,'0090_1',4,'Docente'),(1953,'0093_1',4,'Docente'),(1954,'0100_1',4,'Docente'),(1955,'0103_1',4,'Docente'),(1956,'0107_1',4,'Docente'),(1957,'0108_1',4,'Docente'),(1958,'0110',4,'Docente'),(1959,'0112_1',4,'Docente'),(1960,'0113_1',4,'Docente'),(1961,'0114_1',4,'Docente'),(1962,'0116_1',4,'Docente'),(1963,'0118_1',4,'Docente'),(1964,'0119_1',4,'Docente'),(1965,'0122_1',4,'Docente'),(1966,'0123_1',4,'Docente'),(1967,'0124_1',4,'Docente'),(1968,'0125_1',4,'Docente'),(1969,'0130_1',4,'Docente'),(1970,'0133_1',4,'Docente'),(1971,'0135_1',4,'Docente'),(1972,'0138',4,'Docente'),(1973,'0139',4,'Docente'),(1974,'0142_1',4,'Docente'),(1975,'0143_1',4,'Docente'),(1976,'0144_1',4,'Docente'),(1977,'0149_1',4,'Docente'),(1978,'0156_1',4,'Docente'),(1979,'0157_1',4,'Docente'),(1980,'0158_1',4,'Docente'),(1981,'0160_1',4,'Docente'),(1982,'0161_1',4,'Docente'),(1983,'0169_1',4,'Docente'),(1984,'0173_1',4,'Docente'),(1985,'0174_1',4,'Docente'),(1986,'0175_1',4,'Docente'),(1987,'0183_1',4,'Docente'),(1988,'0184',4,'Docente'),(1989,'0187_1',4,'Docente'),(1990,'0192_1',4,'Docente'),(1991,'0194_1',4,'Docente'),(1992,'0195_1',4,'Docente'),(1993,'0203_1',4,'Docente'),(1994,'0204',4,'Docente'),(1995,'0206_1',4,'Docente'),(1996,'0209_1',4,'Docente'),(1997,'020DC1',4,'Docente'),(1998,'0211_1',4,'Docente'),(1999,'0216',4,'Docente'),(2000,'0220_1',4,'Docente'),(2001,'0223_1',4,'Docente'),(2002,'0224_1',4,'Docente'),(2003,'0229_1',4,'Docente'),(2004,'0230_1',4,'Docente'),(2005,'0232_1',4,'Docente'),(2006,'0236_1',4,'Docente'),(2007,'0238_1',4,'Docente'),(2008,'0239_1',4,'Docente'),(2009,'0240_1',4,'Docente'),(2010,'0241_1',4,'Docente'),(2011,'0245',4,'Docente'),(2012,'0247_1',4,'Docente'),(2013,'0262_1',4,'Docente'),(2014,'0263_1',4,'Docente'),(2015,'0274_1',4,'Docente'),(2016,'0275',4,'Docente'),(2017,'0284_1',4,'Docente'),(2018,'0285_1',4,'Docente'),(2019,'0286_1',4,'Docente'),(2020,'0287_1',4,'Docente'),(2021,'0293_1',4,'Docente'),(2022,'0294',4,'Docente'),(2023,'0297_1',4,'Docente'),(2024,'0301_1',4,'Docente'),(2025,'0304_1',4,'Docente'),(2026,'0305_1',4,'Docente'),(2027,'0312_1',4,'Docente'),(2028,'0317_1',4,'Docente'),(2029,'0318_1',4,'Docente'),(2030,'0319_1',4,'Docente'),(2031,'0326_1',4,'Docente'),(2032,'0346_1',4,'Docente'),(2033,'0348_1',4,'Docente'),(2034,'0351_1',4,'Docente'),(2035,'0352_1',4,'Docente'),(2036,'0355_1',4,'Docente'),(2037,'0370_1',4,'Docente'),(2038,'0374_1',4,'Docente'),(2039,'0376_1',4,'Docente'),(2040,'0380_1',4,'Docente'),(2041,'0381_1',4,'Docente'),(2042,'0382_1',4,'Docente'),(2043,'0383_1',4,'Docente'),(2044,'0387_1',4,'Docente'),(2045,'0393',4,'Docente'),(2046,'0396_1',4,'Docente'),(2047,'0407_1',4,'Docente'),(2048,'0420_1',4,'Docente'),(2049,'0421_1',4,'Docente'),(2050,'0427_1',4,'Docente'),(2051,'0434_1',4,'Docente'),(2052,'0443_1',4,'Docente'),(2053,'0446_1',4,'Docente'),(2054,'0447_1',4,'Docente'),(2055,'0450_1',4,'Docente'),(2056,'0454_1',4,'Docente'),(2057,'0457_1',4,'Docente'),(2058,'0466_1',4,'Docente'),(2059,'0473_1',4,'Docente'),(2060,'0474_1',4,'Docente'),(2061,'0477_1',4,'Docente'),(2062,'0479_1',4,'Docente'),(2063,'0484_1',4,'Docente'),(2064,'0485_1',4,'Docente'),(2065,'0487_1',4,'Docente'),(2066,'0489_1',4,'Docente'),(2067,'0491_1',4,'Docente'),(2068,'0495_1',4,'Docente'),(2069,'0497_1',4,'Docente'),(2070,'0500_1',4,'Docente'),(2071,'0502_1',4,'Docente'),(2072,'0503_1',4,'Docente'),(2073,'0513_1',4,'Docente'),(2074,'0517_1',4,'Docente'),(2075,'0524_1',4,'Docente'),(2076,'0525',4,'Docente'),(2077,'0527_1',4,'Docente'),(2078,'0531_1',4,'Docente'),(2079,'0532_1',4,'Docente'),(2080,'0537_2',4,'Docente'),(2081,'0539_1',4,'Docente'),(2082,'0540_1',4,'Docente'),(2083,'0544_1',4,'Docente'),(2084,'0546_1',4,'Docente'),(2085,'0551_1',4,'Docente'),(2086,'0562_1',4,'Docente'),(2087,'0565_1',4,'Docente'),(2088,'0567_1',4,'Docente'),(2089,'0569_1',4,'Docente'),(2090,'0576_1',4,'Docente'),(2091,'0577_1',4,'Docente'),(2092,'0580_1',4,'Docente'),(2093,'0585_1',4,'Docente'),(2094,'0592_1',4,'Docente'),(2095,'0593_2',4,'Docente'),(2096,'0594_1',4,'Docente'),(2097,'0596_1',4,'Docente'),(2098,'0597_1',4,'Docente'),(2099,'0599_2',4,'Docente'),(2100,'0601_1',4,'Docente'),(2101,'0604_1',4,'Docente'),(2102,'0612_1',4,'Docente'),(2103,'0619_1',4,'Docente'),(2104,'0626_1',4,'Docente'),(2105,'0632_1',4,'Docente'),(2106,'0638_1',4,'Docente'),(2107,'0641_1',4,'Docente'),(2108,'0646_1',4,'Docente'),(2109,'0650_1',4,'Docente'),(2110,'0655_1',4,'Docente'),(2111,'0657_1',4,'Docente'),(2112,'0658_1',4,'Docente'),(2113,'0664_1',4,'Docente'),(2114,'0666_1',4,'Docente'),(2115,'0667_1',4,'Docente'),(2116,'0670_1',4,'Docente'),(2117,'0671_1',4,'Docente'),(2118,'0674_1',4,'Docente'),(2119,'0687_1',4,'Docente'),(2120,'0691_1',4,'Docente'),(2121,'0692_1',4,'Docente'),(2122,'0693_1',4,'Docente'),(2123,'0696_1',4,'Docente'),(2124,'0698_1',4,'Docente'),(2125,'0701_1',4,'Docente'),(2126,'0702_1',4,'Docente'),(2127,'0703',4,'Docente'),(2128,'0705_1',4,'Docente'),(2129,'0707_1',4,'Docente'),(2130,'0708_1',4,'Docente'),(2131,'0711_1',4,'Docente'),(2132,'0712_1',4,'Docente'),(2133,'0717_1',4,'Docente'),(2134,'0720_1',4,'Docente'),(2135,'0722_1',4,'Docente'),(2136,'0724_1',4,'Docente'),(2137,'0728_1',4,'Docente'),(2138,'0729_1',4,'Docente'),(2139,'0733_1',4,'Docente'),(2140,'0734',4,'Docente'),(2141,'0736_1',4,'Docente'),(2142,'0738_1',4,'Docente'),(2143,'0739_1',4,'Docente'),(2144,'0744_1',4,'Docente'),(2145,'0745_1',4,'Docente'),(2146,'0746_1',4,'Docente'),(2147,'0747_1',4,'Docente'),(2148,'0748_1',4,'Docente'),(2149,'0749_1',4,'Docente'),(2150,'0760_1',4,'Docente'),(2151,'0766_1',4,'Docente'),(2152,'0772_1',4,'Docente'),(2153,'0775_1',4,'Docente'),(2154,'0789_1',4,'Docente'),(2155,'0792_1',4,'Docente'),(2156,'0794_1',4,'Docente'),(2157,'0796_1',4,'Docente'),(2158,'0807_1',4,'Docente'),(2159,'0811_1',4,'Docente'),(2160,'0813_1',4,'Docente'),(2161,'0814_1',4,'Docente'),(2162,'0815',4,'Docente'),(2163,'0816_1',4,'Docente'),(2164,'0817_1',4,'Docente'),(2165,'0818',4,'Docente'),(2166,'0820_1',4,'Docente'),(2167,'0822_1',4,'Docente'),(2168,'0826_1',4,'Docente'),(2169,'0829_1',4,'Docente'),(2170,'0830_1',4,'Docente'),(2171,'0831',4,'Docente'),(2172,'0839_1',4,'Docente'),(2173,'0841_1',4,'Docente'),(2174,'0845_1',4,'Docente'),(2175,'0846_1',4,'Docente'),(2176,'0849_1',4,'Docente'),(2177,'0850_1',4,'Docente'),(2178,'0851_1',4,'Docente'),(2179,'0852_1',4,'Docente'),(2180,'0854_1',4,'Docente'),(2181,'0855_1',4,'Docente'),(2182,'0856_1',4,'Docente'),(2183,'0860_1',4,'Docente'),(2184,'0864_1',4,'Docente'),(2185,'0867_1',4,'Docente'),(2186,'0875_1',4,'Docente'),(2187,'0876_1',4,'Docente'),(2188,'0892_1',4,'Docente'),(2189,'0896_1',4,'Docente'),(2190,'0902_1',4,'Docente'),(2191,'0904_1',4,'Docente'),(2192,'0909_1',4,'Docente'),(2193,'0915_1',4,'Docente'),(2194,'0917_1',4,'Docente'),(2195,'0929_1',4,'Docente'),(2196,'0931_1',4,'Docente'),(2197,'0932_1',4,'Docente'),(2198,'0935_1',4,'Docente'),(2199,'0940_1',4,'Docente'),(2200,'0941_1',4,'Docente'),(2201,'0944_1',4,'Docente'),(2202,'0945_1',4,'Docente'),(2203,'0949',4,'Docente'),(2204,'0951_1',4,'Docente'),(2205,'0952',4,'Docente'),(2206,'0955_2',4,'Docente'),(2207,'0960_1',4,'Docente'),(2208,'0961_1',4,'Docente'),(2209,'0965_1',4,'Docente'),(2210,'0972_1',4,'Docente'),(2211,'0974_1',4,'Docente'),(2212,'0978_1',4,'Docente'),(2213,'0986_1',4,'Docente'),(2214,'0987_1',4,'Docente'),(2215,'0991_1',4,'Docente'),(2216,'0996_1',4,'Docente'),(2217,'0998_1',4,'Docente'),(2218,'1000_1',4,'Docente'),(2219,'1001_1',4,'Docente'),(2220,'1004_1',4,'Docente'),(2221,'1005_1',4,'Docente'),(2222,'1007_1',4,'Docente'),(2223,'1008_1',4,'Docente'),(2224,'1014_1',4,'Docente'),(2225,'1015_1',4,'Docente'),(2226,'1017_1',4,'Docente'),(2227,'1020_1',4,'Docente'),(2228,'1024_1',4,'Docente'),(2229,'1026_1',4,'Docente'),(2230,'1041_1',4,'Docente'),(2231,'1044_1',4,'Docente'),(2232,'1045_1',4,'Docente'),(2233,'1046_1',4,'Docente'),(2234,'1047_1',4,'Docente'),(2235,'1048',4,'Docente'),(2236,'1052_1',4,'Docente'),(2237,'1053_1',4,'Docente'),(2238,'1054_1',4,'Docente'),(2239,'1060_1',4,'Docente'),(2240,'1061_1',4,'Docente'),(2241,'1063_1',4,'Docente'),(2242,'1067',4,'Docente'),(2243,'1070_1',4,'Docente'),(2244,'1073_1',4,'Docente'),(2245,'1083_1',4,'Docente'),(2246,'1086_1',4,'Docente'),(2247,'1088_1',4,'Docente'),(2248,'1090',4,'Docente'),(2249,'1100_1',4,'Docente'),(2250,'1102_1',4,'Docente'),(2251,'1103_1',4,'Docente'),(2252,'1106_1',4,'Docente'),(2253,'1107_1',4,'Docente'),(2254,'1109_1',4,'Docente'),(2255,'1110_1',4,'Docente'),(2256,'1113_1',4,'Docente'),(2257,'1115_1',4,'Docente'),(2258,'1117_1',4,'Docente'),(2259,'1136_1',4,'Docente'),(2260,'1138_1',4,'Docente'),(2261,'1140_1',4,'Docente'),(2262,'1146_1',4,'Docente'),(2263,'1150_1',4,'Docente'),(2264,'1156_1',4,'Docente'),(2265,'1159_1',4,'Docente'),(2266,'1165_1',4,'Docente'),(2267,'1167_1',4,'Docente'),(2268,'1169_1',4,'Docente'),(2269,'1174',4,'Docente'),(2270,'1181_1',4,'Docente'),(2271,'1187_1',4,'Docente'),(2272,'1188_1',4,'Docente'),(2273,'1190_1',4,'Docente'),(2274,'1193_1',4,'Docente'),(2275,'1199',4,'Docente'),(2276,'1200_1',4,'Docente'),(2277,'1201_1',4,'Docente'),(2278,'1202',4,'Docente'),(2279,'1204',4,'Docente'),(2280,'1207_1',4,'Docente'),(2281,'1211_1',4,'Docente'),(2282,'1221',4,'Docente'),(2283,'1222_1',4,'Docente'),(2284,'1225_1',4,'Docente'),(2285,'1230',4,'Docente'),(2286,'1233_1',4,'Docente'),(2287,'1234_1',4,'Docente'),(2288,'1236_1',4,'Docente'),(2289,'1238_1',4,'Docente'),(2290,'1239_1',4,'Docente'),(2291,'1242_1',4,'Docente'),(2292,'1249_1',4,'Docente'),(2293,'1251_1',4,'Docente'),(2294,'1253_1',4,'Docente'),(2295,'1255_1',4,'Docente'),(2296,'1259_1',4,'Docente'),(2297,'1260_1',4,'Docente'),(2298,'1264_1',4,'Docente'),(2299,'1265_1',4,'Docente'),(2300,'1269_1',4,'Docente'),(2301,'1270_1',4,'Docente'),(2302,'1273_1',4,'Docente'),(2303,'1275_1',4,'Docente'),(2304,'1278_1',4,'Docente'),(2305,'1282_1',4,'Docente'),(2306,'1286_1',4,'Docente'),(2307,'1288_1',4,'Docente'),(2308,'1290',4,'Docente'),(2309,'1293_1',4,'Docente'),(2310,'1294_1',4,'Docente'),(2311,'1296_1',4,'Docente'),(2312,'1298_1',4,'Docente'),(2313,'1299',4,'Docente'),(2314,'1302_1',4,'Docente'),(2315,'1303',4,'Docente'),(2316,'1304_1',4,'Docente'),(2317,'1309_1',4,'Docente'),(2318,'1314_1',4,'Docente'),(2319,'1319_1',4,'Docente'),(2320,'1322_1',4,'Docente'),(2321,'1331_1',4,'Docente'),(2322,'1335_1',4,'Docente'),(2323,'1345_1',4,'Docente'),(2324,'1348_1',4,'Docente'),(2325,'1349_1',4,'Docente'),(2326,'1360_1',4,'Docente'),(2327,'1362_1',4,'Docente'),(2328,'1367_1',4,'Docente'),(2329,'1378',4,'Docente'),(2330,'1380_1',4,'Docente'),(2331,'1381_1',4,'Docente'),(2332,'1382_1',4,'Docente'),(2333,'1383_1',4,'Docente'),(2334,'1384',4,'Docente'),(2335,'1388_1',4,'Docente'),(2336,'1389_1',4,'Docente'),(2337,'1391_1',4,'Docente'),(2338,'1392_1',4,'Docente'),(2339,'1394_1',4,'Docente'),(2340,'1399_1',4,'Docente'),(2341,'1401_1',4,'Docente'),(2342,'1402_1',4,'Docente'),(2343,'1404_1',4,'Docente'),(2344,'1406_1',4,'Docente'),(2345,'1408',4,'Docente'),(2346,'1423_1',4,'Docente'),(2347,'1426_1',4,'Docente'),(2348,'1427_1',4,'Docente'),(2349,'1433_1',4,'Docente'),(2350,'1435',4,'Docente'),(2351,'1436_1',4,'Docente'),(2352,'1437_1',4,'Docente'),(2353,'1441_1',4,'Docente'),(2354,'1443_1',4,'Docente'),(2355,'1447_1',4,'Docente'),(2356,'1452_1',4,'Docente'),(2357,'1457_1',4,'Docente'),(2358,'1458_1',4,'Docente'),(2359,'1462_1',4,'Docente'),(2360,'1464_1',4,'Docente'),(2361,'1467_1',4,'Docente'),(2362,'1468_1',4,'Docente'),(2363,'1469_1',4,'Docente'),(2364,'1471_1',4,'Docente'),(2365,'1472_1',4,'Docente'),(2366,'1474',4,'Docente'),(2367,'1475_1',4,'Docente'),(2368,'1477_1',4,'Docente'),(2369,'1478',4,'Docente'),(2370,'1480_1',4,'Docente'),(2371,'1483_1',4,'Docente'),(2372,'1484_1',4,'Docente'),(2373,'1487_1',4,'Docente'),(2374,'1488_1',4,'Docente'),(2375,'1490_1',4,'Docente'),(2376,'1491_1',4,'Docente'),(2377,'1493_1',4,'Docente'),(2378,'1498_1',4,'Docente'),(2379,'1499_1',4,'Docente'),(2380,'1500_1',4,'Docente'),(2381,'1510_1',4,'Docente'),(2382,'1511_1',4,'Docente'),(2383,'1514_1',4,'Docente'),(2384,'1515_1',4,'Docente'),(2385,'1516_1',4,'Docente'),(2386,'1517_1',4,'Docente'),(2387,'1522_1',4,'Docente'),(2388,'1528_1',4,'Docente'),(2389,'1530_1',4,'Docente'),(2390,'1533_1',4,'Docente'),(2391,'1535_1',4,'Docente'),(2392,'1539_1',4,'Docente'),(2393,'1545_1',4,'Docente'),(2394,'1547_1',4,'Docente'),(2395,'1549_1',4,'Docente'),(2396,'1550_1',4,'Docente'),(2397,'1555_1',4,'Docente'),(2398,'1558',4,'Docente'),(2399,'1559_1',4,'Docente'),(2400,'1565_1',4,'Docente'),(2401,'1566_1',4,'Docente'),(2402,'1574_1',4,'Docente'),(2403,'1575_1',4,'Docente'),(2404,'1580',4,'Docente'),(2405,'1582_1',4,'Docente'),(2406,'1587_1',4,'Docente'),(2407,'1589_1',4,'Docente'),(2408,'1590_1',4,'Docente'),(2409,'1591_1',4,'Docente'),(2410,'1592_1',4,'Docente'),(2411,'1594_1',4,'Docente'),(2412,'1602_1',4,'Docente'),(2413,'1607_1',4,'Docente'),(2414,'1613_1',4,'Docente'),(2415,'1614_1',4,'Docente'),(2416,'1616_1',4,'Docente'),(2417,'1620_1',4,'Docente'),(2418,'1621_1',4,'Docente'),(2419,'1623',4,'Docente'),(2420,'1628_1',4,'Docente'),(2421,'1629_1',4,'Docente'),(2422,'1632_1',4,'Docente'),(2423,'1634_1',4,'Docente'),(2424,'1635_1',4,'Docente'),(2425,'1640_1',4,'Docente'),(2426,'1644_1',4,'Docente'),(2427,'1649_1',4,'Docente'),(2428,'1650',4,'Docente'),(2429,'1654_1',4,'Docente'),(2430,'1658_1',4,'Docente'),(2431,'1663_1',4,'Docente'),(2432,'1665_1',4,'Docente'),(2433,'1667_1',4,'Docente'),(2434,'1671',4,'Docente'),(2435,'1673_1',4,'Docente'),(2436,'1674_1',4,'Docente'),(2437,'1677_1',4,'Docente'),(2438,'1680_1',4,'Docente'),(2439,'1682_1',4,'Docente'),(2440,'1685_1',4,'Docente'),(2441,'1689_1',4,'Docente'),(2442,'1692_1',4,'Docente'),(2443,'1695_1',4,'Docente'),(2444,'1697_1',4,'Docente'),(2445,'1703_1',4,'Docente'),(2446,'1708_1',4,'Docente'),(2447,'1712_1',4,'Docente'),(2448,'1713_1',4,'Docente'),(2449,'1717_1',4,'Docente'),(2450,'1723_1',4,'Docente'),(2451,'1728_1',4,'Docente'),(2452,'1732_1',4,'Docente'),(2453,'1734_1',4,'Docente'),(2454,'1741_1',4,'Docente'),(2455,'1744_1',4,'Docente'),(2456,'1745_1',4,'Docente'),(2457,'1747_1',4,'Docente'),(2458,'1751_1',4,'Docente'),(2459,'1755_1',4,'Docente'),(2460,'1757_1',4,'Docente'),(2461,'1760_1',4,'Docente'),(2462,'1762_1',4,'Docente'),(2463,'1763_1',4,'Docente'),(2464,'1766_1',4,'Docente'),(2465,'1770_1',4,'Docente'),(2466,'1772_1',4,'Docente'),(2467,'1779_1',4,'Docente'),(2468,'1781_1',4,'Docente'),(2469,'1784_1',4,'Docente'),(2470,'1785_1',4,'Docente'),(2471,'1789_1',4,'Docente'),(2472,'1790_1',4,'Docente'),(2473,'1791_1',4,'Docente'),(2474,'1793_1',4,'Docente'),(2475,'1797_1',4,'Docente'),(2476,'1799_2',4,'Docente'),(2477,'1800_1',4,'Docente'),(2478,'1804_1',4,'Docente'),(2479,'1805_1',4,'Docente'),(2480,'1809_1',4,'Docente'),(2481,'1813_1',4,'Docente'),(2482,'1814_1',4,'Docente'),(2483,'1826_1',4,'Docente'),(2484,'1827_1',4,'Docente'),(2485,'1828_1',4,'Docente'),(2486,'1829_1',4,'Docente'),(2487,'1834_1',4,'Docente'),(2488,'1836_1',4,'Docente'),(2489,'1837_1',4,'Docente'),(2490,'1838_1',4,'Docente'),(2491,'1840_1',4,'Docente'),(2492,'1841_1',4,'Docente'),(2493,'1843_1',4,'Docente'),(2494,'1846_1',4,'Docente'),(2495,'1847_1',4,'Docente'),(2496,'1851_1',4,'Docente'),(2497,'1855_1',4,'Docente'),(2498,'1861_1',4,'Docente'),(2499,'1863_1',4,'Docente'),(2500,'1871',4,'Docente'),(2501,'1872_1',4,'Docente'),(2502,'1874_1',4,'Docente'),(2503,'1875_2',4,'Docente'),(2504,'1878_1',4,'Docente'),(2505,'1881_1',4,'Docente'),(2506,'1883_1',4,'Docente'),(2507,'1886_1',4,'Docente'),(2508,'1890_1',4,'Docente'),(2509,'1891_1',4,'Docente'),(2510,'1904_1',4,'Docente'),(2511,'1905_1',4,'Docente'),(2512,'1906_1',4,'Docente'),(2513,'1911_1',4,'Docente'),(2514,'1912_1',4,'Docente'),(2515,'1913_1',4,'Docente'),(2516,'1915_1',4,'Docente'),(2517,'1917_1',4,'Docente'),(2518,'1921',4,'Docente'),(2519,'1922_1',4,'Docente'),(2520,'1923_1',4,'Docente'),(2521,'1924_1',4,'Docente'),(2522,'1926_1',4,'Docente'),(2523,'1927_1',4,'Docente'),(2524,'1928_1',4,'Docente'),(2525,'1954_1',4,'Docente'),(2526,'1955_1',4,'Docente'),(2527,'1959_1',4,'Docente'),(2528,'1962_1',4,'Docente'),(2529,'1964_1',4,'Docente'),(2530,'1965_1',4,'Docente'),(2531,'1967_1',4,'Docente'),(2532,'1968_1',4,'Docente'),(2533,'1969_1',4,'Docente'),(2534,'1970_1',4,'Docente'),(2535,'1971_1',4,'Docente'),(2536,'1975_1',4,'Docente'),(2537,'1982_1',4,'Docente'),(2538,'1984_1',4,'Docente'),(2539,'1999_1',4,'Docente'),(2540,'2000_1',4,'Docente'),(2541,'2010_1',4,'Docente'),(2542,'2011_1',4,'Docente'),(2543,'2012_1',4,'Docente'),(2544,'2013_1',4,'Docente'),(2545,'2017_1',4,'Docente'),(2546,'2019_1',4,'Docente'),(2547,'2024_1',4,'Docente'),(2548,'2051',4,'Docente'),(2549,'2119_1',4,'Docente'),(2550,'2122_1',4,'Docente'),(2551,'2128_1',4,'Docente'),(2552,'2129_1',4,'Docente'),(2553,'2140_1',4,'Docente'),(2554,'2147',4,'Docente'),(2555,'2150_1',4,'Docente'),(2556,'2151_1',4,'Docente'),(2557,'2152_1',4,'Docente'),(2558,'2154_1',4,'Docente'),(2559,'2155',4,'Docente'),(2560,'2157_1',4,'Docente'),(2561,'2167_1',4,'Docente'),(2562,'2194_2',4,'Docente'),(2563,'2209_1',4,'Docente'),(2564,'2210_1',4,'Docente'),(2565,'2223_1',4,'Docente'),(2566,'2224_1',4,'Docente'),(2567,'2228_1',4,'Docente'),(2568,'2235_1',4,'Docente'),(2569,'2236_1',4,'Docente'),(2570,'2237_1',4,'Docente'),(2571,'2238_1',4,'Docente'),(2572,'2239_1',4,'Docente'),(2573,'2241_1',4,'Docente'),(2574,'2242_1',4,'Docente'),(2575,'2243_1',4,'Docente'),(2576,'2244',4,'Docente'),(2577,'2246_1',4,'Docente'),(2578,'2247_1',4,'Docente'),(2579,'2248_1',4,'Docente'),(2580,'2252_1',4,'Docente'),(2581,'2254_1',4,'Docente'),(2582,'2255_1',4,'Docente'),(2583,'2257_1',4,'Docente'),(2584,'2258_1',4,'Docente'),(2585,'2259_1',4,'Docente'),(2586,'2264_1',4,'Docente'),(2587,'2267_1',4,'Docente'),(2588,'2268_1',4,'Docente'),(2589,'2269_1',4,'Docente'),(2590,'2271_1',4,'Docente'),(2591,'2279_1',4,'Docente'),(2592,'2282_1',4,'Docente'),(2593,'2283_1',4,'Docente'),(2594,'2284_1',4,'Docente'),(2595,'2288_1',4,'Docente'),(2596,'2289_1',4,'Docente'),(2597,'2290_1',4,'Docente'),(2598,'2291_1',4,'Docente'),(2599,'2295_1',4,'Docente'),(2600,'2298_2',4,'Docente'),(2601,'2305_1',4,'Docente'),(2602,'2306_1',4,'Docente'),(2603,'2307_1',4,'Docente'),(2604,'2308_1',4,'Docente'),(2605,'2311_1',4,'Docente'),(2606,'2312_1',4,'Docente'),(2607,'2321_1',4,'Docente'),(2608,'2325_1',4,'Docente'),(2609,'2329_1',4,'Docente'),(2610,'2330_1',4,'Docente'),(2611,'2331_1',4,'Docente'),(2612,'2332_1',4,'Docente'),(2613,'2333_1',4,'Docente'),(2614,'2334_1',4,'Docente'),(2615,'2335_1',4,'Docente'),(2616,'2336_1',4,'Docente'),(2617,'2342_1',4,'Docente'),(2618,'2344_1',4,'Docente'),(2619,'2345_1',4,'Docente'),(2620,'2348_1',4,'Docente'),(2621,'2351_1',4,'Docente'),(2622,'2352_1',4,'Docente'),(2623,'2357_1',4,'Docente'),(2624,'2359_1',4,'Docente'),(2625,'2363_1',4,'Docente'),(2626,'2367_1',4,'Docente'),(2627,'2385',4,'Docente'),(2628,'2393_1',4,'Docente'),(2629,'2396_1',4,'Docente'),(2630,'2416_1',4,'Docente'),(2631,'2434_1',4,'Docente'),(2632,'2462_1',4,'Docente'),(2633,'2498_1',4,'Docente'),(2634,'2607_1',4,'Docente'),(2635,'2611_1',4,'Docente'),(2636,'2613_1',4,'Docente'),(2637,'2614_1',4,'Docente'),(2638,'2623',4,'Docente'),(2639,'2626',4,'Docente'),(2640,'2627_1',4,'Docente'),(2641,'2628_1',4,'Docente'),(2642,'2629_1',4,'Docente'),(2643,'2630_1',4,'Docente'),(2644,'2634_1',4,'Docente'),(2645,'2635_1',4,'Docente'),(2646,'2639_1',4,'Docente'),(2647,'2641_1',4,'Docente'),(2648,'2642_1',4,'Docente'),(2649,'2643_1',4,'Docente'),(2650,'2644_1',4,'Docente'),(2651,'2645_1',4,'Docente'),(2652,'2646_1',4,'Docente'),(2653,'2647_1',4,'Docente'),(2654,'2649_1',4,'Docente'),(2655,'2651_1',4,'Docente'),(2656,'2652_1',4,'Docente'),(2657,'2653_1',4,'Docente'),(2658,'2654_1',4,'Docente'),(2659,'2657_1',4,'Docente'),(2660,'2659_1',4,'Docente'),(2661,'2660_1',4,'Docente'),(2662,'2661_1',4,'Docente'),(2663,'2662_1',4,'Docente'),(2664,'2663_1',4,'Docente'),(2665,'2664_1',4,'Docente'),(2666,'2666_1',4,'Docente'),(2667,'2667_1',4,'Docente'),(2668,'2668_1',4,'Docente'),(2669,'2669_1',4,'Docente'),(2670,'2670_1',4,'Docente'),(2671,'2671_1',4,'Docente'),(2672,'2673_1',4,'Docente'),(2673,'2674_1',4,'Docente'),(2674,'2675_1',4,'Docente'),(2675,'2676_1',4,'Docente'),(2676,'2677_1',4,'Docente'),(2677,'2678_1',4,'Docente'),(2678,'2679_1',4,'Docente'),(2679,'2681_1',4,'Docente'),(2680,'2685_1',4,'Docente'),(2681,'2708_1',4,'Docente'),(2682,'2714_1',4,'Docente'),(2683,'2716_1',4,'Docente'),(2684,'2728_1',4,'Docente'),(2685,'2731_1',4,'Docente'),(2686,'2732_1',4,'Docente'),(2687,'2733_1',4,'Docente'),(2688,'2734_1',4,'Docente'),(2689,'2735_1',4,'Docente'),(2690,'2736_1',4,'Docente'),(2691,'2737_1',4,'Docente'),(2692,'2738_1',4,'Docente'),(2693,'2740_1',4,'Docente'),(2694,'2741_1',4,'Docente'),(2695,'2743',4,'Docente'),(2696,'2745_1',4,'Docente'),(2697,'2746_1',4,'Docente'),(2698,'2748_1',4,'Docente'),(2699,'2750_1',4,'Docente'),(2700,'2756_1',4,'Docente'),(2701,'2757_1',4,'Docente'),(2702,'2758_1',4,'Docente'),(2703,'2764_1',4,'Docente'),(2704,'2767_1',4,'Docente'),(2705,'2768_1',4,'Docente'),(2706,'2770_1',4,'Docente'),(2707,'2771_1',4,'Docente'),(2708,'2773_1',4,'Docente'),(2709,'2775_1',4,'Docente'),(2710,'2776_1',4,'Docente'),(2711,'2777_1',4,'Docente'),(2712,'2778_1',4,'Docente'),(2713,'2780',4,'Docente'),(2714,'2781_1',4,'Docente'),(2715,'2834_1',4,'Docente'),(2716,'2838_1',4,'Docente'),(2717,'2841_1',4,'Docente'),(2718,'2842_1',4,'Docente'),(2719,'2843_1',4,'Docente'),(2720,'2844_1',4,'Docente'),(2721,'2845_1',4,'Docente'),(2722,'2847_1',4,'Docente'),(2723,'2849_1',4,'Docente'),(2724,'2850_1',4,'Docente'),(2725,'2851_1',4,'Docente'),(2726,'2854_1',4,'Docente'),(2727,'2857_1',4,'Docente'),(2728,'2862_1',4,'Docente'),(2729,'2866_1',4,'Docente'),(2730,'2867_1',4,'Docente'),(2731,'2874_1',4,'Docente'),(2732,'2879_1',4,'Docente'),(2733,'2882_1',4,'Docente'),(2734,'2891_1',4,'Docente'),(2735,'2895_1',4,'Docente'),(2736,'2896_1',4,'Docente'),(2737,'2898_1',4,'Docente'),(2738,'2914_1',4,'Docente'),(2739,'2915_1',4,'Docente'),(2740,'2920_1',4,'Docente'),(2741,'2921_2',4,'Docente'),(2742,'2922_1',4,'Docente'),(2743,'2924_1',4,'Docente'),(2744,'2925_1',4,'Docente'),(2745,'2926_1',4,'Docente'),(2746,'2939_1',4,'Docente'),(2747,'2940_1',4,'Docente'),(2748,'2941_1',4,'Docente'),(2749,'2945_1',4,'Docente'),(2750,'2946_1',4,'Docente'),(2751,'2947_1',4,'Docente'),(2752,'2948_1',4,'Docente'),(2753,'2949_1',4,'Docente'),(2754,'2951_1',4,'Docente'),(2755,'2954_1',4,'Docente'),(2756,'2957_1',4,'Docente'),(2757,'2960_1',4,'Docente'),(2758,'2962_2',4,'Docente'),(2759,'2964_1',4,'Docente'),(2760,'2968_1',4,'Docente'),(2761,'2970_1',4,'Docente'),(2762,'2971_1',4,'Docente'),(2763,'2975_1',4,'Docente'),(2764,'2976_1',4,'Docente'),(2765,'2977_1',4,'Docente'),(2766,'2978_1',4,'Docente'),(2767,'2983_1',4,'Docente'),(2768,'2984_1',4,'Docente'),(2769,'3029_1',4,'Docente'),(2770,'3031_1',4,'Docente'),(2771,'3038_1',4,'Docente'),(2772,'3048_1',4,'Docente'),(2773,'3051_2',4,'Docente'),(2774,'3052_1',4,'Docente'),(2775,'3054_1',4,'Docente'),(2776,'3055_1',4,'Docente'),(2777,'3056_1',4,'Docente'),(2778,'3057_1',4,'Docente'),(2779,'3058_1',4,'Docente'),(2780,'3062_1',4,'Docente'),(2781,'3063_1',4,'Docente'),(2782,'3066_1',4,'Docente'),(2783,'3067_1',4,'Docente'),(2784,'3073_1',4,'Docente'),(2785,'3079_1',4,'Docente'),(2786,'3080_1',4,'Docente'),(2787,'3081_1',4,'Docente'),(2788,'3082_1',4,'Docente'),(2789,'3083_1',4,'Docente'),(2790,'3087_1',4,'Docente'),(2791,'3089_1',4,'Docente'),(2792,'3091_1',4,'Docente'),(2793,'3092_1',4,'Docente'),(2794,'3094_1',4,'Docente'),(2795,'3099_1',4,'Docente'),(2796,'3103_1',4,'Docente'),(2797,'3104_1',4,'Docente'),(2798,'3107_1',4,'Docente'),(2799,'3108_1',4,'Docente'),(2800,'3109_1',4,'Docente'),(2801,'3112_1',4,'Docente'),(2802,'3113_1',4,'Docente'),(2803,'3124_1',4,'Docente'),(2804,'3126_1',4,'Docente'),(2805,'3136_2',4,'Docente'),(2806,'3139_1',4,'Docente'),(2807,'3140_1',4,'Docente'),(2808,'3141_1',4,'Docente'),(2809,'3142_1',4,'Docente'),(2810,'3152',4,'Docente'),(2811,'3156_1',4,'Docente'),(2812,'3162_2',4,'Docente'),(2813,'3168_2',4,'Docente'),(2814,'3171_1',4,'Docente'),(2815,'3188_2',4,'Docente'),(2816,'3209_1',4,'Docente'),(2817,'3210',4,'Docente'),(2818,'3215_1',4,'Docente'),(2819,'3216_1',4,'Docente'),(2820,'3217_1',4,'Docente'),(2821,'3222_1',4,'Docente'),(2822,'3249_1',4,'Docente'),(2823,'3250_1',4,'Docente'),(2824,'3251_1',4,'Docente'),(2825,'3252_1',4,'Docente'),(2826,'3253_1',4,'Docente'),(2827,'3254_1',4,'Docente'),(2828,'3255_1',4,'Docente'),(2829,'3256_1',4,'Docente'),(2830,'3260_1',4,'Docente'),(2831,'3262_1',4,'Docente'),(2832,'3263_1',4,'Docente'),(2833,'3265_1',4,'Docente'),(2834,'3266_1',4,'Docente'),(2835,'3267_1',4,'Docente'),(2836,'3268_1',4,'Docente'),(2837,'3269',4,'Docente'),(2838,'3270_1',4,'Docente'),(2839,'3271_1',4,'Docente'),(2840,'3273_1',4,'Docente'),(2841,'3274_1',4,'Docente'),(2842,'3275_1',4,'Docente'),(2843,'3276_1',4,'Docente'),(2844,'3278_1',4,'Docente'),(2845,'3279_1',4,'Docente'),(2846,'3281_1',4,'Docente'),(2847,'3285_1',4,'Docente'),(2848,'3286_2',4,'Docente'),(2849,'3288_1',4,'Docente'),(2850,'3289_1',4,'Docente'),(2851,'3290_1',4,'Docente'),(2852,'3291_1',4,'Docente'),(2853,'3293_1',4,'Docente'),(2854,'3294_1',4,'Docente'),(2855,'3295_1',4,'Docente'),(2856,'3297_1',4,'Docente'),(2857,'3300_1',4,'Docente'),(2858,'3311_1',4,'Docente'),(2859,'3312_1',4,'Docente'),(2860,'3313_1',4,'Docente'),(2861,'3314_1',4,'Docente'),(2862,'3315_1',4,'Docente'),(2863,'3316_1',4,'Docente'),(2864,'3317_1',4,'Docente'),(2865,'3319_1',4,'Docente'),(2866,'3320_1',4,'Docente'),(2867,'3321',4,'Docente'),(2868,'3322_1',4,'Docente'),(2869,'3324_1',4,'Docente'),(2870,'3325_1',4,'Docente'),(2871,'3326_1',4,'Docente'),(2872,'3327_1',4,'Docente'),(2873,'3328_1',4,'Docente'),(2874,'3330_1',4,'Docente'),(2875,'3331_1',4,'Docente'),(2876,'3332_1',4,'Docente'),(2877,'3334_1',4,'Docente'),(2878,'3335_1',4,'Docente'),(2879,'3338_1',4,'Docente'),(2880,'3344_1',4,'Docente'),(2881,'3346_1',4,'Docente'),(2882,'3347_1',4,'Docente'),(2883,'3348_1',4,'Docente'),(2884,'3350_1',4,'Docente'),(2885,'3351_1',4,'Docente'),(2886,'3352_1',4,'Docente'),(2887,'3353_1',4,'Docente'),(2888,'3354_1',4,'Docente'),(2889,'3356_1',4,'Docente'),(2890,'3357_1',4,'Docente'),(2891,'3359',4,'Docente'),(2892,'3361_1',4,'Docente'),(2893,'3363_1',4,'Docente'),(2894,'3365_1',4,'Docente'),(2895,'3367_1',4,'Docente'),(2896,'3370',4,'Docente'),(2897,'3371_1',4,'Docente'),(2898,'3372_1',4,'Docente'),(2899,'3373',4,'Docente'),(2900,'3374_1',4,'Docente'),(2901,'3375_1',4,'Docente'),(2902,'3376_1',4,'Docente'),(2903,'3377_1',4,'Docente'),(2904,'3378_1',4,'Docente'),(2905,'3388_1',4,'Docente'),(2906,'3389_1',4,'Docente'),(2907,'3390_1',4,'Docente'),(2908,'3391_1',4,'Docente'),(2909,'3392_1',4,'Docente'),(2910,'3393_1',4,'Docente'),(2911,'3394_1',4,'Docente'),(2912,'3398_1',4,'Docente'),(2913,'3399_1',4,'Docente'),(2914,'3400_1',4,'Docente'),(2915,'3401_1',4,'Docente'),(2916,'3403_1',4,'Docente'),(2917,'3404_1',4,'Docente'),(2918,'3405_1',4,'Docente'),(2919,'3406_1',4,'Docente'),(2920,'3408_1',4,'Docente'),(2921,'3409_1',4,'Docente'),(2922,'3410_1',4,'Docente'),(2923,'3412_1',4,'Docente'),(2924,'3413_1',4,'Docente'),(2925,'3414_1',4,'Docente'),(2926,'3415_1',4,'Docente'),(2927,'3416_1',4,'Docente'),(2928,'3419_1',4,'Docente'),(2929,'3420_1',4,'Docente'),(2930,'3425_1',4,'Docente'),(2931,'3427_1',4,'Docente'),(2932,'3428_1',4,'Docente'),(2933,'3451_1',4,'Docente'),(2934,'3461_1',4,'Docente'),(2935,'3462_1',4,'Docente'),(2936,'3463_1',4,'Docente'),(2937,'3470_1',4,'Docente'),(2938,'3471_1',4,'Docente'),(2939,'3474_1',4,'Docente'),(2940,'3475',4,'Docente'),(2941,'3476_1',4,'Docente'),(2942,'3477_1',4,'Docente'),(2943,'3479_1',4,'Docente'),(2944,'3480_1',4,'Docente'),(2945,'3482_1',4,'Docente'),(2946,'3483_1',4,'Docente'),(2947,'3485_1',4,'Docente'),(2948,'3486_1',4,'Docente'),(2949,'3487_1',4,'Docente'),(2950,'3489_1',4,'Docente'),(2951,'3491_1',4,'Docente'),(2952,'3493_1',4,'Docente'),(2953,'3495_1',4,'Docente'),(2954,'3498_1',4,'Docente'),(2955,'3499_1',4,'Docente'),(2956,'3502_1',4,'Docente'),(2957,'3503_1',4,'Docente'),(2958,'3504_1',4,'Docente'),(2959,'3505_1',4,'Docente'),(2960,'3507_1',4,'Docente'),(2961,'3508_1',4,'Docente'),(2962,'3509_1',4,'Docente'),(2963,'3510_1',4,'Docente'),(2964,'3511_1',4,'Docente'),(2965,'3512_1',4,'Docente'),(2966,'3513_1',4,'Docente'),(2967,'3514_1',4,'Docente'),(2968,'3516_1',4,'Docente'),(2969,'3517_1',4,'Docente'),(2970,'3518_1',4,'Docente'),(2971,'3519_1',4,'Docente'),(2972,'3520_1',4,'Docente'),(2973,'3521_1',4,'Docente'),(2974,'3522_1',4,'Docente'),(2975,'3525_1',4,'Docente'),(2976,'3526_2',4,'Docente'),(2977,'3529_1',4,'Docente'),(2978,'3530_1',4,'Docente'),(2979,'3531_1',4,'Docente'),(2980,'3532_1',4,'Docente'),(2981,'3533_1',4,'Docente'),(2982,'3536',4,'Docente'),(2983,'3537_1',4,'Docente'),(2984,'3539_1',4,'Docente'),(2985,'3540_1',4,'Docente'),(2986,'3541',4,'Docente'),(2987,'3543_1',4,'Docente'),(2988,'3544_1',4,'Docente'),(2989,'3545_1',4,'Docente'),(2990,'3547',4,'Docente'),(2991,'3548_1',4,'Docente'),(2992,'3550_1',4,'Docente'),(2993,'3551_1',4,'Docente'),(2994,'3552_1',4,'Docente'),(2995,'3553',4,'Docente'),(2996,'3561_2',4,'Docente'),(2997,'3569',4,'Docente'),(2998,'3603_1',4,'Docente'),(2999,'3611_2',4,'Docente'),(3000,'3663_1',4,'Docente'),(3001,'3664_1',4,'Docente'),(3002,'3665_1',4,'Docente'),(3003,'3666_1',4,'Docente'),(3004,'3676_1',4,'Docente'),(3005,'3677_1',4,'Docente'),(3006,'3693_1',4,'Docente'),(3007,'3694',4,'Docente'),(3008,'3698',4,'Docente'),(3009,'3706_1',4,'Docente'),(3010,'3709_1',4,'Docente'),(3011,'3711_1',4,'Docente'),(3012,'3712_1',4,'Docente'),(3013,'3713_1',4,'Docente'),(3014,'3714_1',4,'Docente'),(3015,'3717_1',4,'Docente'),(3016,'3719_1',4,'Docente'),(3017,'3720_1',4,'Docente'),(3018,'3721_1',4,'Docente'),(3019,'3722_1',4,'Docente'),(3020,'3723_1',4,'Docente'),(3021,'3724_1',4,'Docente'),(3022,'3726_1',4,'Docente'),(3023,'3727',4,'Docente'),(3024,'3728_1',4,'Docente'),(3025,'3729_1',4,'Docente'),(3026,'3730_1',4,'Docente'),(3027,'3731_1',4,'Docente'),(3028,'3733',4,'Docente'),(3029,'3736_1',4,'Docente'),(3030,'3737_1',4,'Docente'),(3031,'3738_1',4,'Docente'),(3032,'3739_1',4,'Docente'),(3033,'3741_1',4,'Docente'),(3034,'3742',4,'Docente'),(3035,'3744_1',4,'Docente'),(3036,'3746_1',4,'Docente'),(3037,'3747_1',4,'Docente'),(3038,'3748_1',4,'Docente'),(3039,'3750_1',4,'Docente'),(3040,'3752',4,'Docente'),(3041,'3753',4,'Docente'),(3042,'3757_1',4,'Docente'),(3043,'3759_1',4,'Docente'),(3044,'3761',4,'Docente'),(3045,'3762_1',4,'Docente'),(3046,'3766_1',4,'Docente'),(3047,'3767_1',4,'Docente'),(3048,'3768_1',4,'Docente'),(3049,'3770_1',4,'Docente'),(3050,'3771_1',4,'Docente'),(3051,'3772_1',4,'Docente'),(3052,'3773_1',4,'Docente'),(3053,'3778_1',4,'Docente'),(3054,'3779_1',4,'Docente'),(3055,'3784_1',4,'Docente'),(3056,'3828_1',4,'Docente'),(3057,'3830_2',4,'Docente'),(3058,'3831_1',4,'Docente'),(3059,'3834_1',4,'Docente'),(3060,'3838_1',4,'Docente'),(3061,'3840_1',4,'Docente'),(3062,'3841_1',4,'Docente'),(3063,'3842_1',4,'Docente'),(3064,'3843_1',4,'Docente'),(3065,'3844_1',4,'Docente'),(3066,'3845_1',4,'Docente'),(3067,'3846_1',4,'Docente'),(3068,'3848_1',4,'Docente'),(3069,'3849_1',4,'Docente'),(3070,'3850_1',4,'Docente'),(3071,'3853_1',4,'Docente'),(3072,'3863',4,'Docente'),(3073,'3865_1',4,'Docente'),(3074,'3867_1',4,'Docente'),(3075,'3871_1',4,'Docente'),(3076,'3872_1',4,'Docente'),(3077,'3875_1',4,'Docente'),(3078,'3877_1',4,'Docente'),(3079,'3878_1',4,'Docente'),(3080,'3879_1',4,'Docente'),(3081,'3880',4,'Docente'),(3082,'3881',4,'Docente'),(3083,'3887',4,'Docente'),(3084,'3888',4,'Docente'),(3085,'3889_1',4,'Docente'),(3086,'3890_1',4,'Docente'),(3087,'3892',4,'Docente'),(3088,'3893_1',4,'Docente'),(3089,'3894_1',4,'Docente'),(3090,'3895',4,'Docente'),(3091,'3901_1',4,'Docente'),(3092,'3905',4,'Docente'),(3093,'3907_1',4,'Docente'),(3094,'3908',4,'Docente'),(3095,'3909_1',4,'Docente'),(3096,'3910_1',4,'Docente'),(3097,'3911_1',4,'Docente'),(3098,'3923_2',4,'Docente'),(3099,'3926_1',4,'Docente'),(3100,'3932_1',4,'Docente'),(3101,'3939_2',4,'Docente'),(3102,'3960_2',4,'Docente'),(3103,'3981_2',4,'Docente'),(3104,'3999_1',4,'Docente'),(3105,'4005_2',4,'Docente'),(3106,'4016',4,'Docente'),(3107,'4032_2',4,'Docente'),(3108,'4035_2',4,'Docente'),(3109,'4042_1',4,'Docente'),(3110,'4047_2',4,'Docente'),(3111,'4050_2',4,'Docente'),(3112,'4055_1',4,'Docente'),(3113,'4056_1',4,'Docente'),(3114,'4057_1',4,'Docente'),(3115,'4058_1',4,'Docente'),(3116,'4068_1',4,'Docente'),(3117,'4071_2',4,'Docente'),(3118,'4072_1',4,'Docente'),(3119,'4073_1',4,'Docente'),(3120,'4076_1',4,'Docente'),(3121,'4095_1',4,'Docente'),(3122,'4097',4,'Docente'),(3123,'4099_1',4,'Docente'),(3124,'4108_1',4,'Docente'),(3125,'4109_1',4,'Docente'),(3126,'4117_1',4,'Docente'),(3127,'4118_1',4,'Docente'),(3128,'4119_1',4,'Docente'),(3129,'4120_1',4,'Docente'),(3130,'4122_1',4,'Docente'),(3131,'4123_1',4,'Docente'),(3132,'4124',4,'Docente'),(3133,'4125_1',4,'Docente'),(3134,'4126_1',4,'Docente'),(3135,'4128_1',4,'Docente'),(3136,'4132_1',4,'Docente'),(3137,'4133',4,'Docente'),(3138,'4134_1',4,'Docente'),(3139,'4135_1',4,'Docente'),(3140,'4136',4,'Docente'),(3141,'4137_1',4,'Docente'),(3142,'4138_1',4,'Docente'),(3143,'4139_1',4,'Docente'),(3144,'4140',4,'Docente'),(3145,'4141_1',4,'Docente'),(3146,'4142_1',4,'Docente'),(3147,'4143_1',4,'Docente'),(3148,'4144_1',4,'Docente'),(3149,'4145',4,'Docente'),(3150,'4146',4,'Docente'),(3151,'4147_1',4,'Docente'),(3152,'4148_1',4,'Docente'),(3153,'4149_1',4,'Docente'),(3154,'4150',4,'Docente'),(3155,'4151_1',4,'Docente'),(3156,'4152_1',4,'Docente'),(3157,'4153_1',4,'Docente'),(3158,'4154',4,'Docente'),(3159,'4165_2',4,'Docente'),(3160,'4207_2',4,'Docente'),(3161,'4210_1',4,'Docente'),(3162,'4211_1',4,'Docente'),(3163,'4212_1',4,'Docente'),(3164,'4213_1',4,'Docente'),(3165,'4214_1',4,'Docente'),(3166,'4215_1',4,'Docente'),(3167,'4216_1',4,'Docente'),(3168,'4217',4,'Docente'),(3169,'4218_1',4,'Docente'),(3170,'4219_1',4,'Docente'),(3171,'4221_1',4,'Docente'),(3172,'4232_1',4,'Docente'),(3173,'4235_1',4,'Docente'),(3174,'4236_1',4,'Docente'),(3175,'4237',4,'Docente'),(3176,'4238_1',4,'Docente'),(3177,'4241_1',4,'Docente'),(3178,'4243_1',4,'Docente'),(3179,'4245_1',4,'Docente'),(3180,'4246',4,'Docente'),(3181,'4247_1',4,'Docente'),(3182,'4248_1',4,'Docente'),(3183,'4249_1',4,'Docente'),(3184,'4250_1',4,'Docente'),(3185,'4251',4,'Docente'),(3186,'4252',4,'Docente'),(3187,'4253_1',4,'Docente'),(3188,'4254',4,'Docente'),(3189,'4255_1',4,'Docente'),(3190,'4256_1',4,'Docente'),(3191,'4257_1',4,'Docente'),(3192,'4258_1',4,'Docente'),(3193,'4259_1',4,'Docente'),(3194,'4260_1',4,'Docente'),(3195,'4261',4,'Docente'),(3196,'4262',4,'Docente'),(3197,'4263',4,'Docente'),(3198,'4264_1',4,'Docente'),(3199,'4265',4,'Docente'),(3200,'4266_1',4,'Docente'),(3201,'4267',4,'Docente'),(3202,'4268_1',4,'Docente'),(3203,'4269_1',4,'Docente'),(3204,'4270_1',4,'Docente'),(3205,'4271_1',4,'Docente'),(3206,'4273_1',4,'Docente'),(3207,'4274_1',4,'Docente'),(3208,'4277_1',4,'Docente'),(3209,'4278',4,'Docente'),(3210,'4279',4,'Docente'),(3211,'4281_1',4,'Docente'),(3212,'4282_1',4,'Docente'),(3213,'4283_1',4,'Docente'),(3214,'4284',4,'Docente'),(3215,'4285',4,'Docente'),(3216,'4286_1',4,'Docente'),(3217,'4287_1',4,'Docente'),(3218,'4288',4,'Docente'),(3219,'4289',4,'Docente'),(3220,'4293_1',4,'Docente'),(3221,'4295',4,'Docente'),(3222,'4296_1',4,'Docente'),(3223,'4297',4,'Docente'),(3224,'4298_1',4,'Docente'),(3225,'4299',4,'Docente'),(3226,'4300',4,'Docente'),(3227,'4301_1',4,'Docente'),(3228,'4302',4,'Docente'),(3229,'4306_1',4,'Docente'),(3230,'4307_1',4,'Docente'),(3231,'4308',4,'Docente'),(3232,'4310_1',4,'Docente'),(3233,'4311_1',4,'Docente'),(3234,'4312_1',4,'Docente'),(3235,'4313_1',4,'Docente'),(3236,'4314_1',4,'Docente'),(3237,'4315_1',4,'Docente'),(3238,'4316',4,'Docente'),(3239,'4318_1',4,'Docente'),(3240,'4319_1',4,'Docente'),(3241,'4320_1',4,'Docente'),(3242,'4321_1',4,'Docente'),(3243,'4322',4,'Docente'),(3244,'4324_1',4,'Docente'),(3245,'4325',4,'Docente'),(3246,'4326_1',4,'Docente'),(3247,'4327_1',4,'Docente'),(3248,'4328',4,'Docente'),(3249,'4330_1',4,'Docente'),(3250,'4331_1',4,'Docente'),(3251,'4354',4,'Docente'),(3252,'4355_1',4,'Docente'),(3253,'4362_1',4,'Docente'),(3254,'4363_1',4,'Docente'),(3255,'4364_1',4,'Docente'),(3256,'4365',4,'Docente'),(3257,'4367_1',4,'Docente'),(3258,'4368_1',4,'Docente'),(3259,'4369_1',4,'Docente'),(3260,'4370_1',4,'Docente'),(3261,'4371_1',4,'Docente'),(3262,'4372_1',4,'Docente'),(3263,'4373_1',4,'Docente'),(3264,'4374_1',4,'Docente'),(3265,'4376_1',4,'Docente'),(3266,'4377_1',4,'Docente'),(3267,'4382',4,'Docente'),(3268,'4383_1',4,'Docente'),(3269,'4384_1',4,'Docente'),(3270,'4386_1',4,'Docente'),(3271,'4387_1',4,'Docente'),(3272,'4388_1',4,'Docente'),(3273,'4389_1',4,'Docente'),(3274,'4392_1',4,'Docente'),(3275,'4393_1',4,'Docente'),(3276,'4394_1',4,'Docente'),(3277,'4395_1',4,'Docente'),(3278,'4396_1',4,'Docente'),(3279,'4397_1',4,'Docente'),(3280,'4399',4,'Docente'),(3281,'4410_1',4,'Docente'),(3282,'4411_1',4,'Docente'),(3283,'4413_1',4,'Docente'),(3284,'4415_1',4,'Docente'),(3285,'4416_1',4,'Docente'),(3286,'4417_2',4,'Docente'),(3287,'4419_1',4,'Docente'),(3288,'4420_1',4,'Docente'),(3289,'4421_1',4,'Docente'),(3290,'4422',4,'Docente'),(3291,'4423_1',4,'Docente'),(3292,'4425_1',4,'Docente'),(3293,'4442_1',4,'Docente'),(3294,'4443_1',4,'Docente'),(3295,'4444_1',4,'Docente'),(3296,'4445_1',4,'Docente'),(3297,'4450_1',4,'Docente'),(3298,'4451_1',4,'Docente'),(3299,'4452',4,'Docente'),(3300,'4453_1',4,'Docente'),(3301,'4454_1',4,'Docente'),(3302,'4455_1',4,'Docente'),(3303,'4456_1',4,'Docente'),(3304,'4457_2',4,'Docente'),(3305,'4460_1',4,'Docente'),(3306,'4461_1',4,'Docente'),(3307,'4462_1',4,'Docente'),(3308,'4467_1',4,'Docente'),(3309,'4468_1',4,'Docente'),(3310,'4493_1',4,'Docente'),(3311,'4498_2',4,'Docente'),(3312,'4513_1',4,'Docente'),(3313,'4518_1',4,'Docente'),(3314,'4519_1',4,'Docente'),(3315,'4520_1',4,'Docente'),(3316,'4522_1',4,'Docente'),(3317,'4523_1',4,'Docente'),(3318,'4524_1',4,'Docente'),(3319,'4525_1',4,'Docente'),(3320,'4526_1',4,'Docente'),(3321,'4527_1',4,'Docente'),(3322,'4528_1',4,'Docente'),(3323,'4531_1',4,'Docente'),(3324,'4532_1',4,'Docente'),(3325,'4533_1',4,'Docente'),(3326,'4534_1',4,'Docente'),(3327,'4535_1',4,'Docente'),(3328,'4537_2',4,'Docente'),(3329,'4539_2',4,'Docente'),(3330,'4543_1',4,'Docente'),(3331,'4544_1',4,'Docente'),(3332,'4545_2',4,'Docente'),(3333,'4553_1',4,'Docente'),(3334,'4554_1',4,'Docente'),(3335,'4555_1',4,'Docente'),(3336,'4556_1',4,'Docente'),(3337,'4557_1',4,'Docente'),(3338,'4558_1',4,'Docente'),(3339,'4559_1',4,'Docente'),(3340,'4560_1',4,'Docente'),(3341,'4561_1',4,'Docente'),(3342,'4562_1',4,'Docente'),(3343,'4563_1',4,'Docente'),(3344,'4567_1',4,'Docente'),(3345,'4568_1',4,'Docente'),(3346,'4569_1',4,'Docente'),(3347,'4570_1',4,'Docente'),(3348,'4571_1',4,'Docente'),(3349,'4577_1',4,'Docente'),(3350,'4582_1',4,'Docente'),(3351,'4583_1',4,'Docente'),(3352,'4584_1',4,'Docente'),(3353,'4585_2',4,'Docente'),(3354,'4591_1',4,'Docente'),(3355,'4592_1',4,'Docente'),(3356,'4593_1',4,'Docente'),(3357,'4594_1',4,'Docente'),(3358,'4595_1',4,'Docente'),(3359,'4596_1',4,'Docente'),(3360,'4604_1',4,'Docente'),(3361,'4606_1',4,'Docente'),(3362,'4607_1',4,'Docente'),(3363,'4610_1',4,'Docente'),(3364,'4611_1',4,'Docente'),(3365,'4612_1',4,'Docente'),(3366,'4613_1',4,'Docente'),(3367,'4614_1',4,'Docente'),(3368,'4634_1',4,'Docente'),(3369,'4638_1',4,'Docente'),(3370,'4639_1',4,'Docente'),(3371,'4640_1',4,'Docente'),(3372,'4648_1',4,'Docente'),(3373,'4650_1',4,'Docente'),(3374,'4651_1',4,'Docente'),(3375,'4652_1',4,'Docente'),(3376,'4653_1',4,'Docente'),(3377,'4654_1',4,'Docente'),(3378,'4655_1',4,'Docente'),(3379,'4656_1',4,'Docente'),(3380,'4657_1',4,'Docente'),(3381,'4658_1',4,'Docente'),(3382,'4659_1',4,'Docente'),(3383,'4660_1',4,'Docente'),(3384,'4661_1',4,'Docente'),(3385,'4662_1',4,'Docente'),(3386,'4663_1',4,'Docente'),(3387,'4664_1',4,'Docente'),(3388,'4665_1',4,'Docente'),(3389,'4666_1',4,'Docente'),(3390,'4667_1',4,'Docente'),(3391,'4668_1',4,'Docente'),(3392,'4669_1',4,'Docente'),(3393,'4670_1',4,'Docente'),(3394,'4671_1',4,'Docente'),(3395,'4672_1',4,'Docente'),(3396,'4673_1',4,'Docente'),(3397,'4674_1',4,'Docente'),(3398,'4675_1',4,'Docente'),(3399,'4676_1',4,'Docente'),(3400,'4677_1',4,'Docente'),(3401,'4678_1',4,'Docente'),(3402,'4679_1',4,'Docente'),(3403,'4686_1',4,'Docente'),(3404,'4687_1',4,'Docente'),(3405,'4688_1',4,'Docente'),(3406,'4689_1',4,'Docente'),(3407,'4690_1',4,'Docente'),(3408,'4691_1',4,'Docente'),(3409,'4692_1',4,'Docente'),(3410,'4693_1',4,'Docente'),(3411,'4695_1',4,'Docente'),(3412,'4696_1',4,'Docente'),(3413,'4697_1',4,'Docente'),(3414,'4698_1',4,'Docente'),(3415,'4699_1',4,'Docente'),(3416,'4700_1',4,'Docente'),(3417,'4701_1',4,'Docente'),(3418,'4702_1',4,'Docente'),(3419,'4703_1',4,'Docente'),(3420,'4704_1',4,'Docente'),(3421,'4705_1',4,'Docente'),(3422,'4706_1',4,'Docente'),(3423,'4707_1',4,'Docente'),(3424,'4708_1',4,'Docente'),(3425,'4709_1',4,'Docente'),(3426,'4710_1',4,'Docente'),(3427,'4711_1',4,'Docente'),(3428,'4712_1',4,'Docente'),(3429,'4713_1',4,'Docente'),(3430,'4714_1',4,'Docente'),(3431,'4715_1',4,'Docente'),(3432,'4718_1',4,'Docente'),(3433,'4719',4,'Docente'),(3434,'4726_2',4,'Docente'),(3435,'4727_1',4,'Docente'),(3436,'4728_1',4,'Docente'),(3437,'4729_1',4,'Docente'),(3438,'4730_1',4,'Docente'),(3439,'4731_1',4,'Docente'),(3440,'4732_1',4,'Docente'),(3441,'4733_1',4,'Docente'),(3442,'4734',4,'Docente'),(3443,'4735_1',4,'Docente'),(3444,'4736_1',4,'Docente'),(3445,'4738',4,'Docente'),(3446,'4739',4,'Docente'),(3447,'4740_1',4,'Docente'),(3448,'4741_1',4,'Docente'),(3449,'4743',4,'Docente'),(3450,'4744',4,'Docente'),(3451,'4750_1',4,'Docente'),(3452,'4751_1',4,'Docente'),(3453,'4752',4,'Docente'),(3454,'4756_1',4,'Docente'),(3455,'4757_1',4,'Docente'),(3456,'4759_1',4,'Docente'),(3457,'4760_1',4,'Docente'),(3458,'4762_1',4,'Docente'),(3459,'4763_1',4,'Docente'),(3460,'4764_1',4,'Docente'),(3461,'4765_1',4,'Docente'),(3462,'4766_1',4,'Docente'),(3463,'4767_1',4,'Docente'),(3464,'4768_1',4,'Docente'),(3465,'4769_2',4,'Docente'),(3466,'4772_1',4,'Docente'),(3467,'4773_1',4,'Docente'),(3468,'4774_1',4,'Docente'),(3469,'4775_1',4,'Docente'),(3470,'4776',4,'Docente'),(3471,'4777_1',4,'Docente'),(3472,'4778_1',4,'Docente'),(3473,'4779_1',4,'Docente'),(3474,'4780_1',4,'Docente'),(3475,'4781_1',4,'Docente'),(3476,'4782_1',4,'Docente'),(3477,'4783_1',4,'Docente'),(3478,'4784_1',4,'Docente'),(3479,'4785_1',4,'Docente'),(3480,'4786',4,'Docente'),(3481,'4787_1',4,'Docente'),(3482,'4788_1',4,'Docente'),(3483,'4789',4,'Docente'),(3484,'4790',4,'Docente'),(3485,'4791_1',4,'Docente'),(3486,'4792',4,'Docente'),(3487,'4793_1',4,'Docente'),(3488,'4794_1',4,'Docente'),(3489,'4795_1',4,'Docente'),(3490,'4796_1',4,'Docente'),(3491,'4797_1',4,'Docente'),(3492,'4798_1',4,'Docente'),(3493,'4800_1',4,'Docente'),(3494,'4801_1',4,'Docente'),(3495,'4802',4,'Docente'),(3496,'4803_1',4,'Docente'),(3497,'4804_1',4,'Docente'),(3498,'4805_1',4,'Docente'),(3499,'4806',4,'Docente'),(3500,'4808',4,'Docente'),(3501,'4810_1',4,'Docente'),(3502,'4811_1',4,'Docente'),(3503,'4814_1',4,'Docente'),(3504,'4816_1',4,'Docente'),(3505,'4817_2',4,'Docente'),(3506,'4819_1',4,'Docente'),(3507,'4821_1',4,'Docente'),(3508,'4823_1',4,'Docente'),(3509,'4824_1',4,'Docente'),(3510,'4825_1',4,'Docente'),(3511,'4828_1',4,'Docente'),(3512,'4829_1',4,'Docente'),(3513,'4830_1',4,'Docente'),(3514,'4831_1',4,'Docente'),(3515,'4833_1',4,'Docente'),(3516,'4835_1',4,'Docente'),(3517,'4837_1',4,'Docente'),(3518,'4838_1',4,'Docente'),(3519,'4839_1',4,'Docente'),(3520,'4840_1',4,'Docente'),(3521,'4841_1',4,'Docente'),(3522,'4842_1',4,'Docente'),(3523,'4843_1',4,'Docente'),(3524,'4844_1',4,'Docente'),(3525,'4845_1',4,'Docente'),(3526,'4846_1',4,'Docente'),(3527,'4847_1',4,'Docente'),(3528,'4848_1',4,'Docente'),(3529,'4849_1',4,'Docente'),(3530,'4850_1',4,'Docente'),(3531,'4851_1',4,'Docente'),(3532,'4853_1',4,'Docente'),(3533,'4859_1',4,'Docente'),(3534,'4860_1',4,'Docente'),(3535,'4861_1',4,'Docente'),(3536,'4862_1',4,'Docente'),(3537,'4863_1',4,'Docente'),(3538,'4864_1',4,'Docente'),(3539,'4865_1',4,'Docente'),(3540,'4867_1',4,'Docente'),(3541,'4870_1',4,'Docente'),(3542,'4871_1',4,'Docente'),(3543,'4872_1',4,'Docente'),(3544,'4873_1',4,'Docente'),(3545,'4874',4,'Docente'),(3546,'4875_1',4,'Docente'),(3547,'4880_1',4,'Docente'),(3548,'4881_1',4,'Docente'),(3549,'4882_1',4,'Docente'),(3550,'4883_1',4,'Docente'),(3551,'4884_1',4,'Docente'),(3552,'4885_1',4,'Docente'),(3553,'4887_1',4,'Docente'),(3554,'4888',4,'Docente'),(3555,'4889_1',4,'Docente'),(3556,'4890_1',4,'Docente'),(3557,'4891_1',4,'Docente'),(3558,'4892_1',4,'Docente'),(3559,'4893_1',4,'Docente'),(3560,'4894_1',4,'Docente'),(3561,'4895',4,'Docente'),(3562,'4896_1',4,'Docente'),(3563,'4897_1',4,'Docente'),(3564,'4898_1',4,'Docente'),(3565,'4899',4,'Docente'),(3566,'4900',4,'Docente'),(3567,'4901',4,'Docente'),(3568,'4902_1',4,'Docente'),(3569,'4903_1',4,'Docente'),(3570,'4904',4,'Docente'),(3571,'4905_1',4,'Docente'),(3572,'4906_1',4,'Docente'),(3573,'4907',4,'Docente'),(3574,'4908_1',4,'Docente'),(3575,'4909_1',4,'Docente'),(3576,'4910_1',4,'Docente'),(3577,'4911_1',4,'Docente'),(3578,'4912_1',4,'Docente'),(3579,'4913_1',4,'Docente'),(3580,'4915_1',4,'Docente'),(3581,'4916_1',4,'Docente'),(3582,'4917',4,'Docente'),(3583,'4918_1',4,'Docente'),(3584,'4919_1',4,'Docente'),(3585,'4920_1',4,'Docente'),(3586,'4921_1',4,'Docente'),(3587,'4922_1',4,'Docente'),(3588,'4923_1',4,'Docente'),(3589,'4924_1',4,'Docente'),(3590,'4925_1',4,'Docente'),(3591,'4926_1',4,'Docente'),(3592,'4927_1',4,'Docente'),(3593,'4928_1',4,'Docente'),(3594,'4929_1',4,'Docente'),(3595,'4930_1',4,'Docente'),(3596,'4931',4,'Docente'),(3597,'4932_1',4,'Docente'),(3598,'4933_1',4,'Docente'),(3599,'4934_1',4,'Docente'),(3600,'4935_1',4,'Docente'),(3601,'4936',4,'Docente'),(3602,'4937_1',4,'Docente'),(3603,'4938_1',4,'Docente'),(3604,'4939_1',4,'Docente'),(3605,'4940_1',4,'Docente'),(3606,'4941_1',4,'Docente'),(3607,'4942_1',4,'Docente'),(3608,'4943_1',4,'Docente'),(3609,'4944_1',4,'Docente'),(3610,'4945_1',4,'Docente'),(3611,'4946_1',4,'Docente'),(3612,'4947_1',4,'Docente'),(3613,'4948_1',4,'Docente'),(3614,'4949_1',4,'Docente'),(3615,'4950_1',4,'Docente'),(3616,'4951_1',4,'Docente'),(3617,'4952_1',4,'Docente'),(3618,'4953_1',4,'Docente'),(3619,'4954',4,'Docente'),(3620,'4955_1',4,'Docente'),(3621,'4956_1',4,'Docente'),(3622,'4957',4,'Docente'),(3623,'4958_1',4,'Docente'),(3624,'4959_1',4,'Docente'),(3625,'4960_1',4,'Docente'),(3626,'4961_1',4,'Docente'),(3627,'4962_1',4,'Docente'),(3628,'4963_1',4,'Docente'),(3629,'4964_1',4,'Docente'),(3630,'4965',4,'Docente'),(3631,'4966_1',4,'Docente'),(3632,'4967_1',4,'Docente'),(3633,'4968_1',4,'Docente'),(3634,'4969',4,'Docente'),(3635,'4971_1',4,'Docente'),(3636,'4972_1',4,'Docente'),(3637,'4974',4,'Docente'),(3638,'4976_1',4,'Docente'),(3639,'4993_1',4,'Docente'),(3640,'4994_1',4,'Docente'),(3641,'4995_1',4,'Docente'),(3642,'4996_1',4,'Docente'),(3643,'4997_1',4,'Docente'),(3644,'4998_1',4,'Docente'),(3645,'4999_1',4,'Docente'),(3646,'5000_1',4,'Docente'),(3647,'5001_1',4,'Docente'),(3648,'5002_1',4,'Docente'),(3649,'5003_1',4,'Docente'),(3650,'5004_1',4,'Docente'),(3651,'5005_1',4,'Docente'),(3652,'5006_1',4,'Docente'),(3653,'5007_1',4,'Docente'),(3654,'5008_1',4,'Docente'),(3655,'5009_1',4,'Docente'),(3656,'5070_1',4,'Docente'),(3657,'5120_1',4,'Docente'),(3658,'5126_1',4,'Docente'),(3659,'5139_1',4,'Docente'),(3660,'5235_1',4,'Docente'),(3661,'5242_1',4,'Docente'),(3662,'5275_1',4,'Docente'),(3663,'5290_1',4,'Docente'),(3664,'5366_1',4,'Docente'),(3665,'5367_1',4,'Docente'),(3666,'5368_1',4,'Docente'),(3667,'5369_1',4,'Docente'),(3668,'5370_1',4,'Docente'),(3669,'5371_1',4,'Docente'),(3670,'5372_1',4,'Docente'),(3671,'5373_1',4,'Docente'),(3672,'5374_1',4,'Docente'),(3673,'5375_1',4,'Docente'),(3674,'5377_1',4,'Docente'),(3675,'5378_1',4,'Docente'),(3676,'5379_1',4,'Docente'),(3677,'5380_1',4,'Docente'),(3678,'5381_1',4,'Docente'),(3679,'5382_1',4,'Docente'),(3680,'5383_1',4,'Docente'),(3681,'5384_1',4,'Docente'),(3682,'5385_1',4,'Docente'),(3683,'5386_1',4,'Docente'),(3684,'5413_1',4,'Docente'),(3685,'5414_1',4,'Docente'),(3686,'5416_1',4,'Docente'),(3687,'5417_1',4,'Docente'),(3688,'5418_1',4,'Docente'),(3689,'5419_1',4,'Docente'),(3690,'5420_1',4,'Docente'),(3691,'5421_1',4,'Docente'),(3692,'5422_1',4,'Docente'),(3693,'5423_1',4,'Docente'),(3694,'5424_1',4,'Docente'),(3695,'5425_1',4,'Docente'),(3696,'5426_1',4,'Docente'),(3697,'5427_1',4,'Docente'),(3698,'5428_1',4,'Docente'),(3699,'5430_1',4,'Docente'),(3700,'5431_1',4,'Docente'),(3701,'5432_1',4,'Docente'),(3702,'5433_1',4,'Docente'),(3703,'5440_1',4,'Docente'),(3704,'5441_1',4,'Docente'),(3705,'5442_1',4,'Docente'),(3706,'5443_1',4,'Docente'),(3707,'5444_1',4,'Docente'),(3708,'5445_1',4,'Docente'),(3709,'5454_1',4,'Docente'),(3710,'5486_1',4,'Docente'),(3711,'5487_1',4,'Docente'),(3712,'5488_1',4,'Docente'),(3713,'5489_1',4,'Docente'),(3714,'5490_1',4,'Docente'),(3715,'5492_1',4,'Docente'),(3716,'5493_1',4,'Docente'),(3717,'5494_1',4,'Docente'),(3718,'5495_1',4,'Docente'),(3719,'5500_1',4,'Docente'),(3720,'5501_1',4,'Docente'),(3721,'5502_1',4,'Docente'),(3722,'5503_1',4,'Docente'),(3723,'5504_1',4,'Docente'),(3724,'5505_1',4,'Docente'),(3725,'5507_1',4,'Docente'),(3726,'5508_1',4,'Docente'),(3727,'5509_1',4,'Docente'),(3728,'5511_1',4,'Docente'),(3729,'5512_1',4,'Docente'),(3730,'5513_1',4,'Docente'),(3731,'5516_1',4,'Docente'),(3732,'5517_1',4,'Docente'),(3733,'5518_1',4,'Docente'),(3734,'5519_1',4,'Docente'),(3735,'5520_1',4,'Docente'),(3736,'5521_1',4,'Docente'),(3737,'5522_1',4,'Docente'),(3738,'5523_1',4,'Docente'),(3739,'5524_1',4,'Docente'),(3740,'5525_1',4,'Docente'),(3741,'5543_1',4,'Docente'),(3742,'5544_1',4,'Docente'),(3743,'5545_1',4,'Docente'),(3744,'5546_1',4,'Docente'),(3745,'5547_1',4,'Docente'),(3746,'5548_1',4,'Docente'),(3747,'5549_1',4,'Docente'),(3748,'5550_1',4,'Docente'),(3749,'5552_1',4,'Docente'),(3750,'5556_1',4,'Docente'),(3751,'5557_1',4,'Docente'),(3752,'5558_1',4,'Docente'),(3753,'5564_1',4,'Docente'),(3754,'5565_1',4,'Docente'),(3755,'5566_1',4,'Docente'),(3756,'5567_1',4,'Docente'),(3757,'5568_1',4,'Docente'),(3758,'5574_1',4,'Docente'),(3759,'5575_1',4,'Docente'),(3760,'5576_1',4,'Docente'),(3761,'5578_1',4,'Docente'),(3762,'5579_1',4,'Docente'),(3763,'5580_1',4,'Docente'),(3764,'5581_1',4,'Docente'),(3765,'5583_1',4,'Docente'),(3766,'5585_1',4,'Docente'),(3767,'5587_1',4,'Docente'),(3768,'5589_1',4,'Docente'),(3769,'5599_1',4,'Docente'),(3770,'5600_1',4,'Docente'),(3771,'5601_1',4,'Docente'),(3772,'5602_1',4,'Docente'),(3773,'5603_1',4,'Docente'),(3774,'5604_1',4,'Docente'),(3775,'5605_1',4,'Docente'),(3776,'5606_1',4,'Docente'),(3777,'5607_1',4,'Docente'),(3778,'5608_1',4,'Docente'),(3779,'5614_1',4,'Docente'),(3780,'5615_1',4,'Docente'),(3781,'5616_1',4,'Docente'),(3782,'5619_1',4,'Docente'),(3783,'5620_1',4,'Docente'),(3784,'5621_1',4,'Docente'),(3785,'5622_1',4,'Docente'),(3786,'5623_1',4,'Docente'),(3787,'5624_1',4,'Docente'),(3788,'5627_1',4,'Docente'),(3789,'5628_1',4,'Docente'),(3790,'5629_1',4,'Docente'),(3791,'5633_1',4,'Docente'),(3792,'5634_1',4,'Docente'),(3793,'5635_1',4,'Docente'),(3794,'5652_1',4,'Docente'),(3795,'5653_1',4,'Docente'),(3796,'5654_1',4,'Docente'),(3797,'5655_1',4,'Docente'),(3798,'5656_1',4,'Docente'),(3799,'5657_1',4,'Docente'),(3800,'5658_1',4,'Docente'),(3801,'5659_1',4,'Docente'),(3802,'5660_1',4,'Docente'),(3803,'5661_1',4,'Docente'),(3804,'5662_1',4,'Docente'),(3805,'5663_1',4,'Docente'),(3806,'5664_1',4,'Docente'),(3807,'5665_1',4,'Docente'),(3808,'5666_1',4,'Docente'),(3809,'5702_1',4,'Docente'),(3810,'5703_1',4,'Docente'),(3811,'5704_1',4,'Docente'),(3812,'5705_1',4,'Docente'),(3813,'5706_1',4,'Docente'),(3814,'5707_1',4,'Docente'),(3815,'5708_1',4,'Docente'),(3816,'5709_1',4,'Docente'),(3817,'5710_1',4,'Docente'),(3818,'5711_1',4,'Docente'),(3819,'5712_1',4,'Docente'),(3820,'5713_1',4,'Docente'),(3821,'5714_1',4,'Docente'),(3822,'5715_1',4,'Docente'),(3823,'5716_1',4,'Docente'),(3824,'5717_1',4,'Docente'),(3825,'5718_1',4,'Docente'),(3826,'5719_1',4,'Docente'),(3827,'5720_1',4,'Docente'),(3828,'5721_1',4,'Docente'),(3829,'5722_1',4,'Docente'),(3830,'5723_1',4,'Docente'),(3831,'5724_1',4,'Docente'),(3832,'5725_1',4,'Docente'),(3833,'5726_1',4,'Docente'),(3834,'5727_1',4,'Docente'),(3835,'5728_1',4,'Docente'),(3836,'5729_1',4,'Docente'),(3837,'5730_1',4,'Docente'),(3838,'5731_1',4,'Docente'),(3839,'5732_1',4,'Docente'),(3840,'5733_1',4,'Docente'),(3841,'5734_1',4,'Docente'),(3842,'5735_1',4,'Docente'),(3843,'5736_1',4,'Docente'),(3844,'5737_1',4,'Docente'),(3845,'5738_1',4,'Docente'),(3846,'5739_1',4,'Docente'),(3847,'5740_1',4,'Docente'),(3848,'5741_1',4,'Docente'),(3849,'5742_1',4,'Docente'),(3850,'5743_1',4,'Docente'),(3851,'5744_1',4,'Docente'),(3852,'5745_1',4,'Docente'),(3853,'5746_1',4,'Docente'),(3854,'5747_1',4,'Docente'),(3855,'5748_1',4,'Docente'),(3856,'5749_1',4,'Docente'),(3857,'5750_1',4,'Docente'),(3858,'5751_1',4,'Docente'),(3859,'5752_1',4,'Docente'),(3860,'5753_1',4,'Docente'),(3861,'5754_1',4,'Docente'),(3862,'5755_1',4,'Docente'),(3863,'5756_1',4,'Docente'),(3864,'5757_1',4,'Docente'),(3865,'5758_1',4,'Docente'),(3866,'5759_1',4,'Docente'),(3867,'5760_1',4,'Docente'),(3868,'5761_1',4,'Docente'),(3869,'5762_1',4,'Docente'),(3870,'5763_1',4,'Docente'),(3871,'5764_1',4,'Docente'),(3872,'5765_1',4,'Docente'),(3873,'5766_1',4,'Docente'),(3874,'5784_1',4,'Docente'),(3875,'5785_1',4,'Docente'),(3876,'5786_1',4,'Docente'),(3877,'5787_1',4,'Docente'),(3878,'5788_1',4,'Docente'),(3879,'5789_1',4,'Docente'),(3880,'5790_1',4,'Docente'),(3881,'5797_1',4,'Docente'),(3882,'5798_1',4,'Docente'),(3883,'5799_1',4,'Docente'),(3884,'5800_1',4,'Docente'),(3885,'5801_1',4,'Docente'),(3886,'5802_1',4,'Docente'),(3887,'5803_1',4,'Docente'),(3888,'5804_1',4,'Docente'),(3889,'5805_1',4,'Docente'),(3890,'5806_1',4,'Docente'),(3891,'5807_1',4,'Docente'),(3892,'5808_1',4,'Docente'),(3893,'5809_1',4,'Docente'),(3894,'5810_1',4,'Docente'),(3895,'5811_1',4,'Docente'),(3896,'5812_1',4,'Docente'),(3897,'5813_1',4,'Docente'),(3898,'5814_1',4,'Docente'),(3899,'5815_1',4,'Docente'),(3900,'5816_1',4,'Docente'),(3901,'5817_1',4,'Docente'),(3902,'5818_1',4,'Docente'),(3903,'5819_1',4,'Docente'),(3904,'5820_1',4,'Docente'),(3905,'5821_1',4,'Docente'),(3906,'5822_1',4,'Docente'),(3907,'5823_1',4,'Docente'),(3908,'5824_1',4,'Docente'),(3909,'5825_1',4,'Docente'),(3910,'5826_1',4,'Docente'),(3911,'5827_1',4,'Docente'),(3912,'5828_1',4,'Docente'),(3913,'5829_1',4,'Docente'),(3914,'5830_1',4,'Docente'),(3915,'5831_1',4,'Docente'),(3916,'5832_1',4,'Docente'),(3917,'5850_1',4,'Docente'),(3918,'5861_1',4,'Docente'),(3919,'5862_1',4,'Docente'),(3920,'5863_1',4,'Docente'),(3921,'5864_1',4,'Docente'),(3922,'5865_1',4,'Docente'),(3923,'5866_1',4,'Docente'),(3924,'5867_1',4,'Docente'),(3925,'5868_1',4,'Docente'),(3926,'5869_1',4,'Docente'),(3927,'5870_1',4,'Docente'),(3928,'5871_1',4,'Docente'),(3929,'5872_1',4,'Docente'),(3930,'5873_1',4,'Docente'),(3931,'5874_1',4,'Docente'),(3932,'5875_1',4,'Docente'),(3933,'5876_1',4,'Docente'),(3934,'5877_1',4,'Docente'),(3935,'5878_1',4,'Docente'),(3936,'5879_1',4,'Docente'),(3937,'5880_1',4,'Docente'),(3938,'5881_1',4,'Docente'),(3939,'5882_1',4,'Docente'),(3940,'5883_1',4,'Docente'),(3941,'5884_1',4,'Docente'),(3942,'5885_1',4,'Docente'),(3943,'5886_1',4,'Docente'),(3944,'5887_1',4,'Docente'),(3945,'5888_1',4,'Docente'),(3946,'5889_1',4,'Docente'),(3947,'5890_1',4,'Docente'),(3948,'5892_1',4,'Docente'),(3949,'5893_1',4,'Docente'),(3950,'5894_1',4,'Docente'),(3951,'5895_1',4,'Docente'),(3952,'5896_1',4,'Docente'),(3953,'5897_1',4,'Docente'),(3954,'5898_1',4,'Docente'),(3955,'5899_1',4,'Docente'),(3956,'5900_1',4,'Docente'),(3957,'5901_1',4,'Docente'),(3958,'DC001X',4,'Docente'),(3959,'DC8X10',4,'Docente'),(3960,'DC8X21',4,'Docente'),(3961,'DC9X04',4,'Docente'),(3962,'S042',4,'Docente'),(3963,'S043',4,'Docente'),(3964,'SC001',4,'Docente'),(3965,'SC037',4,'Docente'),(3966,'SC045',4,'Docente'),(3967,'SC049',4,'Docente'),(3968,'SC050',4,'Docente'),(3969,'XXXX_X',4,'Docente'),(3970,'20143489',1,'Estudiante'),(3971,'repo',7,'Administrativo');
/*!40000 ALTER TABLE `gt_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gt_usuario_grado_procedimiento`
--

DROP TABLE IF EXISTS `gt_usuario_grado_procedimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gt_usuario_grado_procedimiento` (
  `idusuario` int(11) NOT NULL,
  `idgrado_procedimiento` int(11) NOT NULL,
  PRIMARY KEY (`idusuario`,`idgrado_procedimiento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gt_usuario_grado_procedimiento`
--

LOCK TABLES `gt_usuario_grado_procedimiento` WRITE;
/*!40000 ALTER TABLE `gt_usuario_grado_procedimiento` DISABLE KEYS */;
/*!40000 ALTER TABLE `gt_usuario_grado_procedimiento` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-05-25 17:59:24
