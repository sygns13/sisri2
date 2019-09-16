-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.7.20-log


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema bdsisri2
--

CREATE DATABASE IF NOT EXISTS bdsisri2;
USE bdsisri2;

--
-- Definition of table `administrativos`
--

DROP TABLE IF EXISTS `administrativos`;
CREATE TABLE `administrativos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `local_id` int(11) DEFAULT NULL,
  `tipoDependencia` tinyint(4) DEFAULT NULL,
  `dependencia` varchar(500) DEFAULT NULL,
  `facultad` varchar(500) DEFAULT NULL,
  `escuela` varchar(500) DEFAULT NULL,
  `cargo` varchar(500) DEFAULT NULL,
  `descripcionCargo` text,
  `grado` tinyint(4) DEFAULT NULL,
  `descripcionGrado` varchar(500) DEFAULT NULL,
  `esTitulado` tinyint(4) DEFAULT NULL,
  `descripcionTitulo` varchar(500) DEFAULT NULL,
  `lugarGrado` varchar(500) DEFAULT NULL,
  `paisGrado` varchar(500) DEFAULT NULL,
  `fechaIngreso` date DEFAULT NULL,
  `observaciones` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `condicion` varchar(500) DEFAULT NULL,
  `fechaSalida` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_administrativos_personas1_idx` (`persona_id`),
  CONSTRAINT `fk_administrativos_personas1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administrativos`
--

/*!40000 ALTER TABLE `administrativos` DISABLE KEYS */;
INSERT INTO `administrativos` (`id`,`persona_id`,`local_id`,`tipoDependencia`,`dependencia`,`facultad`,`escuela`,`cargo`,`descripcionCargo`,`grado`,`descripcionGrado`,`esTitulado`,`descripcionTitulo`,`lugarGrado`,`paisGrado`,`fechaIngreso`,`observaciones`,`activo`,`borrado`,`created_at`,`updated_at`,`estado`,`condicion`,`fechaSalida`) VALUES 
 (1,33,2,9,'Facultad de Ciencias Médicas','Facultad de Ciencias Médicas','0','Director de Escuela','Director de Escuela de Sistemas',0,'',0,'','','','2010-10-02','obs',1,0,'2019-09-11 22:30:26','2019-09-11 22:40:54',1,'Contratado',NULL),
 (2,34,2,3,'dependencia','0','0','Director de Oficina','asdasd',0,'',0,'','','','2019-08-26','obs',1,0,'2019-09-11 22:42:31','2019-09-11 22:42:31',0,'Contratado','2019-09-10');
/*!40000 ALTER TABLE `administrativos` ENABLE KEYS */;


--
-- Definition of table `adminlocacions`
--

DROP TABLE IF EXISTS `adminlocacions`;
CREATE TABLE `adminlocacions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `local_id` tinyint(4) DEFAULT NULL,
  `tipoDependencia` tinyint(4) DEFAULT NULL,
  `dependencia` varchar(500) DEFAULT NULL,
  `facultad` varchar(500) DEFAULT NULL,
  `escuela` varchar(500) DEFAULT NULL,
  `cargo` varchar(500) DEFAULT NULL,
  `descripcionCargo` text,
  `grado` tinyint(4) DEFAULT NULL,
  `descripcionGrado` varchar(500) DEFAULT NULL,
  `lugarGrado` varchar(500) DEFAULT NULL,
  `paisGrado` varchar(500) DEFAULT NULL,
  `estitulado` tinyint(4) DEFAULT NULL,
  `descripcionTitulo` varchar(500) DEFAULT NULL,
  `condicionLaboral` varchar(500) DEFAULT NULL,
  `regimenLaboral` varchar(500) DEFAULT NULL,
  `fechaIngreso` date DEFAULT NULL,
  `fechaInicioContrato` date DEFAULT NULL,
  `fechaFinContrato` date DEFAULT NULL,
  `observaciones` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_adminlocacions_personas1_idx` (`persona_id`),
  CONSTRAINT `fk_adminlocacions_personas1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `adminlocacions`
--

/*!40000 ALTER TABLE `adminlocacions` DISABLE KEYS */;
INSERT INTO `adminlocacions` (`id`,`persona_id`,`local_id`,`tipoDependencia`,`dependencia`,`facultad`,`escuela`,`cargo`,`descripcionCargo`,`grado`,`descripcionGrado`,`lugarGrado`,`paisGrado`,`estitulado`,`descripcionTitulo`,`condicionLaboral`,`regimenLaboral`,`fechaIngreso`,`fechaInicioContrato`,`fechaFinContrato`,`observaciones`,`activo`,`borrado`,`created_at`,`updated_at`,`estado`) VALUES 
 (1,2,2,10,'Ingeniería sanitaria','0','Ingeniería sanitaria','Jefe de Departamento Académico','jefe de dep acad',4,'bachiller sistemas','Internacional','chile',1,'titulo','locacion','regimen','2015-02-02','2010-02-01','2020-02-01','obs reg',1,0,'2019-09-11 23:31:23','2019-09-11 23:44:45',1);
/*!40000 ALTER TABLE `adminlocacions` ENABLE KEYS */;


--
-- Definition of table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodoMatricula` varchar(500) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `escalaPago` tinyint(4) DEFAULT NULL,
  `promedioPonderado` double DEFAULT NULL,
  `promedioSemestre` double DEFAULT NULL,
  `periodoIngreso` int(11) DEFAULT NULL,
  `primerPeriodoMatricula` int(11) DEFAULT NULL,
  `alumnoRiesgo` tinyint(4) DEFAULT NULL,
  `numCursosRiesgo` int(11) DEFAULT NULL,
  `observaciones` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `persona_id` int(11) NOT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `descestado` text,
  `codigo` varchar(50) DEFAULT NULL,
  `tituladoOtraCarrera` tinyint(4) DEFAULT NULL,
  `egresadoOtraCarrera` tinyint(4) DEFAULT NULL,
  `otraCarrera` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  `grado` tinyint(4) DEFAULT NULL,
  `nombreGrado` varchar(500) DEFAULT NULL,
  `escalaPagodesc` varchar(500) DEFAULT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  `movinacional` text,
  `moviinternacional` text,
  `ismovnacional` tinyint(4) DEFAULT NULL,
  `ismovinternacional` tinyint(4) DEFAULT NULL,
  `otrotitulo` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_alumnos_escuelas1_idx` (`escuela_id`),
  KEY `fk_alumnos_personas1_idx` (`persona_id`),
  CONSTRAINT `fk_alumnos_escuelas1` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_alumnos_personas1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alumnos`
--

/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT INTO `alumnos` (`id`,`periodoMatricula`,`escuela_id`,`escalaPago`,`promedioPonderado`,`promedioSemestre`,`periodoIngreso`,`primerPeriodoMatricula`,`alumnoRiesgo`,`numCursosRiesgo`,`observaciones`,`activo`,`borrado`,`created_at`,`updated_at`,`persona_id`,`estado`,`descestado`,`codigo`,`tituladoOtraCarrera`,`egresadoOtraCarrera`,`otraCarrera`,`email`,`tipo`,`grado`,`nombreGrado`,`escalaPagodesc`,`semestre_id`,`movinacional`,`moviinternacional`,`ismovnacional`,`ismovinternacional`,`otrotitulo`) VALUES 
 (2,NULL,9,1,12,11,2,2,1,2,'alumno prueba edited',1,0,'2019-09-08 15:08:19','2019-09-08 16:49:07',12,1,NULL,'081.2502.635',0,0,'','emailexample@mail.com',1,0,'','se paga esta',1,'se fue a esta en la nacional','',1,0,''),
 (3,NULL,16,1,12,11,2,1,0,0,'none',1,0,'2019-09-08 15:40:34','2019-09-08 15:40:34',13,1,NULL,'082.5695',0,0,'','jorge@unasam.edu.pe',1,0,'','paga 50 soles al mes',1,'','',0,0,NULL),
 (5,NULL,4,0,12,4,2,1,0,0,'asdasasd',1,0,'2019-09-08 16:26:40','2019-09-08 16:55:22',15,1,NULL,'adasd',1,1,'egres','asdsa@mail.com',2,0,'','',1,'','',0,0,'titut'),
 (6,NULL,3,0,12,11,2,2,0,0,'asdsad',1,0,'2019-09-08 16:31:27','2019-09-08 16:54:47',11,1,NULL,'123123',1,0,'','asdsad@mail.com',2,0,'','',1,'','',0,0,'otra carrera2'),
 (7,NULL,10,0,15,11,2,2,0,0,'asdasd',1,0,'2019-09-08 16:48:01','2019-09-08 16:49:27',16,1,NULL,'21dsad12ads',0,1,'asdasdasd','daasdsa@mail.com',2,0,'','',1,'','',0,0,''),
 (8,NULL,1,1,12,11,2,2,1,2,'asdsad',1,0,'2019-09-08 16:48:57','2019-09-08 16:48:57',17,1,NULL,'aasdsa123sadsad',0,0,'','asdsad@mail.com',1,0,'','adasd213asdsa',1,'asdas','asdasd',1,1,''),
 (11,NULL,NULL,1,12,11,0,0,0,0,'asdsadasd edited',1,0,'2019-09-08 22:12:23','2019-09-08 22:34:20',26,1,NULL,'asdsa12adsad',0,0,'','dasdsadas@mail.com',3,3,'assadsadasd','asdsadsad edited 50 soles',1,'','',0,0,''),
 (12,NULL,6,0,12,14,2,2,0,0,'asdsadsad',1,0,'2019-09-08 22:14:11','2019-09-08 22:14:11',27,1,NULL,'5683',0,0,'','asdasd@mail.com',1,0,'','asdsadsa123',1,'sadsad','asdsadsad',1,1,''),
 (13,NULL,1,0,12,14,1,1,0,0,'asdasd',1,0,'2019-09-08 22:15:49','2019-09-08 22:15:49',28,1,NULL,'asdasdas',0,0,'','asdasd@mail.com',1,0,'','',1,'','',0,0,''),
 (16,NULL,NULL,0,16,17,0,0,0,0,'asdsad asdsad asdsa sad edited',1,0,'2019-09-08 22:53:47','2019-09-08 22:54:39',30,1,NULL,'12312sad',0,0,'','dasdsa@mail.com',4,3,'Informatica','',2,'','',0,0,'');
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;


--
-- Definition of table `atencions`
--

DROP TABLE IF EXISTS `atencions`;
CREATE TABLE `atencions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anio` int(11) DEFAULT NULL,
  `mes` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `programassalud_id` int(11) NOT NULL,
  `tipobeneficiario` tinyint(4) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`),
  KEY `fk_atenciones_programassaluds1_idx` (`programassalud_id`),
  CONSTRAINT `fk_atenciones_programassaluds1` FOREIGN KEY (`programassalud_id`) REFERENCES `programassaluds` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `atencions`
--

/*!40000 ALTER TABLE `atencions` DISABLE KEYS */;
INSERT INTO `atencions` (`id`,`anio`,`mes`,`cantidad`,`activo`,`borrado`,`created_at`,`updated_at`,`programassalud_id`,`tipobeneficiario`,`observaciones`) VALUES 
 (2,2019,6,43,1,0,'2019-09-15 00:48:25','2019-09-15 00:51:33',2,2,'asdsa');
/*!40000 ALTER TABLE `atencions` ENABLE KEYS */;


--
-- Definition of table `beneficiarios`
--

DROP TABLE IF EXISTS `beneficiarios`;
CREATE TABLE `beneficiarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(4) DEFAULT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `programassalud_id` int(11) NOT NULL,
  `observaciones` text,
  `fechaatencion` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_beneficiarios_programassaluds1_idx` (`programassalud_id`),
  CONSTRAINT `fk_beneficiarios_programassaluds1` FOREIGN KEY (`programassalud_id`) REFERENCES `programassaluds` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `beneficiarios`
--

/*!40000 ALTER TABLE `beneficiarios` DISABLE KEYS */;
INSERT INTO `beneficiarios` (`id`,`tipo`,`persona_id`,`activo`,`borrado`,`created_at`,`updated_at`,`codigo`,`programassalud_id`,`observaciones`,`fechaatencion`) VALUES 
 (1,3,45,1,0,'2019-09-14 23:50:34','2019-09-14 23:52:16',NULL,2,'asdsadas','2019-09-12');
/*!40000 ALTER TABLE `beneficiarios` ENABLE KEYS */;


--
-- Definition of table `beneficiarioscomedors`
--

DROP TABLE IF EXISTS `beneficiarioscomedors`;
CREATE TABLE `beneficiarioscomedors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `beneficiarioscomedors`
--

/*!40000 ALTER TABLE `beneficiarioscomedors` DISABLE KEYS */;
/*!40000 ALTER TABLE `beneficiarioscomedors` ENABLE KEYS */;


--
-- Definition of table `beneficiariosgyms`
--

DROP TABLE IF EXISTS `beneficiariosgyms`;
CREATE TABLE `beneficiariosgyms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `beneficiariosgyms`
--

/*!40000 ALTER TABLE `beneficiariosgyms` DISABLE KEYS */;
/*!40000 ALTER TABLE `beneficiariosgyms` ENABLE KEYS */;


--
-- Definition of table `beneficiariostalldeportivos`
--

DROP TABLE IF EXISTS `beneficiariostalldeportivos`;
CREATE TABLE `beneficiariostalldeportivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  `disciplina` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `beneficiariostalldeportivos`
--

/*!40000 ALTER TABLE `beneficiariostalldeportivos` DISABLE KEYS */;
/*!40000 ALTER TABLE `beneficiariostalldeportivos` ENABLE KEYS */;


--
-- Definition of table `colegios`
--

DROP TABLE IF EXISTS `colegios`;
CREATE TABLE `colegios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `tipogestion` varchar(100) DEFAULT NULL,
  `codmodular` varchar(45) DEFAULT NULL,
  `distrito` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `colegios`
--

/*!40000 ALTER TABLE `colegios` DISABLE KEYS */;
/*!40000 ALTER TABLE `colegios` ENABLE KEYS */;


--
-- Definition of table `convenios`
--

DROP TABLE IF EXISTS `convenios`;
CREATE TABLE `convenios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `descripcion` text,
  `institucion` varchar(500) DEFAULT NULL,
  `resolucion` varchar(500) DEFAULT NULL,
  `objetivo` varchar(500) DEFAULT NULL,
  `obligaciones` text,
  `fechainicio` date DEFAULT NULL,
  `fechafinal` date DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `convenios`
--

/*!40000 ALTER TABLE `convenios` DISABLE KEYS */;
INSERT INTO `convenios` (`id`,`nombre`,`descripcion`,`institucion`,`resolucion`,`objetivo`,`obligaciones`,`fechainicio`,`fechafinal`,`estado`,`activo`,`borrado`,`created_at`,`updated_at`,`tipo`) VALUES 
 (1,'convenio marcoe','desc convenio e','insti convenio e','res convenio e','obj convenio e','oblig convenio e','2015-02-05','2011-05-02',0,1,0,'2019-09-14 17:31:51','2019-09-14 17:33:32',1),
 (3,'asdas','dsad','asd','dsad','dsad','dsa','2019-09-05','2019-09-25',1,1,0,'2019-09-14 17:36:57','2019-09-14 17:36:57',2),
 (6,'asdas','dsad','dsa','dsa','dsa','das','2019-09-11','2019-09-26',1,1,0,'2019-09-14 17:40:14','2019-09-14 17:40:14',3);
/*!40000 ALTER TABLE `convenios` ENABLE KEYS */;


--
-- Definition of table `datosfacultads`
--

DROP TABLE IF EXISTS `datosfacultads`;
CREATE TABLE `datosfacultads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `descripcion` text,
  `cantidad` int(11) DEFAULT NULL,
  `subnombre` varchar(500) DEFAULT NULL,
  `descripcion2` text,
  `cantidad2` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipodato_id` int(11) NOT NULL,
  `facultad_id` int(11) NOT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_datosfacultads_tipodatos1_idx` (`tipodato_id`),
  KEY `fk_datosfacultads_facultads1_idx` (`facultad_id`),
  CONSTRAINT `fk_datosfacultads_facultads1` FOREIGN KEY (`facultad_id`) REFERENCES `facultads` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_datosfacultads_tipodatos1` FOREIGN KEY (`tipodato_id`) REFERENCES `tipodatos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `datosfacultads`
--

/*!40000 ALTER TABLE `datosfacultads` DISABLE KEYS */;
INSERT INTO `datosfacultads` (`id`,`nombre`,`descripcion`,`cantidad`,`subnombre`,`descripcion2`,`cantidad2`,`activo`,`borrado`,`created_at`,`updated_at`,`tipodato_id`,`facultad_id`,`semestre_id`) VALUES 
 (2,NULL,'',4,'','',31,1,0,'2019-08-25 16:35:00','2019-08-25 17:54:57',1,6,1),
 (3,'Monitores','',80,'','',0,1,0,'2019-08-25 16:35:24','2019-08-25 16:35:24',2,6,1),
 (4,NULL,'',5,'','',0,1,0,'2019-08-25 16:35:34','2019-08-25 16:35:34',3,6,1),
 (5,'Especialidad de Algoritmia','',32,'','',0,1,0,'2019-08-25 16:35:54','2019-08-25 16:35:54',4,6,1),
 (6,'Convenio con la Universidad del Santa','',NULL,'','',0,1,0,'2019-08-25 16:39:48','2019-08-25 16:39:48',5,6,1),
 (7,'Colación de estudiantes el 31 de Enero del 2019','',NULL,'','',0,1,0,'2019-08-25 16:40:01','2019-08-25 16:40:01',6,6,1),
 (8,NULL,'',115,'','',0,1,0,'2019-08-25 16:40:12','2019-08-25 16:40:12',7,6,1),
 (9,NULL,'',113,'','',0,1,0,'2019-08-25 16:40:19','2019-08-25 16:40:19',8,6,1),
 (10,NULL,'',40,'','',0,1,0,'2019-08-25 16:40:27','2019-08-25 16:40:27',9,6,1),
 (11,NULL,'',32,'','',0,1,0,'2019-08-25 16:40:32','2019-08-25 16:40:32',10,6,1),
 (12,NULL,'',15,'','',0,1,0,'2019-08-25 16:40:40','2019-08-25 16:40:40',11,6,1),
 (13,NULL,'',5,'','',0,1,0,'2019-08-25 16:40:45','2019-08-25 16:40:45',12,6,1),
 (14,NULL,'',19,'','',0,1,0,'2019-08-25 16:40:51','2019-08-25 16:40:51',13,6,1),
 (15,NULL,'',23,'','',0,1,0,'2019-08-25 16:40:57','2019-08-25 16:40:57',14,6,1),
 (16,NULL,'',16,'','',0,1,0,'2019-08-25 16:41:03','2019-08-25 16:41:03',15,6,1),
 (17,NULL,'',17,'','',0,1,0,'2019-08-25 16:41:08','2019-08-25 16:41:08',16,6,1),
 (18,NULL,'',14,'','',0,1,0,'2019-08-25 16:41:13','2019-09-04 23:15:08',17,6,1),
 (19,NULL,'',87,'','',0,1,0,'2019-08-25 16:41:18','2019-08-25 16:41:18',18,6,1),
 (20,NULL,'',66,'','',0,1,0,'2019-08-25 16:41:38','2019-08-25 16:41:38',18,6,2);
/*!40000 ALTER TABLE `datosfacultads` ENABLE KEYS */;


--
-- Definition of table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `paise_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_departamentos_paises1_idx` (`paise_id`),
  CONSTRAINT `fk_departamentos_paises1` FOREIGN KEY (`paise_id`) REFERENCES `paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `departamentos`
--

/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` (`id`,`nombre`,`codigo`,`activo`,`borrado`,`created_at`,`updated_at`,`paise_id`) VALUES 
 (1,'AMAZONAS','01',1,0,NULL,NULL,1),
 (2,'ANCASH','02',1,0,NULL,NULL,1),
 (3,'APURIMAC','03',1,0,NULL,NULL,1),
 (4,'AREQUIPA','04',1,0,NULL,NULL,1),
 (5,'AYACUCHO','05',1,0,NULL,NULL,1),
 (6,'CAJAMARCA','06',1,0,NULL,NULL,1),
 (7,'CUSCO','07',1,0,NULL,NULL,1),
 (8,'HUANCAVELICA','08',1,0,NULL,NULL,1),
 (9,'HUANUCO','09',1,0,NULL,NULL,1),
 (10,'ICA','10',1,0,NULL,NULL,1),
 (11,'JUNIN','11',1,0,NULL,NULL,1),
 (12,'LA LIBERTAD','12',1,0,NULL,NULL,1),
 (13,'LAMBAYEQUE','13',1,0,NULL,NULL,1),
 (14,'LIMA','14',1,0,NULL,NULL,1),
 (15,'LORETO','15',1,0,NULL,NULL,1),
 (16,'MADRE DE DIOS','16',1,0,NULL,NULL,1),
 (17,'MOQUEGUA','17',1,0,NULL,NULL,1),
 (18,'PASCO','18',1,0,NULL,NULL,1),
 (19,'PIURA','19',1,0,NULL,NULL,1),
 (20,'PUNO','20',1,0,NULL,NULL,1),
 (21,'SAN MARTIN','21',1,0,NULL,NULL,1),
 (22,'TACNA','22',1,0,NULL,NULL,1),
 (23,'TUMBES','23',1,0,NULL,NULL,1),
 (24,'CALLAO','24',1,0,NULL,NULL,1),
 (25,'UCAYALI','25',1,0,NULL,NULL,1);
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;


--
-- Definition of table `detalleinvestigacions`
--

DROP TABLE IF EXISTS `detalleinvestigacions`;
CREATE TABLE `detalleinvestigacions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `investigacion_id` int(11) NOT NULL,
  `cargo` varchar(500) DEFAULT NULL,
  `tipoAutor` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `investigador_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_docentes_has_investigaciones_investigaciones1_idx` (`investigacion_id`),
  KEY `fk_detalleinvestigacions_investigadors1_idx` (`investigador_id`),
  CONSTRAINT `fk_detalleinvestigacions_investigadors1` FOREIGN KEY (`investigador_id`) REFERENCES `investigadors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_docentes_has_investigaciones_investigaciones1` FOREIGN KEY (`investigacion_id`) REFERENCES `investigacions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detalleinvestigacions`
--

/*!40000 ALTER TABLE `detalleinvestigacions` DISABLE KEYS */;
/*!40000 ALTER TABLE `detalleinvestigacions` ENABLE KEYS */;


--
-- Definition of table `distritos`
--

