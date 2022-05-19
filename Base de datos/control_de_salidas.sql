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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`control_de_salidas` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `control_de_salidas`;

/*Table structure for table `alumno` */

DROP TABLE IF EXISTS `alumno`;

CREATE TABLE `alumno` (
  `nia` char(8) NOT NULL,
  `nombre` char(20) NOT NULL,
  `apellido_1` char(20) NOT NULL,
  `apellido_2` char(20) DEFAULT NULL,
  `id_curso` char(30) NOT NULL,
  PRIMARY KEY (`nia`),
  KEY `FK_alumno_curso` (`id_curso`),
  CONSTRAINT `FK_alumno_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`nombre`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `alumno` */

insert  into `alumno`(`nia`,`nombre`,`apellido_1`,`apellido_2`,`id_curso`) values 
('1','Adrian','Andreu','Marti','1º ESO'),
('2','Jaime','Navarro','Menarguez','1º ESO'),
('3','Salva','Perez','ErPELU','4º ESO'),
('4','Nico','Palaoro','las','2º ESO'),
('5','Juan','Martinez','Escobar','3º ESO'),
('6','Lucas','Santos','Juarez','2º ESO');

/*Table structure for table `control` */

DROP TABLE IF EXISTS `control`;

CREATE TABLE `control` (
  `observaciones` char(200) DEFAULT NULL,
  `fecha_registrar` datetime NOT NULL,
  `fecha_fin_actividad` datetime DEFAULT NULL,
  `fecha_llegada` datetime DEFAULT NULL,
  `autorizado` tinyint(1) NOT NULL,
  `id_alumno` char(8) NOT NULL,
  `id_personal_de_autorizacion_registrar` char(80) NOT NULL,
  `id_personal_de_autorizacion_fin_actividad` char(80) NOT NULL,
  `id_personal_de_autorizacion_llegada` char(80) NOT NULL,
  `id_motivo` char(30) NOT NULL,
  PRIMARY KEY (`fecha_registrar`,`id_alumno`,`id_personal_de_autorizacion_registrar`),
  KEY `FK_control_alumno` (`id_alumno`),
  KEY `FK_control_motivo` (`id_motivo`),
  KEY `FK_control_personal_de_autorizacion_registrar` (`id_personal_de_autorizacion_registrar`),
  KEY `FK_control_personal_de_autorizacion_fin_actividad` (`id_personal_de_autorizacion_fin_actividad`),
  KEY `FK_control_personal_de_autorizacion_llegada` (`id_personal_de_autorizacion_llegada`),
  CONSTRAINT `FK_control_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`nia`) ON UPDATE CASCADE,
  CONSTRAINT `FK_control_motivo` FOREIGN KEY (`id_motivo`) REFERENCES `motivo` (`nombre`) ON UPDATE CASCADE,
  CONSTRAINT `FK_control_personal_de_autorizacion_fin_actividad` FOREIGN KEY (`id_personal_de_autorizacion_fin_actividad`) REFERENCES `personal_de_autorizacion` (`email`) ON UPDATE CASCADE,
  CONSTRAINT `FK_control_personal_de_autorizacion_llegada` FOREIGN KEY (`id_personal_de_autorizacion_llegada`) REFERENCES `personal_de_autorizacion` (`email`) ON UPDATE CASCADE,
  CONSTRAINT `FK_control_personal_de_autorizacion_registrar` FOREIGN KEY (`id_personal_de_autorizacion_registrar`) REFERENCES `personal_de_autorizacion` (`email`) ON UPDATE CASCADE
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
('Ir a secretaria',NULL),
('Ir al baño',NULL),
('No tiene autorizacion',NULL),
('otro',NULL),
('Se va de excursion',NULL),
('Sus padres se lo llevan',NULL);

/*Table structure for table `personal_de_autorizacion` */

DROP TABLE IF EXISTS `personal_de_autorizacion`;

CREATE TABLE `personal_de_autorizacion` (
  `email` char(80) NOT NULL,
  `nombre` char(30) NOT NULL,
  `apellido_1` char(20) NOT NULL,
  `apellido_2` char(20) DEFAULT NULL,
  `contrasenya` char(25) NOT NULL,
  `tipo` enum('profesor','administrador','secretaría') NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `personal_de_autorizacion` */

insert  into `personal_de_autorizacion`(`email`,`nombre`,`apellido_1`,`apellido_2`,`contrasenya`,`tipo`) values 
('domingo@gmail.com','Domingo','Lunes','Martes','domingo1234','secretaría'),
('isabelingles@gmail.com','isabel','ingles','nativo','ingles1234','profesor'),
('lamari@gmail.com','Mari','programacion','sitemas','systemout1234','administrador'),
('victorsarabia@gmail.com','Victor','Sarabia','Palos','elcampico1234','profesor');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
