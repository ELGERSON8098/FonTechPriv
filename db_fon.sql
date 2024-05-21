DROP DATABASE IF EXISTS dbfondReal;

CREATE DATABASE dbfondReal;

USE dbfondReal;

CREATE TABLE tb_usuarios (
  id_usuario INT UNSIGNED AUTO_INCREMENT NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  usuario VARCHAR(100) NOT NULL,
  correo VARCHAR(100) NOT NULL,	
  clave VARCHAR(100) NOT NULL, 
  PRIMARY KEY (id_usuario),
  CONSTRAINT uc_usuario UNIQUE (usuario),
  CONSTRAINT uc_correo UNIQUE (correo)
);

INSERT INTO tb_usuarios (id_usuario, nombre, usuario, correo, clave) VALUES
(1, 'Alejandro', 'dikei1', 'af111111@gmail.com' , '123456789'),
(2, 'Alejandro', 'dikei2', 'af222222@gmail.com' , '123456789'),
(3, 'Alejandro', 'dikei3', 'af333333@gmail.com' , '123456789'),
(4, 'Alejandro', 'dikei4', 'af444444@gmail.com' , '123456789'),
(5, 'Alejandro', 'dikei5', 'af555555@gmail.com' , '123456789'),
(6, 'Alejandro', 'dikei6', 'af666666@gmail.com' , '123456789'),
(7, 'Alejandro', 'dikei7', 'af777777@gmail.com' , '123456789'),
(8, 'Alejandro', 'dikei8', 'af888888@gmail.com' , '123456789'),
(9, 'Alejandro', 'dikei9', 'af999999@gmail.com' , '123456789'),
(10, 'Alejandro', 'dikei10', 'af101010@gmail.com' , '123456789');

CREATE TABLE tb_departamentos (
  id_departamento INT UNSIGNED AUTO_INCREMENT NOT NULL,
  departamento VARCHAR(1000) NOT NULL,
  PRIMARY KEY (id_departamento)
);
           
CREATE TABLE tb_municipios (
  id_municipio INT UNSIGNED AUTO_INCREMENT NOT NULL,
  municipio VARCHAR(1000) NOT NULL,
  id_departamento INT UNSIGNED NOT NULL,
  PRIMARY KEY (id_municipio),
  CONSTRAINT muni FOREIGN KEY (id_departamento) REFERENCES tb_departamentos (id_departamento)ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE tb_distritos (
  id_distrito INT UNSIGNED AUTO_INCREMENT NOT NULL,
  distrito VARCHAR(1000) NOT NULL,
  id_municipio INT UNSIGNED NOT NULL,
  PRIMARY KEY (id_distrito),
  CONSTRAINT distrito FOREIGN KEY (id_municipio) REFERENCES tb_municipios (id_municipio)ON DELETE CASCADE ON UPDATE CASCADE
);

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


select * from tb_distritos;



CREATE TABLE tb_admins (
  id_administrador INT UNSIGNED AUTO_INCREMENT NOT NULL,
  nombre_administrador VARCHAR(50) NOT NULL,
  usuario_administrador VARCHAR(50) NOT NULL,
  correo_administrador VARCHAR(50) NOT NULL,
  clave_administrador VARCHAR(100) NOT NULL,
  PRIMARY KEY (id_administrador),
  CONSTRAINT uc_usuario_administrador UNIQUE (usuario_administrador),
  CONSTRAINT uc_correo_administrador UNIQUE (correo_administrador)
);

CREATE TABLE tb_categorias (
  id_categoria INT UNSIGNED AUTO_INCREMENT NOT NULL,
  nombre_categoria VARCHAR(100) NOT NULL,
  imagen VARCHAR(20) NULL,
  PRIMARY KEY (id_categoria)
);

insert into tb_categorias (id_categoria,nombre_categoria, imagen ) values
('1', 'nestle', '6644c4cee4ac0.jpg'),
('2', 'nestle', '6644c4cee4ac0.jpg'),
('3', 'nestle', '6644c4cee4ac0.jpg'),
('4', 'nestle', '6644c4cee4ac0.jpg'),
('5', 'nestle', '6644c4cee4ac0.jpg');

CREATE TABLE tb_marcas (
  id_marca INT UNSIGNED AUTO_INCREMENT NOT NULL,
  marca VARCHAR(50) NOT NULL,
  imagen varchar(20)not null,
  PRIMARY KEY (id_marca)
);

insert into tb_marcas (id_marca,marca, imagen ) values
('1', 'Prado', '6644c4cee4ac0.jpg'),
('2', 'Prado', '6644c4cee4ac0.jpg'),
('3', 'Prado', '6644c4cee4ac0.jpg'),
('4', 'Prado', '6644c4cee4ac0.jpg'),
('5', 'Prado', '6644c4cee4ac0.jpg');

CREATE TABLE tb_ofertas (
  id_oferta INT UNSIGNED AUTO_INCREMENT NOT NULL,
  nombre_descuento VARCHAR(100) NOT NULL,
  descripcion VARCHAR(200) NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id_oferta),
  CONSTRAINT ck_valor CHECK (valor >= 0)
);