DROP TABLE IF EXISTS `distritos`;
CREATE TABLE `distritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `provincia_id` int(11) NOT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_distritos_provincias1_idx` (`provincia_id`),
  CONSTRAINT `fk_distritos_provincias1` FOREIGN KEY (`provincia_id`) REFERENCES `provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1847 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `distritos`
--

/*!40000 ALTER TABLE `distritos` DISABLE KEYS */;
INSERT INTO `distritos` (`id`,`nombre`,`codigo`,`provincia_id`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'CHACHAPOYAS','01',1,1,0,NULL,NULL),
 (2,'ASUNCION','02',1,1,0,NULL,NULL),
 (3,'BALSAS','03',1,1,0,NULL,NULL),
 (4,'CHETO','04',1,1,0,NULL,NULL),
 (5,'CHILIQUIN','05',1,1,0,NULL,NULL),
 (6,'CHUQUIBAMBA','06',1,1,0,NULL,NULL),
 (7,'GRANADA','07',1,1,0,NULL,NULL),
 (8,'HUANCAS','08',1,1,0,NULL,NULL),
 (9,'LA JALCA','09',1,1,0,NULL,NULL),
 (10,'LEIMEBAMBA','10',1,1,0,NULL,NULL),
 (11,'LEVANTO','11',1,1,0,NULL,NULL),
 (12,'MAGDALENA','12',1,1,0,NULL,NULL),
 (13,'MARISCAL CASTILLA','13',1,1,0,NULL,NULL),
 (14,'MOLINOPAMPA','14',1,1,0,NULL,NULL),
 (15,'MONTEVIDEO','15',1,1,0,NULL,NULL),
 (16,'OLLEROS','16',1,1,0,NULL,NULL),
 (17,'QUINJALCA','17',1,1,0,NULL,NULL),
 (18,'SAN FRANCISCO DE DAGUAS','18',1,1,0,NULL,NULL),
 (19,'SAN ISIDRO DE MAINO','19',1,1,0,NULL,NULL),
 (20,'SOLOCO','20',1,1,0,NULL,NULL),
 (21,'SONCHE','21',1,1,0,NULL,NULL),
 (22,'LA PECA','01',2,1,0,NULL,NULL),
 (23,'ARAMANGO','02',2,1,0,NULL,NULL),
 (24,'COPALLIN','03',2,1,0,NULL,NULL),
 (25,'EL PARCO','04',2,1,0,NULL,NULL),
 (26,'BAGUA','05',2,1,0,NULL,NULL),
 (27,'IMAZA','06',2,1,0,NULL,NULL),
 (28,'JUMBILLA','01',3,1,0,NULL,NULL),
 (29,'COROSHA','02',3,1,0,NULL,NULL),
 (30,'CUISPES','03',3,1,0,NULL,NULL),
 (31,'CHISQUILLA','04',3,1,0,NULL,NULL),
 (32,'CHURUJA','05',3,1,0,NULL,NULL),
 (33,'FLORIDA','06',3,1,0,NULL,NULL),
 (34,'RECTA','07',3,1,0,NULL,NULL),
 (35,'SAN CARLOS','08',3,1,0,NULL,NULL),
 (36,'SHIPASBAMBA','09',3,1,0,NULL,NULL),
 (37,'VALERA','10',3,1,0,NULL,NULL),
 (38,'YAMBRASBAMBA','11',3,1,0,NULL,NULL),
 (39,'JAZAN','12',3,1,0,NULL,NULL),
 (40,'LAMUD','01',4,1,0,NULL,NULL),
 (41,'CAMPORREDONDO','02',4,1,0,NULL,NULL),
 (42,'COCABAMBA','03',4,1,0,NULL,NULL),
 (43,'COLCAMAR','04',4,1,0,NULL,NULL),
 (44,'CONILA','05',4,1,0,NULL,NULL),
 (45,'INGUILPATA','06',4,1,0,NULL,NULL),
 (46,'LONGUITA','07',4,1,0,NULL,NULL),
 (47,'LONYA CHICO','08',4,1,0,NULL,NULL),
 (48,'LUYA','09',4,1,0,NULL,NULL),
 (49,'LUYA VIEJO','10',4,1,0,NULL,NULL),
 (50,'MARIA','11',4,1,0,NULL,NULL),
 (51,'OCALLI','12',4,1,0,NULL,NULL),
 (52,'OCUMAL','13',4,1,0,NULL,NULL),
 (53,'PISUQUIA','14',4,1,0,NULL,NULL),
 (54,'SAN CRISTOBAL','15',4,1,0,NULL,NULL),
 (55,'SAN FRANCISCO DE YESO','16',4,1,0,NULL,NULL),
 (56,'SAN JERONIMO','17',4,1,0,NULL,NULL),
 (57,'SAN JUAN DE LOPECANCHA','18',4,1,0,NULL,NULL),
 (58,'SANTA CATALINA','19',4,1,0,NULL,NULL),
 (59,'SANTO TOMAS','20',4,1,0,NULL,NULL),
 (60,'TINGO','21',4,1,0,NULL,NULL),
 (61,'TRITA','22',4,1,0,NULL,NULL),
 (62,'PROVIDENCIA','23',4,1,0,NULL,NULL),
 (63,'SAN NICOLAS','01',5,1,0,NULL,NULL),
 (64,'COCHAMAL','02',5,1,0,NULL,NULL),
 (65,'CHIRIMOTO','03',5,1,0,NULL,NULL),
 (66,'HUAMBO','04',5,1,0,NULL,NULL),
 (67,'LIMABAMBA','05',5,1,0,NULL,NULL),
 (68,'LONGAR','06',5,1,0,NULL,NULL),
 (69,'MILPUCC','07',5,1,0,NULL,NULL),
 (70,'MARISCAL BENAVIDES','08',5,1,0,NULL,NULL),
 (71,'OMIA','09',5,1,0,NULL,NULL),
 (72,'SANTA ROSA','10',5,1,0,NULL,NULL),
 (73,'TOTORA','11',5,1,0,NULL,NULL),
 (74,'VISTA ALEGRE','12',5,1,0,NULL,NULL),
 (75,'NIEVA','01',6,1,0,NULL,NULL),
 (76,'RIO SANTIAGO','02',6,1,0,NULL,NULL),
 (77,'EL CENEPA','03',6,1,0,NULL,NULL),
 (78,'BAGUA GRANDE','01',7,1,0,NULL,NULL),
 (79,'CAJARURO','02',7,1,0,NULL,NULL),
 (80,'CUMBA','03',7,1,0,NULL,NULL),
 (81,'EL MILAGRO','04',7,1,0,NULL,NULL),
 (82,'JAMALCA','05',7,1,0,NULL,NULL),
 (83,'LONYA GRANDE','06',7,1,0,NULL,NULL),
 (84,'YAMON','07',7,1,0,NULL,NULL),
 (85,'HUARAZ','01',8,1,0,NULL,NULL),
 (86,'INDEPENDENCIA','02',8,1,0,NULL,NULL),
 (87,'COCHABAMBA','03',8,1,0,NULL,NULL),
 (88,'COLCABAMBA','04',8,1,0,NULL,NULL),
 (89,'HUANCHAY','05',8,1,0,NULL,NULL),
 (90,'JANGAS','06',8,1,0,NULL,NULL),
 (91,'LA LIBERTAD','07',8,1,0,NULL,NULL),
 (92,'OLLEROS','08',8,1,0,NULL,NULL),
 (93,'PAMPAS GRANDE','09',8,1,0,NULL,NULL),
 (94,'PARIACOTO','10',8,1,0,NULL,NULL),
 (95,'PIRA','11',8,1,0,NULL,NULL),
 (96,'TARICA','12',8,1,0,NULL,NULL),
 (97,'AIJA','01',9,1,0,NULL,NULL),
 (98,'CORIS','03',9,1,0,NULL,NULL),
 (99,'HUACLLAN','05',9,1,0,NULL,NULL),
 (100,'LA MERCED','06',9,1,0,NULL,NULL),
 (101,'SUCCHA','08',9,1,0,NULL,NULL),
 (102,'CHIQUIAN','01',10,1,0,NULL,NULL),
 (103,'ABELARDO PARDO LEZAMETA','02',10,1,0,NULL,NULL),
 (104,'AQUIA','04',10,1,0,NULL,NULL),
 (105,'CAJACAY','05',10,1,0,NULL,NULL),
 (106,'HUAYLLACAYAN','10',10,1,0,NULL,NULL),
 (107,'HUASTA','11',10,1,0,NULL,NULL),
 (108,'MANGAS','13',10,1,0,NULL,NULL),
 (109,'PACLLON','15',10,1,0,NULL,NULL),
 (110,'SAN MIGUEL DE CORPANQUI','17',10,1,0,NULL,NULL),
 (111,'TICLLOS','20',10,1,0,NULL,NULL),
 (112,'ANTONIO RAIMONDI','21',10,1,0,NULL,NULL),
 (113,'CANIS','22',10,1,0,NULL,NULL),
 (114,'COLQUIOC','23',10,1,0,NULL,NULL),
 (115,'LA PRIMAVERA','24',10,1,0,NULL,NULL),
 (116,'HUALLANCA','25',10,1,0,NULL,NULL),
 (117,'CARHUAZ','01',11,1,0,NULL,NULL),
 (118,'ACOPAMPA','02',11,1,0,NULL,NULL),
 (119,'AMASHCA','03',11,1,0,NULL,NULL),
 (120,'ANTA','04',11,1,0,NULL,NULL),
 (121,'ATAQUERO','05',11,1,0,NULL,NULL),
 (122,'MARCARA','06',11,1,0,NULL,NULL),
 (123,'PARIAHUANCA','07',11,1,0,NULL,NULL),
 (124,'SAN MIGUEL DE ACO','08',11,1,0,NULL,NULL),
 (125,'SHILLA','09',11,1,0,NULL,NULL),
 (126,'TINCO','10',11,1,0,NULL,NULL),
 (127,'YUNGAR','11',11,1,0,NULL,NULL),
 (128,'CASMA','01',12,1,0,NULL,NULL),
 (129,'BUENA VISTA ALTA','02',12,1,0,NULL,NULL),
 (130,'COMANDANTE NOEL','03',12,1,0,NULL,NULL),
 (131,'YAUTAN','05',12,1,0,NULL,NULL),
 (132,'CORONGO','01',13,1,0,NULL,NULL),
 (133,'ACO','02',13,1,0,NULL,NULL),
 (134,'BAMBAS','03',13,1,0,NULL,NULL),
 (135,'CUSCA','04',13,1,0,NULL,NULL),
 (136,'LA PAMPA','05',13,1,0,NULL,NULL),
 (137,'YANAC','06',13,1,0,NULL,NULL),
 (138,'YUPAN','07',13,1,0,NULL,NULL),
 (139,'CARAZ','01',14,1,0,NULL,NULL),
 (140,'HUALLANCA','02',14,1,0,NULL,NULL),
 (141,'HUATA','03',14,1,0,NULL,NULL),
 (142,'HUAYLAS','04',14,1,0,NULL,NULL),
 (143,'MATO','05',14,1,0,NULL,NULL),
 (144,'PAMPAROMAS','06',14,1,0,NULL,NULL),
 (145,'PUEBLO LIBRE','07',14,1,0,NULL,NULL),
 (146,'SANTA CRUZ','08',14,1,0,NULL,NULL),
 (147,'YURACMARCA','09',14,1,0,NULL,NULL),
 (148,'SANTO TORIBIO','10',14,1,0,NULL,NULL),
 (149,'HUARI','01',15,1,0,NULL,NULL),
 (150,'CAJAY','02',15,1,0,NULL,NULL),
 (151,'CHAVIN DE HUANTAR','03',15,1,0,NULL,NULL),
 (152,'HUACACHI','04',15,1,0,NULL,NULL),
 (153,'HUACHIS','05',15,1,0,NULL,NULL),
 (154,'HUACCHIS','06',15,1,0,NULL,NULL),
 (155,'HUANTAR','07',15,1,0,NULL,NULL),
 (156,'MASIN','08',15,1,0,NULL,NULL),
 (157,'PAUCAS','09',15,1,0,NULL,NULL),
 (158,'PONTO','10',15,1,0,NULL,NULL),
 (159,'RAHUAPAMPA','11',15,1,0,NULL,NULL),
 (160,'RAPAYAN','12',15,1,0,NULL,NULL),
 (161,'SAN MARCOS','13',15,1,0,NULL,NULL),
 (162,'SAN PEDRO DE CHANA','14',15,1,0,NULL,NULL),
 (163,'UCO','15',15,1,0,NULL,NULL),
 (164,'ANRA','16',15,1,0,NULL,NULL),
 (165,'PISCOBAMBA','01',16,1,0,NULL,NULL),
 (166,'CASCA','02',16,1,0,NULL,NULL),
 (167,'LUCMA','03',16,1,0,NULL,NULL),
 (168,'FIDEL OLIVAS ESCUDERO','04',16,1,0,NULL,NULL),
 (169,'LLAMA','05',16,1,0,NULL,NULL),
 (170,'LLUMPA','06',16,1,0,NULL,NULL),
 (171,'MUSGA','07',16,1,0,NULL,NULL),
 (172,'ELEAZAR GUZMAN BARRON','08',16,1,0,NULL,NULL),
 (173,'CABANA','01',17,1,0,NULL,NULL),
 (174,'BOLOGNESI','02',17,1,0,NULL,NULL),
 (175,'CONCHUCOS','03',17,1,0,NULL,NULL),
 (176,'HUACASCHUQUE','04',17,1,0,NULL,NULL),
 (177,'HUANDOVAL','05',17,1,0,NULL,NULL),
 (178,'LACABAMBA','06',17,1,0,NULL,NULL),
 (179,'LLAPO','07',17,1,0,NULL,NULL),
 (180,'PALLASCA','08',17,1,0,NULL,NULL),
 (181,'PAMPAS','09',17,1,0,NULL,NULL),
 (182,'SANTA ROSA','10',17,1,0,NULL,NULL),
 (183,'TAUCA','11',17,1,0,NULL,NULL),
 (184,'POMABAMBA','01',18,1,0,NULL,NULL),
 (185,'HUAYLLAN','02',18,1,0,NULL,NULL),
 (186,'PAROBAMBA','03',18,1,0,NULL,NULL),
 (187,'QUINUABAMBA','04',18,1,0,NULL,NULL),
 (188,'RECUAY','01',19,1,0,NULL,NULL),
 (189,'COTAPARACO','02',19,1,0,NULL,NULL),
 (190,'HUAYLLAPAMPA','03',19,1,0,NULL,NULL),
 (191,'MARCA','04',19,1,0,NULL,NULL),
 (192,'PAMPAS CHICO','05',19,1,0,NULL,NULL),
 (193,'PARARIN','06',19,1,0,NULL,NULL),
 (194,'TAPACOCHA','07',19,1,0,NULL,NULL),
 (195,'TICAPAMPA','08',19,1,0,NULL,NULL),
 (196,'LLACLLIN','09',19,1,0,NULL,NULL),
 (197,'CATAC','10',19,1,0,NULL,NULL),
 (198,'CHIMBOTE','01',20,1,0,NULL,NULL),
 (199,'CACERES DEL PERU','02',20,1,0,NULL,NULL),
 (200,'MACATE','03',20,1,0,NULL,NULL),
 (201,'MORO','04',20,1,0,NULL,NULL),
 (202,'NEPEÑA','05',20,1,0,NULL,NULL),
 (203,'SAMANCO','06',20,1,0,NULL,NULL),
 (204,'SANTA','07',20,1,0,NULL,NULL),
 (205,'COISHCO','08',20,1,0,NULL,NULL),
 (206,'NUEVO CHIMBOTE','09',20,1,0,NULL,NULL),
 (207,'SIHUAS','01',21,1,0,NULL,NULL),
 (208,'ALFONSO UGARTE','02',21,1,0,NULL,NULL),
 (209,'CHINGALPO','03',21,1,0,NULL,NULL),
 (210,'HUAYLLABAMBA','04',21,1,0,NULL,NULL),
 (211,'QUICHES','05',21,1,0,NULL,NULL),
 (212,'SICSIBAMBA','06',21,1,0,NULL,NULL),
 (213,'ACOBAMBA','07',21,1,0,NULL,NULL),
 (214,'CASHAPAMPA','08',21,1,0,NULL,NULL),
 (215,'RAGASH','09',21,1,0,NULL,NULL),
 (216,'SAN JUAN','10',21,1,0,NULL,NULL),
 (217,'YUNGAY','01',22,1,0,NULL,NULL),
 (218,'CASCAPARA','02',22,1,0,NULL,NULL),
 (219,'MANCOS','03',22,1,0,NULL,NULL),
 (220,'MATACOTO','04',22,1,0,NULL,NULL),
 (221,'QUILLO','05',22,1,0,NULL,NULL),
 (222,'RANRAHIRCA','06',22,1,0,NULL,NULL),
 (223,'SHUPLUY','07',22,1,0,NULL,NULL),
 (224,'YANAMA','08',22,1,0,NULL,NULL),
 (225,'LLAMELLIN','01',23,1,0,NULL,NULL),
 (226,'ACZO','02',23,1,0,NULL,NULL),
 (227,'CHACCHO','03',23,1,0,NULL,NULL),
 (228,'CHINGAS','04',23,1,0,NULL,NULL),
 (229,'MIRGAS','05',23,1,0,NULL,NULL),
 (230,'SAN JUAN DE RONTOY','06',23,1,0,NULL,NULL),
 (231,'SAN LUIS','01',24,1,0,NULL,NULL),
 (232,'YAUYA','02',24,1,0,NULL,NULL),
 (233,'SAN NICOLAS','03',24,1,0,NULL,NULL),
 (234,'CHACAS','01',25,1,0,NULL,NULL),
 (235,'ACOCHACA','02',25,1,0,NULL,NULL),
 (236,'HUARMEY','01',26,1,0,NULL,NULL),
 (237,'COCHAPETI','02',26,1,0,NULL,NULL),
 (238,'HUAYAN','03',26,1,0,NULL,NULL),
 (239,'MALVAS','04',26,1,0,NULL,NULL),
 (240,'CULEBRAS','05',26,1,0,NULL,NULL),
 (241,'ACAS','01',27,1,0,NULL,NULL),
 (242,'CAJAMARQUILLA','02',27,1,0,NULL,NULL),
 (243,'CARHUAPAMPA','03',27,1,0,NULL,NULL),
 (244,'COCHAS','04',27,1,0,NULL,NULL),
 (245,'CONGAS','05',27,1,0,NULL,NULL),
 (246,'LLIPA','06',27,1,0,NULL,NULL),
 (247,'OCROS','07',27,1,0,NULL,NULL),
 (248,'SAN CRISTOBAL DE RAJAN','08',27,1,0,NULL,NULL),
 (249,'SAN PEDRO','09',27,1,0,NULL,NULL),
 (250,'SANTIAGO DE CHILCAS','10',27,1,0,NULL,NULL),
 (251,'ABANCAY','01',28,1,0,NULL,NULL),
 (252,'CIRCA','02',28,1,0,NULL,NULL),
 (253,'CURAHUASI','03',28,1,0,NULL,NULL),
 (254,'CHACOCHE','04',28,1,0,NULL,NULL),
 (255,'HUANIPACA','05',28,1,0,NULL,NULL),
 (256,'LAMBRAMA','06',28,1,0,NULL,NULL),
 (257,'PICHIRHUA','07',28,1,0,NULL,NULL),
 (258,'SAN PEDRO DE CACHORA','08',28,1,0,NULL,NULL),
 (259,'TAMBURCO','09',28,1,0,NULL,NULL),
 (260,'CHALHUANCA','01',29,1,0,NULL,NULL),
 (261,'CAPAYA','02',29,1,0,NULL,NULL),
 (262,'CARAYBAMBA','03',29,1,0,NULL,NULL),
 (263,'COLCABAMBA','04',29,1,0,NULL,NULL),
 (264,'COTARUSE','05',29,1,0,NULL,NULL),
 (265,'CHAPIMARCA','06',29,1,0,NULL,NULL),
 (266,'HUAYLLO','07',29,1,0,NULL,NULL),
 (267,'LUCRE','08',29,1,0,NULL,NULL),
 (268,'POCOHUANCA','09',29,1,0,NULL,NULL),
 (269,'SAÑAYCA','10',29,1,0,NULL,NULL),
 (270,'SORAYA','11',29,1,0,NULL,NULL),
 (271,'TAPAIRIHUA','12',29,1,0,NULL,NULL),
 (272,'TINTAY','13',29,1,0,NULL,NULL),
 (273,'TORAYA','14',29,1,0,NULL,NULL),
 (274,'YANACA','15',29,1,0,NULL,NULL),
 (275,'SAN JUAN DE CHACÑA','16',29,1,0,NULL,NULL),
 (276,'JUSTO APU SAHUARAURA','17',29,1,0,NULL,NULL),
 (277,'ANDAHUAYLAS','01',30,1,0,NULL,NULL),
 (278,'ANDARAPA','02',30,1,0,NULL,NULL),
 (279,'CHIARA','03',30,1,0,NULL,NULL),
 (280,'HUANCARAMA','04',30,1,0,NULL,NULL),
 (281,'HUANCARAY','05',30,1,0,NULL,NULL),
 (282,'KISHUARA','06',30,1,0,NULL,NULL),
 (283,'PACOBAMBA','07',30,1,0,NULL,NULL),
 (284,'PAMPACHIRI','08',30,1,0,NULL,NULL),
 (285,'SAN ANTONIO DE CACHI','09',30,1,0,NULL,NULL),
 (286,'SAN JERONIMO','10',30,1,0,NULL,NULL),
 (287,'TALAVERA','11',30,1,0,NULL,NULL),
 (288,'TURPO','12',30,1,0,NULL,NULL),
 (289,'PACUCHA','13',30,1,0,NULL,NULL),
 (290,'POMACOCHA','14',30,1,0,NULL,NULL),
 (291,'SANTA MARIA DE CHICMO','15',30,1,0,NULL,NULL),
 (292,'TUMAY HUARACA','16',30,1,0,NULL,NULL),
 (293,'HUAYANA','17',30,1,0,NULL,NULL),
 (294,'SAN MIGUEL DE CHACCRAMPA','18',30,1,0,NULL,NULL),
 (295,'KAQUIABAMBA','19',30,1,0,NULL,NULL),
 (296,'ANTABAMBA','01',31,1,0,NULL,NULL),
 (297,'EL ORO','02',31,1,0,NULL,NULL),
 (298,'HUAQUIRCA','03',31,1,0,NULL,NULL),
 (299,'JUAN ESPINOZA MEDRANO','04',31,1,0,NULL,NULL),
 (300,'OROPESA','05',31,1,0,NULL,NULL),
 (301,'PACHACONAS','06',31,1,0,NULL,NULL),
 (302,'SABAINO','07',31,1,0,NULL,NULL),
 (303,'TAMBOBAMBA','01',32,1,0,NULL,NULL),
 (304,'COYLLURQUI','02',32,1,0,NULL,NULL),
 (305,'COTABAMBAS','03',32,1,0,NULL,NULL),
 (306,'HAQUIRA','04',32,1,0,NULL,NULL),
 (307,'MARA','05',32,1,0,NULL,NULL),
 (308,'CHALLHUAHUACHO','06',32,1,0,NULL,NULL),
 (309,'CHUQUIBAMBILLA','01',33,1,0,NULL,NULL),
 (310,'CURPAHUASI','02',33,1,0,NULL,NULL),
 (311,'HUAYLLATI','03',33,1,0,NULL,NULL),
 (312,'MAMARA','04',33,1,0,NULL,NULL),
 (313,'MARISCAL GAMARRA','05',33,1,0,NULL,NULL),
 (314,'MICAELA BASTIDAS','06',33,1,0,NULL,NULL),
 (315,'PROGRESO','07',33,1,0,NULL,NULL),
 (316,'PATAYPAMPA','08',33,1,0,NULL,NULL),
 (317,'SAN ANTONIO','09',33,1,0,NULL,NULL),
 (318,'TURPAY','10',33,1,0,NULL,NULL),
 (319,'VILCABAMBA','11',33,1,0,NULL,NULL),
 (320,'VIRUNDO','12',33,1,0,NULL,NULL),
 (321,'SANTA ROSA','13',33,1,0,NULL,NULL),
 (322,'CURASCO','14',33,1,0,NULL,NULL),
 (323,'CHINCHEROS','01',34,1,0,NULL,NULL),
 (324,'ONGOY','02',34,1,0,NULL,NULL),
 (325,'OCOBAMBA','03',34,1,0,NULL,NULL),
 (326,'COCHARCAS','04',34,1,0,NULL,NULL),
 (327,'ANCO HUALLO','05',34,1,0,NULL,NULL),
 (328,'HUACCANA','06',34,1,0,NULL,NULL),
 (329,'URANMARCA','07',34,1,0,NULL,NULL),
 (330,'RANRACANCHA','08',34,1,0,NULL,NULL),
 (331,'AREQUIPA','01',35,1,0,NULL,NULL),
 (332,'CAYMA','02',35,1,0,NULL,NULL),
 (333,'CERRO COLORADO','03',35,1,0,NULL,NULL),
 (334,'CHARACATO','04',35,1,0,NULL,NULL),
 (335,'CHIGUATA','05',35,1,0,NULL,NULL),
 (336,'LA JOYA','06',35,1,0,NULL,NULL),
 (337,'MIRAFLORES','07',35,1,0,NULL,NULL),
 (338,'MOLLEBAYA','08',35,1,0,NULL,NULL),
 (339,'PAUCARPATA','09',35,1,0,NULL,NULL),
 (340,'POCSI','10',35,1,0,NULL,NULL),
 (341,'POLOBAYA','11',35,1,0,NULL,NULL),
 (342,'QUEQUEÑA','12',35,1,0,NULL,NULL),
 (343,'SABANDIA','13',35,1,0,NULL,NULL),
 (344,'SACHACA','14',35,1,0,NULL,NULL),
 (345,'SAN JUAN DE SIGUAS','15',35,1,0,NULL,NULL),
 (346,'SAN JUAN DE TARUCANI','16',35,1,0,NULL,NULL),
 (347,'SANTA ISABEL DE SIGUAS','17',35,1,0,NULL,NULL),
 (348,'SANTA RITA DE SIHUAS','18',35,1,0,NULL,NULL),
 (349,'SOCABAYA','19',35,1,0,NULL,NULL),
 (350,'TIABAYA','20',35,1,0,NULL,NULL),
 (351,'UCHUMAYO','21',35,1,0,NULL,NULL),
 (352,'VITOR','22',35,1,0,NULL,NULL),
 (353,'YANAHUARA','23',35,1,0,NULL,NULL),
 (354,'YARABAMBA','24',35,1,0,NULL,NULL),
 (355,'YURA','25',35,1,0,NULL,NULL),
 (356,'MARIANO MELGAR','26',35,1,0,NULL,NULL),
 (357,'JACOBO HUNTER','27',35,1,0,NULL,NULL),
 (358,'ALTO SELVA ALEGRE','28',35,1,0,NULL,NULL),
 (359,'JOSE LUIS BUSTAMANTE Y RIVERO','29',35,1,0,NULL,NULL),
 (360,'CHIVAY','01',36,1,0,NULL,NULL),
 (361,'ACHOMA','02',36,1,0,NULL,NULL),
 (362,'CABANACONDE','03',36,1,0,NULL,NULL),
 (363,'CAYLLOMA','04',36,1,0,NULL,NULL),
 (364,'CALLALLI','05',36,1,0,NULL,NULL),
 (365,'COPORAQUE','06',36,1,0,NULL,NULL),
 (366,'HUAMBO','07',36,1,0,NULL,NULL),
 (367,'HUANCA','08',36,1,0,NULL,NULL),
 (368,'ICHUPAMPA','09',36,1,0,NULL,NULL),
 (369,'LARI','10',36,1,0,NULL,NULL),
 (370,'LLUTA','11',36,1,0,NULL,NULL),
 (371,'MACA','12',36,1,0,NULL,NULL),
 (372,'MADRIGAL','13',36,1,0,NULL,NULL),
 (373,'SAN ANTONIO DE CHUCA','14',36,1,0,NULL,NULL),
 (374,'SIBAYO','15',36,1,0,NULL,NULL),
 (375,'TAPAY','16',36,1,0,NULL,NULL),
 (376,'TISCO','17',36,1,0,NULL,NULL),
 (377,'TUTI','18',36,1,0,NULL,NULL),
 (378,'YANQUE','19',36,1,0,NULL,NULL),
 (379,'MAJES','20',36,1,0,NULL,NULL),
 (380,'CAMANA','01',37,1,0,NULL,NULL),
 (381,'JOSE MARIA QUIMPER','02',37,1,0,NULL,NULL),
 (382,'MARIANO NICOLAS VALCARCEL','03',37,1,0,NULL,NULL),
 (383,'MARISCAL CACERES','04',37,1,0,NULL,NULL),
 (384,'NICOLAS DE PIEROLA','05',37,1,0,NULL,NULL),
 (385,'OCOÑA','06',37,1,0,NULL,NULL),
 (386,'QUILCA','07',37,1,0,NULL,NULL),
 (387,'SAMUEL PASTOR','08',37,1,0,NULL,NULL),
 (388,'CARAVELI','01',38,1,0,NULL,NULL),
 (389,'ACARI','02',38,1,0,NULL,NULL),
 (390,'ATICO','03',38,1,0,NULL,NULL),
 (391,'ATIQUIPA','04',38,1,0,NULL,NULL),
 (392,'BELLA UNION','05',38,1,0,NULL,NULL),
 (393,'CAHUACHO','06',38,1,0,NULL,NULL),
 (394,'CHALA','07',38,1,0,NULL,NULL),
 (395,'CHAPARRA','08',38,1,0,NULL,NULL),
 (396,'HUANUHUANU','09',38,1,0,NULL,NULL),
 (397,'JAQUI','10',38,1,0,NULL,NULL),
 (398,'LOMAS','11',38,1,0,NULL,NULL),
 (399,'QUICACHA','12',38,1,0,NULL,NULL),
 (400,'YAUCA','13',38,1,0,NULL,NULL),
 (401,'APLAO','01',39,1,0,NULL,NULL),
 (402,'ANDAGUA','02',39,1,0,NULL,NULL),
 (403,'AYO','03',39,1,0,NULL,NULL),
 (404,'CHACHAS','04',39,1,0,NULL,NULL),
 (405,'CHILCAYMARCA','05',39,1,0,NULL,NULL),
 (406,'CHOCO','06',39,1,0,NULL,NULL),
 (407,'HUANCARQUI','07',39,1,0,NULL,NULL),
 (408,'MACHAGUAY','08',39,1,0,NULL,NULL),
 (409,'ORCOPAMPA','09',39,1,0,NULL,NULL),
 (410,'PAMPACOLCA','10',39,1,0,NULL,NULL),
 (411,'TIPAN','11',39,1,0,NULL,NULL),
 (412,'URACA','12',39,1,0,NULL,NULL),
 (413,'UÑON','13',39,1,0,NULL,NULL),
 (414,'VIRACO','14',39,1,0,NULL,NULL),
 (415,'CHUQUIBAMBA','01',40,1,0,NULL,NULL),
 (416,'ANDARAY','02',40,1,0,NULL,NULL),
 (417,'CAYARANI','03',40,1,0,NULL,NULL),
 (418,'CHICHAS','04',40,1,0,NULL,NULL),
 (419,'IRAY','05',40,1,0,NULL,NULL),
 (420,'SALAMANCA','06',40,1,0,NULL,NULL),
 (421,'YANAQUIHUA','07',40,1,0,NULL,NULL),
 (422,'RIO GRANDE','08',40,1,0,NULL,NULL),
 (423,'MOLLENDO','01',41,1,0,NULL,NULL),
 (424,'COCACHACRA','02',41,1,0,NULL,NULL),
 (425,'DEAN VALDIVIA','03',41,1,0,NULL,NULL),
 (426,'ISLAY','04',41,1,0,NULL,NULL),
 (427,'MEJIA','05',41,1,0,NULL,NULL),
 (428,'PUNTA DE BOMBON','06',41,1,0,NULL,NULL),
 (429,'COTAHUASI','01',42,1,0,NULL,NULL),
 (430,'ALCA','02',42,1,0,NULL,NULL),
 (431,'CHARCANA','03',42,1,0,NULL,NULL),
 (432,'HUAYNACOTAS','04',42,1,0,NULL,NULL),
 (433,'PAMPAMARCA','05',42,1,0,NULL,NULL),
 (434,'PUYCA','06',42,1,0,NULL,NULL),
 (435,'QUECHUALLA','07',42,1,0,NULL,NULL),
 (436,'SAYLA','08',42,1,0,NULL,NULL),
 (437,'TAURIA','09',42,1,0,NULL,NULL),
 (438,'TOMEPAMPA','10',42,1,0,NULL,NULL),
 (439,'TORO','11',42,1,0,NULL,NULL),
 (440,'AYACUCHO','01',43,1,0,NULL,NULL),
 (441,'ACOS VINCHOS','02',43,1,0,NULL,NULL),
 (442,'CARMEN ALTO','03',43,1,0,NULL,NULL),
 (443,'CHIARA','04',43,1,0,NULL,NULL),
 (444,'QUINUA','05',43,1,0,NULL,NULL),
 (445,'SAN JOSE DE TICLLAS','06',43,1,0,NULL,NULL),
 (446,'SAN JUAN BAUTISTA','07',43,1,0,NULL,NULL),
 (447,'SANTIAGO DE PISCHA','08',43,1,0,NULL,NULL),
 (448,'VINCHOS','09',43,1,0,NULL,NULL),
 (449,'TAMBILLO','10',43,1,0,NULL,NULL),
 (450,'ACOCRO','11',43,1,0,NULL,NULL),
 (451,'SOCOS','12',43,1,0,NULL,NULL),
 (452,'OCROS','13',43,1,0,NULL,NULL),
 (453,'PACAYCASA','14',43,1,0,NULL,NULL),
 (454,'JESUS NAZARENO','15',43,1,0,NULL,NULL),
 (455,'CANGALLO','01',44,1,0,NULL,NULL),
 (456,'CHUSCHI','04',44,1,0,NULL,NULL),
 (457,'LOS MOROCHUCOS','06',44,1,0,NULL,NULL),
 (458,'PARAS','07',44,1,0,NULL,NULL),
 (459,'TOTOS','08',44,1,0,NULL,NULL),
 (460,'MARIA PARADO DE BELLIDO','11',44,1,0,NULL,NULL),
 (461,'HUANTA','01',45,1,0,NULL,NULL),
 (462,'AYAHUANCO','02',45,1,0,NULL,NULL),
 (463,'HUAMANGUILLA','03',45,1,0,NULL,NULL),
 (464,'IGUAIN','04',45,1,0,NULL,NULL),
 (465,'LURICOCHA','05',45,1,0,NULL,NULL),
 (466,'SANTILLANA','07',45,1,0,NULL,NULL),
 (467,'SIVIA','08',45,1,0,NULL,NULL),
 (468,'LLOCHEGUA','09',45,1,0,NULL,NULL),
 (469,'SAN MIGUEL','01',46,1,0,NULL,NULL),
 (470,'ANCO','02',46,1,0,NULL,NULL),
 (471,'AYNA','03',46,1,0,NULL,NULL),
 (472,'CHILCAS','04',46,1,0,NULL,NULL),
 (473,'CHUNGUI','05',46,1,0,NULL,NULL),
 (474,'TAMBO','06',46,1,0,NULL,NULL),
 (475,'LUIS CARRANZA','07',46,1,0,NULL,NULL),
 (476,'SANTA ROSA','08',46,1,0,NULL,NULL),
 (477,'SAMUGARI','09',46,1,0,NULL,NULL),
 (478,'PUQUIO','01',47,1,0,NULL,NULL),
 (479,'AUCARA','02',47,1,0,NULL,NULL),
 (480,'CABANA','03',47,1,0,NULL,NULL),
 (481,'CARMEN SALCEDO','04',47,1,0,NULL,NULL),
 (482,'CHAVIÑA','06',47,1,0,NULL,NULL),
 (483,'CHIPAO','08',47,1,0,NULL,NULL),
 (484,'HUAC-HUAS','10',47,1,0,NULL,NULL),
 (485,'LARAMATE','11',47,1,0,NULL,NULL),
 (486,'LEONCIO PRADO','12',47,1,0,NULL,NULL),
 (487,'LUCANAS','13',47,1,0,NULL,NULL),
 (488,'LLAUTA','14',47,1,0,NULL,NULL),
 (489,'OCAÑA','16',47,1,0,NULL,NULL),
 (490,'OTOCA','17',47,1,0,NULL,NULL),
 (491,'SANCOS','20',47,1,0,NULL,NULL),
 (492,'SAN JUAN','21',47,1,0,NULL,NULL),
 (493,'SAN PEDRO','22',47,1,0,NULL,NULL),
 (494,'SANTA ANA DE HUAYCAHUACHO','24',47,1,0,NULL,NULL),
 (495,'SANTA LUCIA','25',47,1,0,NULL,NULL),
 (496,'SAISA','29',47,1,0,NULL,NULL),
 (497,'SAN PEDRO DE PALCO','31',47,1,0,NULL,NULL),
 (498,'SAN CRISTOBAL','32',47,1,0,NULL,NULL),
 (499,'CORACORA','01',48,1,0,NULL,NULL),
 (500,'CORONEL CASTAÑEDA','04',48,1,0,NULL,NULL),
 (501,'CHUMPI','05',48,1,0,NULL,NULL),
 (502,'PACAPAUSA','08',48,1,0,NULL,NULL),
 (503,'PULLO','11',48,1,0,NULL,NULL),
 (504,'PUYUSCA','12',48,1,0,NULL,NULL),
 (505,'SAN FRANCISCO DE RAVACAYCO','15',48,1,0,NULL,NULL),
 (506,'UPAHUACHO','16',48,1,0,NULL,NULL),
 (507,'HUANCAPI','01',49,1,0,NULL,NULL),
 (508,'ALCAMENCA','02',49,1,0,NULL,NULL),
 (509,'APONGO','03',49,1,0,NULL,NULL),
 (510,'CANARIA','04',49,1,0,NULL,NULL),
 (511,'CAYARA','06',49,1,0,NULL,NULL),
 (512,'COLCA','07',49,1,0,NULL,NULL),
 (513,'HUALLA','08',49,1,0,NULL,NULL),
 (514,'HUAMANQUIQUIA','09',49,1,0,NULL,NULL),
 (515,'HUANCARAYLLA','10',49,1,0,NULL,NULL),
 (516,'SARHUA','13',49,1,0,NULL,NULL),
 (517,'VILCANCHOS','14',49,1,0,NULL,NULL),
 (518,'ASQUIPATA','15',49,1,0,NULL,NULL),
 (519,'SANCOS','01',50,1,0,NULL,NULL),
 (520,'SACSAMARCA','02',50,1,0,NULL,NULL),
 (521,'SANTIAGO DE LUCANAMARCA','03',50,1,0,NULL,NULL),
 (522,'CARAPO','04',50,1,0,NULL,NULL),
 (523,'VILCAS HUAMAN','01',51,1,0,NULL,NULL),
 (524,'VISCHONGO','02',51,1,0,NULL,NULL),
 (525,'ACCOMARCA','03',51,1,0,NULL,NULL),
 (526,'CARHUANCA','04',51,1,0,NULL,NULL),
 (527,'CONCEPCION','05',51,1,0,NULL,NULL),
 (528,'HUAMBALPA','06',51,1,0,NULL,NULL),
 (529,'SAURAMA','07',51,1,0,NULL,NULL),
 (530,'INDEPENDENCIA','08',51,1,0,NULL,NULL),
 (531,'PAUSA','01',52,1,0,NULL,NULL),
 (532,'COLTA','02',52,1,0,NULL,NULL),
 (533,'CORCULLA','03',52,1,0,NULL,NULL),
 (534,'LAMPA','04',52,1,0,NULL,NULL),
 (535,'MARCABAMBA','05',52,1,0,NULL,NULL),
 (536,'OYOLO','06',52,1,0,NULL,NULL),
 (537,'PARARCA','07',52,1,0,NULL,NULL),
 (538,'SAN JAVIER DE ALPABAMBA','08',52,1,0,NULL,NULL),
 (539,'SAN JOSE DE USHUA','09',52,1,0,NULL,NULL),
 (540,'SARA SARA','10',52,1,0,NULL,NULL),
 (541,'QUEROBAMBA','01',53,1,0,NULL,NULL),
 (542,'BELEN','02',53,1,0,NULL,NULL),
 (543,'CHALCOS','03',53,1,0,NULL,NULL),
 (544,'SAN SALVADOR DE QUIJE','04',53,1,0,NULL,NULL),
 (545,'PAICO','05',53,1,0,NULL,NULL),
 (546,'SANTIAGO DE PAUCARAY','06',53,1,0,NULL,NULL),
 (547,'SAN PEDRO DE LARCAY','07',53,1,0,NULL,NULL),
 (548,'SORAS','08',53,1,0,NULL,NULL),
 (549,'HUACAÑA','09',53,1,0,NULL,NULL),
 (550,'CHILCAYOC','10',53,1,0,NULL,NULL),
 (551,'MORCOLLA','11',53,1,0,NULL,NULL),
 (552,'CAJAMARCA','01',54,1,0,NULL,NULL),
 (553,'ASUNCION','02',54,1,0,NULL,NULL),
 (554,'COSPAN','03',54,1,0,NULL,NULL),
 (555,'CHETILLA','04',54,1,0,NULL,NULL),
 (556,'ENCAÑADA','05',54,1,0,NULL,NULL),
 (557,'JESUS','06',54,1,0,NULL,NULL),
 (558,'LOS BAÑOS DEL INCA','07',54,1,0,NULL,NULL),
 (559,'LLACANORA','08',54,1,0,NULL,NULL),
 (560,'MAGDALENA','09',54,1,0,NULL,NULL),
 (561,'MATARA','10',54,1,0,NULL,NULL),
 (562,'NAMORA','11',54,1,0,NULL,NULL),
 (563,'SAN JUAN','12',54,1,0,NULL,NULL),
 (564,'CAJABAMBA','01',55,1,0,NULL,NULL),
 (565,'CACHACHI','02',55,1,0,NULL,NULL),
 (566,'CONDEBAMBA','03',55,1,0,NULL,NULL),
 (567,'SITACOCHA','05',55,1,0,NULL,NULL),
 (568,'CELENDIN','01',56,1,0,NULL,NULL),
 (569,'CORTEGANA','02',56,1,0,NULL,NULL),
 (570,'CHUMUCH','03',56,1,0,NULL,NULL),
 (571,'HUASMIN','04',56,1,0,NULL,NULL),
 (572,'JORGE CHAVEZ','05',56,1,0,NULL,NULL),
 (573,'JOSE GALVEZ','06',56,1,0,NULL,NULL),
 (574,'MIGUEL IGLESIAS','07',56,1,0,NULL,NULL),
 (575,'OXAMARCA','08',56,1,0,NULL,NULL),
 (576,'SOROCHUCO','09',56,1,0,NULL,NULL),
 (577,'SUCRE','10',56,1,0,NULL,NULL),
 (578,'UTCO','11',56,1,0,NULL,NULL),
 (579,'LA LIBERTAD DE PALLAN','12',56,1,0,NULL,NULL),
 (580,'CONTUMAZA','01',57,1,0,NULL,NULL),
 (581,'CHILETE','03',57,1,0,NULL,NULL),
 (582,'GUZMANGO','04',57,1,0,NULL,NULL),
 (583,'SAN BENITO','05',57,1,0,NULL,NULL),
 (584,'CUPISNIQUE','06',57,1,0,NULL,NULL),
 (585,'TANTARICA','07',57,1,0,NULL,NULL),
 (586,'YONAN','08',57,1,0,NULL,NULL),
 (587,'SANTA CRUZ DE TOLED','09',57,1,0,NULL,NULL),
 (588,'CUTERVO','01',58,1,0,NULL,NULL),
 (589,'CALLAYUC','02',58,1,0,NULL,NULL),
 (590,'CUJILLO','03',58,1,0,NULL,NULL),
 (591,'CHOROS','04',58,1,0,NULL,NULL),
 (592,'LA RAMADA','05',58,1,0,NULL,NULL),
 (593,'PIMPINGOS','06',58,1,0,NULL,NULL),
 (594,'QUEROCOTILLO','07',58,1,0,NULL,NULL),
 (595,'SAN ANDRES DE CUTERVO','08',58,1,0,NULL,NULL),
 (596,'SAN JUAN DE CUTERVO','09',58,1,0,NULL,NULL),
 (597,'SAN LUIS DE LUCMA','10',58,1,0,NULL,NULL),
 (598,'SANTA CRUZ','11',58,1,0,NULL,NULL),
 (599,'SANTO DOMINGO DE LA CAPILLA','12',58,1,0,NULL,NULL),
 (600,'SANTO TOMAS','13',58,1,0,NULL,NULL),
 (601,'SOCOTA','14',58,1,0,NULL,NULL),
 (602,'TORIBIO CASANOVA','15',58,1,0,NULL,NULL),
 (603,'CHOTA','01',59,1,0,NULL,NULL),
 (604,'ANGUIA','02',59,1,0,NULL,NULL),
 (605,'COCHABAMBA','03',59,1,0,NULL,NULL),
 (606,'CONCHAN','04',59,1,0,NULL,NULL),
 (607,'CHADIN','05',59,1,0,NULL,NULL),
 (608,'CHIGUIRIP','06',59,1,0,NULL,NULL),
 (609,'CHIMBAN','07',59,1,0,NULL,NULL),
 (610,'HUAMBOS','08',59,1,0,NULL,NULL),
 (611,'LAJAS','09',59,1,0,NULL,NULL),
 (612,'LLAMA','10',59,1,0,NULL,NULL),
 (613,'MIRACOSTA','11',59,1,0,NULL,NULL),
 (614,'PACCHA','12',59,1,0,NULL,NULL),
 (615,'PION','13',59,1,0,NULL,NULL),
 (616,'QUEROCOTO','14',59,1,0,NULL,NULL),
 (617,'TACABAMBA','15',59,1,0,NULL,NULL),
 (618,'TOCMOCHE','16',59,1,0,NULL,NULL),
 (619,'SAN JUAN DE LICUPIS','17',59,1,0,NULL,NULL),
 (620,'CHOROPAMPA','18',59,1,0,NULL,NULL),
 (621,'CHALAMARCA','19',59,1,0,NULL,NULL),
 (622,'BAMBAMARCA','01',60,1,0,NULL,NULL),
 (623,'CHUGUR','02',60,1,0,NULL,NULL),
 (624,'HUALGAYOC','03',60,1,0,NULL,NULL),
 (625,'JAEN','01',61,1,0,NULL,NULL),
 (626,'BELLAVISTA','02',61,1,0,NULL,NULL),
 (627,'COLASAY','03',61,1,0,NULL,NULL),
 (628,'CHONTALI','04',61,1,0,NULL,NULL),
 (629,'POMAHUACA','05',61,1,0,NULL,NULL),
 (630,'PUCARA','06',61,1,0,NULL,NULL),
 (631,'SALLIQUE','07',61,1,0,NULL,NULL),
 (632,'SAN FELIPE','08',61,1,0,NULL,NULL),
 (633,'SAN JOSE DEL ALTO','09',61,1,0,NULL,NULL),
 (634,'SANTA ROSA','10',61,1,0,NULL,NULL),
 (635,'LAS PIRIAS','11',61,1,0,NULL,NULL),
 (636,'HUABAL','12',61,1,0,NULL,NULL),
 (637,'SANTA CRUZ','01',62,1,0,NULL,NULL),
 (638,'CATACHE','02',62,1,0,NULL,NULL),
 (639,'CHANCAYBAÑOS','03',62,1,0,NULL,NULL),
 (640,'LA ESPERANZA','04',62,1,0,NULL,NULL),
 (641,'NINABAMBA','05',62,1,0,NULL,NULL),
 (642,'PULAN','06',62,1,0,NULL,NULL),
 (643,'SEXI','07',62,1,0,NULL,NULL),
 (644,'UTICYACU','08',62,1,0,NULL,NULL),
 (645,'YAUYUCAN','09',62,1,0,NULL,NULL),
 (646,'ANDABAMBA','10',62,1,0,NULL,NULL),
 (647,'SAUCEPAMPA','11',62,1,0,NULL,NULL),
 (648,'SAN MIGUEL','01',63,1,0,NULL,NULL),
 (649,'CALQUIS','02',63,1,0,NULL,NULL),
 (650,'LA FLORIDA','03',63,1,0,NULL,NULL),
 (651,'LLAPA','04',63,1,0,NULL,NULL),
 (652,'NANCHOC','05',63,1,0,NULL,NULL),
 (653,'NIEPOS','06',63,1,0,NULL,NULL),
 (654,'SAN GREGORIO','07',63,1,0,NULL,NULL),
 (655,'SAN SILVESTRE DE COCHAN','08',63,1,0,NULL,NULL),
 (656,'EL PRADO','09',63,1,0,NULL,NULL),
 (657,'UNION AGUA BLANCA','10',63,1,0,NULL,NULL),
 (658,'TONGOD','11',63,1,0,NULL,NULL),
 (659,'CATILLUC','12',63,1,0,NULL,NULL),
 (660,'BOLIVAR','13',63,1,0,NULL,NULL),
 (661,'SAN IGNACIO','01',64,1,0,NULL,NULL),
 (662,'CHIRINOS','02',64,1,0,NULL,NULL),
 (663,'HUARANGO','03',64,1,0,NULL,NULL),
 (664,'NAMBALLE','04',64,1,0,NULL,NULL),
 (665,'LA COIPA','05',64,1,0,NULL,NULL),
 (666,'SAN JOSE DE LOURDES','06',64,1,0,NULL,NULL),
 (667,'TABACONAS','07',64,1,0,NULL,NULL),
 (668,'PEDRO GALVEZ','01',65,1,0,NULL,NULL),
 (669,'ICHOCAN','02',65,1,0,NULL,NULL),
 (670,'GREGORIO PITA','03',65,1,0,NULL,NULL),
 (671,'JOSE MANUEL QUIROZ','04',65,1,0,NULL,NULL),
 (672,'EDUARDO VILLANUEVA','05',65,1,0,NULL,NULL),
 (673,'JOSE SABOGAL','06',65,1,0,NULL,NULL),
 (674,'CHANCAY','07',65,1,0,NULL,NULL),
 (675,'SAN PABLO','01',66,1,0,NULL,NULL),
 (676,'SAN BERNARDINO','02',66,1,0,NULL,NULL),
 (677,'SAN LUIS','03',66,1,0,NULL,NULL),
 (678,'TUMBADEN','04',66,1,0,NULL,NULL),
 (679,'CUSCO','01',67,1,0,NULL,NULL),
 (680,'CCORCA','02',67,1,0,NULL,NULL),
 (681,'POROY','03',67,1,0,NULL,NULL),
 (682,'SAN JERONIMO','04',67,1,0,NULL,NULL),
 (683,'SAN SEBASTIAN','05',67,1,0,NULL,NULL),
 (684,'SANTIAGO','06',67,1,0,NULL,NULL),
 (685,'SAYLLA','07',67,1,0,NULL,NULL),
 (686,'WANCHAQ','08',67,1,0,NULL,NULL),
 (687,'ACOMAYO','01',68,1,0,NULL,NULL),
 (688,'ACOPIA','02',68,1,0,NULL,NULL),
 (689,'ACOS','03',68,1,0,NULL,NULL),
 (690,'POMACANCHI','04',68,1,0,NULL,NULL),
 (691,'RONDOCAN','05',68,1,0,NULL,NULL),
 (692,'SANGARARA','06',68,1,0,NULL,NULL),
 (693,'MOSOC LLACTA','07',68,1,0,NULL,NULL),
 (694,'ANTA','01',69,1,0,NULL,NULL),
 (695,'CHINCHAYPUJIO','02',69,1,0,NULL,NULL),
 (696,'HUAROCONDO','03',69,1,0,NULL,NULL),
 (697,'LIMATAMBO','04',69,1,0,NULL,NULL),
 (698,'MOLLEPATA','05',69,1,0,NULL,NULL),
 (699,'PUCYURA','06',69,1,0,NULL,NULL),
 (700,'ZURITE','07',69,1,0,NULL,NULL),
 (701,'CACHIMAYO','08',69,1,0,NULL,NULL),
 (702,'ANCAHUASI','09',69,1,0,NULL,NULL),
 (703,'CALCA','01',70,1,0,NULL,NULL),
 (704,'COYA','02',70,1,0,NULL,NULL),
 (705,'LAMAY','03',70,1,0,NULL,NULL),
 (706,'LARES','04',70,1,0,NULL,NULL),
 (707,'PISAC','05',70,1,0,NULL,NULL),
 (708,'SAN SALVADOR','06',70,1,0,NULL,NULL),
 (709,'TARAY','07',70,1,0,NULL,NULL),
 (710,'YANATILE','08',70,1,0,NULL,NULL),
 (711,'YANAOCA','01',71,1,0,NULL,NULL),
 (712,'CHECCA','02',71,1,0,NULL,NULL),
 (713,'KUNTURKANKI','03',71,1,0,NULL,NULL),
 (714,'LANGUI','04',71,1,0,NULL,NULL),
 (715,'LAYO','05',71,1,0,NULL,NULL),
 (716,'PAMPAMARCA','06',71,1,0,NULL,NULL),
 (717,'QUEHUE','07',71,1,0,NULL,NULL),
 (718,'TUPAC AMARU','08',71,1,0,NULL,NULL),
 (719,'SICUANI','01',72,1,0,NULL,NULL),
 (720,'COMBAPATA','02',72,1,0,NULL,NULL),
 (721,'CHECACUPE','03',72,1,0,NULL,NULL),
 (722,'MARANGANI','04',72,1,0,NULL,NULL),
 (723,'PITUMARCA','05',72,1,0,NULL,NULL),
 (724,'SAN PABLO','06',72,1,0,NULL,NULL),
 (725,'SAN PEDRO','07',72,1,0,NULL,NULL),
 (726,'TINTA','08',72,1,0,NULL,NULL),
 (727,'SANTO TOMAS','01',73,1,0,NULL,NULL),
 (728,'CAPACMARCA','02',73,1,0,NULL,NULL),
 (729,'COLQUEMARCA','03',73,1,0,NULL,NULL),
 (730,'CHAMACA','04',73,1,0,NULL,NULL),
 (731,'LIVITACA','05',73,1,0,NULL,NULL),
 (732,'LLUSCO','06',73,1,0,NULL,NULL),
 (733,'QUIÑOTA','07',73,1,0,NULL,NULL),
 (734,'VELILLE','08',73,1,0,NULL,NULL),
 (735,'ESPINAR','01',74,1,0,NULL,NULL),
 (736,'CONDOROMA','02',74,1,0,NULL,NULL),
 (737,'COPORAQUE','03',74,1,0,NULL,NULL),
 (738,'OCORURO','04',74,1,0,NULL,NULL),
 (739,'PALLPATA','05',74,1,0,NULL,NULL),
 (740,'PICHIGUA','06',74,1,0,NULL,NULL),
 (741,'SUYCKUTAMBO','07',74,1,0,NULL,NULL),
 (742,'ALTO PICHIGUA','08',74,1,0,NULL,NULL),
 (743,'SANTA ANA','01',75,1,0,NULL,NULL),
 (744,'ECHARATE','02',75,1,0,NULL,NULL),
 (745,'HUAYOPATA','03',75,1,0,NULL,NULL),
 (746,'MARANURA','04',75,1,0,NULL,NULL),
 (747,'OCOBAMBA','05',75,1,0,NULL,NULL),
 (748,'SANTA TERESA','06',75,1,0,NULL,NULL),
 (749,'VILCABAMBA','07',75,1,0,NULL,NULL),
 (750,'QUELLOUNO','08',75,1,0,NULL,NULL),
 (751,'KIMBIRI','09',75,1,0,NULL,NULL),
 (752,'PICHARI','10',75,1,0,NULL,NULL),
 (753,'PARURO','01',76,1,0,NULL,NULL),
 (754,'ACCHA','02',76,1,0,NULL,NULL),
 (755,'CCAPI','03',76,1,0,NULL,NULL),
 (756,'COLCHA','04',76,1,0,NULL,NULL),
 (757,'HUANOQUITE','05',76,1,0,NULL,NULL),
 (758,'OMACHA','06',76,1,0,NULL,NULL),
 (759,'YAURISQUE','07',76,1,0,NULL,NULL),
 (760,'PACCARITAMBO','08',76,1,0,NULL,NULL),
 (761,'PILLPINTO','09',76,1,0,NULL,NULL),
 (762,'PAUCARTAMBO','01',77,1,0,NULL,NULL),
 (763,'CAICAY','02',77,1,0,NULL,NULL),
 (764,'COLQUEPATA','03',77,1,0,NULL,NULL),
 (765,'CHALLABAMBA','04',77,1,0,NULL,NULL),
 (766,'KOSÑIPATA','05',77,1,0,NULL,NULL),
 (767,'HUANCARANI','06',77,1,0,NULL,NULL),
 (768,'URCOS','01',78,1,0,NULL,NULL),
 (769,'ANDAHUAYLILLAS','02',78,1,0,NULL,NULL),
 (770,'CAMANTI','03',78,1,0,NULL,NULL),
 (771,'CCARHUAYO','04',78,1,0,NULL,NULL),
 (772,'CCATCA','05',78,1,0,NULL,NULL),
 (773,'CUSIPATA','06',78,1,0,NULL,NULL),
 (774,'HUARO','07',78,1,0,NULL,NULL),
 (775,'LUCRE','08',78,1,0,NULL,NULL),
 (776,'MARCAPATA','09',78,1,0,NULL,NULL),
 (777,'OCONGATE','10',78,1,0,NULL,NULL),
 (778,'OROPESA','11',78,1,0,NULL,NULL),
 (779,'QUIQUIJANA','12',78,1,0,NULL,NULL),
 (780,'URUBAMBA','01',79,1,0,NULL,NULL),
 (781,'CHINCHERO','02',79,1,0,NULL,NULL),
 (782,'HUAYLLABAMBA','03',79,1,0,NULL,NULL),
 (783,'MACHUPICCHU','04',79,1,0,NULL,NULL),
 (784,'MARAS','05',79,1,0,NULL,NULL),
 (785,'OLLANTAYTAMBO','06',79,1,0,NULL,NULL),
 (786,'YUCAY','07',79,1,0,NULL,NULL),
 (787,'HUANCAVELICA','01',80,1,0,NULL,NULL),
 (788,'ACOBAMBILLA','02',80,1,0,NULL,NULL),
 (789,'ACORIA','03',80,1,0,NULL,NULL),
 (790,'CONAYCA','04',80,1,0,NULL,NULL),
 (791,'CUENCA','05',80,1,0,NULL,NULL),
 (792,'HUACHOCOLPA','06',80,1,0,NULL,NULL),
 (793,'HUAYLLAHUARA','08',80,1,0,NULL,NULL),
 (794,'IZCUCHACA','09',80,1,0,NULL,NULL),
 (795,'LARIA','10',80,1,0,NULL,NULL),
 (796,'MANTA','11',80,1,0,NULL,NULL),
 (797,'MARISCAL CACERES','12',80,1,0,NULL,NULL),
 (798,'MOYA','13',80,1,0,NULL,NULL),
 (799,'NUEVO OCCORO','14',80,1,0,NULL,NULL),
 (800,'PALCA','15',80,1,0,NULL,NULL),
 (801,'PILCHACA','16',80,1,0,NULL,NULL),
 (802,'VILCA','17',80,1,0,NULL,NULL),
 (803,'YAULI','18',80,1,0,NULL,NULL),
 (804,'ASCENSION','19',80,1,0,NULL,NULL),
 (805,'HUANDO','20',80,1,0,NULL,NULL),
 (806,'ACOBAMBA','01',81,1,0,NULL,NULL),
 (807,'ANTA','02',81,1,0,NULL,NULL),
 (808,'ANDABAMBA','03',81,1,0,NULL,NULL),
 (809,'CAJA','04',81,1,0,NULL,NULL),
 (810,'MARCAS','05',81,1,0,NULL,NULL),
 (811,'PAUCARA','06',81,1,0,NULL,NULL),
 (812,'POMACOCHA','07',81,1,0,NULL,NULL),
 (813,'ROSARIO','08',81,1,0,NULL,NULL),
 (814,'LIRCAY','01',82,1,0,NULL,NULL),
 (815,'ANCHONGA','02',82,1,0,NULL,NULL),
 (816,'CALLANMARCA','03',82,1,0,NULL,NULL),
 (817,'CONGALLA','04',82,1,0,NULL,NULL),
 (818,'CHINCHO','05',82,1,0,NULL,NULL),
 (819,'HUAYLLAY-GRANDE','06',82,1,0,NULL,NULL),
 (820,'HUANCA-HUANCA','07',82,1,0,NULL,NULL),
 (821,'JULCAMARCA','08',82,1,0,NULL,NULL),
 (822,'SAN ANTONIO DE ANTAPARCO','09',82,1,0,NULL,NULL),
 (823,'SANTO TOMAS DE PATA','10',82,1,0,NULL,NULL),
 (824,'SECCLLA','11',82,1,0,NULL,NULL),
 (825,'CCOCHACCASA','12',82,1,0,NULL,NULL),
 (826,'CASTROVIRREYNA','01',83,1,0,NULL,NULL),
 (827,'ARMA','02',83,1,0,NULL,NULL),
 (828,'AURAHUA','03',83,1,0,NULL,NULL),
 (829,'CAPILLAS','05',83,1,0,NULL,NULL),
 (830,'COCAS','06',83,1,0,NULL,NULL),
 (831,'CHUPAMARCA','08',83,1,0,NULL,NULL),
 (832,'HUACHOS','09',83,1,0,NULL,NULL),
 (833,'HUAMATAMBO','10',83,1,0,NULL,NULL),
 (834,'MOLLEPAMPA','14',83,1,0,NULL,NULL),
 (835,'SAN JUAN','22',83,1,0,NULL,NULL),
 (836,'TANTARA','27',83,1,0,NULL,NULL),
 (837,'TICRAPO','28',83,1,0,NULL,NULL),
 (838,'SANTA ANA','29',83,1,0,NULL,NULL),
 (839,'PAMPAS','01',84,1,0,NULL,NULL),
 (840,'ACOSTAMBO','02',84,1,0,NULL,NULL),
 (841,'ACRAQUIA','03',84,1,0,NULL,NULL),
 (842,'AHUAYCHA','04',84,1,0,NULL,NULL),
 (843,'COLCABAMBA','06',84,1,0,NULL,NULL),
 (844,'DANIEL HERNANDEZ','09',84,1,0,NULL,NULL),
 (845,'HUACHOCOLPA','11',84,1,0,NULL,NULL),
 (846,'HUARIBAMBA','12',84,1,0,NULL,NULL),
 (847,'ÑAHUIMPUQUIO','15',84,1,0,NULL,NULL),
 (848,'PAZOS','17',84,1,0,NULL,NULL),
 (849,'QUISHUAR','18',84,1,0,NULL,NULL),
 (850,'SALCABAMBA','19',84,1,0,NULL,NULL),
 (851,'SAN MARCOS DE ROCCHAC','20',84,1,0,NULL,NULL),
 (852,'SURCUBAMBA','23',84,1,0,NULL,NULL),
 (853,'TINTAY PUNCU','25',84,1,0,NULL,NULL),
 (854,'SALCAHUASI','26',84,1,0,NULL,NULL),
 (855,'AYAVI','01',85,1,0,NULL,NULL),
 (856,'CORDOVA','02',85,1,0,NULL,NULL),
 (857,'HUAYACUNDO ARMA','03',85,1,0,NULL,NULL),
 (858,'HUAYTARA','04',85,1,0,NULL,NULL),
 (859,'LARAMARCA','05',85,1,0,NULL,NULL),
 (860,'OCOYO','06',85,1,0,NULL,NULL),
 (861,'PILPICHACA','07',85,1,0,NULL,NULL),
 (862,'QUERCO','08',85,1,0,NULL,NULL),
 (863,'QUITO ARMA','09',85,1,0,NULL,NULL),
 (864,'SAN ANTONIO DE CUSICANCHA','10',85,1,0,NULL,NULL),
 (865,'SAN FRANCISCO DE SANGAYAICO','11',85,1,0,NULL,NULL),
 (866,'SAN ISIDRO','12',85,1,0,NULL,NULL),
 (867,'SANTIAGO DE CHOCORVOS','13',85,1,0,NULL,NULL),
 (868,'SANTIAGO DE QUIRAHUARA','14',85,1,0,NULL,NULL),
 (869,'SANTO DOMINGO DE CAPILLAS','15',85,1,0,NULL,NULL),
 (870,'TAMBO','16',85,1,0,NULL,NULL),
 (871,'CHURCAMPA','01',86,1,0,NULL,NULL),
 (872,'ANCO','02',86,1,0,NULL,NULL),
 (873,'CHINCHIHUASI','03',86,1,0,NULL,NULL),
 (874,'EL CARMEN','04',86,1,0,NULL,NULL),
 (875,'LA MERCED','05',86,1,0,NULL,NULL),
 (876,'LOCROJA','06',86,1,0,NULL,NULL),
 (877,'PAUCARBAMBA','07',86,1,0,NULL,NULL),
 (878,'SAN MIGUEL DE MAYOCC','08',86,1,0,NULL,NULL),
 (879,'SAN PEDRO DE CORIS','09',86,1,0,NULL,NULL),
 (880,'PACHAMARCA','10',86,1,0,NULL,NULL),
 (881,'COSME','11',86,1,0,NULL,NULL),
 (882,'HUANUCO','01',87,1,0,NULL,NULL),
 (883,'CHINCHAO','02',87,1,0,NULL,NULL),
 (884,'CHURUBAMBA','03',87,1,0,NULL,NULL),
 (885,'MARGOS','04',87,1,0,NULL,NULL),
 (886,'QUISQUI','05',87,1,0,NULL,NULL),
 (887,'SAN FRANCISCO DE CAYRAN','06',87,1,0,NULL,NULL),
 (888,'SAN PEDRO DE CHAULAN','07',87,1,0,NULL,NULL),
 (889,'SANTA MARIA DEL VALLE','08',87,1,0,NULL,NULL),
 (890,'YARUMAYO','09',87,1,0,NULL,NULL),
 (891,'AMARILIS','10',87,1,0,NULL,NULL),
 (892,'PILLCO MARCA','11',87,1,0,NULL,NULL),
 (893,'YACUS','12',87,1,0,NULL,NULL),
 (894,'AMBO','01',88,1,0,NULL,NULL),
 (895,'CAYNA','02',88,1,0,NULL,NULL),
 (896,'COLPAS','03',88,1,0,NULL,NULL),
 (897,'CONCHAMARCA','04',88,1,0,NULL,NULL),
 (898,'HUACAR','05',88,1,0,NULL,NULL),
 (899,'SAN FRANCISCO','06',88,1,0,NULL,NULL),
 (900,'SAN RAFAEL','07',88,1,0,NULL,NULL),
 (901,'TOMAY-KICHWA','08',88,1,0,NULL,NULL),
 (902,'LA UNION','01',89,1,0,NULL,NULL),
 (903,'CHUQUIS','07',89,1,0,NULL,NULL),
 (904,'MARIAS','12',89,1,0,NULL,NULL),
 (905,'PACHAS','14',89,1,0,NULL,NULL),
 (906,'QUIVILLA','16',89,1,0,NULL,NULL),
 (907,'RIPAN','17',89,1,0,NULL,NULL),
 (908,'SHUNQUI','21',89,1,0,NULL,NULL),
 (909,'SILLAPATA','22',89,1,0,NULL,NULL),
 (910,'YANAS','23',89,1,0,NULL,NULL),
 (911,'LLATA','01',90,1,0,NULL,NULL),
 (912,'ARANCAY','02',90,1,0,NULL,NULL),
 (913,'CHAVIN DE PARIARCA','03',90,1,0,NULL,NULL),
 (914,'JACAS GRANDE','04',90,1,0,NULL,NULL),
 (915,'JIRCAN','05',90,1,0,NULL,NULL),
 (916,'MIRAFLORES','06',90,1,0,NULL,NULL),
 (917,'MONZON','07',90,1,0,NULL,NULL),
 (918,'PUNCHAO','08',90,1,0,NULL,NULL),
 (919,'PUÑOS','09',90,1,0,NULL,NULL),
 (920,'SINGA','10',90,1,0,NULL,NULL),
 (921,'TANTAMAYO','11',90,1,0,NULL,NULL),
 (922,'HUACRACHUCO','01',91,1,0,NULL,NULL),
 (923,'CHOLON','02',91,1,0,NULL,NULL),
 (924,'SAN BUENAVENTURA','05',91,1,0,NULL,NULL),
 (925,'RUPA-RUPA','01',92,1,0,NULL,NULL),
 (926,'DANIEL ALOMIA ROBLES','02',92,1,0,NULL,NULL),
 (927,'HERMILIO VALDIZAN','03',92,1,0,NULL,NULL),
 (928,'LUYANDO','04',92,1,0,NULL,NULL),
 (929,'MARIANO DAMASO BERAUN','05',92,1,0,NULL,NULL),
 (930,'JOSE CRESPO Y CASTILLO','06',92,1,0,NULL,NULL),
 (931,'PANAO','01',93,1,0,NULL,NULL),
 (932,'CHAGLLA','02',93,1,0,NULL,NULL),
 (933,'MOLINO','04',93,1,0,NULL,NULL),
 (934,'UMARI','06',93,1,0,NULL,NULL),
 (935,'HONORIA','01',94,1,0,NULL,NULL),
 (936,'PUERTO INCA','02',94,1,0,NULL,NULL),
 (937,'CODO DEL POZUZO','03',94,1,0,NULL,NULL),
 (938,'TOURNAVISTA','04',94,1,0,NULL,NULL),
 (939,'YUYAPICHIS','05',94,1,0,NULL,NULL),
 (940,'HUACAYBAMBA','01',95,1,0,NULL,NULL),
 (941,'PINRA','02',95,1,0,NULL,NULL),
 (942,'CANCHABAMBA','03',95,1,0,NULL,NULL),
 (943,'COCHABAMBA','04',95,1,0,NULL,NULL),
 (944,'JESUS','01',96,1,0,NULL,NULL),
 (945,'BAÑOS','02',96,1,0,NULL,NULL),
 (946,'SAN FRANCISCO DE ASIS','03',96,1,0,NULL,NULL),
 (947,'QUEROPALCA','04',96,1,0,NULL,NULL),
 (948,'SAN MIGUEL DE CAURI','05',96,1,0,NULL,NULL),
 (949,'RONDOS','06',96,1,0,NULL,NULL),
 (950,'JIVIA','07',96,1,0,NULL,NULL),
 (951,'CHAVINILLO','01',97,1,0,NULL,NULL),
 (952,'APARICIO POMARES','02',97,1,0,NULL,NULL),
 (953,'CAHUAC','03',97,1,0,NULL,NULL),
 (954,'CHACABAMBA','04',97,1,0,NULL,NULL),
 (955,'JACAS CHICO','05',97,1,0,NULL,NULL),
 (956,'OBAS','06',97,1,0,NULL,NULL),
 (957,'PAMPAMARCA','07',97,1,0,NULL,NULL),
 (958,'CHORAS','08',97,1,0,NULL,NULL),
 (959,'ICA','01',98,1,0,NULL,NULL),
 (960,'LA TINGUIÑA','02',98,1,0,NULL,NULL),
 (961,'LOS AQUIJES','03',98,1,0,NULL,NULL),
 (962,'PARCONA','04',98,1,0,NULL,NULL),
 (963,'PUEBLO NUEVO','05',98,1,0,NULL,NULL),
 (964,'SALAS','06',98,1,0,NULL,NULL),
 (965,'SAN JOSE DE LOS MOLINOS','07',98,1,0,NULL,NULL),
 (966,'SAN JUAN BAUTISTA','08',98,1,0,NULL,NULL),
 (967,'SANTIAGO','09',98,1,0,NULL,NULL),
 (968,'SUBTANJALLA','10',98,1,0,NULL,NULL),
 (969,'YAUCA DEL ROSARIO','11',98,1,0,NULL,NULL),
 (970,'TATE','12',98,1,0,NULL,NULL),
 (971,'PACHACUTEC','13',98,1,0,NULL,NULL),
 (972,'OCUCAJE','14',98,1,0,NULL,NULL),
 (973,'CHINCHA ALTA','01',99,1,0,NULL,NULL),
 (974,'CHAVIN','02',99,1,0,NULL,NULL),
 (975,'CHINCHA BAJA','03',99,1,0,NULL,NULL),
 (976,'EL CARMEN','04',99,1,0,NULL,NULL),
 (977,'GROCIO PRADO','05',99,1,0,NULL,NULL),
 (978,'SAN PEDRO DE HUACARPANA','06',99,1,0,NULL,NULL),
 (979,'SUNAMPE','07',99,1,0,NULL,NULL),
 (980,'TAMBO DE MORA','08',99,1,0,NULL,NULL),
 (981,'ALTO LARAN','09',99,1,0,NULL,NULL),
 (982,'PUEBLO NUEVO','10',99,1,0,NULL,NULL),
 (983,'SAN JUAN DE YANAC','11',99,1,0,NULL,NULL),
 (984,'NAZCA','01',100,1,0,NULL,NULL),
 (985,'CHANGUILLO','02',100,1,0,NULL,NULL),
 (986,'EL INGENIO','03',100,1,0,NULL,NULL),
 (987,'MARCONA','04',100,1,0,NULL,NULL),
 (988,'VISTA ALEGRE','05',100,1,0,NULL,NULL),
 (989,'PISCO','01',101,1,0,NULL,NULL),
 (990,'HUANCANO','02',101,1,0,NULL,NULL),
 (991,'HUMAY','03',101,1,0,NULL,NULL),
 (992,'INDEPENDENCIA','04',101,1,0,NULL,NULL),
 (993,'PARACAS','05',101,1,0,NULL,NULL),
 (994,'SAN ANDRES','06',101,1,0,NULL,NULL),
 (995,'SAN CLEMENTE','07',101,1,0,NULL,NULL),
 (996,'TUPAC AMARU INCA','08',101,1,0,NULL,NULL),
 (997,'PALPA','01',102,1,0,NULL,NULL),
 (998,'LLIPATA','02',102,1,0,NULL,NULL),
 (999,'RIO GRANDE','03',102,1,0,NULL,NULL),
 (1000,'SANTA CRUZ','04',102,1,0,NULL,NULL),
 (1001,'TIBILLO','05',102,1,0,NULL,NULL),
 (1002,'HUANCAYO','01',103,1,0,NULL,NULL),
 (1003,'CARHUACALLANGA','03',103,1,0,NULL,NULL),
 (1004,'COLCA','04',103,1,0,NULL,NULL),
 (1005,'CULLHUAS','05',103,1,0,NULL,NULL),
 (1006,'CHACAPAMPA','06',103,1,0,NULL,NULL),
 (1007,'CHICCHE','07',103,1,0,NULL,NULL),
 (1008,'CHILCA','08',103,1,0,NULL,NULL),
 (1009,'CHONGOS ALTO','09',103,1,0,NULL,NULL),
 (1010,'CHUPURO','12',103,1,0,NULL,NULL),
 (1011,'EL TAMBO','13',103,1,0,NULL,NULL),
 (1012,'HUACRAPUQUIO','14',103,1,0,NULL,NULL),
 (1013,'HUALHUAS','16',103,1,0,NULL,NULL),
 (1014,'HUANCAN','18',103,1,0,NULL,NULL),
 (1015,'HUASICANCHA','19',103,1,0,NULL,NULL),
 (1016,'HUAYUCACHI','20',103,1,0,NULL,NULL),
 (1017,'INGENIO','21',103,1,0,NULL,NULL),
 (1018,'PARIAHUANCA','22',103,1,0,NULL,NULL),
 (1019,'PILCOMAYO','23',103,1,0,NULL,NULL),
 (1020,'PUCARA','24',103,1,0,NULL,NULL),
 (1021,'QUICHUAY','25',103,1,0,NULL,NULL),
 (1022,'QUILCAS','26',103,1,0,NULL,NULL),
 (1023,'SAN AGUSTIN','27',103,1,0,NULL,NULL),
 (1024,'SAN JERONIMO DE TUNAN','28',103,1,0,NULL,NULL),
 (1025,'SANTO DOMINGO DE ACOBAMBA','31',103,1,0,NULL,NULL),
 (1026,'SAÑO','32',103,1,0,NULL,NULL),
 (1027,'SAPALLANGA','33',103,1,0,NULL,NULL),
 (1028,'SICAYA','34',103,1,0,NULL,NULL),
 (1029,'VIQUES','36',103,1,0,NULL,NULL),
 (1030,'CONCEPCION','01',104,1,0,NULL,NULL),
 (1031,'ACO','02',104,1,0,NULL,NULL),
 (1032,'ANDAMARCA','03',104,1,0,NULL,NULL),
 (1033,'COMAS','04',104,1,0,NULL,NULL),
 (1034,'COCHAS','05',104,1,0,NULL,NULL),
 (1035,'CHAMBARA','06',104,1,0,NULL,NULL),
 (1036,'HEROINAS TOLEDO','07',104,1,0,NULL,NULL),
 (1037,'MANZANARES','08',104,1,0,NULL,NULL),
 (1038,'MARISCAL CASTILLA','09',104,1,0,NULL,NULL),
 (1039,'MATAHUASI','10',104,1,0,NULL,NULL),
 (1040,'MITO','11',104,1,0,NULL,NULL),
 (1041,'NUEVE DE JULIO','12',104,1,0,NULL,NULL),
 (1042,'ORCOTUNA','13',104,1,0,NULL,NULL),
 (1043,'SANTA ROSA DE OCOPA','14',104,1,0,NULL,NULL),
 (1044,'SAN JOSE DE QUERO','15',104,1,0,NULL,NULL),
 (1045,'JAUJA','01',105,1,0,NULL,NULL),
 (1046,'ACOLLA','02',105,1,0,NULL,NULL),
 (1047,'APATA','03',105,1,0,NULL,NULL),
 (1048,'ATAURA','04',105,1,0,NULL,NULL),
 (1049,'CANCHAYLLO','05',105,1,0,NULL,NULL),
 (1050,'EL MANTARO','06',105,1,0,NULL,NULL),
 (1051,'HUAMALI','07',105,1,0,NULL,NULL),
 (1052,'HUARIPAMPA','08',105,1,0,NULL,NULL),
 (1053,'HUERTAS','09',105,1,0,NULL,NULL),
 (1054,'JANJAILLO','10',105,1,0,NULL,NULL),
 (1055,'JULCAN','11',105,1,0,NULL,NULL),
 (1056,'LEONOR ORDOÑEZ','12',105,1,0,NULL,NULL),
 (1057,'LLOCLLAPAMPA','13',105,1,0,NULL,NULL),
 (1058,'MARCO','14',105,1,0,NULL,NULL),
 (1059,'MASMA','15',105,1,0,NULL,NULL),
 (1060,'MOLINOS','16',105,1,0,NULL,NULL),
 (1061,'MONOBAMBA','17',105,1,0,NULL,NULL),
 (1062,'MUQUI','18',105,1,0,NULL,NULL),
 (1063,'MUQUIYAUYO','19',105,1,0,NULL,NULL),
 (1064,'PACA','20',105,1,0,NULL,NULL),
 (1065,'PACCHA','21',105,1,0,NULL,NULL),
 (1066,'PANCAN','22',105,1,0,NULL,NULL),
 (1067,'PARCO','23',105,1,0,NULL,NULL),
 (1068,'POMACANCHA','24',105,1,0,NULL,NULL),
 (1069,'RICRAN','25',105,1,0,NULL,NULL),
 (1070,'SAN LORENZO','26',105,1,0,NULL,NULL),
 (1071,'SAN PEDRO DE CHUNAN','27',105,1,0,NULL,NULL),
 (1072,'SINCOS','28',105,1,0,NULL,NULL),
 (1073,'TUNAN MARCA','29',105,1,0,NULL,NULL),
 (1074,'YAULI','30',105,1,0,NULL,NULL),
 (1075,'CURICACA','31',105,1,0,NULL,NULL),
 (1076,'MASMA CHICCHE','32',105,1,0,NULL,NULL),
 (1077,'SAUSA','33',105,1,0,NULL,NULL),
 (1078,'YAUYOS','34',105,1,0,NULL,NULL),
 (1079,'JUNIN','01',106,1,0,NULL,NULL),
 (1080,'CARHUAMAYO','02',106,1,0,NULL,NULL),
 (1081,'ONDORES','03',106,1,0,NULL,NULL),
 (1082,'ULCUMAYO','04',106,1,0,NULL,NULL),
 (1083,'TARMA','01',107,1,0,NULL,NULL),
 (1084,'ACOBAMBA','02',107,1,0,NULL,NULL),
 (1085,'HUARICOLCA','03',107,1,0,NULL,NULL),
 (1086,'HUASAHUASI','04',107,1,0,NULL,NULL),
 (1087,'LA UNION','05',107,1,0,NULL,NULL),
 (1088,'PALCA','06',107,1,0,NULL,NULL),
 (1089,'PALCAMAYO','07',107,1,0,NULL,NULL),
 (1090,'SAN PEDRO DE CAJAS','08',107,1,0,NULL,NULL),
 (1091,'TAPO','09',107,1,0,NULL,NULL),
 (1092,'LA OROYA','01',108,1,0,NULL,NULL),
 (1093,'CHACAPALPA','02',108,1,0,NULL,NULL),
 (1094,'HUAY HUAY','03',108,1,0,NULL,NULL),
 (1095,'MARCAPOMACOCHA','04',108,1,0,NULL,NULL),
 (1096,'MOROCOCHA','05',108,1,0,NULL,NULL),
 (1097,'PACCHA','06',108,1,0,NULL,NULL),
 (1098,'SANTA BARBARA DE CARHUACAYAN','07',108,1,0,NULL,NULL),
 (1099,'SUITUCANCHA','08',108,1,0,NULL,NULL),
 (1100,'YAULI','09',108,1,0,NULL,NULL),
 (1101,'SANTA ROSA DE SACCO','10',108,1,0,NULL,NULL),
 (1102,'SATIPO','01',109,1,0,NULL,NULL),
 (1103,'COVIRIALI','02',109,1,0,NULL,NULL),
 (1104,'LLAYLLA','03',109,1,0,NULL,NULL),
 (1105,'MAZAMARI','04',109,1,0,NULL,NULL),
 (1106,'PAMPA HERMOSA','05',109,1,0,NULL,NULL),
 (1107,'PANGOA','06',109,1,0,NULL,NULL),
 (1108,'RIO NEGRO','07',109,1,0,NULL,NULL),
 (1109,'RIO TAMBO','08',109,1,0,NULL,NULL),
 (1110,'CHANCHAMAYO','01',110,1,0,NULL,NULL),
 (1111,'SAN RAMON','02',110,1,0,NULL,NULL),
 (1112,'VITOC','03',110,1,0,NULL,NULL),
 (1113,'SAN LUIS DE SHUARO','04',110,1,0,NULL,NULL),
 (1114,'PICHANAQUI','05',110,1,0,NULL,NULL),
 (1115,'PERENE','06',110,1,0,NULL,NULL),
 (1116,'CHUPACA','01',111,1,0,NULL,NULL),
 (1117,'AHUAC','02',111,1,0,NULL,NULL),
 (1118,'CHONGOS BAJO','03',111,1,0,NULL,NULL),
 (1119,'HUACHAC','04',111,1,0,NULL,NULL),
 (1120,'HUAMANCACA CHICO','05',111,1,0,NULL,NULL),
 (1121,'SAN JUAN DE YSCOS','06',111,1,0,NULL,NULL),
 (1122,'SAN JUAN DE JARPA','07',111,1,0,NULL,NULL),
 (1123,'TRES DE DICIEMBRE','08',111,1,0,NULL,NULL),
 (1124,'YANACANCHA','09',111,1,0,NULL,NULL),
 (1125,'TRUJILLO','01',112,1,0,NULL,NULL),
 (1126,'HUANCHACO','02',112,1,0,NULL,NULL),
 (1127,'LAREDO','03',112,1,0,NULL,NULL),
 (1128,'MOCHE','04',112,1,0,NULL,NULL),
 (1129,'SALAVERRY','05',112,1,0,NULL,NULL),
 (1130,'SIMBAL','06',112,1,0,NULL,NULL),
 (1131,'VICTOR LARCO HERRERA','07',112,1,0,NULL,NULL),
 (1132,'POROTO','09',112,1,0,NULL,NULL),
 (1133,'EL PORVENIR','10',112,1,0,NULL,NULL),
 (1134,'LA ESPERANZA','11',112,1,0,NULL,NULL),
 (1135,'FLORENCIA DE MORA','12',112,1,0,NULL,NULL),
 (1136,'BOLIVAR','01',113,1,0,NULL,NULL),
 (1137,'BAMBAMARCA','02',113,1,0,NULL,NULL),
 (1138,'CONDORMARCA','03',113,1,0,NULL,NULL),
 (1139,'LONGOTEA','04',113,1,0,NULL,NULL),
 (1140,'UCUNCHA','05',113,1,0,NULL,NULL),
 (1141,'UCHUMARCA','06',113,1,0,NULL,NULL),
 (1142,'HUAMACHUCO','01',114,1,0,NULL,NULL),
 (1143,'COCHORCO','02',114,1,0,NULL,NULL),
 (1144,'CURGOS','03',114,1,0,NULL,NULL),
 (1145,'CHUGAY','04',114,1,0,NULL,NULL),
 (1146,'MARCABAL','05',114,1,0,NULL,NULL),
 (1147,'SANAGORAN','06',114,1,0,NULL,NULL),
 (1148,'SARIN','07',114,1,0,NULL,NULL),
 (1149,'SARTIMBAMBA','08',114,1,0,NULL,NULL),
 (1150,'OTUZCO','01',115,1,0,NULL,NULL),
 (1151,'AGALLPAMPA','02',115,1,0,NULL,NULL),
 (1152,'CHARAT','03',115,1,0,NULL,NULL),
 (1153,'HUARANCHAL','04',115,1,0,NULL,NULL),
 (1154,'LA CUESTA','05',115,1,0,NULL,NULL),
 (1155,'PARANDAY','08',115,1,0,NULL,NULL),
 (1156,'SALPO','09',115,1,0,NULL,NULL),
 (1157,'SINSICAP','10',115,1,0,NULL,NULL),
 (1158,'USQUIL','11',115,1,0,NULL,NULL),
 (1159,'MACHE','13',115,1,0,NULL,NULL),
 (1160,'SAN PEDRO DE LLOC','01',116,1,0,NULL,NULL),
 (1161,'GUADALUPE','03',116,1,0,NULL,NULL),
 (1162,'JEQUETEPEQUE','04',116,1,0,NULL,NULL),
 (1163,'PACASMAYO','06',116,1,0,NULL,NULL),
 (1164,'SAN JOSE','08',116,1,0,NULL,NULL),
 (1165,'TAYABAMBA','01',117,1,0,NULL,NULL),
 (1166,'BULDIBUYO','02',117,1,0,NULL,NULL),
 (1167,'CHILLIA','03',117,1,0,NULL,NULL),
 (1168,'HUAYLILLAS','04',117,1,0,NULL,NULL),
 (1169,'HUANCASPATA','05',117,1,0,NULL,NULL),
 (1170,'HUAYO','06',117,1,0,NULL,NULL),
 (1171,'ONGON','07',117,1,0,NULL,NULL),
 (1172,'PARCOY','08',117,1,0,NULL,NULL),
 (1173,'PATAZ','09',117,1,0,NULL,NULL),
 (1174,'PIAS','10',117,1,0,NULL,NULL),
 (1175,'TAURIJA','11',117,1,0,NULL,NULL),
 (1176,'URPAY','12',117,1,0,NULL,NULL),
 (1177,'SANTIAGO DE CHALLAS','13',117,1,0,NULL,NULL),
 (1178,'SANTIAGO DE CHUCO','01',118,1,0,NULL,NULL),
 (1179,'CACHICADAN','02',118,1,0,NULL,NULL),
 (1180,'MOLLEBAMBA','03',118,1,0,NULL,NULL),
 (1181,'MOLLEPATA','04',118,1,0,NULL,NULL),
 (1182,'QUIRUVILCA','05',118,1,0,NULL,NULL),
 (1183,'SANTA CRUZ DE CHUCA','06',118,1,0,NULL,NULL),
 (1184,'SITABAMBA','07',118,1,0,NULL,NULL),
 (1185,'ANGASMARCA','08',118,1,0,NULL,NULL),
 (1186,'ASCOPE','01',119,1,0,NULL,NULL),
 (1187,'CHICAMA','02',119,1,0,NULL,NULL),
 (1188,'CHOCOPE','03',119,1,0,NULL,NULL),
 (1189,'SANTIAGO DE CAO','04',119,1,0,NULL,NULL),
 (1190,'MAGDALENA DE CAO','05',119,1,0,NULL,NULL),
 (1191,'PAIJAN','06',119,1,0,NULL,NULL),
 (1192,'RAZURI','07',119,1,0,NULL,NULL),
 (1193,'CASA GRANDE','08',119,1,0,NULL,NULL),
 (1194,'CHEPEN','01',120,1,0,NULL,NULL),
 (1195,'PACANGA','02',120,1,0,NULL,NULL),
 (1196,'PUEBLO NUEVO','03',120,1,0,NULL,NULL),
 (1197,'JULCAN','01',121,1,0,NULL,NULL),
 (1198,'CARABAMBA','02',121,1,0,NULL,NULL),
 (1199,'CALAMARCA','03',121,1,0,NULL,NULL),
 (1200,'HUASO','04',121,1,0,NULL,NULL),
 (1201,'CASCAS','01',122,1,0,NULL,NULL),
 (1202,'LUCMA','02',122,1,0,NULL,NULL),
 (1203,'MARMOT','03',122,1,0,NULL,NULL),
 (1204,'SAYAPULLO','04',122,1,0,NULL,NULL),
 (1205,'VIRU','01',123,1,0,NULL,NULL),
 (1206,'CHAO','02',123,1,0,NULL,NULL),
 (1207,'GUADALUPITO','03',123,1,0,NULL,NULL),
 (1208,'CHICLAYO','01',124,1,0,NULL,NULL),
 (1209,'CHONGOYAPE','02',124,1,0,NULL,NULL),
 (1210,'ETEN','03',124,1,0,NULL,NULL),
 (1211,'ETEN PUERTO','04',124,1,0,NULL,NULL),
 (1212,'LAGUNAS','05',124,1,0,NULL,NULL),
 (1213,'MONSEFU','06',124,1,0,NULL,NULL),
 (1214,'NUEVA ARICA','07',124,1,0,NULL,NULL),
 (1215,'OYOTUN','08',124,1,0,NULL,NULL),
 (1216,'PICSI','09',124,1,0,NULL,NULL),
 (1217,'PIMENTEL','10',124,1,0,NULL,NULL),
 (1218,'REQUE','11',124,1,0,NULL,NULL),
 (1219,'JOSE LEONARDO ORTIZ','12',124,1,0,NULL,NULL),
 (1220,'SANTA ROSA','13',124,1,0,NULL,NULL),
 (1221,'SAÑA','14',124,1,0,NULL,NULL),
 (1222,'LA VICTORIA','15',124,1,0,NULL,NULL),
 (1223,'CAYALTI','16',124,1,0,NULL,NULL),
 (1224,'PATAPO','17',124,1,0,NULL,NULL),
 (1225,'POMALCA','18',124,1,0,NULL,NULL),
 (1226,'PUCALA','19',124,1,0,NULL,NULL),
 (1227,'TUMAN','20',124,1,0,NULL,NULL),
 (1228,'FERREÑAFE','01',125,1,0,NULL,NULL),
 (1229,'INCAHUASI','02',125,1,0,NULL,NULL),
 (1230,'CAÑARIS','03',125,1,0,NULL,NULL),
 (1231,'PITIPO','04',125,1,0,NULL,NULL),
 (1232,'PUEBLO NUEVO','05',125,1,0,NULL,NULL),
 (1233,'MANUEL ANTONIO MESONES MURO','06',125,1,0,NULL,NULL),
 (1234,'LAMBAYEQUE','01',126,1,0,NULL,NULL),
 (1235,'CHOCHOPE','02',126,1,0,NULL,NULL),
 (1236,'ILLIMO','03',126,1,0,NULL,NULL),
 (1237,'JAYANCA','04',126,1,0,NULL,NULL),
 (1238,'MOCHUMI','05',126,1,0,NULL,NULL),
 (1239,'MORROPE','06',126,1,0,NULL,NULL),
 (1240,'MOTUPE','07',126,1,0,NULL,NULL),
 (1241,'OLMOS','08',126,1,0,NULL,NULL),
 (1242,'PACORA','09',126,1,0,NULL,NULL),
 (1243,'SALAS','10',126,1,0,NULL,NULL),
 (1244,'SAN JOSE','11',126,1,0,NULL,NULL),
 (1245,'TUCUME','12',126,1,0,NULL,NULL),
 (1246,'LIMA','01',127,1,0,NULL,NULL),
 (1247,'ANCON','02',127,1,0,NULL,NULL),
 (1248,'ATE','03',127,1,0,NULL,NULL),
 (1249,'BREÑA','04',127,1,0,NULL,NULL),
 (1250,'CARABAYLLO','05',127,1,0,NULL,NULL),
 (1251,'COMAS','06',127,1,0,NULL,NULL),
 (1252,'CHACLACAYO','07',127,1,0,NULL,NULL),
 (1253,'CHORRILLOS','08',127,1,0,NULL,NULL),
 (1254,'LA VICTORIA','09',127,1,0,NULL,NULL),
 (1255,'LA MOLINA','10',127,1,0,NULL,NULL),
 (1256,'LINCE','11',127,1,0,NULL,NULL),
 (1257,'LURIGANCHO','12',127,1,0,NULL,NULL),
 (1258,'LURIN','13',127,1,0,NULL,NULL),
 (1259,'MAGDALENA DEL MAR','14',127,1,0,NULL,NULL),
 (1260,'MIRAFLORES','15',127,1,0,NULL,NULL),
 (1261,'PACHACAMAC','16',127,1,0,NULL,NULL),
 (1262,'PUEBLO LIBRE','17',127,1,0,NULL,NULL),
 (1263,'PUCUSANA','18',127,1,0,NULL,NULL),
 (1264,'PUENTE PIEDRA','19',127,1,0,NULL,NULL),
 (1265,'PUNTA HERMOSA','20',127,1,0,NULL,NULL),
 (1266,'PUNTA NEGRA','21',127,1,0,NULL,NULL),
 (1267,'RIMAC','22',127,1,0,NULL,NULL),
 (1268,'SAN BARTOLO','23',127,1,0,NULL,NULL),
 (1269,'SAN ISIDRO','24',127,1,0,NULL,NULL),
 (1270,'BARRANCO','25',127,1,0,NULL,NULL),
 (1271,'SAN MARTIN DE PORRES','26',127,1,0,NULL,NULL),
 (1272,'SAN MIGUEL','27',127,1,0,NULL,NULL),
 (1273,'SANTA MARIA DEL MAR','28',127,1,0,NULL,NULL),
 (1274,'SANTA ROSA','29',127,1,0,NULL,NULL),
 (1275,'SANTIAGO DE SURCO','30',127,1,0,NULL,NULL),
 (1276,'SURQUILLO','31',127,1,0,NULL,NULL),
 (1277,'VILLA MARIA DEL TRIUNFO','32',127,1,0,NULL,NULL),
 (1278,'JESUS MARIA','33',127,1,0,NULL,NULL),
 (1279,'INDEPENDENCIA','34',127,1,0,NULL,NULL),
 (1280,'EL AGUSTINO','35',127,1,0,NULL,NULL),
 (1281,'SAN JUAN DE MIRAFLORES','36',127,1,0,NULL,NULL),
 (1282,'SAN JUAN DE LURIGANCHO','37',127,1,0,NULL,NULL),
 (1283,'SAN LUIS','38',127,1,0,NULL,NULL),
 (1284,'CIENEGUILLA','39',127,1,0,NULL,NULL),
 (1285,'SAN BORJA','40',127,1,0,NULL,NULL),
 (1286,'VILLA EL SALVADOR','41',127,1,0,NULL,NULL),
 (1287,'LOS OLIVOS','42',127,1,0,NULL,NULL),
 (1288,'SANTA ANITA','43',127,1,0,NULL,NULL),
 (1289,'CAJATAMBO','01',128,1,0,NULL,NULL),
 (1290,'COPA','05',128,1,0,NULL,NULL),
 (1291,'GORGOR','06',128,1,0,NULL,NULL),
 (1292,'HUANCAPON','07',128,1,0,NULL,NULL),
 (1293,'MANAS','08',128,1,0,NULL,NULL),
 (1294,'CANTA','01',129,1,0,NULL,NULL),
 (1295,'ARAHUAY','02',129,1,0,NULL,NULL),
 (1296,'HUAMANTANGA','03',129,1,0,NULL,NULL),
 (1297,'HUAROS','04',129,1,0,NULL,NULL),
 (1298,'LACHAQUI','05',129,1,0,NULL,NULL),
 (1299,'SAN BUENAVENTURA','06',129,1,0,NULL,NULL),
 (1300,'SANTA ROSA DE QUIVES','07',129,1,0,NULL,NULL),
 (1301,'SAN VICENTE DE CAÑETE','01',130,1,0,NULL,NULL),
 (1302,'CALANGO','02',130,1,0,NULL,NULL),
 (1303,'CERRO AZUL','03',130,1,0,NULL,NULL),
 (1304,'COAYLLO','04',130,1,0,NULL,NULL),
 (1305,'CHILCA','05',130,1,0,NULL,NULL),
 (1306,'IMPERIAL','06',130,1,0,NULL,NULL),
 (1307,'LUNAHUANA','07',130,1,0,NULL,NULL),
 (1308,'MALA','08',130,1,0,NULL,NULL),
 (1309,'NUEVO IMPERIAL','09',130,1,0,NULL,NULL),
 (1310,'PACARAN','10',130,1,0,NULL,NULL),
 (1311,'QUILMANA','11',130,1,0,NULL,NULL),
 (1312,'SAN ANTONIO','12',130,1,0,NULL,NULL),
 (1313,'SAN LUIS','13',130,1,0,NULL,NULL),
 (1314,'SANTA CRUZ DE FLORES','14',130,1,0,NULL,NULL),
 (1315,'ZUÑIGA','15',130,1,0,NULL,NULL),
 (1316,'ASIA','16',130,1,0,NULL,NULL),
 (1317,'HUACHO','01',131,1,0,NULL,NULL),
 (1318,'AMBAR','02',131,1,0,NULL,NULL),
 (1319,'CALETA DE CARQUIN','04',131,1,0,NULL,NULL),
 (1320,'CHECRAS','05',131,1,0,NULL,NULL),
 (1321,'HUALMAY','06',131,1,0,NULL,NULL),
 (1322,'HUAURA','07',131,1,0,NULL,NULL),
 (1323,'LEONCIO PRADO','08',131,1,0,NULL,NULL),
 (1324,'PACCHO','09',131,1,0,NULL,NULL),
 (1325,'SANTA LEONOR','11',131,1,0,NULL,NULL),
 (1326,'SANTA MARIA','12',131,1,0,NULL,NULL),
 (1327,'SAYAN','13',131,1,0,NULL,NULL),
 (1328,'VEGUETA','16',131,1,0,NULL,NULL),
 (1329,'MATUCANA','01',132,1,0,NULL,NULL),
 (1330,'ANTIOQUIA','02',132,1,0,NULL,NULL),
 (1331,'CALLAHUANCA','03',132,1,0,NULL,NULL),
 (1332,'CARAMPOMA','04',132,1,0,NULL,NULL),
 (1333,'CASTA','05',132,1,0,NULL,NULL),
 (1334,'SAN JOSE DE LOS CHORRILLOS','06',132,1,0,NULL,NULL),
 (1335,'CHICLA','07',132,1,0,NULL,NULL),
 (1336,'HUANZA','08',132,1,0,NULL,NULL),
 (1337,'HUAROCHIRI','09',132,1,0,NULL,NULL),
 (1338,'LAHUAYTAMBO','10',132,1,0,NULL,NULL),
 (1339,'LANGA','11',132,1,0,NULL,NULL),
 (1340,'MARIATANA','12',132,1,0,NULL,NULL),
 (1341,'RICARDO PALMA','13',132,1,0,NULL,NULL),
 (1342,'SAN ANDRES DE TUPICOCHA','14',132,1,0,NULL,NULL),
 (1343,'SAN ANTONIO','15',132,1,0,NULL,NULL),
 (1344,'SAN BARTOLOME','16',132,1,0,NULL,NULL),
 (1345,'SAN DAMIAN','17',132,1,0,NULL,NULL),
 (1346,'SANGALLAYA','18',132,1,0,NULL,NULL),
 (1347,'SAN JUAN DE TANTARANCHE','19',132,1,0,NULL,NULL),
 (1348,'SAN LORENZO DE QUINTI','20',132,1,0,NULL,NULL),
 (1349,'SAN MATEO','21',132,1,0,NULL,NULL),
 (1350,'SAN MATEO DE OTAO','22',132,1,0,NULL,NULL),
 (1351,'SAN PEDRO DE HUANCAYRE','23',132,1,0,NULL,NULL),
 (1352,'SANTA CRUZ DE COCACHACRA','24',132,1,0,NULL,NULL),
 (1353,'SANTA EULALIA','25',132,1,0,NULL,NULL),
 (1354,'SANTIAGO DE ANCHUCAYA','26',132,1,0,NULL,NULL),
 (1355,'SANTIAGO DE TUNA','27',132,1,0,NULL,NULL),
 (1356,'SANTO DOMINGO DE LOS OLLEROS','28',132,1,0,NULL,NULL),
 (1357,'SURCO','29',132,1,0,NULL,NULL),
 (1358,'HUACHUPAMPA','30',132,1,0,NULL,NULL),
 (1359,'LARAOS','31',132,1,0,NULL,NULL),
 (1360,'SAN JUAN DE IRIS','32',132,1,0,NULL,NULL),
 (1361,'YAUYOS','01',133,1,0,NULL,NULL),
 (1362,'ALIS','02',133,1,0,NULL,NULL),
 (1363,'ALLAUCA','03',133,1,0,NULL,NULL),
 (1364,'AYAVIRI','04',133,1,0,NULL,NULL),
 (1365,'AZANGARO','05',133,1,0,NULL,NULL),
 (1366,'CACRA','06',133,1,0,NULL,NULL),
 (1367,'CARANIA','07',133,1,0,NULL,NULL),
 (1368,'COCHAS','08',133,1,0,NULL,NULL),
 (1369,'COLONIA','09',133,1,0,NULL,NULL),
 (1370,'CHOCOS','10',133,1,0,NULL,NULL),
 (1371,'HUAMPARA','11',133,1,0,NULL,NULL),
 (1372,'HUANCAYA','12',133,1,0,NULL,NULL),
 (1373,'HUANGASCAR','13',133,1,0,NULL,NULL),
 (1374,'HUANTAN','14',133,1,0,NULL,NULL),
 (1375,'HUAÑEC','15',133,1,0,NULL,NULL),
 (1376,'LARAOS','16',133,1,0,NULL,NULL),
 (1377,'LINCHA','17',133,1,0,NULL,NULL),
 (1378,'MIRAFLORES','18',133,1,0,NULL,NULL),
 (1379,'OMAS','19',133,1,0,NULL,NULL),
 (1380,'QUINCHES','20',133,1,0,NULL,NULL),
 (1381,'QUINOCAY','21',133,1,0,NULL,NULL),
 (1382,'SAN JOAQUIN','22',133,1,0,NULL,NULL),
 (1383,'SAN PEDRO DE PILAS','23',133,1,0,NULL,NULL),
 (1384,'TANTA','24',133,1,0,NULL,NULL),
 (1385,'TAURIPAMPA','25',133,1,0,NULL,NULL),
 (1386,'TUPE','26',133,1,0,NULL,NULL),
 (1387,'TOMAS','27',133,1,0,NULL,NULL),
 (1388,'VIÑAC','28',133,1,0,NULL,NULL),
 (1389,'VITIS','29',133,1,0,NULL,NULL),
 (1390,'HONGOS','30',133,1,0,NULL,NULL),
 (1391,'MADEAN','31',133,1,0,NULL,NULL),
 (1392,'PUTINZA','32',133,1,0,NULL,NULL),
 (1393,'CATAHUASI','33',133,1,0,NULL,NULL),
 (1394,'HUARAL','01',134,1,0,NULL,NULL),
 (1395,'ATAVILLOS ALTO','02',134,1,0,NULL,NULL),
 (1396,'ATAVILLOS BAJO','03',134,1,0,NULL,NULL),
 (1397,'AUCALLAMA','04',134,1,0,NULL,NULL),
 (1398,'CHANCAY','05',134,1,0,NULL,NULL),
 (1399,'IHUARI','06',134,1,0,NULL,NULL),
 (1400,'LAMPIAN','07',134,1,0,NULL,NULL),
 (1401,'PACARAOS','08',134,1,0,NULL,NULL),
 (1402,'SAN MIGUEL DE ACOS','09',134,1,0,NULL,NULL),
 (1403,'VEINTISIETE DE NOVIEMBRE','10',134,1,0,NULL,NULL),
 (1404,'SANTA CRUZ DE ANDAMARCA','11',134,1,0,NULL,NULL),
 (1405,'SUMBILCA','12',134,1,0,NULL,NULL),
 (1406,'BARRANCA','01',135,1,0,NULL,NULL),
 (1407,'PARAMONGA','02',135,1,0,NULL,NULL),
 (1408,'PATIVILCA','03',135,1,0,NULL,NULL),
 (1409,'SUPE','04',135,1,0,NULL,NULL),
 (1410,'SUPE PUERTO','05',135,1,0,NULL,NULL),
 (1411,'OYON','01',136,1,0,NULL,NULL),
 (1412,'NAVAN','02',136,1,0,NULL,NULL),
 (1413,'CAUJUL','03',136,1,0,NULL,NULL),
 (1414,'ANDAJES','04',136,1,0,NULL,NULL),
 (1415,'PACHANGARA','05',136,1,0,NULL,NULL),
 (1416,'COCHAMARCA','06',136,1,0,NULL,NULL),
 (1417,'IQUITOS','01',137,1,0,NULL,NULL),
 (1418,'ALTO NANAY','02',137,1,0,NULL,NULL),
 (1419,'FERNANDO LORES','03',137,1,0,NULL,NULL),
 (1420,'LAS AMAZONAS','04',137,1,0,NULL,NULL),
 (1421,'MAZAN','05',137,1,0,NULL,NULL),
 (1422,'NAPO','06',137,1,0,NULL,NULL),
 (1423,'PUTUMAYO','07',137,1,0,NULL,NULL),
 (1424,'TORRES CAUSANA','08',137,1,0,NULL,NULL),
 (1425,'INDIANA','10',137,1,0,NULL,NULL),
 (1426,'PUNCHANA','11',137,1,0,NULL,NULL),
 (1427,'BELEN','12',137,1,0,NULL,NULL),
 (1428,'SAN JUAN BAUTISTA','13',137,1,0,NULL,NULL),
 (1429,'TENIENTE MANUEL CLAVERO','14',137,1,0,NULL,NULL),
 (1430,'YURIMAGUAS','01',138,1,0,NULL,NULL),
 (1431,'BALSAPUERTO','02',138,1,0,NULL,NULL),
 (1432,'JEBEROS','05',138,1,0,NULL,NULL),
 (1433,'LAGUNAS','06',138,1,0,NULL,NULL),
 (1434,'SANTA CRUZ','10',138,1,0,NULL,NULL),
 (1435,'TENIENTE CESAR LOPEZ ROJAS','11',138,1,0,NULL,NULL),
 (1436,'NAUTA','01',139,1,0,NULL,NULL),
 (1437,'PARINARI','02',139,1,0,NULL,NULL),
 (1438,'TIGRE','03',139,1,0,NULL,NULL),
 (1439,'URARINAS','04',139,1,0,NULL,NULL),
 (1440,'TROMPETEROS','05',139,1,0,NULL,NULL),
 (1441,'REQUENA','01',140,1,0,NULL,NULL),
 (1442,'ALTO TAPICHE','02',140,1,0,NULL,NULL),
 (1443,'CAPELO','03',140,1,0,NULL,NULL),
 (1444,'EMILIO SAN MARTIN','04',140,1,0,NULL,NULL),
 (1445,'MAQUIA','05',140,1,0,NULL,NULL),
 (1446,'PUINAHUA','06',140,1,0,NULL,NULL),
 (1447,'SAQUENA','07',140,1,0,NULL,NULL),
 (1448,'SOPLIN','08',140,1,0,NULL,NULL),
 (1449,'TAPICHE','09',140,1,0,NULL,NULL),
 (1450,'JENARO HERRERA','10',140,1,0,NULL,NULL),
 (1451,'YAQUERANA','11',140,1,0,NULL,NULL),
 (1452,'CONTAMANA','01',141,1,0,NULL,NULL),
 (1453,'VARGAS GUERRA','02',141,1,0,NULL,NULL),
 (1454,'PADRE MARQUEZ','03',141,1,0,NULL,NULL),
 (1455,'PAMPA HERMOSA','04',141,1,0,NULL,NULL),
 (1456,'SARAYACU','05',141,1,0,NULL,NULL),
 (1457,'INAHUAYA','06',141,1,0,NULL,NULL),
 (1458,'RAMON CASTILLA','01',142,1,0,NULL,NULL),
 (1459,'PEBAS','02',142,1,0,NULL,NULL),
 (1460,'YAVARI','03',142,1,0,NULL,NULL),
 (1461,'SAN PABLO','04',142,1,0,NULL,NULL),
 (1462,'BARRANCA','01',143,1,0,NULL,NULL),
 (1463,'ANDOAS','02',143,1,0,NULL,NULL),
 (1464,'CAHUAPANAS','03',143,1,0,NULL,NULL),
 (1465,'MANSERICHE','04',143,1,0,NULL,NULL),
 (1466,'MORONA','05',143,1,0,NULL,NULL),
 (1467,'PASTAZA','06',143,1,0,NULL,NULL),
 (1468,'TAMBOPATA','01',144,1,0,NULL,NULL),
 (1469,'INAMBARI','02',144,1,0,NULL,NULL),
 (1470,'LAS PIEDRAS','03',144,1,0,NULL,NULL),
 (1471,'LABERINTO','04',144,1,0,NULL,NULL),
 (1472,'MANU','01',145,1,0,NULL,NULL),
 (1473,'FITZCARRALD','02',145,1,0,NULL,NULL),
 (1474,'MADRE DE DIOS','03',145,1,0,NULL,NULL),
 (1475,'HUEPETUHE','04',145,1,0,NULL,NULL),
 (1476,'IÑAPARI','01',146,1,0,NULL,NULL),
 (1477,'IBERIA','02',146,1,0,NULL,NULL),
 (1478,'TAHUAMANU','03',146,1,0,NULL,NULL),
 (1479,'MOQUEGUA','01',147,1,0,NULL,NULL),
 (1480,'CARUMAS','02',147,1,0,NULL,NULL),
 (1481,'CUCHUMBAYA','03',147,1,0,NULL,NULL),
 (1482,'SAN CRISTOBAL','04',147,1,0,NULL,NULL),
 (1483,'TORATA','05',147,1,0,NULL,NULL),
 (1484,'SAMEGUA','06',147,1,0,NULL,NULL),
 (1485,'OMATE','01',148,1,0,NULL,NULL),
 (1486,'COALAQUE','02',148,1,0,NULL,NULL),
 (1487,'CHOJATA','03',148,1,0,NULL,NULL),
 (1488,'ICHUÑA','04',148,1,0,NULL,NULL),
 (1489,'LA CAPILLA','05',148,1,0,NULL,NULL),
 (1490,'LLOQUE','06',148,1,0,NULL,NULL),
 (1491,'MATALAQUE','07',148,1,0,NULL,NULL),
 (1492,'PUQUINA','08',148,1,0,NULL,NULL),
 (1493,'QUINISTAQUILLAS','09',148,1,0,NULL,NULL),
 (1494,'UBINAS','10',148,1,0,NULL,NULL),
 (1495,'YUNGA','11',148,1,0,NULL,NULL);
INSERT INTO `distritos` (`id`,`nombre`,`codigo`,`provincia_id`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1496,'ILO','01',149,1,0,NULL,NULL),
 (1497,'EL ALGARROBAL','02',149,1,0,NULL,NULL),
 (1498,'PACOCHA','03',149,1,0,NULL,NULL),
 (1499,'CHAUPIMARCA','01',150,1,0,NULL,NULL),
 (1500,'HUACHON','03',150,1,0,NULL,NULL),
 (1501,'HUARIACA','04',150,1,0,NULL,NULL),
 (1502,'HUAYLLAY','05',150,1,0,NULL,NULL),
 (1503,'NINACACA','06',150,1,0,NULL,NULL),
 (1504,'PALLANCHACRA','07',150,1,0,NULL,NULL),
 (1505,'PAUCARTAMBO','08',150,1,0,NULL,NULL),
 (1506,'SAN FCO DE ASIS DE YARUSYACAN','09',150,1,0,NULL,NULL),
 (1507,'SIMON BOLIVAR','10',150,1,0,NULL,NULL),
 (1508,'TICLACAYAN','11',150,1,0,NULL,NULL),
 (1509,'TINYAHUARCO','12',150,1,0,NULL,NULL),
 (1510,'VICCO','13',150,1,0,NULL,NULL),
 (1511,'YANACANCHA','14',150,1,0,NULL,NULL),
 (1512,'YANAHUANCA','01',151,1,0,NULL,NULL),
 (1513,'CHACAYAN','02',151,1,0,NULL,NULL),
 (1514,'GOYLLARISQUIZGA','03',151,1,0,NULL,NULL),
 (1515,'PAUCAR','04',151,1,0,NULL,NULL),
 (1516,'SAN PEDRO DE PILLAO','05',151,1,0,NULL,NULL),
 (1517,'SANTA ANA DE TUSI','06',151,1,0,NULL,NULL),
 (1518,'TAPUC','07',151,1,0,NULL,NULL),
 (1519,'VILCABAMBA','08',151,1,0,NULL,NULL),
 (1520,'OXAPAMPA','01',152,1,0,NULL,NULL),
 (1521,'CHONTABAMBA','02',152,1,0,NULL,NULL),
 (1522,'HUANCABAMBA','03',152,1,0,NULL,NULL),
 (1523,'PUERTO BERMUDEZ','04',152,1,0,NULL,NULL),
 (1524,'VILLA RICA','05',152,1,0,NULL,NULL),
 (1525,'POZUZO','06',152,1,0,NULL,NULL),
 (1526,'PALCAZU','07',152,1,0,NULL,NULL),
 (1527,'CONSTITUCION','08',152,1,0,NULL,NULL),
 (1528,'PIURA','01',153,1,0,NULL,NULL),
 (1529,'CASTILLA','03',153,1,0,NULL,NULL),
 (1530,'CATACAOS','04',153,1,0,NULL,NULL),
 (1531,'LA ARENA','05',153,1,0,NULL,NULL),
 (1532,'LA UNION','06',153,1,0,NULL,NULL),
 (1533,'LAS LOMAS','07',153,1,0,NULL,NULL),
 (1534,'TAMBO GRANDE','09',153,1,0,NULL,NULL),
 (1535,'CURA MORI','13',153,1,0,NULL,NULL),
 (1536,'EL TALLAN','14',153,1,0,NULL,NULL),
 (1537,'VEINTISEIS DE OCTUBRE','15',153,1,0,NULL,NULL),
 (1538,'AYABACA','01',154,1,0,NULL,NULL),
 (1539,'FRIAS','02',154,1,0,NULL,NULL),
 (1540,'LAGUNAS','03',154,1,0,NULL,NULL),
 (1541,'MONTERO','04',154,1,0,NULL,NULL),
 (1542,'PACAIPAMPA','05',154,1,0,NULL,NULL),
 (1543,'SAPILLICA','06',154,1,0,NULL,NULL),
 (1544,'SICCHEZ','07',154,1,0,NULL,NULL),
 (1545,'SUYO','08',154,1,0,NULL,NULL),
 (1546,'JILILI','09',154,1,0,NULL,NULL),
 (1547,'PAIMAS','10',154,1,0,NULL,NULL),
 (1548,'HUANCABAMBA','01',155,1,0,NULL,NULL),
 (1549,'CANCHAQUE','02',155,1,0,NULL,NULL),
 (1550,'HUARMACA','03',155,1,0,NULL,NULL),
 (1551,'SONDOR','04',155,1,0,NULL,NULL),
 (1552,'SONDORILLO','05',155,1,0,NULL,NULL),
 (1553,'EL CARMEN DE LA FRONTERA','06',155,1,0,NULL,NULL),
 (1554,'SAN MIGUEL DE EL FAIQUE','07',155,1,0,NULL,NULL),
 (1555,'LALAQUIZ','08',155,1,0,NULL,NULL),
 (1556,'CHULUCANAS','01',156,1,0,NULL,NULL),
 (1557,'BUENOS AIRES','02',156,1,0,NULL,NULL),
 (1558,'CHALACO','03',156,1,0,NULL,NULL),
 (1559,'MORROPON','04',156,1,0,NULL,NULL),
 (1560,'SALITRAL','05',156,1,0,NULL,NULL),
 (1561,'SANTA CATALINA DE MOSSA','06',156,1,0,NULL,NULL),
 (1562,'SANTO DOMINGO','07',156,1,0,NULL,NULL),
 (1563,'LA MATANZA','08',156,1,0,NULL,NULL),
 (1564,'YAMANGO','09',156,1,0,NULL,NULL),
 (1565,'SAN JUAN DE BIGOTE','10',156,1,0,NULL,NULL),
 (1566,'PAITA','01',157,1,0,NULL,NULL),
 (1567,'AMOTAPE','02',157,1,0,NULL,NULL),
 (1568,'ARENAL','03',157,1,0,NULL,NULL),
 (1569,'LA HUACA','04',157,1,0,NULL,NULL),
 (1570,'COLAN','05',157,1,0,NULL,NULL),
 (1571,'TAMARINDO','06',157,1,0,NULL,NULL),
 (1572,'VICHAYAL','07',157,1,0,NULL,NULL),
 (1573,'SULLANA','01',158,1,0,NULL,NULL),
 (1574,'BELLAVISTA','02',158,1,0,NULL,NULL),
 (1575,'LANCONES','03',158,1,0,NULL,NULL),
 (1576,'MARCAVELICA','04',158,1,0,NULL,NULL),
 (1577,'MIGUEL CHECA','05',158,1,0,NULL,NULL),
 (1578,'QUERECOTILLO','06',158,1,0,NULL,NULL),
 (1579,'SALITRAL','07',158,1,0,NULL,NULL),
 (1580,'IGNACIO ESCUDERO','08',158,1,0,NULL,NULL),
 (1581,'PARIÑAS','01',159,1,0,NULL,NULL),
 (1582,'EL ALTO','02',159,1,0,NULL,NULL),
 (1583,'LA BREA','03',159,1,0,NULL,NULL),
 (1584,'LOBITOS','04',159,1,0,NULL,NULL),
 (1585,'MANCORA','05',159,1,0,NULL,NULL),
 (1586,'LOS ORGANOS','06',159,1,0,NULL,NULL),
 (1587,'SECHURA','01',160,1,0,NULL,NULL),
 (1588,'VICE','02',160,1,0,NULL,NULL),
 (1589,'BERNAL','03',160,1,0,NULL,NULL),
 (1590,'BELLAVISTA DE LA UNION','04',160,1,0,NULL,NULL),
 (1591,'CRISTO NOS VALGA','05',160,1,0,NULL,NULL),
 (1592,'RINCONADA-LLICUAR','06',160,1,0,NULL,NULL),
 (1593,'PUNO','01',161,1,0,NULL,NULL),
 (1594,'ACORA','02',161,1,0,NULL,NULL),
 (1595,'ATUNCOLLA','03',161,1,0,NULL,NULL),
 (1596,'CAPACHICA','04',161,1,0,NULL,NULL),
 (1597,'COATA','05',161,1,0,NULL,NULL),
 (1598,'CHUCUITO','06',161,1,0,NULL,NULL),
 (1599,'HUATA','07',161,1,0,NULL,NULL),
 (1600,'MAÑAZO','08',161,1,0,NULL,NULL),
 (1601,'PAUCARCOLLA','09',161,1,0,NULL,NULL),
 (1602,'PICHACANI','10',161,1,0,NULL,NULL),
 (1603,'SAN ANTONIO','11',161,1,0,NULL,NULL),
 (1604,'TIQUILLACA','12',161,1,0,NULL,NULL),
 (1605,'VILQUE','13',161,1,0,NULL,NULL),
 (1606,'PLATERIA','14',161,1,0,NULL,NULL),
 (1607,'AMANTANI','15',161,1,0,NULL,NULL),
 (1608,'AZANGARO','01',162,1,0,NULL,NULL),
 (1609,'ACHAYA','02',162,1,0,NULL,NULL),
 (1610,'ARAPA','03',162,1,0,NULL,NULL),
 (1611,'ASILLO','04',162,1,0,NULL,NULL),
 (1612,'CAMINACA','05',162,1,0,NULL,NULL),
 (1613,'CHUPA','06',162,1,0,NULL,NULL),
 (1614,'JOSE DOMINGO CHOQUEHUANCA','07',162,1,0,NULL,NULL),
 (1615,'MUÑANI','08',162,1,0,NULL,NULL),
 (1616,'POTONI','10',162,1,0,NULL,NULL),
 (1617,'SAMAN','12',162,1,0,NULL,NULL),
 (1618,'SAN ANTON','13',162,1,0,NULL,NULL),
 (1619,'SAN JOSE','14',162,1,0,NULL,NULL),
 (1620,'SAN JUAN DE SALINAS','15',162,1,0,NULL,NULL),
 (1621,'SANTIAGO DE PUPUJA','16',162,1,0,NULL,NULL),
 (1622,'TIRAPATA','17',162,1,0,NULL,NULL),
 (1623,'MACUSANI','01',163,1,0,NULL,NULL),
 (1624,'AJOYANI','02',163,1,0,NULL,NULL),
 (1625,'AYAPATA','03',163,1,0,NULL,NULL),
 (1626,'COASA','04',163,1,0,NULL,NULL),
 (1627,'CORANI','05',163,1,0,NULL,NULL),
 (1628,'CRUCERO','06',163,1,0,NULL,NULL),
 (1629,'ITUATA','07',163,1,0,NULL,NULL),
 (1630,'OLLACHEA','08',163,1,0,NULL,NULL),
 (1631,'SAN GABAN','09',163,1,0,NULL,NULL),
 (1632,'USICAYOS','10',163,1,0,NULL,NULL),
 (1633,'JULI','01',164,1,0,NULL,NULL),
 (1634,'DESAGUADERO','02',164,1,0,NULL,NULL),
 (1635,'HUACULLANI','03',164,1,0,NULL,NULL),
 (1636,'PISACOMA','06',164,1,0,NULL,NULL),
 (1637,'POMATA','07',164,1,0,NULL,NULL),
 (1638,'ZEPITA','10',164,1,0,NULL,NULL),
 (1639,'KELLUYO','12',164,1,0,NULL,NULL),
 (1640,'HUANCANE','01',165,1,0,NULL,NULL),
 (1641,'COJATA','02',165,1,0,NULL,NULL),
 (1642,'INCHUPALLA','04',165,1,0,NULL,NULL),
 (1643,'PUSI','06',165,1,0,NULL,NULL),
 (1644,'ROSASPATA','07',165,1,0,NULL,NULL),
 (1645,'TARACO','08',165,1,0,NULL,NULL),
 (1646,'VILQUE CHICO','09',165,1,0,NULL,NULL),
 (1647,'HUATASANI','11',165,1,0,NULL,NULL),
 (1648,'LAMPA','01',166,1,0,NULL,NULL),
 (1649,'CABANILLA','02',166,1,0,NULL,NULL),
 (1650,'CALAPUJA','03',166,1,0,NULL,NULL),
 (1651,'NICASIO','04',166,1,0,NULL,NULL),
 (1652,'OCUVIRI','05',166,1,0,NULL,NULL),
 (1653,'PALCA','06',166,1,0,NULL,NULL),
 (1654,'PARATIA','07',166,1,0,NULL,NULL),
 (1655,'PUCARA','08',166,1,0,NULL,NULL),
 (1656,'SANTA LUCIA','09',166,1,0,NULL,NULL),
 (1657,'VILAVILA','10',166,1,0,NULL,NULL),
 (1658,'AYAVIRI','01',167,1,0,NULL,NULL),
 (1659,'ANTAUTA','02',167,1,0,NULL,NULL),
 (1660,'CUPI','03',167,1,0,NULL,NULL),
 (1661,'LLALLI','04',167,1,0,NULL,NULL),
 (1662,'MACARI','05',167,1,0,NULL,NULL),
 (1663,'NUÑOA','06',167,1,0,NULL,NULL),
 (1664,'ORURILLO','07',167,1,0,NULL,NULL),
 (1665,'SANTA ROSA','08',167,1,0,NULL,NULL),
 (1666,'UMACHIRI','09',167,1,0,NULL,NULL),
 (1667,'SANDIA','01',168,1,0,NULL,NULL),
 (1668,'CUYOCUYO','03',168,1,0,NULL,NULL),
 (1669,'LIMBANI','04',168,1,0,NULL,NULL),
 (1670,'PHARA','05',168,1,0,NULL,NULL),
 (1671,'PATAMBUCO','06',168,1,0,NULL,NULL),
 (1672,'QUIACA','07',168,1,0,NULL,NULL),
 (1673,'SAN JUAN DEL ORO','08',168,1,0,NULL,NULL),
 (1674,'YANAHUAYA','10',168,1,0,NULL,NULL),
 (1675,'ALTO INAMBARI','11',168,1,0,NULL,NULL),
 (1676,'SAN PEDRO DE PUTINA PUNCO','12',168,1,0,NULL,NULL),
 (1677,'JULIACA','01',169,1,0,NULL,NULL),
 (1678,'CABANA','02',169,1,0,NULL,NULL),
 (1679,'CABANILLAS','03',169,1,0,NULL,NULL),
 (1680,'CARACOTO','04',169,1,0,NULL,NULL),
 (1681,'YUNGUYO','01',170,1,0,NULL,NULL),
 (1682,'UNICACHI','02',170,1,0,NULL,NULL),
 (1683,'ANAPIA','03',170,1,0,NULL,NULL),
 (1684,'COPANI','04',170,1,0,NULL,NULL),
 (1685,'CUTURAPI','05',170,1,0,NULL,NULL),
 (1686,'OLLARAYA','06',170,1,0,NULL,NULL),
 (1687,'TINICACHI','07',170,1,0,NULL,NULL),
 (1688,'PUTINA','01',171,1,0,NULL,NULL),
 (1689,'PEDRO VILCA APAZA','02',171,1,0,NULL,NULL),
 (1690,'QUILCAPUNCU','03',171,1,0,NULL,NULL),
 (1691,'ANANEA','04',171,1,0,NULL,NULL),
 (1692,'SINA','05',171,1,0,NULL,NULL),
 (1693,'ILAVE','01',172,1,0,NULL,NULL),
 (1694,'PILCUYO','02',172,1,0,NULL,NULL),
 (1695,'SANTA ROSA','03',172,1,0,NULL,NULL),
 (1696,'CAPAZO','04',172,1,0,NULL,NULL),
 (1697,'CONDURIRI','05',172,1,0,NULL,NULL),
 (1698,'MOHO','01',173,1,0,NULL,NULL),
 (1699,'CONIMA','02',173,1,0,NULL,NULL),
 (1700,'TILALI','03',173,1,0,NULL,NULL),
 (1701,'HUAYRAPATA','04',173,1,0,NULL,NULL),
 (1702,'MOYOBAMBA','01',174,1,0,NULL,NULL),
 (1703,'CALZADA','02',174,1,0,NULL,NULL),
 (1704,'HABANA','03',174,1,0,NULL,NULL),
 (1705,'JEPELACIO','04',174,1,0,NULL,NULL),
 (1706,'SORITOR','05',174,1,0,NULL,NULL),
 (1707,'YANTALO','06',174,1,0,NULL,NULL),
 (1708,'SAPOSOA','01',175,1,0,NULL,NULL),
 (1709,'PISCOYACU','02',175,1,0,NULL,NULL),
 (1710,'SACANCHE','03',175,1,0,NULL,NULL),
 (1711,'TINGO DE SAPOSOA','04',175,1,0,NULL,NULL),
 (1712,'ALTO SAPOSOA','05',175,1,0,NULL,NULL),
 (1713,'EL ESLABON','06',175,1,0,NULL,NULL),
 (1714,'LAMAS','01',176,1,0,NULL,NULL),
 (1715,'BARRANQUITA','03',176,1,0,NULL,NULL),
 (1716,'CAYNARACHI','04',176,1,0,NULL,NULL),
 (1717,'CUÑUMBUQUI','05',176,1,0,NULL,NULL),
 (1718,'PINTO RECODO','06',176,1,0,NULL,NULL),
 (1719,'RUMISAPA','07',176,1,0,NULL,NULL),
 (1720,'SHANAO','11',176,1,0,NULL,NULL),
 (1721,'TABALOSOS','13',176,1,0,NULL,NULL),
 (1722,'ZAPATERO','14',176,1,0,NULL,NULL),
 (1723,'ALONSO DE ALVARADO','15',176,1,0,NULL,NULL),
 (1724,'SAN ROQUE DE CUMBAZA','16',176,1,0,NULL,NULL),
 (1725,'JUANJUI','01',177,1,0,NULL,NULL),
 (1726,'CAMPANILLA','02',177,1,0,NULL,NULL),
 (1727,'HUICUNGO','03',177,1,0,NULL,NULL),
 (1728,'PACHIZA','04',177,1,0,NULL,NULL),
 (1729,'PAJARILLO','05',177,1,0,NULL,NULL),
 (1730,'RIOJA','01',178,1,0,NULL,NULL),
 (1731,'POSIC','02',178,1,0,NULL,NULL),
 (1732,'YORONGOS','03',178,1,0,NULL,NULL),
 (1733,'YURACYACU','04',178,1,0,NULL,NULL),
 (1734,'NUEVA CAJAMARCA','05',178,1,0,NULL,NULL),
 (1735,'ELIAS SOPLIN VARGAS','06',178,1,0,NULL,NULL),
 (1736,'SAN FERNANDO','07',178,1,0,NULL,NULL),
 (1737,'PARDO MIGUEL','08',178,1,0,NULL,NULL),
 (1738,'AWAJUN','09',178,1,0,NULL,NULL),
 (1739,'TARAPOTO','01',179,1,0,NULL,NULL),
 (1740,'ALBERTO LEVEAU','02',179,1,0,NULL,NULL),
 (1741,'CACATACHI','04',179,1,0,NULL,NULL),
 (1742,'CHAZUTA','06',179,1,0,NULL,NULL),
 (1743,'CHIPURANA','07',179,1,0,NULL,NULL),
 (1744,'EL PORVENIR','08',179,1,0,NULL,NULL),
 (1745,'HUIMBAYOC','09',179,1,0,NULL,NULL),
 (1746,'JUAN GUERRA','10',179,1,0,NULL,NULL),
 (1747,'MORALES','11',179,1,0,NULL,NULL),
 (1748,'PAPAPLAYA','12',179,1,0,NULL,NULL),
 (1749,'SAN ANTONIO','16',179,1,0,NULL,NULL),
 (1750,'SAUCE','19',179,1,0,NULL,NULL),
 (1751,'SHAPAJA','20',179,1,0,NULL,NULL),
 (1752,'LA BANDA DE SHILCAYO','21',179,1,0,NULL,NULL),
 (1753,'BELLAVISTA','01',180,1,0,NULL,NULL),
 (1754,'SAN RAFAEL','02',180,1,0,NULL,NULL),
 (1755,'SAN PABLO','03',180,1,0,NULL,NULL),
 (1756,'ALTO BIAVO','04',180,1,0,NULL,NULL),
 (1757,'HUALLAGA','05',180,1,0,NULL,NULL),
 (1758,'BAJO BIAVO','06',180,1,0,NULL,NULL),
 (1759,'TOCACHE','01',181,1,0,NULL,NULL),
 (1760,'NUEVO PROGRESO','02',181,1,0,NULL,NULL),
 (1761,'POLVORA','03',181,1,0,NULL,NULL),
 (1762,'SHUNTE','04',181,1,0,NULL,NULL),
 (1763,'UCHIZA','05',181,1,0,NULL,NULL),
 (1764,'PICOTA','01',182,1,0,NULL,NULL),
 (1765,'BUENOS AIRES','02',182,1,0,NULL,NULL),
 (1766,'CASPIZAPA','03',182,1,0,NULL,NULL),
 (1767,'PILLUANA','04',182,1,0,NULL,NULL),
 (1768,'PUCACACA','05',182,1,0,NULL,NULL),
 (1769,'SAN CRISTOBAL','06',182,1,0,NULL,NULL),
 (1770,'SAN HILARION','07',182,1,0,NULL,NULL),
 (1771,'TINGO DE PONASA','08',182,1,0,NULL,NULL),
 (1772,'TRES UNIDOS','09',182,1,0,NULL,NULL),
 (1773,'SHAMBOYACU','10',182,1,0,NULL,NULL),
 (1774,'SAN JOSE DE SISA','01',183,1,0,NULL,NULL),
 (1775,'AGUA BLANCA','02',183,1,0,NULL,NULL),
 (1776,'SHATOJA','03',183,1,0,NULL,NULL),
 (1777,'SAN MARTIN','04',183,1,0,NULL,NULL),
 (1778,'SANTA ROSA','05',183,1,0,NULL,NULL),
 (1779,'TACNA','01',184,1,0,NULL,NULL),
 (1780,'CALANA','02',184,1,0,NULL,NULL),
 (1781,'INCLAN','04',184,1,0,NULL,NULL),
 (1782,'PACHIA','07',184,1,0,NULL,NULL),
 (1783,'PALCA','08',184,1,0,NULL,NULL),
 (1784,'POCOLLAY','09',184,1,0,NULL,NULL),
 (1785,'SAMA','10',184,1,0,NULL,NULL),
 (1786,'ALTO DE LA ALIANZA','11',184,1,0,NULL,NULL),
 (1787,'CIUDAD NUEVA','12',184,1,0,NULL,NULL),
 (1788,'CORONEL GREGORIO ALBARRACIN L.','13',184,1,0,NULL,NULL),
 (1789,'TARATA','01',185,1,0,NULL,NULL),
 (1790,'HEROES ALBARRACIN','05',185,1,0,NULL,NULL),
 (1791,'ESTIQUE','06',185,1,0,NULL,NULL),
 (1792,'ESTIQUE PAMPA','07',185,1,0,NULL,NULL),
 (1793,'SITAJARA','10',185,1,0,NULL,NULL),
 (1794,'SUSAPAYA','11',185,1,0,NULL,NULL),
 (1795,'TARUCACHI','12',185,1,0,NULL,NULL),
 (1796,'TICACO','13',185,1,0,NULL,NULL),
 (1797,'LOCUMBA','01',186,1,0,NULL,NULL),
 (1798,'ITE','02',186,1,0,NULL,NULL),
 (1799,'ILABAYA','03',186,1,0,NULL,NULL),
 (1800,'CANDARAVE','01',187,1,0,NULL,NULL),
 (1801,'CAIRANI','02',187,1,0,NULL,NULL),
 (1802,'CURIBAYA','03',187,1,0,NULL,NULL),
 (1803,'HUANUARA','04',187,1,0,NULL,NULL),
 (1804,'QUILAHUANI','05',187,1,0,NULL,NULL),
 (1805,'CAMILACA','06',187,1,0,NULL,NULL),
 (1806,'TUMBES','01',188,1,0,NULL,NULL),
 (1807,'CORRALES','02',188,1,0,NULL,NULL),
 (1808,'LA CRUZ','03',188,1,0,NULL,NULL),
 (1809,'PAMPAS DE HOSPITAL','04',188,1,0,NULL,NULL),
 (1810,'SAN JACINTO','05',188,1,0,NULL,NULL),
 (1811,'SAN JUAN DE LA VIRGEN','06',188,1,0,NULL,NULL),
 (1812,'ZORRITOS','01',189,1,0,NULL,NULL),
 (1813,'CASITAS','02',189,1,0,NULL,NULL),
 (1814,'CANOAS DE PUNTA SAL','03',189,1,0,NULL,NULL),
 (1815,'ZARUMILLA','01',190,1,0,NULL,NULL),
 (1816,'MATAPALO','02',190,1,0,NULL,NULL),
 (1817,'PAPAYAL','03',190,1,0,NULL,NULL),
 (1818,'AGUAS VERDES','04',190,1,0,NULL,NULL),
 (1819,'CALLAO','01',191,1,0,NULL,NULL),
 (1820,'BELLAVISTA','02',191,1,0,NULL,NULL),
 (1821,'LA PUNTA','03',191,1,0,NULL,NULL),
 (1822,'CARMEN DE LA LEGUA-REYNOSO','04',191,1,0,NULL,NULL),
 (1823,'LA PERLA','05',191,1,0,NULL,NULL),
 (1824,'VENTANILLA','06',191,1,0,NULL,NULL),
 (1825,'CALLERIA','01',192,1,0,NULL,NULL),
 (1826,'YARINACOCHA','02',192,1,0,NULL,NULL),
 (1827,'MASISEA','03',192,1,0,NULL,NULL),
 (1828,'CAMPOVERDE','04',192,1,0,NULL,NULL),
 (1829,'IPARIA','05',192,1,0,NULL,NULL),
 (1830,'NUEVA REQUENA','06',192,1,0,NULL,NULL),
 (1831,'MANANTAY','07',192,1,0,NULL,NULL),
 (1832,'PADRE ABAD','01',193,1,0,NULL,NULL),
 (1833,'IRAZOLA','02',193,1,0,NULL,NULL),
 (1834,'CURIMANA','03',193,1,0,NULL,NULL),
 (1835,'RAIMONDI','01',194,1,0,NULL,NULL),
 (1836,'TAHUANIA','02',194,1,0,NULL,NULL),
 (1837,'YURUA','03',194,1,0,NULL,NULL),
 (1838,'SEPAHUA','04',194,1,0,NULL,NULL),
 (1839,'PURUS','01',195,1,0,NULL,NULL),
 (1840,'MI PERU','07',191,1,0,NULL,NULL),
 (1841,'COMPIN','05',122,1,0,NULL,NULL),
 (1842,'GAMARRA','15',33,1,0,NULL,NULL),
 (1843,'CANAYRE','10',45,1,0,NULL,NULL),
 (1844,'UCHURACCAY','10',45,1,0,NULL,NULL),
 (1845,'SAN PEDRO DE CASTA','33',132,1,0,NULL,NULL),
 (1846,'ANCHIHUAY','10',46,1,0,NULL,NULL);
/*!40000 ALTER TABLE `distritos` ENABLE KEYS */;


--
-- Definition of table `docentes`
--

DROP TABLE IF EXISTS `docentes`;
CREATE TABLE `docentes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personalacademico` varchar(200) DEFAULT NULL,
  `cargogeneral` varchar(200) DEFAULT NULL,
  `descripcioncargo` text,
  `maximogrado` varchar(50) DEFAULT NULL,
  `descmaximogrado` varchar(500) DEFAULT NULL,
  `universidadgrado` varchar(500) DEFAULT NULL,
  `lugarmaximogrado` varchar(500) DEFAULT NULL,
  `paismaximogrado` varchar(500) DEFAULT NULL,
  `otrogrado` varchar(500) DEFAULT NULL,
  `estadootrogrado` varchar(500) DEFAULT NULL,
  `univotrogrado` varchar(500) DEFAULT NULL,
  `lugarotrogrado` varchar(500) DEFAULT NULL,
  `paisotrogrado` varchar(500) DEFAULT NULL,
  `titulo` varchar(50) DEFAULT NULL,
  `descripciontitulo` varchar(500) DEFAULT NULL,
  `condicion` varchar(500) DEFAULT NULL,
  `categoria` varchar(500) DEFAULT NULL,
  `regimen` varchar(500) DEFAULT NULL,
  `investigador` tinyint(4) DEFAULT NULL,
  `pregrado` tinyint(4) DEFAULT NULL,
  `postgrado` tinyint(4) DEFAULT NULL,
  `esdestacado` tinyint(4) DEFAULT NULL,
  `fechaingreso` date DEFAULT NULL,
  `modalidadingreso` varchar(200) DEFAULT NULL,
  `observaciones` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `persona_id` int(11) NOT NULL,
  `horaslectivas` int(11) DEFAULT NULL,
  `horasnolectivas` int(11) DEFAULT NULL,
  `horasinvestigacion` int(11) DEFAULT NULL,
  `horasdedicacion` int(11) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `facultad_id` int(11) DEFAULT NULL,
  `dependencia` varchar(600) DEFAULT NULL,
  `semestre_id` int(11) NOT NULL,
  `email` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_docentes_personas1_idx` (`persona_id`),
  KEY `fk_docentes_semestres1_idx` (`semestre_id`),
  CONSTRAINT `fk_docentes_personas1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_docentes_semestres1` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `docentes`
