-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: colegiohuetamo
-- ------------------------------------------------------
-- Server version	8.0.33

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `actividades`
--

DROP TABLE IF EXISTS `actividades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `actividades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `valor` int DEFAULT NULL,
  `unidad` varchar(45) DEFAULT NULL,
  `id_grupo` int NOT NULL,
  `id_materia` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_materia` (`id_materia`),
  KEY `actividades_ibfk_2_idx` (`id_grupo`),
  KEY `actividades_ibfk_3_idx` (`id_grupo`),
  CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`),
  CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `numero_control` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--


--
-- Table structure for table `calificacion_final`
--

DROP TABLE IF EXISTS `calificacion_final`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificacion_final` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_student` int NOT NULL,
  `id_materia` int NOT NULL,
  `periodo` varchar(45) NOT NULL,
  `calificacion_final` decimal(5,2) NOT NULL,
  `retroalimentacion_final` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `calificacion_final_fkn1_idx` (`id_student`),
  KEY `calificacion_final_fkn2_idx` (`id_materia`),
  CONSTRAINT `calificacion_final_fkn1` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`),
  CONSTRAINT `calificacion_final_fkn2` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificacion_final`
--


--
-- Table structure for table `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_actividad` int NOT NULL,
  `id_student` int NOT NULL,
  `calificacion` decimal(5,2) DEFAULT NULL,
  `retroalimentacion` varchar(45) DEFAULT NULL,
  `estado` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_actividad` (`id_actividad`),
  KEY `id_student` (`id_student`),
  CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_actividad`) REFERENCES `actividades` (`id`),
  CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`id_student`) REFERENCES `student` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificaciones`
--

--
-- Table structure for table `grupos`
--

DROP TABLE IF EXISTS `grupos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupos`
--

LOCK TABLES `grupos` WRITE;
/*!40000 ALTER TABLE `grupos` DISABLE KEYS */;
INSERT INTO `grupos` VALUES (15,'1ro A'),(16,'1ro B'),(17,'2do A'),(18,'2do B'),(19,'3ro A'),(20,'3ro B');
/*!40000 ALTER TABLE `grupos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materia_grupo`
--

DROP TABLE IF EXISTS `materia_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materia_grupo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_materia` int NOT NULL,
  `id_grupo` int NOT NULL,
  `id_teacher` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_materia` (`id_materia`),
  KEY `id_grupo` (`id_grupo`),
  KEY `materia_grupo_ibfk_3_idx` (`id_teacher`),
  CONSTRAINT `materia_grupo_ibfk_1` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id`),
  CONSTRAINT `materia_grupo_ibfk_2` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`),
  CONSTRAINT `materia_grupo_ibfk_3` FOREIGN KEY (`id_teacher`) REFERENCES `teacher` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materia_grupo`
--

LOCK TABLES `materia_grupo` WRITE;
/*!40000 ALTER TABLE `materia_grupo` DISABLE KEYS */;
INSERT INTO `materia_grupo` VALUES (40,21,15,7),(42,22,15,8),(43,24,16,7),(44,26,16,8),(46,27,17,7),(47,28,17,8),(49,30,18,7),(50,31,18,8),(53,34,19,7),(54,35,19,8),(56,37,20,7),(57,38,20,8),(58,23,15,10),(59,25,16,10),(60,29,17,10),(61,32,18,10),(62,33,19,10),(63,36,20,10);
/*!40000 ALTER TABLE `materia_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias`
--

DROP TABLE IF EXISTS `materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `clave` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
INSERT INTO `materias` VALUES (21,'1ABMAT','Español'),(22,'1ABMAT','Matematicas'),(23,'1ABMAT','Historia'),(24,'1ABMAT','Geografia'),(25,'1ABMAT','Etica'),(26,'1ABMAT','Quimica'),(27,'2ABMAT','Español II'),(28,'2ABMAT','Matematicas II'),(29,'2ABMAT','Historia II'),(30,'2ABMAT','Fisica'),(31,'2ABMAT','Etica II'),(32,'2ABMAT','Quimica II'),(33,'3ABMAT','Español III'),(34,'3ABMAT','Algebra'),(35,'3ABMAT','Historia de México'),(36,'3ABMAT','Biologia'),(37,'3ABMAT','Calculo Integral'),(38,'3ABMAT','Inovacion y Calidad'),(39,'1ABMAT','Español-B'),(40,'1ABMAT','Matematicas-B'),(41,'1ABMAT','Historia-B'),(42,'1ABMAT','Geografia-B'),(43,'1ABMAT','Etica-B'),(44,'1ABMAT','Quimica-B'),(45,'2ABMAT','Español II-B'),(46,'2ABMAT','Matematicas II-B'),(47,'2ABMAT','Historia II-B'),(48,'2ABMAT','Fisica-B'),(49,'2ABMAT','Etica II-B'),(50,'2ABMAT','Quimica II-B'),(51,'3ABMAT','Español III-B'),(52,'3ABMAT','Algebra-B'),(53,'3ABMAT','Historia de México-B'),(54,'3ABMAT','Biologia-B'),(55,'3ABMAT','Calculo Integral-B'),(56,'3ABMAT','Inovacion y Calidad-B');
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `curp` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `segundo_apellido` varchar(50) NOT NULL,
  `correo_electronico` varchar(50) NOT NULL,
  `id_tutor` int NOT NULL,
  `id_grupo` int NOT NULL,
  `foto` mediumblob,
  `mime_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_tutor` (`id_tutor`),
  KEY `student_ibfk_3_idx` (`id_grupo`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `student_ibfk_2` FOREIGN KEY (`id_tutor`) REFERENCES `tutor` (`id`),
  CONSTRAINT `student_ibfk_3` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--


--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teacher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `segundo_apellido` varchar(50) NOT NULL,
  `correo_electronico` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `nivel_estudios` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher`
--

LOCK TABLES `teacher` WRITE;
/*!40000 ALTER TABLE `teacher` DISABLE KEYS */;
INSERT INTO `teacher` VALUES (7,76,'José Claudio','Salgado','Betancurth','claudio.sb@huetamo.tecnm.mx','4351045910','Ing. Sistemas Computacionales'),(8,77,'Mariela Yanin','Magaña ','Gutierrez','mariela.mg@huetamo.tecnm.mx','4251290045','Dra. Sistemas Computacionales'),(10,93,'Esbeyde','Mora','Sánchez','esbeyde.ms@huetamo.tecnm.mx','5214351058349','Ing. Sistemas Computacionales');
/*!40000 ALTER TABLE `teacher` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutor`
--

DROP TABLE IF EXISTS `tutor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `primer_apellido` varchar(50) NOT NULL,
  `segundo_apellido` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `num_con_hijo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;



DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-18 21:59:17