insert into tb_ofertas (id_oferta, nombre_descuento, descripcion, valor) values
('1', 'Descuento de verano', 'Verano descuento', '12.10'),
('2', 'Descuento de verano', 'Verano descuento', '12.10'),
('3', 'Descuento de verano', 'Verano descuento', '12.10'),
('4', 'Descuento de verano', 'Verano descuento', '12.10'),
('5', 'Descuento de verano', 'Verano descuento', '12.10');

CREATE TABLE tb_productos (
  id_producto INT UNSIGNED AUTO_INCREMENT NOT NULL,
  nombre_producto VARCHAR(100) NOT NULL,
  id_marca INT UNSIGNED,
  id_categoria INT UNSIGNED,
  imagen VARCHAR(20) NOT NULL,
  estado_producto tinyint(1) NOT NULL,
  PRIMARY KEY (id_producto),	
  CONSTRAINT fk_marcas_ FOREIGN KEY (id_marca) REFERENCES tb_marcas(id_marca)ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_categorias FOREIGN KEY (id_categoria) REFERENCES tb_categorias(id_categoria)ON DELETE CASCADE ON UPDATE CASCADE
);

insert into tb_productos (id_producto,nombre_producto,id_marca, id_categoria, imagen, estado_producto) values
('1', 'Leche', '1', '1', '6644c4cee4ac0.jpg', 1),
('2', 'Leche', '2', '2', '6644c4cee4ac0.jpg', 1),
('3', 'Leche', '3', '3', '6644c4cee4ac0.jpg', 1),
('4', 'Leche', '4', '4', '6644c4cee4ac0.jpg', 1),
('5', 'Leche', '5', '5', '6644c4cee4ac0.jpg', 1);



CREATE TABLE tb_detalles_productos (
  id_detalle_producto INT UNSIGNED AUTO_INCREMENT NOT NULL,
  id_producto INT UNSIGNED NOT NULL,
  id_oferta INT UNSIGNED NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  existencias INT UNSIGNED NOT NULL,
  descripcion VARCHAR(200) NOT NULL,
  capacidad_memoria_interna_celular varchar(50) NOT NULL,
  ram_celular varchar(50) NOT NULL,
  pantalla_tamaño varchar(50) NOT NULL,
  camara_trasera_celular varchar(50) NOT NULL,
  sistema_operativo_celular varchar(50) NOT NULL,
  camara_frontal_celular varchar(50) NOT NULL,
  procesador_celular varchar(50) NOT NULL,
  PRIMARY KEY (id_detalle_producto),
  CONSTRAINT fk_producto FOREIGN KEY (id_producto) REFERENCES tb_productos(id_producto)ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_oferta FOREIGN KEY (id_oferta) REFERENCES tb_ofertas(id_oferta)ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT ck_precio  CHECK (precio >= 0),
  CONSTRAINT ck_existencias  CHECK (existencias >= 0)
);