--

/*!40000 ALTER TABLE `docentes` DISABLE KEYS */;
INSERT INTO `docentes` (`id`,`personalacademico`,`cargogeneral`,`descripcioncargo`,`maximogrado`,`descmaximogrado`,`universidadgrado`,`lugarmaximogrado`,`paismaximogrado`,`otrogrado`,`estadootrogrado`,`univotrogrado`,`lugarotrogrado`,`paisotrogrado`,`titulo`,`descripciontitulo`,`condicion`,`categoria`,`regimen`,`investigador`,`pregrado`,`postgrado`,`esdestacado`,`fechaingreso`,`modalidadingreso`,`observaciones`,`activo`,`borrado`,`created_at`,`updated_at`,`persona_id`,`horaslectivas`,`horasnolectivas`,`horasinvestigacion`,`horasdedicacion`,`escuela_id`,`facultad_id`,`dependencia`,`semestre_id`,`email`) VALUES 
 (2,'Docente','Vicerrector de Investigación','vicerrector descrito','Maestro','Ciencias de Informatica','UNASAM','Internacional','Suiza','Ing. Agrónoma','Si','Merida UAN','Internacional','Francia','Si','Ing. Industrial','Nombrado','Asociado','Tiempo parcial',1,1,0,1,'1965-09-08','Examen de Ingreso','Obs',1,0,'2019-09-08 00:01:45','2019-09-08 00:01:45',10,13,14,6,8,11,3,'Vicerrector',2,'manuel@robinson.com'),
 (3,'Docente','Decano','Decano','Bachiller','Electrico','UNI','Nacional','PERÚ','','No','','','','Si','Electrico','Contratado a plazo determinado –a','Asociado','Tiempo parcial',1,1,0,1,'2002-04-25','Postulación','Obs',1,0,'2019-09-08 00:09:09','2019-09-08 00:45:49',11,2,4,7,4,5,6,'Decano',1,'asdsad@mail.com'),
 (4,'Docente','Vicerrector Académico','adsad','0','asdsa','asdsadasd','Nacional','PERÚ','','No','','','','Si','asdsadsad','Nombrado','Auxiliar','Tiempo completo',1,1,0,1,'2019-09-17','asdasd','asdsad',1,0,'2019-09-14 10:58:07','2019-09-14 10:58:07',37,3,4,5,3,0,5,'312asdsad',1,'cristian_7_70@hotmail.com');
