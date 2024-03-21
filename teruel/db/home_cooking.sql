-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-07-2022 a las 23:38:25
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `home_cooking`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `categoria` varchar(15) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`categoria`, `id`) VALUES
('comida', 2),
('postre', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(10) NOT NULL,
  `usuario_id` varchar(10) NOT NULL,
  `comida_id` varchar(10) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_comentario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id`, `usuario_id`, `comida_id`, `comentario`, `fecha_comentario`) VALUES
(1, '1', '2', 'texto', '2022-06-11 03:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidas`
--

CREATE TABLE `comidas` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usuarios_id` int(10) NOT NULL,
  `paises_id` int(10) NOT NULL,
  `categorias_id` tinyint(1) NOT NULL,
  `procedimiento` text,
  `ingredientes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `comidas`
--

INSERT INTO `comidas` (`id`, `nombre`, `descripcion`, `fecha`, `usuarios_id`, `paises_id`, `categorias_id`, `procedimiento`, `ingredientes`) VALUES
(53, 'Galletas_de_manteca', '<p>Galletas de mantequilla caseras</p>', '2022-07-26 01:19:55', 0, 3, 2, 'Lo primero, ponemos la mantequilla a temperatura ambiente en un bol junto al azúcar y lo mezclamos todo con una varilla o con un tenedor.', 'Manteca'),
(54, 'Nuggets_caseros', 'Receta de nuggets de pollo caseras faciles ', '2022-07-13 06:44:56', 0, 4, 2, 'Ponemos en un bol la carne picada de pollo y salpimentamos. Después, quitamos la corteza a la rebanada de pan de mole y la añadimos al bol junto a la carne picada. Añadimos un chorro de leche. La miga y la leche, serán lo que les de esa cremosidad que queremos, al interior de la nugget de pollo. Añadimos, si lo deseamos, el queso y mezclamos todo con ayuda de la mano o una cuchara, hasta que quede todo bien integrado. Después, se puede dejar reposar unos minutos en el frigorífico para que se compacte la masa.', 'Huevos'),
(55, 'Bizcocho_de_zanahori', 'Bizcocho de zanahoria casero. También conocido como pastel de zanahoria.', '2022-07-13 06:48:47', 0, 23, 1, 'Rallamos o picamos la zanahoria. Una vez rallada, la ponemos en una batidora americana. Añadimos el aceite y trituramos todo. También puedes triturar con una batidora manual.', 'Azucar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `comida_id` int(8) NOT NULL,
  `usuario_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`comida_id`, `usuario_id`) VALUES
(7, 7),
(24, 7),
(7, 7),
(27, 7),
(31, 7),
(30, 7),
(5, 7),
(48, 7),
(52, 7),
(52, 7),
(53, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `like_comentarios`
--

CREATE TABLE `like_comentarios` (
  `comentario_id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `like_comidas`
--

CREATE TABLE `like_comidas` (
  `comida_id` int(10) NOT NULL,
  `usuario_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE `paises` (
  `id` int(10) NOT NULL,
  `pais` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`id`, `pais`) VALUES
(1, 'Argentina'),
(2, 'Bolivia'),
(3, 'Brasil'),
(4, 'Chile'),
(5, 'Perú'),
(6, 'Venezuela'),
(7, 'Ecuador'),
(8, 'Colombia'),
(9, 'Costa_Rica'),
(10, 'Guatemala'),
(11, 'El_Salvador'),
(12, 'Panamá'),
(13, 'China'),
(14, 'Japón'),
(15, 'India'),
(16, 'Tailandia'),
(17, 'Arabia_Saudita'),
(18, 'España'),
(19, 'Portugal'),
(20, 'Francia'),
(21, 'Alemania'),
(22, 'Italia'),
(23, 'Inglaterra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `usuarios` varchar(20) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `genero` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuarios`, `nombre`, `genero`, `mail`, `password`, `fecha_creacion`) VALUES
(12, 'Tam', 'Camila Tamara', 'Mujer', 'tam@gmail.com', '202cb962ac59075b964b', '2022-07-13 06:28:11'),
(13, 'Tobi', 'Tobias', 'Hombre', 'tobi@gmail.com', '202cb962ac59075b964b', '2022-07-13 06:24:31'),
(14, 'Azu', 'Azul ', 'Mujer', 'azul@gmail.com', '202cb962ac59075b964b', '2022-07-13 06:29:23'),
(15, 'Lean', 'Leandro', 'Hombre', 'lean@gmail.com', '202cb962ac59075b964b', '2022-07-13 06:29:33'),
(16, 'Folco', 'Luca', 'Hombre', 'folquito@gmail.com', '202cb962ac59075b964b', '2022-07-13 06:26:30'),
(17, 'Clau', 'Claudia Valentina', 'Mujer', 'clau@gmail.com', '202cb962ac59075b964b', '2022-07-13 06:27:30'),
(18, 'An', 'Angie Jackelin', 'Mujer', 'angie@gmail.com', '202cb962ac59075b964b', '2022-07-13 06:30:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `comidas`
--
ALTER TABLE `comidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria` (`categorias_id`),
  ADD KEY `pais` (`paises_id`),
  ADD KEY `usuario` (`usuarios_id`);

--
-- Indices de la tabla `like_comentarios`
--
ALTER TABLE `like_comentarios`
  ADD PRIMARY KEY (`comentario_id`);

--
-- Indices de la tabla `like_comidas`
--
ALTER TABLE `like_comidas`
  ADD PRIMARY KEY (`comida_id`);

--
-- Indices de la tabla `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comidas`
--
ALTER TABLE `comidas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT de la tabla `like_comentarios`
--
ALTER TABLE `like_comentarios`
  MODIFY `comentario_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `like_comidas`
--
ALTER TABLE `like_comidas`
  MODIFY `comida_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `paises`
--
ALTER TABLE `paises`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