insert into tb_detalles_productos (id_detalle_producto, id_producto, id_oferta, precio, existencias, descripcion, capacidad_memoria_interna_celular, ram_celular,
pantalla_tamaño, camara_trasera_celular, sistema_operativo_celular, camara_frontal_celular,procesador_celular) values
('1', '1', '1', '12.01', '1', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon'),
('2', '2', '2', '12.01', '2', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon'),
('3', '3', '3', '12.01', '3', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon'),
('4', '4', '4', '12.01', '4', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon'),
('5', '5', '5', '12.01', '5', 'AAAAAAAAAAA', '12gb', '12gb', '21px', '12px', 'android', '22px', 'redragon');

ALTER TABLE tb_detalles_productos
MODIFY COLUMN id_oferta INT UNSIGNED DEFAULT NULL,
ADD CONSTRAINT ck_oferta 
    FOREIGN KEY (id_oferta) 
    REFERENCES tb_ofertas(id_oferta) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE;

    UPDATE tb_detalles_productos AS dp
            INNER JOIN tb_productos AS p ON dp.id_producto = p.id_producto
            SET dp.id_producto = 2,
                dp.id_oferta = 1,
                dp.precio = 12,
                dp.existencias = 12,
                dp.descripcion = 'sssssss',
                dp.capacidad_memoria_interna_celular = 'ssss',
                dp.ram_celular = 'ssss',
                dp.pantalla_tamaño = 'sssss',
                dp.camara_trasera_celular = 'ssssss',
                dp.sistema_operativo_celular = 'sssss',
                dp.camara_frontal_celular = 'sssss',
                dp.procesador_celular = 'asssasasasa',
                p.nombre_producto = 'sasssssss',
                p.imagen = 'papita.jpg',
                p.id_marca = 1,  -- Agregar id_marca
                p.id_categoria = 1  -- Agregar id_categoria
            WHERE dp.id_detalle_producto = 5;
            
    SELECT * FROM tb_productos
SELECT 
            p.id_producto,
            p.nombre_producto,
            m.marca,
            c.nombre_categoria,
            p.imagen
        FROM 
            tb_productos p
        INNER JOIN 
            tb_marcas m ON p.id_marca = m.id_marca
        INNER JOIN 
            tb_categorias c ON p.id_categoria = c.id_categoria



CREATE TABLE tb_valoraciones (
  id_valoracion INT AUTO_INCREMENT PRIMARY KEY,
  calificacion_valoracion INT,
  comentario_valoracion VARCHAR(250),
  fecha_valoracion DATETIME DEFAULT CURRENT_TIMESTAMP,
  estado_valoracion BOOL,
  id_producto INT UNSIGNED NOT NULL,
  CONSTRAINT calificacion_valoracion_check CHECK (calificacion_valoracion >= 0),
  CONSTRAINT fk_productos FOREIGN KEY (id_producto) REFERENCES tb_productos(id_producto) ON DELETE CASCADE ON UPDATE CASCADE
);

insert into tb_valoraciones (id_valoracion,calificacion_valoracion,comentario_valoracion,fecha_valoracion, estado_valoracion,id_producto) values
('1', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '1'),
('2', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '2'),
('3', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '3'),
('4', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '4'),
('5', '2', 'ayudaaaaa', '2024-05-20 15:30:00', '1', '5');

select * from tb_valoraciones;

drop table tb_reservas;

CREATE TABLE tb_reservas (
  id_reserva INT UNSIGNED AUTO_INCREMENT NOT NULL,
  id_usuario INT UNSIGNED NOT NULL,
  id_producto INT UNSIGNED NOT NULL,
  id_detalle_producto INT UNSIGNED NOT NULL,
  fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
  estado_reserva ENUM ('Aceptado', 'Pendiente') NOT NULL,
  id_distrito INT UNSIGNED NOT NULL,
  CONSTRAINT fk_direcciones FOREIGN KEY (id_distrito) REFERENCES tb_distritos (id_distrito)ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_reserva_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuarios (id_usuario)ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (id_reserva) 
);

insert into tb_reservas (id_reserva, id_usuario, id_producto, id_detalle_producto, fecha_reserva, estado_reserva, id_distrito) values
('1', '1','1', '1', '2024-05-20 15:30:00', 'Pendiente', '1'),
('2', '2','2', '2', '2024-05-20 15:30:00', 'Pendiente', '2'),
('3', '3','3', '3', '2024-05-20 15:30:00', 'Pendiente', '3'),
('4', '4','4', '4', '2024-05-20 15:30:00', 'Pendiente', '4'),
('5', '5','5', '5', '2024-05-20 15:30:00', 'Pendiente', '5');

select * from tb_reservas;

CREATE TABLE tb_detalles_reservas (
  id_detalle_reserva INT UNSIGNED AUTO_INCREMENT NOT NULL,
  id_reserva INT UNSIGNED NOT NULL,
  cantidad INT UNSIGNED NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id_detalle_reserva),
  CONSTRAINT fk_reserva FOREIGN KEY (id_reserva) REFERENCES tb_reservas(id_reserva)ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT ck_cantidad  CHECK (cantidad >= 0),
  CONSTRAINT ck_precio_unitario CHECK (precio_unitario >= 0)
);
insert into tb_detalles_reservas (id_detalle_reserva, id_reserva, cantidad, precio_unitario) values
('1', '1', '2', '12.10'),
('2', '2', '3', '13.10'),
('3', '3', '4', '31.23'),
('4', '4', '2', '14.12'),
('5', '5', '1', '15.92');


select * from tb_detalles_reservas
where id_reserva=1;

SELECT 
                r.id_reserva,
                r.id_usuario,
                r.fecha_reserva,
                r.estado_reserva,
                d.distrito,
                m.municipio,
                dept.departamento
            FROM 
                tb_reservas r
            INNER JOIN 
                tb_distritos d ON r.id_distrito = d.id_distrito
            INNER JOIN 
                tb_municipios m ON d.id_municipio = m.id_municipio
            INNER JOIN 
                tb_departamentos dept ON m.id_departamento = dept.id_departamento
                
                
                SELECT 
                r.id_usuario, 
                r.id_reserva, 
                r.estado_reserva, 
                r.fecha_reserva,
                d.distrito,
                u.nombre AS nombre_usuario
            FROM 
                tb_reservas r
            INNER JOIN 
                tb_usuarios u ON r.id_usuario = u.id_usuario
            INNER JOIN 
                tb_distritos d ON r.id_distrito = d.id_distrito
            WHERE r.id_reserva = 1
            
            
            SELECT 
                    r.id_reserva,
                    r.id_usuario,
                    r.fecha_reserva,
                    r.estado_reserva,
                    d.distrito,
                    m.municipio,
                    dept.departamento
                FROM 
                    tb_reservas r
                INNER JOIN 
                    tb_distritos d ON r.id_distrito = d.id_distrito
                INNER JOIN 
                    tb_municipios m ON d.id_municipio = m.id_municipio
                INNER JOIN 
                    tb_departamentos dept ON m.id_departamento = dept.id_departamento
                    
                    
                    SELECT 
                    p.nombre_producto,
                    p.imagen,
                    r.fecha_reserva
                FROM 
                    tb_reservas r
                INNER JOIN 
                    tb_productos p ON r.id_producto = p.id_producto
                    
                    select * from tb_detalles_reservas
    where id_reserva=2;