/*!40000 ALTER TABLE `docentes` ENABLE KEYS */;


--
-- Definition of table `escuelas`
--

DROP TABLE IF EXISTS `escuelas`;
CREATE TABLE `escuelas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `facultad_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_escuelas_facultads1_idx` (`facultad_id`),
  CONSTRAINT `fk_escuelas_facultads1` FOREIGN KEY (`facultad_id`) REFERENCES `facultads` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `escuelas`
--

/*!40000 ALTER TABLE `escuelas` DISABLE KEYS */;
INSERT INTO `escuelas` (`id`,`nombre`,`activo`,`borrado`,`created_at`,`updated_at`,`facultad_id`) VALUES 
 (1,'Ingeniería de Sistemas e Informática',1,0,'2019-08-24 18:56:24','2019-08-24 18:56:42',1),
 (2,'asdasd',1,1,'2019-08-24 18:56:48','2019-08-24 18:57:57',1),
 (3,'Estadística e Informática',1,0,'2019-09-03 21:39:12','2019-09-03 21:39:12',1),
 (4,'Matemática',1,0,'2019-09-03 21:39:20','2019-09-03 21:39:20',1),
 (5,'Administración',1,0,'2019-09-04 23:17:58','2019-09-04 23:17:58',6),
 (6,'Turismo',1,0,'2019-09-04 23:19:48','2019-09-04 23:19:48',6),
 (7,'Agronomía',1,0,'2019-09-04 23:20:16','2019-09-04 23:20:16',7),
 (8,'Ingeniería agrícola',1,0,'2019-09-04 23:20:26','2019-09-04 23:20:26',7),
 (9,'Ingeniería ambiental',1,0,'2019-09-04 23:20:38','2019-09-04 23:20:38',4),
 (10,'Ingeniería sanitaria',1,0,'2019-09-04 23:20:49','2019-09-04 23:20:49',4),
 (11,'Enfermería',1,0,'2019-09-04 23:21:01','2019-09-04 23:21:01',3),
 (12,'Obstetricia',1,0,'2019-09-04 23:21:11','2019-09-04 23:21:11',3),
 (13,'Ciencias de la comunicación',1,0,'2019-09-04 23:21:25','2019-09-04 23:21:25',12),
 (14,'Lengua extranjera ingles',1,0,'2019-09-04 23:21:39','2019-09-04 23:21:39',12),
 (15,'Matemática e informática',1,0,'2019-09-04 23:21:50','2019-09-04 23:21:50',12),
 (16,'Arqueología',1,0,'2019-09-04 23:22:02','2019-09-04 23:22:02',12),
 (17,'Educación primaria bilingüe intercultural',1,0,'2019-09-04 23:22:15','2019-09-04 23:22:15',12),
 (18,'Comunicación lingüística y literatura',1,0,'2019-09-04 23:22:26','2019-09-04 23:22:26',12),
 (19,'Derecho y ciencias políticas',1,0,'2019-09-04 23:22:40','2019-09-04 23:22:40',10),
 (20,'Economía',1,0,'2019-09-04 23:22:56','2019-09-04 23:22:56',5),
 (21,'Contabilidad',1,0,'2019-09-04 23:23:10','2019-09-04 23:23:10',5),
 (22,'Ingeniería civil',1,0,'2019-09-04 23:23:24','2019-09-04 23:23:24',8),
 (23,'Arquitectura y urbanismo',1,0,'2019-09-04 23:23:34','2019-09-04 23:23:34',8),
 (24,'Ingeniería industrial',1,0,'2019-09-04 23:23:46','2019-09-04 23:23:46',11),
 (25,'Ingeniería de industrias alimentarias',1,0,'2019-09-04 23:23:59','2019-09-04 23:23:59',11),
 (26,'Ingeniería de minas',1,0,'2019-09-04 23:24:13','2019-09-04 23:24:13',9);
/*!40000 ALTER TABLE `escuelas` ENABLE KEYS */;


--
-- Definition of table `eventoculturals`
--

DROP TABLE IF EXISTS `eventoculturals`;
CREATE TABLE `eventoculturals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `descripcion` text,
  `lugarpresentacion` varchar(500) DEFAULT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafinal` date DEFAULT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `entidad` varchar(500) DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eventoculturals`
