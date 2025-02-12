-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-05-2017 a las 09:34:59
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
CREATE DATABASE discografia;
USE discografia;
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistas`
--

CREATE TABLE `artistas` (
  `idartista` int(11) NOT NULL,
  `nombre` varchar(128) CHARACTER SET latin1 NOT NULL,
  `nacionalidad` varchar(128) CHARACTER SET latin1 NOT NULL,
  `instrumento` varchar(255) CHARACTER SET latin1 NOT NULL,
  `biografia` text CHARACTER SET latin1 NOT NULL,
  `website` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `artistas`
--

INSERT INTO `artistas` (`idartista`, `nombre`, `nacionalidad`, `instrumento`, `biografia`, `website`) VALUES
(1, 'Dave Gahan', 'Reino Unido', 'vocalista', '', ''),
(2, 'Martin Gore', 'Reino Unido', 'teclados', '', ''),
(3, 'Andy Fletcher', 'Reino Unido', 'teclados', '', ''),
(4, 'Alan Wilder', 'Reino Unido', 'teclados', '', ''),
(5, 'Vince Clarke', 'Reino Unido', 'teclados', '', ''),
(6, 'Anthony Kiedis', 'EEUU', 'vocalista', '', ''),
(7, 'Michael "Flea" Balzary', 'EEUU', 'bajo', '', ''),
(8, 'Chad Smith', 'EEUU', 'bateria', '', ''),
(9, 'John Frusciante', 'EEUU', 'guitarra', '', ''),
(10, 'Josh Klinghoffer', 'EEUU', 'guitarra', '', ''),
(11, 'Trent Reznor', 'EEUU', 'vocalista', '', ''),
(12, 'Alessandro Cortini', 'EEUU', 'teclados', '', ''),
(13, 'Atticus Ross', 'EEUU', 'teclados', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `idcancion` int(11) NOT NULL,
  `titulo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `duracion` int(11) NOT NULL,
  `autor` varchar(128) CHARACTER SET latin1 NOT NULL,
  `fecha-grabacion` date NOT NULL,
  `letra` text CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`idcancion`, `titulo`, `duracion`, `autor`, `fecha-grabacion`, `letra`) VALUES
