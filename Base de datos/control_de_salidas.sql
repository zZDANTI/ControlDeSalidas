/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 10.4.21-MariaDB : Database - control_de_salidas
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*`control`/`control_de_salidas` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `control_de_salidas`;

/*Table structure for table `alumno` */

DROP TABLE IF EXISTS `alumno`;

CREATE TABLE `alumno` (
  `nia` CHAR(8) NOT NULL,
  `nombre` CHAR(20) NOT NULL,
  `apellido_1` CHAR(20) NOT NULL,
  `apellido_2` CHAR(20) DEFAULT NULL,
  `id_curso` CHAR(30) NOT NULL,
  PRIMARY KEY (`nia`),
  KEY `FK_alumno_curso` (`id_curso`),
  CONSTRAINT `FK_alumno_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`nombre`) ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8;

/*Data for the table `alumno` */

INSERT  INTO `alumno`(`nia`,`nombre`,`apellido_1`,`apellido_2`,`id_curso`) VALUES 
('10','Raul','Mora','Gomez','2º ESO'),
('11','Jesús','Ruiz','Santos','3º ESO'),
('12','Fabián','Gil','Martinez','2º ESO'),
('13','Diego','Diaz','Rubio','2º ESO'),
('14','Luis','Flores','Mora','3º ESO'),
('15','Paco','Leon','Vidal','3º ESO'),
('16','Diego','Caballero','Iglesias','4º ESO'),
('17','Daniel','Rosa','Rodriguez','4º ESO'),
('18','Jose','Rosa','Rodriguez','4º ESO'),
('19','Carlos','Rosa','Rodriguez','4º ESO'),
('20','Alex','Lopez','Sanchez','3º ESO'),
('21','Hugo','Ruiz','Las','1º ESO'),
('22','Leo','Sanchez','Martinez','2º ESO'),
('23','Ness','Moreno','Cabrera','3º ESO'),
('24','Joaquín','Muñoz','Martin','3º ESO'),
('25','Iván','Prieto','Cruz','4º ESO'),
('26','Ness','Calvo','Vega','3º ESO'),
('27','Alex','Torres','Soto','1º ESO'),
('28','Antonio','Leon','Marquez','2º ESO'),
('29','Aitana','Vinal','Reyes','2º ESO'),
('30','Ness','Vega','Calvo','4º ESO'),
('31','Alex','Cabreras','Campos','4º ESO'),
('32','Pablo','Mora','Roman','1º ESO'),
('33','Martín','Campos','Soto','2º ESO'),
('34','Alejandro','Calvo','Prieto','3º ESO'),
('35','Daniel','Reyes','Cruz','3º ESO'),
('5','Juan','Martinez','Escobar','3º ESO'),
('6','Lucas','Santos','Juarez','2º ESO'),
('7','Juan','Garcia','Pérez','1º ESO'),
('8','Antonio','Lozano','Santos','1º ESO'),
('9','Violeta','Ballester','Castillo','1º ESO');

/*Table structure for table `control` */

DROP TABLE IF EXISTS `control`;

CREATE TABLE `control` (
  `observaciones` varchar(500) DEFAULT NULL,
  `fecha_registrar` datetime NOT NULL,
  `fecha_fin_actividad` datetime DEFAULT NULL,
  `fecha_llegada` datetime DEFAULT NULL,
  `autorizado` tinyint(1) NOT NULL,
  `id_alumno` char(8) NOT NULL,
  `id_personal_registrar` char(80) NOT NULL,
  `id_personal_fin_actividad` char(80) DEFAULT NULL,
  `id_personal_llegada` char(80) DEFAULT NULL,
  `id_motivo` char(30) NOT NULL,
  PRIMARY KEY (`fecha_registrar`,`id_alumno`,`id_personal_registrar`),
  KEY `FK_control_alumno` (`id_alumno`),
  KEY `FK_control_motivo` (`id_motivo`),
  KEY `FK_control_personal_registrar` (`id_personal_registrar`),
  KEY `FK_control_personal_fin_actividad` (`id_personal_fin_actividad`),
  KEY `FK_control_personal_llegada` (`id_personal_llegada`),
  CONSTRAINT `FK_control_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`nia`) ON UPDATE CASCADE,
  CONSTRAINT `FK_control_motivo` FOREIGN KEY (`id_motivo`) REFERENCES `motivo` (`nombre`) ON UPDATE CASCADE,
  CONSTRAINT `FK_control_personal_fin_actividad` FOREIGN KEY (`id_personal_fin_actividad`) REFERENCES `personal` (`email`) ON UPDATE CASCADE,
  CONSTRAINT `FK_control_personal_llegada` FOREIGN KEY (`id_personal_llegada`) REFERENCES `personal` (`email`) ON UPDATE CASCADE,
  CONSTRAINT `FK_control_personal_registrar` FOREIGN KEY (`id_personal_registrar`) REFERENCES `personal` (`email`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `control` */

/*Table structure for table `curso` */

DROP TABLE IF EXISTS `curso`;

CREATE TABLE `curso` (
  `nombre` char(30) NOT NULL,
  `fecha_baja` datetime DEFAULT NULL,
  PRIMARY KEY (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `curso` */

insert  into `curso`(`nombre`,`fecha_baja`) values 
('1º ESO',NULL),
('2º ESO',NULL),
('3º ESO',NULL),
('4º ESO',NULL);

/*Table structure for table `motivo` */

DROP TABLE IF EXISTS `motivo`;

CREATE TABLE `motivo` (
  `nombre` char(30) NOT NULL,
  `fecha_de_baja` datetime DEFAULT NULL,
  PRIMARY KEY (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `motivo` */

insert  into `motivo`(`nombre`,`fecha_de_baja`) values 
('',NULL),
('Ir a secretaria',NULL),
('Ir al baño',NULL),
('No tiene autorizacion',NULL),
('Otros',NULL),
('Sus padres se lo llevan',NULL);

/*Table structure for table `personal` */

DROP TABLE IF EXISTS `personal`;

CREATE TABLE `personal` (
  `email` char(80) NOT NULL,
  `nombre` char(30) NOT NULL,
  `apellido_1` char(20) NOT NULL,
  `apellido_2` char(20) DEFAULT NULL,
  `contrasenya` char(64) NOT NULL,
  `tipo` enum('profesor','administrador','secretaría') NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `personal` */

insert  into `personal`(`email`,`nombre`,`apellido_1`,`apellido_2`,`contrasenya`,`tipo`) values 
('david@elcampico.org','David','Sanchez','Vega','david1234','profesor'),
('maria@elcampico.org','Maria','Calvo','Cruz','maria1234','secretaría'),
('pepe@elcampico.org','Pepe','Martin','Mora','pepe1234','secretaría'),
('tere@elcampico.org','Tere','Vinal','Pérez','tere1234','administrador'),
('trino@elcampico.org','Trino','Navarro','Gomez','trino1234','administrador'),
('victor@elcampico.org','Victor','Sarabia','Palos','elcampico1234','profesor');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