--

/*!40000 ALTER TABLE `eventoculturals` DISABLE KEYS */;
INSERT INTO `eventoculturals` (`id`,`nombre`,`descripcion`,`lugarpresentacion`,`fechainicio`,`fechafinal`,`semestre_id`,`created_at`,`updated_at`,`activo`,`borrado`,`entidad`,`observaciones`) VALUES 
 (1,'event','desc','lugar','2010-02-01','2011-02-02',1,'2019-09-15 13:01:39','2019-09-15 13:01:44',1,1,'entidad','obs'),
 (2,'nombre evento','desc evento','lugar','2010-01-08','2011-01-13',1,'2019-09-15 13:01:57','2019-09-15 13:03:35',1,0,'entidad','obs');
/*!40000 ALTER TABLE `eventoculturals` ENABLE KEYS */;


--
-- Definition of table `facultads`
--

DROP TABLE IF EXISTS `facultads`;
CREATE TABLE `facultads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `local_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_facultads_locals1_idx` (`local_id`),
  CONSTRAINT `fk_facultads_locals1` FOREIGN KEY (`local_id`) REFERENCES `locals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `facultads`
--

/*!40000 ALTER TABLE `facultads` DISABLE KEYS */;
INSERT INTO `facultads` (`id`,`nombre`,`activo`,`borrado`,`created_at`,`updated_at`,`local_id`) VALUES 
 (1,'Facultad de Ciencias',1,0,'2019-08-24 16:45:07','2019-08-24 18:54:31',3),
 (2,'sadsad',1,1,'2019-08-24 18:54:53','2019-08-24 18:54:56',3),
 (3,'Facultad de Ciencias Médicas',1,0,'2019-08-24 21:14:19','2019-08-24 21:14:19',6),
 (4,'Facultad de Ciencias del Ambiente',1,0,'2019-08-24 21:14:45','2019-08-24 21:14:45',3),
 (5,'Facultad de Economía y Contabilidad',1,0,'2019-08-24 21:15:13','2019-08-24 21:15:13',3),
 (6,'Facultad de Administración y Turismo',1,0,'2019-08-24 21:15:33','2019-08-24 21:15:33',3),
 (7,'Facultad de Ciencias Agrarias',1,0,'2019-08-24 21:15:49','2019-08-24 21:15:49',3),
 (8,'Facultad de Ingeniería Civil',1,0,'2019-08-24 21:16:02','2019-08-24 21:16:02',3),
 (9,'Facultad de Ingeniería de Minas, Geología y Metalurgia',1,0,'2019-08-24 21:16:22','2019-08-24 21:16:22',3),
 (10,'Facultad de Derecho y Ciencias Políticas',1,0,'2019-08-24 21:16:43','2019-08-24 21:16:43',7),
 (11,'Facultad de Ingeniería de Industrias Alimentarias',1,0,'2019-08-24 21:17:06','2019-08-24 21:17:06',3),
 (12,'Facultad de Ciencias Sociales, Educación Comunicación',1,0,'2019-08-24 21:17:50','2019-08-24 21:18:10',3);