(1, 'Enjoy the Silence', 0, '', '0000-00-00', ''),
(2, 'Personal Jesus', 0, '', '0000-00-00', ''),
(3, 'In your Room', 0, '', '0000-00-00', ''),
(4, 'Black Celebration', 0, '', '0000-00-00', ''),
(5, 'Never Let me Down Again', 0, '', '0000-00-00', ''),
(6, 'Master and Servant', 0, '', '0000-00-00', ''),
(7, 'It''s No Good', 0, '', '0000-00-00', ''),
(8, 'Strangelove', 0, '', '0000-00-00', ''),
(9, 'I Feel You', 0, '', '0000-00-00', ''),
(10, 'Walking in My Shoes', 0, '', '0000-00-00', ''),
(11, 'Condemnation', 0, '', '0000-00-00', ''),
(12, 'Behind the Wheel', 0, '', '0000-00-00', ''),
(13, 'But Not Tonight', 0, '', '0000-00-00', ''),
(14, 'Policy of Truth', 0, '', '0000-00-00', ''),
(15, 'Waiting for the Night', 0, '', '0000-00-00', ''),
(16, 'Barrel of a Gun', 0, '', '0000-00-00', ''),
(17, 'Under the bridge', 0, '', '0000-00-00', ''),
(18, 'Californicatio', 0, '', '0000-00-00', ''),
(19, 'Otherside', 0, '', '0000-00-00', ''),
(20, 'Give it Away', 0, '', '0000-00-00', ''),
(21, 'Dani California', 0, '', '0000-00-00', ''),
(22, 'By the Way', 0, '', '0000-00-00', ''),
(23, 'Dark Necessities', 0, '', '0000-00-00', ''),
(24, 'Snow', 0, '', '0000-00-00', ''),
(25, 'The Zephyr Song', 0, '', '0000-00-00', ''),
(26, 'Around the World', 0, '', '0000-00-00', ''),
(27, 'Can''t Stop', 0, '', '0000-00-00', ''),
(28, 'Scar Tissue', 0, '', '0000-00-00', ''),
(29, 'Suck my Kiss', 0, '', '0000-00-00', ''),
(30, 'Tell me Baby', 0, '', '0000-00-00', ''),
(31, 'Road Trippin''', 0, '', '0000-00-00', ''),
(32, 'Breaking the Girl', 0, '', '0000-00-00', ''),
(33, 'Aeroplane', 0, '', '0000-00-00', ''),
(34, 'Parallel Universe', 0, '', '0000-00-00', ''),
(35, 'Go Robot', 0, '', '0000-00-00', ''),
(36, 'Dosed', 0, '', '0000-00-00', ''),
(37, 'Hurt', 0, '', '0000-00-00', ''),
(38, 'Closer', 0, '', '0000-00-00', ''),
(39, 'march of the Pigs', 0, '', '0000-00-00', ''),
(40, 'The hand that Feeds', 0, '', '0000-00-00', ''),
(41, 'Every Day is Exactly the Same', 0, '', '0000-00-00', ''),
(42, 'Capital G', 0, '', '0000-00-00', ''),
(43, 'We''re in This Together', 0, '', '0000-00-00', ''),
(44, 'A Warm Place', 0, '', '0000-00-00', ''),
(45, 'Mr Self Destruction', 0, '', '0000-00-00', ''),
(46, 'Only', 0, '', '0000-00-00', ''),
(47, 'Survivalism', 0, '', '0000-00-00', ''),
(48, 'Piggy', 0, '', '0000-00-00', ''),
(49, 'Starfuckers, Inc.', 0, '', '0000-00-00', ''),
(50, 'All the Love in the World', 0, '', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cancionesdisco`
--

CREATE TABLE `cancionesdisco` (
  `iddisco` int(11) NOT NULL,
  `idcancion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `cancionesdisco`
--

INSERT INTO `cancionesdisco` (`iddisco`, `idcancion`) VALUES
(4, 6),
(5, 4),
(5, 13),
(6, 5),
(6, 8),
(6, 12),
(7, 1),
(7, 2),
(7, 14),
(7, 15),
(8, 3),
(8, 9),
(8, 10),
(8, 11),
(9, 7),
(9, 16),
(19, 17),
(19, 20),
(19, 29),
(19, 32),
(20, 33),
(21, 18),
(21, 19),
(21, 26),
(21, 28),
(21, 31),
(21, 34),
(22, 22),
(22, 25),
(22, 27),
(22, 36),
(23, 21),
(23, 24),
(23, 30),
(25, 23),
(25, 35),
(27, 37),
(27, 38),
(27, 39),
(27, 44),
(27, 45),
(27, 48),
(28, 43),
(28, 49),
(29, 40),
(29, 41),
(29, 46),
(29, 50),
(30, 42),
(30, 47);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `discos`
--

CREATE TABLE `discos` (
  `iddisco` int(11) NOT NULL,
  `titulo` varchar(80) CHARACTER SET latin1 NOT NULL,
  `anyo` int(50) NOT NULL,
  `idsello` int(11) NOT NULL,
  `cubierta` varchar(200) CHARACTER SET latin1 NOT NULL,
  `descripcion` text CHARACTER SET latin1 NOT NULL,
  `idgrupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `discos`
--

INSERT INTO `discos` (`iddisco`, `titulo`, `anyo`, `idsello`, `cubierta`, `descripcion`, `idgrupo`) VALUES
(1, 'Speak & Spell', 1981, 1, 'https://img.discogs.com/r69XF8qlTRGPslHbtnNeOMuHxPQ=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-56293-1175931119.jpeg.jpg', '', 1),
(2, 'A broken frame', 1982, 1, 'https://img.discogs.com/3ksDl3ekag2QtpSovWLzvw3JWPY=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-60662-1413145899-3784.jpeg.jpg', '', 1),
(3, 'Construction Time Again', 1983, 1, 'https://img.discogs.com/B_VvW-drCfOjB1DLEz6mzK-MNgU=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-126824-1176188524.jpeg.jpg', '', 1),
(4, 'Some Great Reward', 1984, 1, 'https://img.discogs.com/QKIdDzhP3yodP1LKK0V9oQCp-UE=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-65445-1176188671.jpeg.jpg', '', 1),
(5, 'Black celebration', 1986, 1, 'https://img.discogs.com/n3Pu6TkaBBD-CSg6J9ruI05d2GE=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-65449-1319726932.jpeg.jpg', '', 1),
(6, 'Music for the masses', 1987, 1, 'https://img.discogs.com/9Femo41s3vD_APbqD2trcBgd3Jk=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-85252-1360378223-8056.jpeg.jpg', '', 1),
(7, 'Violator', 1990, 1, 'https://img.discogs.com/04M7t7rQc_D5Mk7N1q4FOnU00QY=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-46905-1364082461-3242.jpeg.jpg', '', 1),
(8, 'Songs of faith and devotion', 1993, 1, 'https://img.discogs.com/kwBDgdoaR8ENhzzaORMZGOIUC28=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-57541-1270138042.jpeg.jpg', '', 1),
(9, 'ULTRA', 1997, 1, 'https://img.discogs.com/pQaefC-oPXIdaui8hGbaiqkAXNs=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-31636-1362850101-2016.jpeg.jpg', '', 1),
(10, 'Exciter', 2001, 1, 'https://img.discogs.com/oWvJE5Q0yCMWc5gPbHmZ6tnn6aE=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-23176-1408100138-1843.jpeg.jpg', '', 1),
(11, 'Playing the angel', 2005, 1, 'https://img.discogs.com/epEX4Qd7KWazD45AU6g4pmL6eiY=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-545137-1368263749-1059.jpeg.jpg', '', 1),
(12, 'Sounds of the Universe', 2009, 1, 'https://img.discogs.com/GsPeYGw92tlrQBqkQAibEjQKgA8=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-1734870-1303562390.jpeg.jpg', '', 1),
(13, 'Delta Machine', 2013, 1, 'https://img.discogs.com/J9akUYTj31f0gOjckjh9hxk_0rw=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-4402947-1363962110-8195.jpeg.jpg', '', 1),
(14, 'Spirit', 2017, 1, 'https://img.discogs.com/CMqm7auAlAYjjFb22IXM5CCgmhg=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-9950965-1489783574-3815.jpeg.jpg', '', 1),
(15, 'The Red Hot Chili Peppers ', 1984, 2, 'https://img.discogs.com/4HWGMGceEOli4SPEntZp___3HEM=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-687880-1225352853.jpeg.jpg', '', 3),
(16, 'Freaky Styley', 1985, 2, 'https://img.discogs.com/9c_fdldma5nZ5lPnSinBSlm3cFo=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-687169-1164933559.jpeg.jpg', '', 3),
(17, 'The Uplift Mofo Party Plan', 1987, 2, 'https://img.discogs.com/SY7vitkas6WQaJOr2e613-6xUOE=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-689739-1348468233-7071.jpeg.jpg', '', 3),
(18, 'Mother''s Milk', 1989, 2, 'https://img.discogs.com/dGFDTkFDBgJt_3dRPWPIbJ5Eo5w=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-3268280-1327859423.jpeg.jpg', '', 3),
(19, 'Blood Sugar Sex Magik', 1991, 2, 'https://img.discogs.com/lMrFxP4Ha7737EkbDirBENrWkTo=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-1119354-1193563629.jpeg.jpg', '', 3),
(20, 'One Hot Minute', 1995, 2, 'https://img.discogs.com/YN-H9gxfIfb-FheHVu0Wg7HGHgI=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-367895-1461290174-6757.jpeg.jpg', '', 3),
(21, 'Californication', 1999, 2, 'https://img.discogs.com/rARwVRPSO6XUJh_NBK8YZDb1yVY=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-403972-1356280838-5510.jpeg.jpg', '', 3),
(22, 'By the Way', 2002, 2, 'https://img.discogs.com/VSE24zAdeY0v3h0h2p9YGBgTJUc=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-1162737-1197254678.jpeg.jpg', '', 3),
(23, 'Stadium Arcadium', 2006, 2, 'https://img.discogs.com/Ov94EudFoEXmWvMbar2AneOGo9I=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-681721-1149476525.jpeg.jpg', '', 3),
(24, 'I''m with You', 2011, 2, 'https://img.discogs.com/CX4RpAbsz-4hv7fG8xloOeg8slM=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-3073711-1315252087.jpeg.jpg', '', 3),
(25, 'The Getaway', 2016, 2, 'https://img.discogs.com/SBmQ_FqAta4SvXo7PWH_7LVFBZE=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-8651167-1465932755-4011.jpeg.jpg', '', 3),
(26, 'Pretty Hate Machine', 1989, 3, 'https://img.discogs.com/BU7A2nRxKIpEgz66-_JUjCt87g0=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-75544-1268423786.jpeg.jpg', '', 2),
(27, 'The Downward Spiral', 1994, 3, 'https://img.discogs.com/1z_THuOoyHZZKOEF3e7SC-YUwic=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-4404-1169671952.jpeg.jpg', '', 2),
(28, 'The Fragile', 1999, 3, 'https://img.discogs.com/lQPmL54qGmv9m1eGiE6cE6xAneI=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-4405-1462046686-7708.jpeg.jpg', '', 2),
(29, 'With Teeth', 2005, 3, 'https://img.discogs.com/ibPgMlNZsRuFZmelVTyueYTFgoU=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-448222-1242481158.jpeg.jpg', '', 2),
(30, 'Year Zero', 2007, 3, 'https://img.discogs.com/ThKepuf9BjRK5OUBI4vOfdnOR-8=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-951224-1231169770.jpeg.jpg', '', 2),
(31, 'Ghosts I?IV', 2008, 3, 'https://img.discogs.com/qRzGfsHdK--Q9L0G6XCANtdqy_o=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-1262566-1204749587.jpeg.jpg', '', 2),
(32, 'The Slip', 2008, 3, 'https://img.discogs.com/q2sr6Dt5b1blEaSev6a6Cz4Tr4c=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-1327658-1209973759.jpeg.jpg', '', 2),
(33, 'Hesitation Marks', 2013, 3, 'https://img.discogs.com/u_k0UxBDW-xjG7T0QkuAGkeRZ68=/100x100/filters:strip_icc():format(jpeg):mode_rgb():quality(40)/discogs-images/R-4864835-1440897282-6601.jpeg.jpg', '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `idgrupo` int(11) NOT NULL,
  `nombre` varchar(128) CHARACTER SET latin1 NOT NULL,
  `nacionalidad` varchar(128) CHARACTER SET latin1 NOT NULL,
  `idioma` varchar(128) CHARACTER SET latin1 NOT NULL,
  `descripción` text CHARACTER SET latin1 NOT NULL,
  `website` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `grupos`
--

INSERT INTO `grupos` (`idgrupo`, `nombre`, `nacionalidad`, `idioma`, `descripción`, `website`) VALUES
(1, 'Depeche Mode', 'Reino Unido', 'inglés', 'a', 'dm.com'),
(2, 'Nine Inch Nails', 'EEUU', 'inglés', 'b', 'nin.com'),
(3, 'Red Hot Chilli Peppers', 'EEUU', 'inglés', 'c', 'redhot.com'),
(4, 'Nirvana', 'EEUU', 'inglés', 'd', 'nirvana.org'),
(5, 'Foo Fighters', 'EEUU', 'inglés', 'e', 'foofighters.com'),
(6, 'Kraftwerk', 'Alemania', 'alemán', 'f', 'kraftwerk.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `integrantes`
--

CREATE TABLE `integrantes` (
  `idgrupo` int(11) NOT NULL,
  `idartista` int(11) NOT NULL,
  `idrol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `integrantes`
--

INSERT INTO `integrantes` (`idgrupo`, `idartista`, `idrol`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 2, 2),
(1, 2, 3),
(1, 3, 2),
(1, 4, 2),
(1, 5, 2);


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idrol` int(11) NOT NULL,
  `nombre` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idrol`, `nombre`) VALUES
(1, 'Vocalista'),
(2, 'Teclados'),
(3, 'Guitarra'),
(4, 'Bajo'),
(5, 'Batería'),
(6, 'Coros'),
(7, 'Orquestaciones'),
(8, 'Trompeta'),
(9, 'Vocalista'),
(10, 'Teclados'),
(11, 'Guitarra'),
(12, 'Bajo'),
(13, 'Batería'),
(14, 'Coros'),
(15, 'Orquestaciones'),
(16, 'Trompeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sellos`
--

CREATE TABLE `sellos` (
  `idsello` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `director` varchar(128) NOT NULL,
  `telefono` int(11) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sellos`
--

INSERT INTO `sellos` (`idsello`, `nombre`, `director`, `telefono`, `direccion`, `website`) VALUES
(1, 'Mute records', '', 1, '', ''),
(2, 'Warner Bros', '', 22, '', ''),
(3, 'Independiente', '', 33, '', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artistas`
--
ALTER TABLE `artistas`
  ADD PRIMARY KEY (`idartista`);

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD PRIMARY KEY (`idcancion`);

--
-- Indices de la tabla `cancionesdisco`
--
ALTER TABLE `cancionesdisco`
  ADD PRIMARY KEY (`iddisco`,`idcancion`),
  ADD KEY `iddisco` (`iddisco`),
  ADD KEY `idcancion` (`idcancion`);

--
-- Indices de la tabla `discos`
--
ALTER TABLE `discos`
  ADD PRIMARY KEY (`iddisco`),
  ADD KEY `idgrupo` (`idgrupo`),
  ADD KEY `idsello` (`idsello`);

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`idgrupo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idrol`);

--
-- Indices de la tabla `sellos`
--
ALTER TABLE `sellos`
  ADD PRIMARY KEY (`idsello`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `artistas`
--
ALTER TABLE `artistas`
  MODIFY `idartista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
  MODIFY `idcancion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT de la tabla `discos`
--
ALTER TABLE `discos`
  MODIFY `iddisco` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `idgrupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idrol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `sellos`
--
ALTER TABLE `sellos`
  MODIFY `idsello` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cancionesdisco`
--
ALTER TABLE `cancionesdisco`
  ADD CONSTRAINT `cancionesdisco_ibfk_1` FOREIGN KEY (`iddisco`) REFERENCES `discos` (`iddisco`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cancionesdisco_ibfk_2` FOREIGN KEY (`idcancion`) REFERENCES `canciones` (`idcancion`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `discos`
--
ALTER TABLE `discos`
  ADD CONSTRAINT `discos_ibfk_1` FOREIGN KEY (`idgrupo`) REFERENCES `grupos` (`idgrupo`) ON UPDATE CASCADE,
  ADD CONSTRAINT `discos_ibfk_2` FOREIGN KEY (`idsello`) REFERENCES `sellos` (`idsello`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
