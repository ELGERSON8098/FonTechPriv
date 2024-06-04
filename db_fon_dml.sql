INSERT INTO tb_usuarios (id_usuario, nombre, usuario, correo, clave, estado_cliente) VALUES
(1, 'Alejandro', 'dikei1', 'af111111@gmail.com' , '123456789', '1'),
(2, 'Alejandro', 'dikei2', 'af222222@gmail.com' , '123456789', '1'),
(3, 'Alejandro', 'dikei3', 'af333333@gmail.com' , '123456789', '1'),
(4, 'Alejandro', 'dikei4', 'af444444@gmail.com' , '123456789', '1'),
(5, 'Alejandro', 'dikei5', 'af555555@gmail.com' , '123456789', '1'),
(6, 'Alejandro', 'dikei6', 'af666666@gmail.com' , '123456789', '1'),
(7, 'Alejandro', 'dikei7', 'af777777@gmail.com' , '123456789', '1'),
(8, 'Alejandro', 'dikei8', 'af888888@gmail.com' , '123456789', '1'),
(9, 'Alejandro', 'dikei9', 'af999999@gmail.com' , '123456789', '1'),
(10, 'Alejandro', 'dikei10', 'af101010@gmail.com' , '123456789', '1');

INSERT INTO tb_departamentos (departamento) VALUES
('San Salvador'),
('Santa Ana'),
('San Miguel');


INSERT INTO tb_municipios (municipio, id_departamento) VALUES
('San Salvador', 1),
('Santa Tecla', 1),
('Santa Ana', 2),
('Metapán', 2),
('San Miguel', 3),
('Usulután', 3);

INSERT INTO tb_distritos (distrito, id_municipio) VALUES
('Distrito 1', 1),
('Distrito 2', 2),
('Distrito 3', 3),
('Distrito 4', 4),
('Distrito 5', 5),
('Distrito 6', 6);

insert into tb_categorias (id_categoria,nombre_categoria, imagen ) values
('1', 'nestle', '6644c4cee4ac0.jpg'),
('2', 'nestle', '6644c4cee4ac0.jpg'),
('3', 'nestle', '6644c4cee4ac0.jpg'),
('4', 'nestle', '6644c4cee4ac0.jpg'),
('5', 'nestle', '6644c4cee4ac0.jpg');

insert into tb_marcas (id_marca,marca, imagen ) values
('1', 'Prado', '6644c4cee4ac0.jpg'),
('2', 'Prado', '6644c4cee4ac0.jpg'),
('3', 'Prado', '6644c4cee4ac0.jpg'),
('4', 'Prado', '6644c4cee4ac0.jpg'),
('5', 'Prado', '6644c4cee4ac0.jpg');

insert into tb_ofertas (id_oferta, nombre_descuento, descripcion, valor) values
('1', 'Descuento de verano', 'Verano descuento', '12.10'),
('2', 'Descuento de verano', 'Verano descuento', '12.10'),
('3', 'Descuento de verano', 'Verano descuento', '12.10'),
('4', 'Descuento de verano', 'Verano descuento', '12.10'),
('5', 'Descuento de verano', 'Verano descuento', '12.10');

insert into tb_productos (id_producto,nombre_producto,id_marca, id_categoria, imagen, estado_producto) values
('1', 'Leche', '1', '1', '6644c4cee4ac0.jpg', 1),
('2', 'Leche', '2', '2', '6644c4cee4ac0.jpg', 1),
('3', 'Leche', '3', '3', '6644c4cee4ac0.jpg', 1),
('4', 'Leche', '4', '4', '6644c4cee4ac0.jpg', 1),
('5', 'Leche', '5', '5', '6644c4cee4ac0.jpg', 1);

insert into tb_detalles_productos (id_detalle_producto, id_producto, id_oferta, precio, existencias, descripcion, capacidad_memoria_interna_celular, ram_celular,
pantalla_tamaño, camara_trasera_celular, sistema_operativo_celular, camara_frontal_celular,procesador_celular) values
('1', '1', '1', '12.01', '1', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon'),
('2', '2', '2', '12.01', '2', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon'),
('3', '3', '3', '12.01', '3', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon'),
('4', '4', '4', '12.01', '4', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon'),
('5', '5', '5', '12.01', '5', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon');

insert into tb_valoraciones (id_valoracion,calificacion_valoracion,comentario_valoracion,fecha_valoracion, estado_valoracion,id_producto) values
('1', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '1'),
('2', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '2'),
('3', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '3'),
('4', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '4'),
('5', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '5');

insert into tb_reservas (id_reserva, id_usuario, fecha_reserva, estado_reserva, id_distrito) values
('1', '1', '2024-05-20 15:30:00', 'Pendiente', '1'),
('2', '2', '2024-05-20 15:30:00', 'Pendiente', '2'),
('3', '3', '2024-05-20 15:30:00', 'Pendiente', '3'),
('4', '4', '2024-05-20 15:30:00', 'Pendiente', '4'),
('5', '5', '2024-05-20 15:30:00', 'Pendiente', '5');

insert into tb_detalles_reservas (id_detalle_reserva, id_reserva,id_detalle_producto, cantidad) values
('1', '1', '1', '1'),
('2', '2', '2', '2'),
('3', '3', '3', '3'),
('4', '4', '4', '4'),
('5', '5', '5', '5');