/*!40000 ALTER TABLE `facultads` ENABLE KEYS */;


--
-- Definition of table `graduados`
--

DROP TABLE IF EXISTS `graduados`;
CREATE TABLE `graduados` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `escuela_id` int(11) DEFAULT NULL,
  `nombreGrado` varchar(500) DEFAULT NULL,
  `programaEstudios` varchar(500) DEFAULT NULL,
  `fechaEgreso` date DEFAULT NULL,
  `idioma` varchar(500) DEFAULT NULL,
  `modalidadObtencion` varchar(500) DEFAULT NULL,
  `numResolucion` varchar(200) DEFAULT NULL,
  `fechaResol` date DEFAULT NULL,
  `numeroDiploma` varchar(500) DEFAULT NULL,
  `autoridadRector` varchar(500) DEFAULT NULL,
  `fechaEmision` date DEFAULT NULL,
  `observaciones` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `persona_id` int(11) NOT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  `trabajoinvestigacion` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_bachilleres_personas1_idx` (`persona_id`),
  CONSTRAINT `fk_bachilleres_personas1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `graduados`
--

/*!40000 ALTER TABLE `graduados` DISABLE KEYS */;
INSERT INTO `graduados` (`id`,`escuela_id`,`nombreGrado`,`programaEstudios`,`fechaEgreso`,`idioma`,`modalidadObtencion`,`numResolucion`,`fechaResol`,`numeroDiploma`,`autoridadRector`,`fechaEmision`,`observaciones`,`activo`,`borrado`,`created_at`,`updated_at`,`persona_id`,`tipo`,`trabajoinvestigacion`) VALUES 
 (2,13,'Bachiller de Comunicación','comunicación integral','2019-09-03','Aleman','asdsad','asdsadasd','2019-09-05','asdsadsa','asdsad','2019-09-10','asdsad',1,0,'2019-09-10 00:09:48','2019-09-10 21:47:54',31,1,NULL),
 (3,1,'Ingeniero de Sistemas e Informática','Ingeniería de Sistemas e Informática','2014-08-23','Inglés','Tesis','RR-452-2019-UNASAM','2019-11-23','AR000254','JULIO G','2019-12-05','TODO CORRECTO edited',1,0,'2019-09-10 21:46:24','2019-09-10 21:48:12',1,2,NULL),
 (4,NULL,'magister de seguridad informatica','maestria en seguridad informatica','2010-02-01','Inglés','tesis ed','rr grado','2011-02-01','0001','julito g','2015-02-01','todo godu ed',1,0,'2019-09-10 21:54:10','2019-09-10 22:14:12',32,3,'investigaste esta ed'),
 (5,NULL,'doctor en administracion','doctorado de administracion','2014-05-02','Inglés','tesis guiada','rr 234 unasam','2016-06-05','dip 2','julito gg','2018-07-07','obs e',1,0,'2019-09-10 22:15:24','2019-09-10 22:15:29',11,4,'la administracion en las fuentes de soda');
