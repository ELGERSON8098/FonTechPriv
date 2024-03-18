-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-03-2024 a las 21:16:49
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP database IF exists db_fon;

CREATE DATABASE db_fon;

USE db_fon;	

--
-- Estructura de tabla para la tabla `tb_administradores_fon`
--

CREATE TABLE `tb_administradores_fon` (
  `id_Administrador_Fon` INT UNSIGNED AUTO_INCREMENT,
  `nombre_admin` varchar(50) NOT NULL,
  `apellido_admin` varchar(50) NOT NULL,
  `edad_admin` int(11) NOT NULL,
  `correo_admin` varchar(50) NOT NULL,
  `telefono_admin` int(11) NOT NULL,
  `contraseña_admin` varchar(50) NOT NULL,
  PRIMARY KEY (`id_Administrador_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_categorias_fon`
--

CREATE TABLE `tb_categorias_fon` (
  `id_Categoria_Fon`  INT UNSIGNED auto_increment,
  `nombre_Categoria` varchar(50) NOT NULL,
  `producto_Categoria` varchar(50) NOT NULL,
  `id_Marca_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Categoria_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_comentarios_fon`
--

CREATE TABLE `tb_comentarios_fon` (
  `id_Comentario_Fon` INT UNSIGNED AUTO_INCREMENT,
  `comentario` varchar(50) NOT NULL,
  `id_Detalle_Reserva_Fon`INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Comentario_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_detalles_reservas_fon`
--

CREATE TABLE `tb_detalles_reservas_fon` (
  `id_Detalle_Reserva_Fon` INT UNSIGNED AUTO_INCREMENT,
  `precio` decimal(10,0) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `log_message` varchar(255) NOT NULL,
  `id_Producto_Fon` INT UNSIGNED NOT NULL,
  `id_Reserva_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Detalle_Reserva_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_direcciones_fon`
--

CREATE TABLE `tb_direcciones_fon` (
  `id_Direccion_Fon` INT UNSIGNED AUTO_INCREMENT,
  `direccion` varchar(50) NOT NULL,
  `id_Reserva_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Direccion_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_especificaciones_celulares_fon`
--

CREATE TABLE `tb_especificaciones_celulares_fon` (
  `id_Especificacion_Celulares` INT UNSIGNED AUTO_INCREMENT,
  `capacidad_memoria_interna_celular` varchar(50) NOT NULL,
  `ram_celular` varchar(50) NOT NULL,
  `pantalla_celular` varchar(50) NOT NULL,
  `camara_trasera_celular` varchar(50) NOT NULL,
  `sistema_operativo_celular` enum('Android','IOS') NOT NULL,
  `camara_frontal_celular` varchar(50) NOT NULL,
  `procesador_celular` varchar(50) NOT NULL,
  `id_Producto_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Especificacion_Celulares`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_especificaciones_tablets_fon`
--

CREATE TABLE `tb_especificaciones_tablets_fon` (
  `id_Especificacion_Tablets` INT UNSIGNED AUTO_INCREMENT,
  `capacidad_almacenamiento_tablet` varchar(50) NOT NULL,
  `camara_primaria_tablet` varchar(50) NOT NULL,
  `camara_forntal_tablet` varchar(50) NOT NULL,
  `sistema_operativo_tablet` enum('Android','IOS') NOT NULL,
  `ram_tablet` varchar(50) NOT NULL,
  `tamaño_pantalla_tablet` varchar(50) NOT NULL,
  `id_Producto_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Especificacion_Tablets`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_estados_pedidos_fon`
--

CREATE TABLE `tb_estados_pedidos_fon` (
  `id_Estado_Pedido_Fon` INT UNSIGNED AUTO_INCREMENT,
  `estado` enum('Cancelado','En camino','Aceptado','Entregado') NOT NULL,
  `id_Reserva_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Estado_Pedido_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_marcas_fon`
--

CREATE TABLE `tb_marcas_fon` (
  `id_Marca_Fon`INT UNSIGNED AUTO_INCREMENT,
  `nombre_Marca` VARCHAR(50) NOT NULL,
  `producto_marcar` varchar(50) NOT NULL,
  PRIMARY KEY (`id_Marca_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_GENERAL_CI;






-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_niveles_usuarios_fon`
--

CREATE TABLE `tb_niveles_usuarios_fon` (
  `id_Nivel_Usuario_Fon` INT UNSIGNED AUTO_INCREMENT,
  `nivel_usuario` enum('Supervisor','Empleado','Conserje') NOT NULL,
  `id_Administrador_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Nivel_Usuario_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_productos_fon`
--

CREATE TABLE `tb_productos_fon` (
  `id_Producto_Fon` INT UNSIGNED AUTO_INCREMENT,
  `nombre_producto` varchar(50) NOT NULL,
  `descripcion_producto` varchar(50) NOT NULL,
  `precio_producto` decimal(10,0) NOT NULL,
  `existencia_producto` int(11) NOT NULL,
  `id_Marca_Fon` INT UNSIGNED NOT NULL,
  `id_Categoria_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Producto_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_registros_clientes_fon`
--

CREATE TABLE `tb_registros_clientes_fon` (
  `id_Registro_Fon` INT UNSIGNED AUTO_INCREMENT,
  `nombre_registro` varchar(50) NOT NULL,
  `apellido_registro` varchar(50) NOT NULL,
  `edad_registro` int(11) NOT NULL,
  `correo_registro` varchar(50) NOT NULL,
  `telefono_registro` int(11) NOT NULL,
  `contraseña_registro` varchar(50) NOT NULL,
  PRIMARY KEY (`id_Registro_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_reservas_fon`
--

CREATE TABLE `tb_reservas_fon` (
  `id_Reserva_Fon` INT UNSIGNED AUTO_INCREMENT,
  `id_Registro_Fon` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Reserva_Fon`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Filtros para la tabla `tb_detalles_reservas_fon`
--
ALTER TABLE `tb_detalles_reservas_fon`
  ADD CONSTRAINT `fk_detalles_reservas_producto` FOREIGN KEY (`id_Producto_Fon`) REFERENCES `tb_productos_fon` (`id_Producto_Fon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalles_reservas_reserva` FOREIGN KEY (`id_Reserva_Fon`) REFERENCES `tb_reservas_fon` (`id_Reserva_Fon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_detalles_reservas_fon_ibfk_1` FOREIGN KEY (`id_Detalle_Reserva_Fon`) REFERENCES `tb_comentarios_fon` (`id_Comentario_Fon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_especificaciones_celulares_fon`
--
ALTER TABLE `tb_especificaciones_celulares_fon`
  ADD CONSTRAINT `fk_especificaciones_celulares_producto` FOREIGN KEY (`id_Producto_Fon`) REFERENCES `tb_productos_fon` (`id_Producto_Fon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_especificaciones_tablets_fon`
--
ALTER TABLE `tb_especificaciones_tablets_fon`
  ADD CONSTRAINT `especificaciones_tablets_producto` FOREIGN KEY (`id_Producto_Fon`) REFERENCES `tb_productos_fon` (`id_Producto_Fon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_estados_pedidos_fon`
--
ALTER TABLE `tb_estados_pedidos_fon`
  ADD CONSTRAINT `fk_estados_pedidos_reserva` FOREIGN KEY (`id_Reserva_Fon`) REFERENCES `tb_reservas_fon` (`id_Reserva_Fon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_niveles_usuarios_fon`
--
ALTER TABLE `tb_niveles_usuarios_fon`
  ADD CONSTRAINT `fk_niveles_usuarios_admin` FOREIGN KEY (`id_Administrador_Fon`) REFERENCES `tb_administradores_fon` (`id_Administrador_Fon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_productos_fon`
--
ALTER TABLE `tb_productos_fon`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`id_Categoria_Fon`) REFERENCES `tb_categorias_fon` (`id_Categoria_Fon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_productos_marca` FOREIGN KEY (`id_Marca_Fon`) REFERENCES `tb_marcas_fon` (`id_Marca_Fon`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tb_reservas_fon`
--
ALTER TABLE `tb_reservas_fon`
  ADD CONSTRAINT `fk_reservas_cliente` FOREIGN KEY (`id_Registro_Fon`) REFERENCES `tb_registros_clientes_fon` (`id_Registro_Fon`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_reservas_fon_ibfk_1` FOREIGN KEY (`id_Reserva_Fon`) REFERENCES `tb_direcciones_fon` (`id_Direccion_Fon`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


INSERT INTO `tb_administradores_fon` (`id_Administrador_Fon`, `nombre_admin`, `apellido_admin`, `edad_admin`, `correo_admin`, `telefono_admin`, `contraseña_admin`)
VALUES
(1, 'Juan', 'Perez', 35, 'juan.perez@email.com', 123456789, 'clave123'),
(2, 'María', 'Gomez', 28, 'maria.gomez@email.com', 987654321, 'password456'),
(3, 'Carlos', 'Rodriguez', 40, 'carlos.rodriguez@email.com', 555111222, 'secreto789'),
(4, 'Ana', 'Lopez', 22, 'ana.lopez@email.com', 333444555, 'securepass'),
(5, 'Luis', 'Fernandez', 33, 'luis.fernandez@email.com', 999888777, '123abc'),
(6, 'Elena', 'Martinez', 27, 'elena.martinez@email.com', 666777888, 'pass321'),
(7, 'Miguel', 'Sanchez', 45, 'miguel.sanchez@email.com', 111222333, 'adminpass'),
(8, 'Laura', 'Garcia', 30, 'laura.garcia@email.com', 444555666, 'laurita123'),
(9, 'Pedro', 'Ramirez', 38, 'pedro.ramirez@email.com', 222333444, 'ramirez456'),
(10, 'Sofia', 'Diaz', 26, 'sofia.diaz@email.com', 777888999, 'sofiaPass'),
(11, 'Jorge', 'Hernandez', 32, 'jorge.hernandez@email.com', 555444333, 'jhPass123'),
(12, 'Carmen', 'Torres', 29, 'carmen.torres@email.com', 999666333, 'carmenPass'),
(13, 'Alberto', 'Reyes', 41, 'alberto.reyes@email.com', 123999888, 'albertoPass123'),
(14, 'Rosa', 'Ortega', 24, 'rosa.ortega@email.com', 456123789, 'rosa123'),
(15, 'Francisco', 'Flores', 36, 'francisco.flores@email.com', 987123456, 'ffloresPass'),
(16, 'Beatriz', 'Cruz', 31, 'beatriz.cruz@email.com', 654789321, 'beatrizPass'),
(17, 'Diego', 'Mendoza', 34, 'diego.mendoza@email.com', 321456987, 'diego123'),
(18, 'Isabel', 'Gutierrez', 27, 'isabel.gutierrez@email.com', 789456123, 'isabelPass789'),
(19, 'Victor', 'Vargas', 39, 'victor.vargas@email.com', 987456321, 'victorPass'),
(20, 'Julia', 'Morales', 25, 'julia.morales@email.com', 321789654, 'juliaPass123'),
(21, 'Hector', 'Castro', 37, 'hector.castro@email.com', 456789123, 'hectorPass'),
(22, 'Patricia', 'Nunez', 28, 'patricia.nunez@email.com', 789123456, 'patricia123'),
(23, 'Daniel', 'Iglesias', 33, 'daniel.iglesias@email.com', 654321789, 'danielPass123'),
(24, 'Monica', 'Rojas', 30, 'monica.rojas@email.com', 123789456, 'monicaPass'),
(25, 'Alejandro', 'Jimenez', 29, 'alejandro.jimenez@email.com', 987321654, 'alejandro123');

SELECT * FROM tb_administradores_fon;

INSERT INTO `tb_niveles_usuarios_fon` (`id_Nivel_Usuario_Fon`, `nivel_usuario`, `id_Administrador_Fon`)
VALUES
(1, 'Supervisor', 1),
(2, 'Empleado', 2),
(3, 'Conserje', 3),
(4, 'Empleado', 4),
(5, 'Conserje', 5),
(6, 'Supervisor', 6),
(7, 'Empleado', 7),
(8, 'Conserje', 8),
(9, 'Supervisor', 9),
(10, 'Empleado', 10),
(11, 'Conserje', 11),
(12, 'Supervisor', 12),
(13, 'Empleado', 13),
(14, 'Conserje', 14),
(15, 'Supervisor', 15),
(16, 'Empleado', 16),
(17, 'Conserje', 17),
(18, 'Supervisor', 18),
(19, 'Empleado', 19),
(20, 'Conserje', 20),
(21, 'Supervisor', 21),
(22, 'Empleado', 22),
(23, 'Conserje', 23),
(24, 'Supervisor', 24),
(25, 'Empleado', 25);

SELECT * FROM tb_niveles_usuarios_fon;

INSERT INTO `tb_marcas_fon` (`id_Marca_Fon`, `nombre_Marca`, `producto_marcar`)
VALUES
(1, 'Poco', 'Pixi 4'),
(2, 'Redmi', 'Pixi 4'),
(3, 'Alcaltel', 'Pixi 4'),
(4, 'Xiaomi', 'Redmi Note 10'),
(5, 'Samsung', 'Galaxy A52'),
(6, 'Iphone', 'iPhone SE'),
(7, 'Alcaltel', '1S'),
(8, 'Xiaomi', 'Mi 11'),
(9, 'Samsung', 'Galaxy Z Fold 3'),
(10, 'Iphone', 'iPhone 12 Mini'),
(11, 'Alcaltel', '3X'),
(12, 'Xiaomi', 'Redmi 9'),
(13, 'Samsung', 'Galaxy A71'),
(14, 'Iphone', 'iPhone XR'),
(15, 'Alcaltel', 'TCL 10L'),
(16, 'Xiaomi', 'Poco X3'),
(17, 'Samsung', 'Galaxy Note 20'),
(18, 'Iphone', 'iPhone 11 Pro'),
(19, 'Alcaltel', 'Pop 4 Plus'),
(20, 'Xiaomi', 'Mi 10'),
(21, 'Samsung', 'Galaxy S20'),
(22, 'Iphone', 'iPhone XS'),
(23, 'Alcaltel', '1V'),
(24, 'Xiaomi', 'Redmi Note 9'),
(25, 'Samsung', 'Galaxy A12'); 

INSERT INTO `tb_marcas_fon` (`id_Marca_Fon`, `nombre_Marca`, `producto_marcar`)
VALUES
(27, 'Redmi', 'NOTE')

SELECT * FROM tb_marcas_fon;

INSERT INTO `tb_categorias_fon` (`id_Categoria_Fon`, `nombre_Categoria`, `producto_Categoria`, `id_Marca_Fon`)
VALUES
(1, 'Tecnología', 'Smartphones', 1),
(2, 'Tecnología', 'Laptops', 2),
(3, 'Tecnología', 'Tablets', 3),
(4, 'Tecnología', 'Smartwatches', 1),
(5, 'Tecnología', 'Cámaras', 2),
(6, 'Tecnología', 'Auriculares', 3),
(7, 'Tecnología', 'Impresoras', 1),
(8, 'Tecnología', 'Monitores', 2),
(9, 'Tecnología', 'Accesorios de Computadora', 3),
(10, 'Tecnología', 'Altavoces Inteligentes', 1),
(11, 'Tecnología', 'Gadgets', 2),
(12, 'Tecnología', 'Consolas de Videojuegos', 3),
(13, 'Tecnología', 'Móviles Plegables', 1),
(14, 'Tecnología', 'Dispositivos de Almacenamiento', 2),
(15, 'Tecnología', 'Tarjetas Gráficas', 3),
(16, 'Tecnología', 'Drones', 1),
(17, 'Tecnología', 'Teclados y Ratones', 2),
(18, 'Tecnología', 'Proyectores', 3),
(19, 'Tecnología', 'Software', 1),
(20, 'Tecnología', 'Cables y Adaptadores', 2),
(21, 'Tecnología', 'Baterías Externas', 3),
(22, 'Tecnología', 'Cámaras de Seguridad', 1),
(23, 'Tecnología', 'Smart TV', 2),
(24, 'Tecnología', 'Robótica', 3),
(25, 'Tecnología', 'Dispositivos IoT', 1);

SELECT * FROM tb_categorias_fon;

INSERT INTO `tb_productos_fon` (`id_Producto_Fon`, `nombre_producto`, `descripcion_producto`, `precio_producto`, `existencia_producto`, `id_Marca_Fon`, `id_Categoria_Fon`)
VALUES
(1, 'Producto1', 'Descripción1', 100, 50, 1, 1),
(2, 'Producto2', 'Descripción2', 150, 30, 2, 1),
(3, 'Producto3', 'Descripción3', 200, 20, 3, 2),
(4, 'Producto4', 'Descripción4', 120, 40, 1, 2),
(5, 'Producto5', 'Descripción5', 180, 25, 2, 3),
(6, 'Producto6', 'Descripción6', 250, 15, 3, 3),
(7, 'Producto7', 'Descripción7', 300, 10, 1, 1),
(8, 'Producto8', 'Descripción8', 130, 35, 2, 1),
(9, 'Producto9', 'Descripción9', 220, 18, 3, 2),
(10, 'Producto10', 'Descripción10', 160, 22, 1, 2),
(11, 'Producto11', 'Descripción11', 270, 12, 2, 3),
(12, 'Producto12', 'Descripción12', 190, 28, 3, 3),
(13, 'Producto13', 'Descripción13', 110, 45, 1, 1),
(14, 'Producto14', 'Descripción14', 140, 33, 2, 1),
(15, 'Producto15', 'Descripción15', 180, 27, 3, 2),
(16, 'Producto16', 'Descripción16', 200, 21, 1, 2),
(17, 'Producto17', 'Descripción17', 250, 14, 2, 3),
(18, 'Producto18', 'Descripción18', 300, 9, 3, 3),
(19, 'Producto19', 'Descripción19', 120, 38, 1, 1),
(20, 'Producto20', 'Descripción20', 160, 24, 2, 1),
(21, 'Producto21', 'Descripción21', 220, 17, 3, 2),
(22, 'Producto22', 'Descripción22', 130, 34, 1, 2),
(23, 'Producto23', 'Descripción23', 270, 11, 2, 3),
(24, 'Producto24', 'Descripción24', 190, 29, 3, 3),
(25, 'Producto25', 'Descripción25', 110, 42, 1, 1),
(26, 'Producto26', 'Descripción26', 120, 30, 4, 3),
(27, 'Producto27', 'Descripción27', 180, 25, 5, 2),
(28, 'Producto28', 'Descripción28', 250, 20, 2, 1),
(29, 'Producto29', 'Descripción29', 140, 35, 3, 2),
(30, 'Producto30', 'Descripción30', 200, 18, 1, 3),
(31, 'Producto31', 'Descripción31', 160, 22, 4, 2),
(32, 'Producto32', 'Descripción32', 280, 15, 5, 3),
(33, 'Producto33', 'Descripción33', 300, 12, 2, 1),
(34, 'Producto34', 'Descripción34', 130, 28, 3, 2),
(35, 'Producto35', 'Descripción35', 220, 17, 1, 3),
(36, 'Producto36', 'Descripción36', 190, 24, 4, 2),
(37, 'Producto37', 'Descripción37', 260, 14, 5, 3),
(38, 'Producto38', 'Descripción38', 140, 32, 2, 1),
(39, 'Producto39', 'Descripción39', 180, 27, 3, 2),
(40, 'Producto40', 'Descripción40', 240, 20, 1, 3),
(41, 'Producto41', 'Descripción41', 170, 30, 4, 2),
(42, 'Producto42', 'Descripción42', 280, 16, 5, 3),
(43, 'Producto43', 'Descripción43', 150, 25, 2, 1),
(44, 'Producto44', 'Descripción44', 200, 19, 3, 2),
(45, 'Producto45', 'Descripción45', 230, 22, 1, 3),
(46, 'Producto46', 'Descripción46', 190, 26, 4, 2),
(47, 'Producto47', 'Descripción47', 260, 15, 5, 3),
(48, 'Producto48', 'Descripción48', 140, 31, 2, 1),
(49, 'Producto49', 'Descripción49', 180, 28, 3, 2),
(50, 'Producto50', 'Descripción50', 250, 18, 1, 3);

SELECT * FROM tb_productos_fon;

INSERT INTO `tb_especificaciones_tablets_fon` (`id_Especificacion_Tablets`, `capacidad_almacenamiento_tablet`, `camara_primaria_tablet`, `camara_forntal_tablet`, `sistema_operativo_tablet`, `ram_tablet`, `tamaño_pantalla_tablet`, `id_Producto_Fon`)
VALUES
(1, '128 GB', '12 MP', '8 MP', 'Android', '4 GB', '10.1 pulgadas', 1),
(2, '64 GB', '8 MP', '5 MP', 'IOS', '3 GB', '9.7 pulgadas', 2),
(3, '256 GB', '16 MP', '12 MP', 'Android', '6 GB', '11 pulgadas', 3),
(4, '32 GB', '5 MP', '2 MP', 'IOS', '2 GB', '8 pulgadas', 4),
(5, '128 GB', '12 MP', '8 MP', 'Android', '4 GB', '10 pulgadas', 5),
(6, '64 GB', '8 MP', '5 MP', 'IOS', '3 GB', '9.7 pulgadas', 6),
(7, '128 GB', '12 MP', '8 MP', 'Android', '4 GB', '10.1 pulgadas', 7),
(8, '256 GB', '16 MP', '12 MP', 'IOS', '6 GB', '11 pulgadas', 8),
(9, '64 GB', '8 MP', '5 MP', 'Android', '3 GB', '9.7 pulgadas', 9),
(10, '32 GB', '5 MP', '2 MP', 'IOS', '2 GB', '8 pulgadas', 10),
(11, '128 GB', '12 MP', '8 MP', 'Android', '4 GB', '10 pulgadas', 11),
(12, '64 GB', '8 MP', '5 MP', 'IOS', '3 GB', '9.7 pulgadas', 12),
(13, '256 GB', '16 MP', '12 MP', 'Android', '6 GB', '11 pulgadas', 13),
(14, '32 GB', '5 MP', '2 MP', 'IOS', '2 GB', '8 pulgadas', 14),
(15, '128 GB', '12 MP', '8 MP', 'Android', '4 GB', '10.1 pulgadas', 15),
(16, '256 GB', '16 MP', '12 MP', 'IOS', '6 GB', '11 pulgadas', 16),
(17, '64 GB', '8 MP', '5 MP', 'Android', '3 GB', '9.7 pulgadas', 17),
(18, '32 GB', '5 MP', '2 MP', 'IOS', '2 GB', '8 pulgadas', 18),
(19, '128 GB', '12 MP', '8 MP', 'Android', '4 GB', '10 pulgadas', 19),
(20, '64 GB', '8 MP', '5 MP', 'IOS', '3 GB', '9.7 pulgadas', 20),
(21, '256 GB', '16 MP', '12 MP', 'Android', '6 GB', '11 pulgadas', 21),
(22, '32 GB', '5 MP', '2 MP', 'IOS', '2 GB', '8 pulgadas', 22),
(23, '128 GB', '12 MP', '8 MP', 'Android', '4 GB', '10.1 pulgadas', 23),
(24, '64 GB', '8 MP', '5 MP', 'IOS', '3 GB', '9.7 pulgadas', 24),
(25, '256 GB', '16 MP', '12 MP', 'Android', '6 GB', '11 pulgadas', 25);

SELECT * FROM tb_especificaciones_tablets_fon;

INSERT INTO `tb_especificaciones_celulares_fon` (`id_Especificacion_Celulares`, `capacidad_memoria_interna_celular`, `ram_celular`, `pantalla_celular`, `camara_trasera_celular`, `sistema_operativo_celular`, `camara_frontal_celular`, `procesador_celular`, `id_Producto_Fon`)
VALUES
(26, '128GB', '6GB', '6.2 pulgadas', '12MP', 'Android', '8MP', 'Snapdragon 765', 26),
(27, '256GB', '8GB', '6.5 pulgadas', '48MP', 'Android', '16MP', 'Exynos 990', 27),
(28, '64GB', '4GB', '6.0 pulgadas', '16MP', 'IOS', '8MP', 'A13 Bionic', 28),
(29, '128GB', '6GB', '6.4 pulgadas', '64MP', 'Android', '20MP', 'Snapdragon 870', 29),
(30, '256GB', '8GB', '6.7 pulgadas', '108MP', 'Android', '32MP', 'Exynos 990', 30),
(31, '128GB', '6GB', '6.1 pulgadas', '12MP', 'IOS', '12MP', 'A14 Bionic', 31),
(32, '64GB', '4GB', '6.3 pulgadas', '48MP', 'Android', '8MP', 'Snapdragon 765G', 32),
(33, '256GB', '12GB', '6.8 pulgadas', '108MP', 'Android', '32MP', 'Exynos 2100', 33),
(34, '128GB', '8GB', '6.5 pulgadas', '64MP', 'Android', '16MP', 'Snapdragon 888', 34),
(35, '64GB', '6GB', '6.2 pulgadas', '12MP', 'IOS', '8MP', 'A15 Bionic', 35),
(36, '256GB', '8GB', '6.4 pulgadas', '48MP', 'Android', '20MP', 'Dimensity 1200', 36),
(37, '128GB', '6GB', '6.7 pulgadas', '64MP', 'Android', '32MP', 'Exynos 980', 37),
(38, '256GB', '12GB', '6.1 pulgadas', '12MP', 'IOS', '12MP', 'A16 Bionic', 38),
(39, '128GB', '8GB', '6.3 pulgadas', '48MP', 'Android', '8MP', 'Snapdragon 865', 39),
(40, '256GB', '12GB', '6.8 pulgadas', '108MP', 'Android', '32MP', 'Exynos 1080', 40),
(41, '128GB', '6GB', '6.5 pulgadas', '64MP', 'Android', '16MP', 'Snapdragon 870', 41),
(42, '64GB', '4GB', '6.2 pulgadas', '12MP', 'IOS', '8MP', 'A14 Bionic', 42),
(43, '256GB', '8GB', '6.4 pulgadas', '48MP', 'Android', '20MP', 'Snapdragon 765G', 43),
(44, '128GB', '6GB', '6.7 pulgadas', '64MP', 'Android', '32MP', 'Exynos 2100', 44),
(45, '256GB', '12GB', '6.1 pulgadas', '12MP', 'IOS', '12MP', 'A15 Bionic', 45),
(46, '128GB', '8GB', '6.3 pulgadas', '48MP', 'Android', '8MP', 'Dimensity 1200', 46),
(47, '256GB', '12GB', '6.8 pulgadas', '108MP', 'Android', '32MP', 'Snapdragon 888', 47),
(48, '128GB', '6GB', '6.5 pulgadas', '64MP', 'IOS', '16MP', 'Exynos 980', 48),
(49, '64GB', '4GB', '6.2 pulgadas', '12MP', 'Android', '8MP', 'A16 Bionic', 49),
(50, '256GB', '8GB', '6.4 pulgadas', '48MP', 'IOS', '20MP', 'Snapdragon 865', 50);

SELECT * FROM tb_especificaciones_celulares_fon;

INSERT INTO `tb_registros_clientes_fon` (`id_Registro_Fon`, `nombre_registro`, `apellido_registro`, `edad_registro`, `correo_registro`, `telefono_registro`, `contraseña_registro`)
VALUES
(1, 'Nombre1', 'Apellido1', 25, 'correo1@example.com', 123456789, 'contraseña1'),
(2, 'Nombre2', 'Apellido2', 28, 'correo2@example.com', 987654321, 'contraseña2'),
(3, 'Nombre3', 'Apellido3', 22, 'correo3@example.com', 456789123, 'contraseña3'),
(4, 'Nombre4', 'Apellido4', 30, 'correo4@example.com', 654321987, 'contraseña4'),
(5, 'Nombre5', 'Apellido5', 26, 'correo5@example.com', 321987654, 'contraseña5'),
(6, 'Nombre6', 'Apellido6', 29, 'correo6@example.com', 789123456, 'contraseña6'),
(7, 'Nombre7', 'Apellido7', 24, 'correo7@example.com', 234567891, 'contraseña7'),
(8, 'Nombre8', 'Apellido8', 27, 'correo8@example.com', 876543219, 'contraseña8'),
(9, 'Nombre9', 'Apellido9', 31, 'correo9@example.com', 543210987, 'contraseña9'),
(10, 'Nombre10', 'Apellido10', 23, 'correo10@example.com', 210987654, 'contraseña10'),
(11, 'Nombre11', 'Apellido11', 32, 'correo11@example.com', 111223344, 'contraseña11'),
(12, 'Nombre12', 'Apellido12', 28, 'correo12@example.com', 445566778, 'contraseña12'),
(13, 'Nombre13', 'Apellido13', 35, 'correo13@example.com', 998877665, 'contraseña13'),
(14, 'Nombre14', 'Apellido14', 27, 'correo14@example.com', 554433221, 'contraseña14'),
(15, 'Nombre15', 'Apellido15', 29, 'correo15@example.com', 112233445, 'contraseña15'),
(16, 'Nombre16', 'Apellido16', 33, 'correo16@example.com', 667788990, 'contraseña16'),
(17, 'Nombre17', 'Apellido17', 26, 'correo17@example.com', 334455667, 'contraseña17'),
(18, 'Nombre18', 'Apellido18', 30, 'correo18@example.com', 991122334, 'contraseña18'),
(19, 'Nombre19', 'Apellido19', 28, 'correo19@example.com', 112233445, 'contraseña19'),
(20, 'Nombre20', 'Apellido20', 25, 'correo20@example.com', 556677889, 'contraseña20'),
(21, 'Nombre21', 'Apellido21', 34, 'correo21@example.com', 223344556, 'contraseña21'),
(22, 'Nombre22', 'Apellido22', 27, 'correo22@example.com', 778899001, 'contraseña22'),
(23, 'Nombre23', 'Apellido23', 31, 'correo23@example.com', 445566778, 'contraseña23'),
(24, 'Nombre24', 'Apellido24', 29, 'correo24@example.com', 112233445, 'contraseña24'),
(25, 'Nombre25', 'Apellido25', 28, 'correo25@example.com', 667788990, 'contraseña25');

SELECT * FROM tb_registros_clientes_fon;

INSERT INTO tb_reservas_fon (id_Reserva_Fon, id_Registro_Fon) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 20),
(21, 21),
(22, 22),
(23, 23),
(24, 24),
(25, 25);

SELECT * FROM tb_registros_clientes_fon;

INSERT INTO tb_detalles_reservas_fon (id_Detalle_Reserva_Fon, precio, cantidad, id_Producto_Fon, id_Reserva_Fon) VALUES
(1, 100, 2, 1, 1),
(2, 150, 1, 2, 2),
(3, 200, 3, 3, 3),
(4, 120, 2, 4, 4),
(5, 180, 1, 5, 5),
(6, 250, 4, 6, 6),
(7, 300, 3, 7, 7),
(8, 130, 2, 8, 8),
(9, 220, 1, 9, 9),
(10, 160, 3, 10, 10),
(11, 270, 2, 11, 11),
(12, 190, 1, 12, 12),
(13, 110, 4, 13, 13),
(14, 140, 2, 14, 14),
(15, 180, 1, 15, 15),
(16, 200, 3, 16, 16),
(17, 250, 2, 17, 17),
(18, 300, 1, 18, 18),
(19, 120, 3, 19, 19),
(20, 160, 2, 20, 20),
(21, 220, 1, 21, 21),
(22, 130, 4, 22, 22),
(23, 270, 1, 23, 23),
(24, 190, 2, 24, 24),
(25, 110, 3, 25, 25);

SELECT * FROM tb_detalles_reservas_fon;

INSERT INTO tb_direcciones_fon (id_Direccion_Fon, direccion, id_Reserva_Fon) VALUES
(1, 'Calle 1, Ciudad A', 1),
(2, 'Avenida 2, Ciudad B', 2),
(3, 'Carrera 3, Ciudad C', 3),
(4, 'Calle 4, Ciudad A', 4),
(5, 'Avenida 5, Ciudad B', 5),
(6, 'Carrera 6, Ciudad C', 6),
(7, 'Calle 7, Ciudad A', 7),
(8, 'Avenida 8, Ciudad B', 8),
(9, 'Carrera 9, Ciudad C', 9),
(10, 'Calle 10, Ciudad A', 10),
(11, 'Avenida 11, Ciudad B', 11),
(12, 'Carrera 12, Ciudad C', 12),
(13, 'Calle 13, Ciudad A', 13),
(14, 'Avenida 14, Ciudad B', 14),
(15, 'Carrera 15, Ciudad C', 15),
(16, 'Calle 16, Ciudad A', 16),
(17, 'Avenida 17, Ciudad B', 17),
(18, 'Carrera 18, Ciudad C', 18),
(19, 'Calle 19, Ciudad A', 19),
(20, 'Avenida 20, Ciudad B', 20),
(21, 'Carrera 21, Ciudad C', 21),
(22, 'Calle 22, Ciudad A', 22),
(23, 'Avenida 23, Ciudad B', 23),
(24, 'Carrera 24, Ciudad C', 24),
(25, 'Calle 25, Ciudad A', 25);

SELECT * FROM tb_direcciones_fon;

INSERT INTO tb_estados_pedidos_fon (id_Estado_Pedido_Fon, estado, id_Reserva_Fon) VALUES
(1, 'Aceptado', 1),
(2, 'Entregado', 2),
(3, 'Cancelado', 3),
(4, 'En camino', 4),
(5, 'Aceptado', 5),
(6, 'Entregado', 6),
(7, 'Cancelado', 7),
(8, 'En camino', 8),
(9, 'Aceptado', 9),
(10, 'Entregado', 10),
(11, 'Cancelado', 11),
(12, 'En camino', 12),
(13, 'Aceptado', 13),
(14, 'Entregado', 14),
(15, 'Cancelado', 15),
(16, 'En camino', 16),
(17, 'Aceptado', 17),
(18, 'Entregado', 18),
(19, 'Cancelado', 19),
(20, 'En camino', 20),
(21, 'Aceptado', 21),
(22, 'Entregado', 22),
(23, 'Cancelado', 23),
(24, 'En camino', 24),
(25, 'Aceptado', 25);

SELECT * FROM tb_estados_pedidos_fon;

INSERT INTO tb_comentarios_fon (id_Comentario_Fon, comentario, id_Detalle_Reserva_Fon) VALUES
(1, 'Buen servicio', 1),
(2, 'Excelente atención al cliente', 2),
(3, 'Producto de buena calidad', 3),
(4, 'Rápido envío', 4),
(5, 'Satisfecho con la compra', 5),
(6, 'Recomendado', 6),
(7, 'Problemas con la entrega', 7),
(8, 'Deberían mejorar el empaque', 8),
(9, 'Muy amables', 9),
(10, 'Entrega puntual', 10),
(11, 'Atención al cliente mejorable', 11),
(12, 'Producto defectuoso', 12),
(13, 'Fácil proceso de compra', 13),
(14, 'Producto no recibido', 14),
(15, 'Servicio al cliente lento', 15),
(16, 'Buena relación calidad-precio', 16),
(17, 'Reembolso solicitado', 17),
(18, 'Envío perdido', 18),
(19, 'Sorpresa con el producto', 19),
(20, 'Respuesta rápida ante problemas', 20),
(21, 'Mejoraría la comunicación', 21),
(22, 'Pedido incorrecto', 22),
(23, 'Envío rápido', 23),
(24, 'Atención al cliente ineficiente', 24),
(25, 'Producto dañado en tránsito', 25);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
