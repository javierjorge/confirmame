-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2013 at 03:18 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `confirmame`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacto`
--

CREATE TABLE IF NOT EXISTS `contacto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `id_contacto_de_usuario` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `invitaciones` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `contacto`
--

INSERT INTO `contacto` (`id`, `id_usuario`, `id_contacto_de_usuario`, `email`, `nombre`, `apellido`, `invitaciones`) VALUES
(10, 5, 4, 'eldamo83@hotmail.com', 'Damian', 'Godenzi', 0),
(11, 0, 5, 'jorge_fj@hotmail.com', 'Javier', 'J', 0);

-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

CREATE TABLE IF NOT EXISTS `evento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` text,
  `fecha` date DEFAULT NULL,
  `hora_desde` time DEFAULT NULL,
  `hora_hasta` time DEFAULT NULL,
  `fecha_venc` date DEFAULT NULL,
  `cancelado` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`id`, `id_usuario`, `nombre`, `descripcion`, `fecha`, `hora_desde`, `hora_hasta`, `fecha_venc`, `cancelado`) VALUES
(5, 4, 'Haceme el diseño', 'hace el diseño de la pagina', '0000-00-00', '09:00:00', '18:00:00', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invitacion`
--

CREATE TABLE IF NOT EXISTS `invitacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_evento` int(11) DEFAULT NULL,
  `id_contacto` int(11) DEFAULT NULL,
  `confirma` int(11) DEFAULT NULL,
  `cantidad_enviadas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `invitacion`
--

INSERT INTO `invitacion` (`id`, `id_evento`, `id_contacto`, `confirma`, `cantidad_enviadas`) VALUES
(8, 5, 10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `posibles_usuarios`
--

CREATE TABLE IF NOT EXISTS `posibles_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `activo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `email`, `password`, `activo`) VALUES
(4, 'Javier', 'Jorge', 'fjjorge@gmail.com', 'Pruebas1', 1),
(5, 'Damian', 'G', 'eldamo83@hotmail.com', '123456', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