/*!40000 ALTER TABLE `graduados` ENABLE KEYS */;


--
-- Definition of table `investigacions`
--

DROP TABLE IF EXISTS `investigacions`;
CREATE TABLE `investigacions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(500) DEFAULT NULL,
  `descripcion` text,
  `resolucionAprobacion` varchar(500) DEFAULT NULL,
  `presupuestoAsignado` double DEFAULT NULL,
  `presupuestoEjecutado` double DEFAULT NULL,
  `horas` double DEFAULT NULL,
  `fechaInicio` date DEFAULT NULL,
  `fechaTermino` date DEFAULT NULL,
  `clasificacion` varchar(500) DEFAULT NULL,
  `rutadocumento` varchar(2000) DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avance` double DEFAULT NULL,
  `descripcionAvance` varchar(2000) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `lineainvestigacion` varchar(500) DEFAULT NULL,
  `financiamiento` varchar(500) DEFAULT NULL,
  `patentado` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `investigacions`
--

/*!40000 ALTER TABLE `investigacions` DISABLE KEYS */;
/*!40000 ALTER TABLE `investigacions` ENABLE KEYS */;


--
-- Definition of table `investigadors`
--

DROP TABLE IF EXISTS `investigadors`;
CREATE TABLE `investigadors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `facultad_id` int(11) DEFAULT NULL,
  `observaciones` text,
  `clasificacion` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `investigadors`
--

/*!40000 ALTER TABLE `investigadors` DISABLE KEYS */;
INSERT INTO `investigadors` (`id`,`persona_id`,`escuela_id`,`facultad_id`,`observaciones`,`clasificacion`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (2,49,1,1,'asdas','DINA',1,0,'2019-09-15 17:50:36','2019-09-15 17:51:56');
/*!40000 ALTER TABLE `investigadors` ENABLE KEYS */;


--
-- Definition of table `locals`
--

DROP TABLE IF EXISTS `locals`;
CREATE TABLE `locals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `distrito_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_locals_distritos1_idx` (`distrito_id`),
  CONSTRAINT `fk_locals_distritos1` FOREIGN KEY (`distrito_id`) REFERENCES `distritos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locals`
--

/*!40000 ALTER TABLE `locals` DISABLE KEYS */;
INSERT INTO `locals` (`id`,`nombre`,`direccion`,`activo`,`borrado`,`created_at`,`updated_at`,`distrito_id`) VALUES 
 (2,'Local Central','Av. Centenario N° 200',1,0,'2019-08-24 16:04:03','2019-08-24 16:39:57',86),
 (3,'Ciudad Universitaria','Shancayan s/n',1,0,'2019-08-24 16:07:51','2019-08-24 16:07:51',86),
 (4,'Local de Postgrado','Av Simón Bolivar',1,0,'2019-08-24 16:08:16','2019-08-24 16:40:05',85),
 (5,'asd','dsad',1,1,'2019-08-24 16:09:25','2019-08-24 16:09:32',122),
 (6,'Local de Ciencias Médicas','Av. Gamarra N° 900',1,0,'2019-08-24 21:12:27','2019-08-24 21:12:27',85),
 (7,'Local de la Facultad de Derecho y Ciencias Políticas','Pedregal s/n',1,0,'2019-08-24 21:13:03','2019-08-24 21:13:03',85),
 (8,'Ex Minas','Jr. Julian de Morales 400',1,0,'2019-08-24 21:13:34','2019-08-24 21:13:34',85);
/*!40000 ALTER TABLE `locals` ENABLE KEYS */;


--
-- Definition of table `medicos`
--

DROP TABLE IF EXISTS `medicos`;
CREATE TABLE `medicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) DEFAULT NULL,
  `especialidad` varchar(500) DEFAULT NULL,
  `fechaingreso` date DEFAULT NULL,
  `fechainiciocontrato` date DEFAULT NULL,
  `fechafincontrato` date DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `acargo` tinyint(4) DEFAULT NULL,
  `programassalud_id` int(11) NOT NULL,
  `observaciones` text,
  `tipo` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_medicos_programassaluds1_idx` (`programassalud_id`),
  CONSTRAINT `fk_medicos_programassaluds1` FOREIGN KEY (`programassalud_id`) REFERENCES `programassaluds` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `medicos`
--

/*!40000 ALTER TABLE `medicos` DISABLE KEYS */;
INSERT INTO `medicos` (`id`,`persona_id`,`especialidad`,`fechaingreso`,`fechainiciocontrato`,`fechafincontrato`,`activo`,`borrado`,`created_at`,`updated_at`,`acargo`,`programassalud_id`,`observaciones`,`tipo`) VALUES 
 (1,42,'otorrino','2010-02-01','2010-03-01','2011-04-01',1,0,'2019-09-14 22:08:55','2019-09-14 22:12:24',1,2,'obs',1),
 (3,46,'asdasd',NULL,NULL,NULL,1,0,'2019-09-15 01:09:28','2019-09-15 01:09:28',0,5,'asd',1);
/*!40000 ALTER TABLE `medicos` ENABLE KEYS */;


--
-- Definition of table `modalidadadmisions`
--

DROP TABLE IF EXISTS `modalidadadmisions`;
CREATE TABLE `modalidadadmisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `descripcion` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modalidadadmisions`
--

/*!40000 ALTER TABLE `modalidadadmisions` DISABLE KEYS */;
INSERT INTO `modalidadadmisions` (`id`,`nombre`,`descripcion`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Examen Ordinario','Examen Ordinario',1,0,'2019-08-25 19:07:41','2019-09-04 23:24:53'),
 (2,'asdsa','sadasd',1,1,'2019-08-25 19:11:26','2019-08-25 19:11:29'),
 (3,'Centro pre universitario','Centro pre universitario',1,0,'2019-08-25 19:17:44','2019-09-04 23:25:06'),
 (4,'Convenios con comunidades campesinas','Convenios con comunidades campesinas',1,0,'2019-09-02 21:21:40','2019-09-04 23:25:19'),
 (5,'Graduados y titulados','Graduados y titulados',1,0,'2019-09-04 23:25:33','2019-09-04 23:25:33'),
 (6,'Traslado externo de universidades','Traslado externo de universidades',1,0,'2019-09-04 23:25:44','2019-09-04 23:25:44'),
 (7,'Primer y segundo puesto','Primer y segundo puesto',1,0,'2019-09-04 23:25:54','2019-09-04 23:25:54'),
 (8,'Deportistas destacados','Deportistas destacados',1,0,'2019-09-04 23:26:05','2019-09-04 23:26:05'),
 (9,'Personas con discapacidad','Personas con discapacidad',1,0,'2019-09-04 23:26:15','2019-09-04 23:26:15'),
 (10,'Víctimas de la violencia subversiva','Víctimas de la violencia subversiva',1,0,'2019-09-04 23:26:25','2019-09-04 23:26:25'),
 (11,'Convenio entre la UNASAM y otras instituciones','Convenio entre la UNASAM y otras instituciones',1,0,'2019-09-04 23:26:51','2019-09-04 23:26:51');
/*!40000 ALTER TABLE `modalidadadmisions` ENABLE KEYS */;


--
-- Definition of table `movilidads`
--

DROP TABLE IF EXISTS `movilidads`;
CREATE TABLE `movilidads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(4) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `institucion` varchar(500) DEFAULT NULL,
  `pais` varchar(500) DEFAULT NULL,
  `departamento` varchar(500) DEFAULT NULL,
  `provincia` varchar(500) DEFAULT NULL,
  `distrito` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alumno_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_movilidads_alumnos1_idx` (`alumno_id`),
  CONSTRAINT `fk_movilidads_alumnos1` FOREIGN KEY (`alumno_id`) REFERENCES `alumnos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `movilidads`
--

/*!40000 ALTER TABLE `movilidads` DISABLE KEYS */;
/*!40000 ALTER TABLE `movilidads` ENABLE KEYS */;


--
-- Definition of table `paises`
--

DROP TABLE IF EXISTS `paises`;
CREATE TABLE `paises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `abreviatura` varchar(45) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paises`
--

/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` (`id`,`nombre`,`abreviatura`,`codigo`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Perú','PE','01',1,0,NULL,NULL),
 (2,'Chile','CHI','02',1,0,NULL,NULL);
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;


--
-- Definition of table `participantes`
--

DROP TABLE IF EXISTS `participantes`;
CREATE TABLE `participantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `taller_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_participantes_tallers1_idx` (`taller_id`),
  CONSTRAINT `fk_participantes_tallers1` FOREIGN KEY (`taller_id`) REFERENCES `tallers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `participantes`
--

/*!40000 ALTER TABLE `participantes` DISABLE KEYS */;
INSERT INTO `participantes` (`id`,`persona_id`,`escuela_id`,`activo`,`borrado`,`created_at`,`updated_at`,`taller_id`) VALUES 
 (2,48,21,1,0,'2019-09-15 15:25:01','2019-09-15 15:25:36',2);
/*!40000 ALTER TABLE `participantes` ENABLE KEYS */;


--
-- Definition of table `pasantias`
--

DROP TABLE IF EXISTS `pasantias`;
CREATE TABLE `pasantias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) DEFAULT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `modalidads` varchar(500) DEFAULT NULL,
  `concepto` text,
  `paispasantia` varchar(500) DEFAULT NULL,
  `institucionpasantia` varchar(500) DEFAULT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafinal` date DEFAULT NULL,
  `monto` double DEFAULT NULL,
  `resolucions` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  `dependencia` varchar(500) DEFAULT NULL,
  `observaciones` text,
  `facultad_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pasantias`
--

/*!40000 ALTER TABLE `pasantias` DISABLE KEYS */;
INSERT INTO `pasantias` (`id`,`persona_id`,`escuela_id`,`modalidads`,`concepto`,`paispasantia`,`institucionpasantia`,`fechainicio`,`fechafinal`,`monto`,`resolucions`,`activo`,`borrado`,`created_at`,`updated_at`,`tipo`,`dependencia`,`observaciones`,`facultad_id`) VALUES 
 (2,38,4,'mod estae','concepto estae','pais estae','insit estae','2002-12-31','2003-01-30',400,'rr dadasd',1,0,'2019-09-14 10:22:58','2019-09-14 10:33:18',1,NULL,'dasdasde',NULL),
 (3,39,0,'asdsad','asdsad','asdsad','asdsad','2019-09-09','2019-09-30',231,'rr 12asdasd',1,0,'2019-09-14 11:09:50','2019-09-14 11:09:50',2,NULL,'asdsad',3),
 (4,40,6,'312312sdsad','asdasd','asdsad','asdsad','2019-08-01','2019-08-31',359,'rr numero 2',1,0,'2019-09-14 11:10:16','2019-09-14 11:10:16',2,NULL,'adsad23sdasd',6),
 (5,41,0,'terceros','sasdasd','dasdasd','adasdasd','2019-09-03','2019-09-27',3123,'rr sdasd',1,0,'2019-09-14 12:08:46','2019-09-14 12:08:59',3,'ogtise ed','adasd',NULL),
 (6,42,4,'modalidad procede','concepto','pais procede','institucion procede','2019-09-01','2019-09-30',3124,'rr ada23',1,0,'2019-09-14 15:27:12','2019-09-14 15:27:12',4,NULL,'sdasd',1),
 (7,43,21,'asdsad','asdsad','ddasd','asdsad','2019-06-01','2019-09-04',134,'adasdas',1,0,'2019-09-14 15:28:21','2019-09-14 15:28:21',5,NULL,'dasd',5);
/*!40000 ALTER TABLE `pasantias` ENABLE KEYS */;


--
-- Definition of table `personas`
--

DROP TABLE IF EXISTS `personas`;
CREATE TABLE `personas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipodoc` tinyint(4) DEFAULT NULL,
  `doc` varchar(45) DEFAULT NULL,
  `nombres` varchar(500) DEFAULT NULL,
  `apellidopat` varchar(500) DEFAULT NULL,
  `apellidomat` varchar(500) DEFAULT NULL,
  `genero` varchar(45) DEFAULT NULL,
  `estadocivil` varchar(45) DEFAULT NULL,
  `fechanac` date DEFAULT NULL,
  `esdiscapacitado` tinyint(4) DEFAULT NULL,
  `discapacidad` varchar(500) DEFAULT NULL,
  `pais` varchar(500) DEFAULT NULL,
  `departamento` varchar(500) DEFAULT NULL,
  `provincia` varchar(500) DEFAULT NULL,
  `distrito` varchar(500) DEFAULT NULL,
  `direccion` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `telefono` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personas`
--

/*!40000 ALTER TABLE `personas` DISABLE KEYS */;
INSERT INTO `personas` (`id`,`tipodoc`,`doc`,`nombres`,`apellidopat`,`apellidomat`,`genero`,`estadocivil`,`fechanac`,`esdiscapacitado`,`discapacidad`,`pais`,`departamento`,`provincia`,`distrito`,`direccion`,`activo`,`borrado`,`created_at`,`updated_at`,`email`,`telefono`) VALUES 
 (1,1,'47331640','Cristian Fernando','Chavez','Torres','M','1','1991-11-13',0,'','Perú','Ancash','Huaraz','Huaraz','Hz',1,0,NULL,'2019-09-12 22:45:38','cristian_7_70@hotmail.com','423544'),
 (2,1,'14725836','Marco','Quispe','Quiroga','M','1','1991-11-13',0,'','PERÚ','ANCASH','HUARAZP','HUARAZD','Av. Luzuriaga 234',1,0,'2019-09-03 21:25:41','2019-09-11 23:31:23','asdsad@mail.com','423544'),
 (3,1,'78945613','Juana','Loli','Telma','F','2','1980-12-13',1,'Ceguera Parcial','PERÚ','ANCASH','HUARAZ','HUARAZ','Psje. Los Villos 234',1,0,'2019-09-03 21:41:35','2019-09-03 22:52:49','juanita@mail.com','426598'),
 (4,1,'25836985','dsasdas asd','asdasd','Urrutia','M','1','2019-09-18',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asdasd',1,0,'2019-09-03 21:45:08','2019-09-03 21:45:08','asdasd@asdas.com','13123'),
 (5,1,'25896325','dddd','dddddd','Benjas','M','1','2019-09-04',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','dddd',1,0,'2019-09-03 21:48:02','2019-09-03 21:48:02','ddd@ddd.ccc','31234123'),
 (6,1,'85263258','dsadas','adasdasd','dsadasd','M','1','2019-09-11',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asdasdsad',1,0,'2019-09-03 22:21:15','2019-09-03 22:21:15','asdasdasd@mail.com','423544'),
 (7,1,'14765852','dasdsad','asdasd','dasdsad','M','1','2019-02-12',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asd',1,0,'2019-09-07 20:48:55','2019-09-07 20:48:55','dsadsad@mail.com','asdsad'),
 (8,1,'14765852','dasdsad','asdasd','dasdsad','M','1','2019-02-12',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asd',1,0,'2019-09-07 20:49:55','2019-09-07 20:49:55','dsadsad@mail.com','asdsad'),
 (9,1,'14765852','dasdsad','asdasd','dasdsad','M','1','2019-02-12',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asd',1,0,'2019-09-07 20:51:50','2019-09-07 20:51:50','dsadsad@mail.com','asdsad'),
 (10,1,'12345678','Manuel','Sanchez','Torres','M','2','1995-02-10',1,'Aneurisma','PERÚ','ANCASH','HUARAZ','HUARAZ','Jr. Los Maizales 234',1,0,'2019-09-08 00:01:44','2019-09-08 00:01:44','manuel@robinson.com','85652598'),
 (11,1,'14785236','Diana','Quiroz','Ortega','F','1','1980-05-02',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','aasdsad',1,0,'2019-09-08 00:09:09','2019-09-10 22:15:24','asdsad@mail.com','12312331'),
 (12,1,'11458654','Basilia','Chauca','Martinez','F','2','2000-01-01',1,'rodillas caidas','PERÚ','ANCASH','HUARAZ','HUARAZ','Jr Santa Carmela 169',1,0,'2019-09-08 15:08:19','2019-09-08 15:30:01','emailexample@mail.com','84957485'),
 (13,1,'25874165','Jorge','Roman','Quiroz','M','1','2000-05-12',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','Psj. Belen 213',1,0,'2019-09-08 15:40:34','2019-09-08 15:40:34','jorge@unasam.edu.pe',NULL),
 (14,1,'98765432','cdasdsadsadas','asdsad','bdasdas','M','2','1960-06-02',1,'dasdsad','PERÚ','ANCASH','HUARAZ','HUARAZ','Jr. Los paijares 234',1,0,'2019-09-08 16:23:03','2019-09-08 16:23:03','asasdas@asdsad.com','425896'),
 (15,1,'25874123','dasd','asdad','da','M','1','1980-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','dasd',1,0,'2019-09-08 16:26:40','2019-09-08 16:26:40','asdsa@mail.com','123123'),
 (16,1,'14725863','dsadsad','asdsad','dasd','M','1','1985-02-05',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdasd asda',1,0,'2019-09-08 16:48:01','2019-09-08 16:48:01','daasdsa@mail.com','123123123'),
 (17,1,'25874126','dasdasdasd','asdasd','dasdasd','M','3','1963-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad',1,0,'2019-09-08 16:48:57','2019-09-08 16:48:57','asdsad@mail.com','13123123'),
 (18,1,'25889648','dsadsad','adsasdasd','dasdsad','M','1','2002-08-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','dsadsa',1,0,'2019-09-08 17:06:46','2019-09-08 17:06:46','dasdsa@mail.com','123sdsad'),
 (19,1,'25874125','Rocio','Rios','Zavala','F','1','1968-12-05',1,'piernas rotas','PERÚ','ANCASH','HUARAZ','HUARAZ','Belen',1,0,'2019-09-08 21:05:03','2019-09-08 21:05:03','rocio@mail.com','943589658'),
 (20,1,'25874125','Rocio','Rios','Zavala','F','1','1968-12-05',1,'piernas rotas','PERÚ','ANCASH','HUARAZ','HUARAZ','Belen',1,0,'2019-09-08 21:07:12','2019-09-08 21:07:12','rocio@mail.com','943589658'),
 (21,1,'36547852','asdsad','dasdd','dsasda','M','2','2017-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','adasd',1,0,'2019-09-08 21:13:17','2019-09-08 21:13:17','dsadasd@mail.com','12312312'),
 (22,1,'258741365','Cidrolax','Montana','Roselin','M','1','2000-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','adsadsad',1,0,'2019-09-08 21:21:11','2019-09-08 21:32:13','asdsad@mail.com','13asd3asd'),
 (23,1,'312312asdsa','dsadasd','asdsad','dasd','M','1','1985-02-05',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad',1,0,'2019-09-08 21:22:06','2019-09-08 21:22:06','dasdasd@mail.com','123123asd'),
 (24,1,'14785235','dsadasd','asdsad','dsad','M','1','2003-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad',1,0,'2019-09-08 22:09:42','2019-09-08 22:09:42','dasdsadas@mail.com','sasa'),
 (25,1,'14785235','dsadasd','asdsad','dsad','M','1','2003-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad',1,0,'2019-09-08 22:10:55','2019-09-08 22:10:55','dasdsadas@mail.com','sasa'),
 (26,1,'14785235','dsadasd','asdsad','dsad','M','1','2003-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad',1,0,'2019-09-08 22:12:23','2019-09-08 22:12:23','dasdsadas@mail.com','sasa'),
 (27,1,'213123123','dsadsad','asdsad','dsadsa','M','1','2000-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','sadasdd',1,0,'2019-09-08 22:14:11','2019-09-08 22:14:11','asdasd@mail.com','123221sad'),
 (28,1,'asdsadsa','asdasd','asdasdasd','dsadsa','M','1','2019-09-03',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad',1,0,'2019-09-08 22:15:49','2019-09-08 22:15:49','asdasd@mail.com','1312sad'),
 (29,1,'65478985','Cristian','Vilchez','Samaso','M','1','1985-02-05',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad1asd',1,0,'2019-09-08 22:52:39','2019-09-08 22:52:39','13123sda@mail.com','945856592'),
 (30,1,'98741258','Carmen','Quiroga','Rios','F','1','1995-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','adssad asdsa',1,0,'2019-09-08 22:53:47','2019-09-08 22:54:39','dasdsa@mail.com','123asd12s'),
 (31,1,'31233123','Mata','Raul','Quispe','M','2','2010-05-02',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asdsadsa',1,0,'2019-09-10 00:09:48','2019-09-10 00:22:11','dasdsad@mail.com','123123sad'),
 (32,1,'85965475','dasdsad','asdsad','dasdasd','M','1','2019-05-02',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad',1,0,'2019-09-10 21:54:10','2019-09-10 21:54:10','asdsa@mail.com','123123213'),
 (33,1,'14785236','nombres','apellido paterno','apellido materno','F','1','1970-02-01',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsad',1,0,'2019-09-11 22:30:26','2019-09-11 22:30:26','asdsad@mail.com','942587454'),
 (34,1,'85236745','dsadas','asdasdas','dasdas','M','1','2010-05-02',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','adsad',1,0,'2019-09-11 22:42:31','2019-09-11 22:42:31','asdsad@mail.com','13123123'),
 (35,1,'12312312','dsadas','asdsa','dasd','M','1','2019-08-27',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','adsad',1,0,'2019-09-11 23:32:28','2019-09-11 23:32:28','asdsa@mail.com','asdasd23sad'),
 (36,1,'25836585','dasdsad','asdasdsa','adasdasda','M','1','2019-09-04',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','adsad',1,0,'2019-09-12 22:49:48','2019-09-12 22:49:48','asdsa@mail.com','13123123'),
 (37,1,'47331640','Cristian Fernando','Chavez','Torres','M','1','1991-11-13',0,'','Perú','Ancash','Huaraz','Huaraz','Hz',1,0,'2019-09-14 10:21:21','2019-09-14 10:21:21','cristian_7_70@hotmail.com','423544'),
 (38,1,'255684466','dsada','dasdasd','dasd','M','2','2000-02-12',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asda',1,0,'2019-09-14 10:22:58','2019-09-14 10:22:58','dasd@mail.com','12312312'),
 (39,1,'47331640','Cristian Fernando','Chavez','Torres','M','1','1991-11-13',0,'','Perú','Ancash','Huaraz','Huaraz','Hz',1,0,'2019-09-14 11:09:50','2019-09-14 11:09:50','cristian_7_70@hotmail.com','423544'),
 (40,1,'14725836','Marco','Quispe','Quiroga','M','1','1991-11-13',0,'','PERÚ','ANCASH','HUARAZP','HUARAZD','Av. Luzuriaga 234',1,0,'2019-09-14 11:10:16','2019-09-14 11:10:16','asdsad@mail.com','423544'),
 (41,1,'47331640','Cristian Fernando','Chavez','Torres','M','1','1991-11-13',0,'','Perú','Ancash','Huaraz','Huaraz','Hz',1,0,'2019-09-14 12:08:46','2019-09-14 12:08:46','cristian_7_70@hotmail.com','423544'),
 (42,1,'47331640','Cristian Fernando','Chavez','Torres','M','1','1991-11-13',0,NULL,'Perú','Ancash','Huaraz','Huaraz','Hz',1,0,'2019-09-14 15:27:12','2019-09-14 22:08:55','cristian_7_70@hotmail.com','423544'),
 (43,1,'14725836','Marco','Quispe','Quiroga','M','1','1991-11-13',0,'','PERÚ','ANCASH','HUARAZP','HUARAZD','Av. Luzuriaga 234',1,0,'2019-09-14 15:28:21','2019-09-14 15:28:21','asdsad@mail.com','423544'),
 (44,1,'14785233','dasda','asdasd','dasda','M','1','2000-02-01',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asdas',1,0,'2019-09-14 22:09:27','2019-09-14 22:09:27','dasdas@mail.com','13123'),
 (45,1,'47331640','Cristian Fernando','Chavez','Torres','M','1','1991-11-13',0,'','Perú','Ancash','Huaraz','Huaraz','Hz',1,0,'2019-09-14 23:50:34','2019-09-15 17:50:03','cristian_7_70@hotmail.com','423544'),
 (46,1,'12355584','dsadsad','adasd','dasda','M','2','1999-11-13',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','asasd',1,0,'2019-09-14 23:51:08','2019-09-14 23:51:08','dasdsa@mail.com','1321312'),
 (47,1,'14725845','sdadasd','asddsa','dsad','M','2','2019-08-27',0,NULL,'PERÚ','ANCASH','HUARAZ','HUARAZ','assad',1,0,'2019-09-15 15:21:29','2019-09-15 15:21:29','sad@mail.com','sadasd'),
 (48,1,'47331633','dasdsad','Juan','dsada','M','3','2019-09-11',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','asdsa',1,0,'2019-09-15 15:25:01','2019-09-15 15:25:15','dsadas@mail.com','123122'),
 (49,1,'147258312','Miguel','Pancho','Fierro','M','1','2019-09-17',0,'','PERÚ','ANCASH','HUARAZ','HUARAZ','adasdasd',1,0,'2019-09-15 17:50:36','2019-09-15 17:51:14','asdsad6@mail.com','3123213');
/*!40000 ALTER TABLE `personas` ENABLE KEYS */;


--
-- Definition of table `postulantes`
--

DROP TABLE IF EXISTS `postulantes`;
CREATE TABLE `postulantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) DEFAULT NULL,
  `semestre_id` int(11) NOT NULL,
  `escuela_id` int(11) DEFAULT NULL,
  `colegio` varchar(2000) DEFAULT NULL,
  `modalidadadmision_id` int(11) NOT NULL,
  `modalidadestudios` varchar(500) DEFAULT NULL,
  `puntaje` double DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `opcioningreso` int(11) DEFAULT NULL,
  `persona_id` int(11) NOT NULL,
  `observaciones` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  `grado` tinyint(4) DEFAULT NULL,
  `nombreGrado` varchar(500) DEFAULT NULL,
  `pais` varchar(500) DEFAULT NULL,
  `provincia` varchar(500) DEFAULT NULL,
  `distrito` varchar(500) DEFAULT NULL,
  `universidadCulminoPregrado` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `escuela_id2` int(11) DEFAULT NULL,
  `tipogestioncolegio` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_postulantes_semestres1_idx` (`semestre_id`),
  KEY `fk_postulantes_escuelas1_idx` (`escuela_id`),
  KEY `fk_postulantes_modalidadadmisions1_idx` (`modalidadadmision_id`),
  KEY `fk_postulantes_personas1_idx` (`persona_id`),
  CONSTRAINT `fk_postulantes_escuelas1` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_postulantes_modalidadadmisions1` FOREIGN KEY (`modalidadadmision_id`) REFERENCES `modalidadadmisions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_postulantes_personas1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_postulantes_semestres1` FOREIGN KEY (`semestre_id`) REFERENCES `semestres` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `postulantes`
--

/*!40000 ALTER TABLE `postulantes` DISABLE KEYS */;
INSERT INTO `postulantes` (`id`,`codigo`,`semestre_id`,`escuela_id`,`colegio`,`modalidadadmision_id`,`modalidadestudios`,`puntaje`,`estado`,`opcioningreso`,`persona_id`,`observaciones`,`activo`,`borrado`,`created_at`,`updated_at`,`tipo`,`grado`,`nombreGrado`,`pais`,`provincia`,`distrito`,`universidadCulminoPregrado`,`email`,`escuela_id2`,`tipogestioncolegio`) VALUES 
 (1,'AR71',1,1,'SANTA ROSA DE VITERBO',1,'1',105,0,0,2,'detalle postulante',1,0,'2019-09-03 21:30:17','2019-09-03 21:30:17',1,NULL,NULL,NULL,NULL,NULL,NULL,'asdsad@mail.com',0,1),
 (2,'AR72',1,3,'LA INMACULADA',1,'1',180,1,4,3,'INGRESÓ A LA SEGUNDA OPCION',1,0,'2019-09-03 21:41:35','2019-09-03 22:52:49',1,NULL,NULL,NULL,NULL,NULL,NULL,'juanita@mail.com',4,2),
 (3,'asdsa',2,4,'daasdasdsad',3,'2',250,0,0,4,'dasdasd',1,0,'2019-09-03 21:45:08','2019-09-03 21:45:08',1,NULL,NULL,NULL,NULL,NULL,NULL,'asdasd@asdas.com',0,1),
 (5,'312dsad',1,1,'SANTA ROSA DE VITERBO',1,'2',150,0,0,6,'asdsadsad',1,0,'2019-09-03 22:21:15','2019-09-03 22:21:15',1,NULL,NULL,NULL,NULL,NULL,NULL,'asdasdasd@mail.com',0,1),
 (6,'asd123sad',1,7,'asdsad123dsad',6,'2',156,1,12,18,'asdsad',1,0,'2019-09-08 17:06:46','2019-09-08 17:06:46',1,NULL,NULL,NULL,NULL,NULL,NULL,'dasdsa@mail.com',8,2),
 (8,'pos142585',1,NULL,NULL,1,'1',145,1,NULL,20,'obs del postulante',1,0,'2019-09-08 21:07:12','2019-09-08 21:07:12',2,3,'Maestría en Ingeniería, Mensión en Seguridad e Informática',NULL,NULL,NULL,'San Marcos','rocio@mail.com',NULL,NULL),
 (9,'asdsad',1,4,'asdsad2asdsa',5,'2',123,1,8,21,'asdsad',1,0,'2019-09-08 21:13:17','2019-09-08 21:13:17',1,NULL,NULL,NULL,NULL,NULL,NULL,'dsadasd@mail.com',7,1),
 (10,'311asdsa',1,NULL,NULL,5,'2',123,1,NULL,22,'asdsadasd',1,0,'2019-09-08 21:21:11','2019-09-08 21:32:13',2,3,'adasd',NULL,NULL,NULL,'asdsadsad','asdsad@mail.com',NULL,NULL);
/*!40000 ALTER TABLE `postulantes` ENABLE KEYS */;


--
-- Definition of table `presentacions`
--

DROP TABLE IF EXISTS `presentacions`;
CREATE TABLE `presentacions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `asistentes` int(11) DEFAULT NULL,
  `detalle` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `taller_id` int(11) NOT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`),
  KEY `fk_presentacions_talleres1_idx` (`taller_id`),
  CONSTRAINT `fk_presentacions_talleres1` FOREIGN KEY (`taller_id`) REFERENCES `tallers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `presentacions`
--

/*!40000 ALTER TABLE `presentacions` DISABLE KEYS */;
INSERT INTO `presentacions` (`id`,`fecha`,`asistentes`,`detalle`,`activo`,`borrado`,`created_at`,`updated_at`,`taller_id`,`observaciones`) VALUES 
 (2,'2019-09-03',233,'detalles e',1,0,'2019-09-15 15:49:33','2019-09-15 15:49:47',2,'obs e');
/*!40000 ALTER TABLE `presentacions` ENABLE KEYS */;


--
-- Definition of table `programassaluds`
--

DROP TABLE IF EXISTS `programassaluds`;
CREATE TABLE `programassaluds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `descripcion` text,
  `cantidadAtenciones` int(11) DEFAULT NULL,
  `fechaini` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  `lugar` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `programassaluds`
