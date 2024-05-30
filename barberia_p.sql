-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2024 a las 01:04:46
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `barberia_p`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id_admin`, `usuario`, `contraseña`) VALUES
(1, 'admin_2024', '4Dm1n_2024');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `cliente` varchar(300) NOT NULL,
  `tel` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `id_servicio` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `cliente`, `tel`, `email`, `id_servicio`, `id_empleado`, `fecha`, `hora`, `estado`) VALUES
(4, 'Jeon Jeha', 34565677, 'hyungdelpiano@gmail.com', 1, 1, '2024-05-27', '12:30:00', 1),
(7, 'Daemian Kim', 12345678, 'kdgs2014@gmail.com', 3, 1, '2024-05-30', '22:00:00', 1),
(8, 'Kim Jooan', 33334567, 'jaybp63@boysplanet.com', 6, 4, '2024-06-05', '12:30:00', 1),
(9, 'Kim Hwan', 45777777, 'wonteo@jin.com', 5, 2, '2024-05-30', '09:00:00', 1),
(10, 'Daemian Kim', 34567899, 'jaybp63@boysplanet.com', 2, 4, '2024-05-31', '09:30:00', 1),
(11, 'Julian Alvarez', 12346776, 'jaybp63@boysplanet.com', 2, 4, '2024-05-31', '11:00:00', 1),
(12, 'Luis Lopez', 23452344, 'llopez@gmail.com', 6, 4, '2024-05-31', '12:30:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `usuario`, `code`) VALUES
(1, 'Barbero 1', 'barber_1', 'B4rb3r1'),
(2, 'Barbero 2', 'barber_2', 'b4rBEr2'),
(4, 'Barbero principal', 'admin_2024', '4Dm1n_2024');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE `salida` (
  `id_salida` int(11) NOT NULL,
  `id_cita` int(11) NOT NULL,
  `costo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicios` int(11) NOT NULL,
  `servicio` varchar(100) NOT NULL,
  `precio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id_servicios`, `servicio`, `precio`) VALUES
(1, 'Corte Clasico', 20),
(2, 'Corte con Tijera', 35),
(3, 'Corte Fade', 35),
(4, 'Colochos', 250),
(5, 'Keratina', 350),
(6, 'Cortes Modernos', 50);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `id_servicio` (`id_servicio`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`id_salida`),
  ADD KEY `id_cita` (`id_cita`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicios`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `salida`
--
ALTER TABLE `salida`
  MODIFY `id_salida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `cita_ibfk_1` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicios`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cita_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `salida`
--
ALTER TABLE `salida`
  ADD CONSTRAINT `salida_ibfk_1` FOREIGN KEY (`id_cita`) REFERENCES `cita` (`id_cita`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