--

/*!40000 ALTER TABLE `programassaluds` DISABLE KEYS */;
INSERT INTO `programassaluds` (`id`,`nombre`,`descripcion`,`cantidadAtenciones`,`fechaini`,`fechafin`,`activo`,`borrado`,`created_at`,`updated_at`,`tipo`,`lugar`) VALUES 
 (1,'Odontología','asdas',NULL,NULL,NULL,1,1,'2019-09-14 20:44:39','2019-09-14 20:45:12',1,NULL),
 (2,'Obstetricia','obste',NULL,NULL,NULL,1,0,'2019-09-14 20:45:15','2019-09-14 20:45:58',1,NULL),
 (3,'asdas','asd',NULL,NULL,NULL,1,0,'2019-09-14 22:09:35','2019-09-14 22:09:35',1,NULL),
 (4,'campaña de revision auditiva','desc',34,'2019-09-01','2019-09-18',1,1,'2019-09-15 01:06:54','2019-09-15 01:09:06',2,'campus de shanchayan'),
 (5,'Campaña Auditiva','buena campaña',20,'2019-09-01','2019-09-19',1,0,'2019-09-15 01:09:15','2019-09-15 01:11:24',2,'Campus de Shancayan FC');
/*!40000 ALTER TABLE `programassaluds` ENABLE KEYS */;


--
-- Definition of table `provincias`
--

DROP TABLE IF EXISTS `provincias`;
CREATE TABLE `provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `departamento_id` int(11) NOT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_provincias_departamentos1_idx` (`departamento_id`),
  CONSTRAINT `fk_provincias_departamentos1` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=196 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provincias`
--

/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` (`id`,`nombre`,`codigo`,`departamento_id`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'CHACHAPOYAS','01',1,1,0,NULL,NULL),
 (2,'BAGUA','02',1,1,0,NULL,NULL),
 (3,'BONGARA','03',1,1,0,NULL,NULL),
 (4,'LUYA','04',1,1,0,NULL,NULL),
 (5,'RODRIGUEZ DE MENDOZA','05',1,1,0,NULL,NULL),
 (6,'CONDORCANQUI','06',1,1,0,NULL,NULL),
 (7,'UTCUBAMBA','07',1,1,0,NULL,NULL),
 (8,'HUARAZ','01',2,1,0,NULL,NULL),
 (9,'AIJA','02',2,1,0,NULL,NULL),
 (10,'BOLOGNESI','03',2,1,0,NULL,NULL),
 (11,'CARHUAZ','04',2,1,0,NULL,NULL),
 (12,'CASMA','05',2,1,0,NULL,NULL),
 (13,'CORONGO','06',2,1,0,NULL,NULL),
 (14,'HUAYLAS','07',2,1,0,NULL,NULL),
 (15,'HUARI','08',2,1,0,NULL,NULL),
 (16,'MARISCAL LUZURIAGA','09',2,1,0,NULL,NULL),
 (17,'PALLASCA','10',2,1,0,NULL,NULL),
 (18,'POMABAMBA','11',2,1,0,NULL,NULL),
 (19,'RECUAY','12',2,1,0,NULL,NULL),
 (20,'SANTA','13',2,1,0,NULL,NULL),
 (21,'SIHUAS','14',2,1,0,NULL,NULL),
 (22,'YUNGAY','15',2,1,0,NULL,NULL),
 (23,'ANTONIO RAIMONDI','16',2,1,0,NULL,NULL),
 (24,'CARLOS FERMIN FITZCARRALD','17',2,1,0,NULL,NULL),
 (25,'ASUNCION','18',2,1,0,NULL,NULL),
 (26,'HUARMEY','19',2,1,0,NULL,NULL),
 (27,'OCROS','20',2,1,0,NULL,NULL),
 (28,'ABANCAY','01',3,1,0,NULL,NULL),
 (29,'AYMARAES','02',3,1,0,NULL,NULL),
 (30,'ANDAHUAYLAS','03',3,1,0,NULL,NULL),
 (31,'ANTABAMBA','04',3,1,0,NULL,NULL),
 (32,'COTABAMBAS','05',3,1,0,NULL,NULL),
 (33,'GRAU','06',3,1,0,NULL,NULL),
 (34,'CHINCHEROS','07',3,1,0,NULL,NULL),
 (35,'AREQUIPA','01',4,1,0,NULL,NULL),
 (36,'CAYLLOMA','02',4,1,0,NULL,NULL),
 (37,'CAMANA','03',4,1,0,NULL,NULL),
 (38,'CARAVELI','04',4,1,0,NULL,NULL),
 (39,'CASTILLA','05',4,1,0,NULL,NULL),
 (40,'CONDESUYOS','06',4,1,0,NULL,NULL),
 (41,'ISLAY','07',4,1,0,NULL,NULL),
 (42,'LA UNION','08',4,1,0,NULL,NULL),
 (43,'HUAMANGA','01',5,1,0,NULL,NULL),
 (44,'CANGALLO','02',5,1,0,NULL,NULL),
 (45,'HUANTA','03',5,1,0,NULL,NULL),
 (46,'LA MAR','04',5,1,0,NULL,NULL),
 (47,'LUCANAS','05',5,1,0,NULL,NULL),
 (48,'PARINACOCHAS','06',5,1,0,NULL,NULL),
 (49,'VICTOR FAJARDO','07',5,1,0,NULL,NULL),
 (50,'HUANCA SANCOS','08',5,1,0,NULL,NULL),
 (51,'VILCAS HUAMAN','09',5,1,0,NULL,NULL),
 (52,'PAUCAR DEL SARA SARA','10',5,1,0,NULL,NULL),
 (53,'SUCRE','11',5,1,0,NULL,NULL),
 (54,'CAJAMARCA','01',6,1,0,NULL,NULL),
 (55,'CAJABAMBA','02',6,1,0,NULL,NULL),
 (56,'CELENDIN','03',6,1,0,NULL,NULL),
 (57,'CONTUMAZA','04',6,1,0,NULL,NULL),
 (58,'CUTERVO','05',6,1,0,NULL,NULL),
 (59,'CHOTA','06',6,1,0,NULL,NULL),
 (60,'HUALGAYOC','07',6,1,0,NULL,NULL),
 (61,'JAEN','08',6,1,0,NULL,NULL),
 (62,'SANTA CRUZ','09',6,1,0,NULL,NULL),
 (63,'SAN MIGUEL','10',6,1,0,NULL,NULL),
 (64,'SAN IGNACIO','11',6,1,0,NULL,NULL),
 (65,'SAN MARCOS','12',6,1,0,NULL,NULL),
 (66,'SAN PABLO','13',6,1,0,NULL,NULL),
 (67,'CUSCO','01',7,1,0,NULL,NULL),
 (68,'ACOMAYO','02',7,1,0,NULL,NULL),
 (69,'ANTA','03',7,1,0,NULL,NULL),
 (70,'CALCA','04',7,1,0,NULL,NULL),
 (71,'CANAS','05',7,1,0,NULL,NULL),
 (72,'CANCHIS','06',7,1,0,NULL,NULL),
 (73,'CHUMBIVILCAS','07',7,1,0,NULL,NULL),
 (74,'ESPINAR','08',7,1,0,NULL,NULL),
 (75,'LA CONVENCION','09',7,1,0,NULL,NULL),
 (76,'PARURO','10',7,1,0,NULL,NULL),
 (77,'PAUCARTAMBO','11',7,1,0,NULL,NULL),
 (78,'QUISPICANCHI','12',7,1,0,NULL,NULL),
 (79,'URUBAMBA','13',7,1,0,NULL,NULL),
 (80,'HUANCAVELICA','01',8,1,0,NULL,NULL),
 (81,'ACOBAMBA','02',8,1,0,NULL,NULL),
 (82,'ANGARAES','03',8,1,0,NULL,NULL),
 (83,'CASTROVIRREYNA','04',8,1,0,NULL,NULL),
 (84,'TAYACAJA','05',8,1,0,NULL,NULL),
 (85,'HUAYTARA','06',8,1,0,NULL,NULL),
 (86,'CHURCAMPA','07',8,1,0,NULL,NULL),
 (87,'HUANUCO','01',9,1,0,NULL,NULL),
 (88,'AMBO','02',9,1,0,NULL,NULL),
 (89,'DOS DE MAYO','03',9,1,0,NULL,NULL),
 (90,'HUAMALIES','04',9,1,0,NULL,NULL),
 (91,'MARAÑON','05',9,1,0,NULL,NULL),
 (92,'LEONCIO PRADO','06',9,1,0,NULL,NULL),
 (93,'PACHITEA','07',9,1,0,NULL,NULL),
 (94,'PUERTO INCA','08',9,1,0,NULL,NULL),
 (95,'HUACAYBAMBA','09',9,1,0,NULL,NULL),
 (96,'LAURICOCHA','10',9,1,0,NULL,NULL),
 (97,'YAROWILCA','11',9,1,0,NULL,NULL),
 (98,'ICA','01',10,1,0,NULL,NULL),
 (99,'CHINCHA','02',10,1,0,NULL,NULL),
 (100,'NAZCA','03',10,1,0,NULL,NULL),
 (101,'PISCO','04',10,1,0,NULL,NULL),
 (102,'PALPA','05',10,1,0,NULL,NULL),
 (103,'HUANCAYO','01',11,1,0,NULL,NULL),
 (104,'CONCEPCION','02',11,1,0,NULL,NULL),
 (105,'JAUJA','03',11,1,0,NULL,NULL),
 (106,'JUNIN','04',11,1,0,NULL,NULL),
 (107,'TARMA','05',11,1,0,NULL,NULL),
 (108,'YAULI','06',11,1,0,NULL,NULL),
 (109,'SATIPO','07',11,1,0,NULL,NULL),
 (110,'CHANCHAMAYO','08',11,1,0,NULL,NULL),
 (111,'CHUPACA','09',11,1,0,NULL,NULL),
 (112,'TRUJILLO','01',12,1,0,NULL,NULL),
 (113,'BOLIVAR','02',12,1,0,NULL,NULL),
 (114,'SANCHEZ CARRION','03',12,1,0,NULL,NULL),
 (115,'OTUZCO','04',12,1,0,NULL,NULL),
 (116,'PACASMAYO','05',12,1,0,NULL,NULL),
 (117,'PATAZ','06',12,1,0,NULL,NULL),
 (118,'SANTIAGO DE CHUCO','07',12,1,0,NULL,NULL),
 (119,'ASCOPE','08',12,1,0,NULL,NULL),
 (120,'CHEPEN','09',12,1,0,NULL,NULL),
 (121,'JULCAN','10',12,1,0,NULL,NULL),
 (122,'GRAN CHIMU','11',12,1,0,NULL,NULL),
 (123,'VIRU','12',12,1,0,NULL,NULL),
 (124,'CHICLAYO','01',13,1,0,NULL,NULL),
 (125,'FERREÑAFE','02',13,1,0,NULL,NULL),
 (126,'LAMBAYEQUE','03',13,1,0,NULL,NULL),
 (127,'LIMA','01',14,1,0,NULL,NULL),
 (128,'CAJATAMBO','02',14,1,0,NULL,NULL),
 (129,'CANTA','03',14,1,0,NULL,NULL),
 (130,'CAÑETE','04',14,1,0,NULL,NULL),
 (131,'HUAURA','05',14,1,0,NULL,NULL),
 (132,'HUAROCHIRI','06',14,1,0,NULL,NULL),
 (133,'YAUYOS','07',14,1,0,NULL,NULL),
 (134,'HUARAL','08',14,1,0,NULL,NULL),
 (135,'BARRANCA','09',14,1,0,NULL,NULL),
 (136,'OYON','10',14,1,0,NULL,NULL),
 (137,'MAYNAS','01',15,1,0,NULL,NULL),
 (138,'ALTO AMAZONAS','02',15,1,0,NULL,NULL),
 (139,'LORETO','03',15,1,0,NULL,NULL),
 (140,'REQUENA','04',15,1,0,NULL,NULL),
 (141,'UCAYALI','05',15,1,0,NULL,NULL),
 (142,'MARISCAL RAMON CASTILLA','06',15,1,0,NULL,NULL),
 (143,'DATEM DEL MARAÑON','07',15,1,0,NULL,NULL),
 (144,'TAMBOPATA','01',16,1,0,NULL,NULL),
 (145,'MANU','02',16,1,0,NULL,NULL),
 (146,'TAHUAMANU','03',16,1,0,NULL,NULL),
 (147,'MARISCAL NIETO','01',17,1,0,NULL,NULL),
 (148,'GENERAL SANCHEZ CERRO','02',17,1,0,NULL,NULL),
 (149,'ILO','03',17,1,0,NULL,NULL),
 (150,'PASCO','01',18,1,0,NULL,NULL),
 (151,'DANIEL ALCIDES CARRION','02',18,1,0,NULL,NULL),
 (152,'OXAPAMPA','03',18,1,0,NULL,NULL),
 (153,'PIURA','01',19,1,0,NULL,NULL),
 (154,'AYABACA','02',19,1,0,NULL,NULL),
 (155,'HUANCABAMBA','03',19,1,0,NULL,NULL),
 (156,'MORROPON','04',19,1,0,NULL,NULL),
 (157,'PAITA','05',19,1,0,NULL,NULL),
 (158,'SULLANA','06',19,1,0,NULL,NULL),
 (159,'TALARA','07',19,1,0,NULL,NULL),
 (160,'SECHURA','08',19,1,0,NULL,NULL),
 (161,'PUNO','01',20,1,0,NULL,NULL),
 (162,'AZANGARO','02',20,1,0,NULL,NULL),
 (163,'CARABAYA','03',20,1,0,NULL,NULL),
 (164,'CHUCUITO','04',20,1,0,NULL,NULL),
 (165,'HUANCANE','05',20,1,0,NULL,NULL),
 (166,'LAMPA','06',20,1,0,NULL,NULL),
 (167,'MELGAR','07',20,1,0,NULL,NULL),
 (168,'SANDIA','08',20,1,0,NULL,NULL),
 (169,'SAN ROMAN','09',20,1,0,NULL,NULL),
 (170,'YUNGUYO','10',20,1,0,NULL,NULL),
 (171,'SAN ANTONIO DE PUTINA','11',20,1,0,NULL,NULL),
 (172,'EL COLLAO','12',20,1,0,NULL,NULL),
 (173,'MOHO','13',20,1,0,NULL,NULL),
 (174,'MOYOBAMBA','01',21,1,0,NULL,NULL),
 (175,'HUALLAGA','02',21,1,0,NULL,NULL),
 (176,'LAMAS','03',21,1,0,NULL,NULL),
 (177,'MARISCAL CACERES','04',21,1,0,NULL,NULL),
 (178,'RIOJA','05',21,1,0,NULL,NULL),
 (179,'SAN MARTIN','06',21,1,0,NULL,NULL),
 (180,'BELLAVISTA','07',21,1,0,NULL,NULL),
 (181,'TOCACHE','08',21,1,0,NULL,NULL),
 (182,'PICOTA','09',21,1,0,NULL,NULL),
 (183,'EL DORADO','10',21,1,0,NULL,NULL),
 (184,'TACNA','01',22,1,0,NULL,NULL),
 (185,'TARATA','02',22,1,0,NULL,NULL),
 (186,'JORGE BASADRE','03',22,1,0,NULL,NULL),
 (187,'CANDARAVE','04',22,1,0,NULL,NULL),
 (188,'TUMBES','01',23,1,0,NULL,NULL),
 (189,'CONTRALMIRANTE VILLAR','02',23,1,0,NULL,NULL),
 (190,'ZARUMILLA','03',23,1,0,NULL,NULL),
 (191,'CALLAO','01',24,1,0,NULL,NULL),
 (192,'CORONEL PORTILLO','01',25,1,0,NULL,NULL),
 (193,'PADRE ABAD','02',25,1,0,NULL,NULL),
 (194,'ATALAYA','03',25,1,0,NULL,NULL),
 (195,'PURUS','04',25,1,0,NULL,NULL);
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;


--
-- Definition of table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `descripcion` text,
  `fechainicio` date DEFAULT NULL,
  `fechafinal` date DEFAULT NULL,
  `lugar` varchar(500) DEFAULT NULL,
  `jefeproyecto` varchar(500) DEFAULT NULL,
  `fuentefinanciamiento` varchar(500) DEFAULT NULL,
  `cantidadbeneficiarios` int(11) DEFAULT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `persona_id` int(11) DEFAULT NULL,
  `presupuesto` double DEFAULT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `proyectos`
--

/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` (`id`,`nombre`,`descripcion`,`fechainicio`,`fechafinal`,`lugar`,`jefeproyecto`,`fuentefinanciamiento`,`cantidadbeneficiarios`,`semestre_id`,`activo`,`borrado`,`tipo`,`created_at`,`updated_at`,`persona_id`,`presupuesto`,`observaciones`) VALUES 
 (2,'Proy','desc ed','2019-09-12','2019-10-01','lug','Cristian Fernando Chavez Torres','fuente',123,1,1,0,2,'2019-09-15 12:17:50','2019-09-15 12:18:17',45,456,'obs');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;


--
-- Definition of table `publicaciones`
--

DROP TABLE IF EXISTS `publicaciones`;
CREATE TABLE `publicaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `detalles` text,
  `fecha` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `investigacion_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_publicaciones_investigacions1_idx` (`investigacion_id`),
  CONSTRAINT `fk_publicaciones_investigacions1` FOREIGN KEY (`investigacion_id`) REFERENCES `investigacions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `publicaciones`
--

/*!40000 ALTER TABLE `publicaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `publicaciones` ENABLE KEYS */;


--
-- Definition of table `revistaspublicacions`
--

DROP TABLE IF EXISTS `revistaspublicacions`;
CREATE TABLE `revistaspublicacions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipoPublicacion` varchar(500) DEFAULT NULL,
  `titulo` varchar(500) DEFAULT NULL,
  `descripcion` text,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `escuela_id` int(11) NOT NULL,
  `fechaPublicado` date DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  `investigacion_id` int(11) DEFAULT NULL,
  `indexada` tinyint(4) DEFAULT NULL,
  `lugarIndexada` varchar(500) DEFAULT NULL,
  `numero` varchar(500) DEFAULT NULL,
  `rutadoc` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_revistas_escuelas1_idx` (`escuela_id`),
  CONSTRAINT `fk_revistas_escuelas1` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `revistaspublicacions`
--

/*!40000 ALTER TABLE `revistaspublicacions` DISABLE KEYS */;
/*!40000 ALTER TABLE `revistaspublicacions` ENABLE KEYS */;


--
-- Definition of table `semestres`
--

DROP TABLE IF EXISTS `semestres`;
CREATE TABLE `semestres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `fechainicio` date DEFAULT NULL,
  `fechafin` date DEFAULT NULL,
  `estado` tinyint(4) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `semestres`
--

/*!40000 ALTER TABLE `semestres` DISABLE KEYS */;
INSERT INTO `semestres` (`id`,`nombre`,`fechainicio`,`fechafin`,`estado`,`activo`,`borrado`,`created_at`,`updated_at`,`user_id`) VALUES 
 (1,'2019-II','2019-08-01','2019-12-30',1,1,0,'2019-08-24 14:21:40','2019-08-24 14:29:34',1),
 (2,'2019-I','2019-01-01','2019-06-30',0,1,0,'2019-08-24 14:22:06','2019-08-24 14:28:49',1),
 (3,'asdasd','2019-08-06','2019-08-30',0,1,1,'2019-08-24 14:28:49','2019-08-24 14:29:34',1);
/*!40000 ALTER TABLE `semestres` ENABLE KEYS */;


--
-- Definition of table `talleresparticipantes`
--

DROP TABLE IF EXISTS `talleresparticipantes`;
CREATE TABLE `talleresparticipantes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `participantes` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `eventocultural_id` int(11) NOT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`),
  KEY `fk_talleresparticipantes_eventoculturals1_idx` (`eventocultural_id`),
  CONSTRAINT `fk_talleresparticipantes_eventoculturals1` FOREIGN KEY (`eventocultural_id`) REFERENCES `eventoculturals` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `talleresparticipantes`
--

/*!40000 ALTER TABLE `talleresparticipantes` DISABLE KEYS */;
INSERT INTO `talleresparticipantes` (`id`,`nombre`,`fecha`,`participantes`,`activo`,`borrado`,`created_at`,`updated_at`,`eventocultural_id`,`observaciones`) VALUES 
 (1,'taller','2019-05-01',15,1,0,'2019-09-15 13:41:58','2019-09-15 13:42:33',2,'obs');
/*!40000 ALTER TABLE `talleresparticipantes` ENABLE KEYS */;


--
-- Definition of table `tallers`
--

DROP TABLE IF EXISTS `tallers`;
CREATE TABLE `tallers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(500) DEFAULT NULL,
  `descripcion` text,
  `docentecargo` varchar(500) DEFAULT NULL,
  `dnidocente` varchar(20) DEFAULT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `semestre_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tallers`
--

/*!40000 ALTER TABLE `tallers` DISABLE KEYS */;
INSERT INTO `tallers` (`id`,`nombre`,`descripcion`,`docentecargo`,`dnidocente`,`docente_id`,`activo`,`borrado`,`created_at`,`updated_at`,`semestre_id`) VALUES 
 (1,'asda','asd','Cristian Fernando Chavez Torres','47331640',4,1,1,'2019-09-15 14:41:13','2019-09-15 14:42:48',1),
 (2,'danza','dnazas p','Diana Quiroz Ortega','14785236',3,1,0,'2019-09-15 14:41:18','2019-09-15 14:44:10',1);
/*!40000 ALTER TABLE `tallers` ENABLE KEYS */;


--
-- Definition of table `tesis`
--

DROP TABLE IF EXISTS `tesis`;
CREATE TABLE `tesis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProyecto` varchar(500) DEFAULT NULL,
  `autor` varchar(500) DEFAULT NULL,
  `fuenteFinanciamiento` varchar(500) DEFAULT NULL,
  `escuela2_id` int(11) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `escuela_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tesis_escuelas1_idx` (`escuela_id`),
  CONSTRAINT `fk_tesis_escuelas1` FOREIGN KEY (`escuela_id`) REFERENCES `escuelas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tesis`
--

/*!40000 ALTER TABLE `tesis` DISABLE KEYS */;
/*!40000 ALTER TABLE `tesis` ENABLE KEYS */;


--
-- Definition of table `tipodatos`
--

DROP TABLE IF EXISTS `tipodatos`;
CREATE TABLE `tipodatos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) DEFAULT NULL,
  `descripcion` varchar(2000) DEFAULT NULL,
  `tipo` tinyint(4) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipodatos`
--

/*!40000 ALTER TABLE `tipodatos` DISABLE KEYS */;
INSERT INTO `tipodatos` (`id`,`titulo`,`descripcion`,`tipo`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Centros de Cómputo','N° Centros de Computo',2,1,0,NULL,NULL),
 (2,'Cantidad de Equipos de Cómputo','N° de Equipos de Cómputo',3,1,0,NULL,NULL),
 (3,'Bibliotecas Especializadas','N° Bibliotecas Especializadas',1,1,0,NULL,NULL),
 (4,'Libros por Especialidad','Libros por Especialidad',3,1,0,NULL,NULL),
 (5,'Convenio','Convenios',4,1,0,NULL,NULL),
 (6,'Actividades Programadas','Actividades Programadas',4,1,0,NULL,NULL),
 (7,'Alumnos Matriculados','N° Alumnos Matriculados',1,1,0,NULL,NULL),
 (8,'Docentes Nombrados','N° Docentes Nombrados',1,1,0,NULL,NULL),
 (9,'Docentes Contratados','N° Docentes Contratados',1,1,0,NULL,NULL),
 (10,'Docentes Locación de Servicios','N° Docentes Locación de Servicios',1,1,0,NULL,NULL),
 (11,'Docentes con Maestría','N° Docentes Maestría',1,1,0,NULL,NULL),
 (12,'Docentes con Doctorado','N° Docentes Doctorado',1,1,0,NULL,NULL),
 (13,'Administrativos Nombrados','N° Administrativos Nombrados',1,1,0,NULL,NULL),
 (14,'Administrativos Contratados','N° Administrativos Contratados',1,1,0,NULL,NULL),
 (15,'Administrativos Locación de Servicios','N° Administrativos Locación de Servicios',1,1,0,NULL,NULL),
 (16,'Administrativos con Maestría','N° Administrativos Maestría',1,1,0,NULL,NULL),
 (17,'Administrativos con Doctorado','N° Administrativos Doctorado',1,1,0,NULL,NULL),
 (18,'Cantidad de Egresados','N° Egresados',1,1,0,NULL,NULL);
/*!40000 ALTER TABLE `tipodatos` ENABLE KEYS */;


--
-- Definition of table `tipousers`
--

DROP TABLE IF EXISTS `tipousers`;
CREATE TABLE `tipousers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tipousers`
--

/*!40000 ALTER TABLE `tipousers` DISABLE KEYS */;
INSERT INTO `tipousers` (`id`,`nombre`,`descripcion`,`activo`,`borrado`,`created_at`,`updated_at`) VALUES 
 (1,'Superadministrador','sa',1,0,NULL,NULL),
 (2,'Administrador','admin',1,0,NULL,NULL),
 (3,'Digitador','digit',1,0,NULL,NULL);
/*!40000 ALTER TABLE `tipousers` ENABLE KEYS */;


--
-- Definition of table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL,
  `remember_token` varchar(500) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  `borrado` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipouser_id` int(11) NOT NULL,
  `persona_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_tipousers_idx` (`tipouser_id`),
  KEY `fk_users_personas1_idx` (`persona_id`),
  CONSTRAINT `fk_users_personas1` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_tipousers` FOREIGN KEY (`tipouser_id`) REFERENCES `tipousers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`,`name`,`email`,`password`,`remember_token`,`activo`,`borrado`,`created_at`,`updated_at`,`tipouser_id`,`persona_id`) VALUES 
 (1,'admin','cristian_7_70@hotmail.com','$2y$10$8R0Wn4QFvXNfiCdfM3XgIO36/Cw.qBEsJ9VMc1wls0pbK4Sx2cjES',NULL,1,0,NULL,NULL,1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
