DROP DATABASE IF EXISTS dbfondReal;

CREATE DATABASE dbfondReal;

USE dbfondReal;

CREATE TABLE tb_usuarios (
  id_usuario INT UNSIGNED AUTO_INCREMENT NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  usuario VARCHAR(100) NOT NULL,
  correo VARCHAR(100) NOT NULL,	
  clave VARCHAR(100) NOT NULL,
  direccion LONGTEXT NOT NULL,
  estado_cliente TINYINT(1) DEFAULT TRUE, 
  PRIMARY KEY (id_usuario),
  CONSTRAINT uc_usuario UNIQUE (usuario),
  CONSTRAINT uc_correo UNIQUE (correo)
);


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


CREATE TABLE tb_marcas (
  id_marca INT UNSIGNED AUTO_INCREMENT NOT NULL,
  marca VARCHAR(50) NOT NULL,
  imagen varchar(20)not null,
  PRIMARY KEY (id_marca)
);


CREATE TABLE tb_ofertas (
  id_oferta INT UNSIGNED AUTO_INCREMENT NOT NULL,
  nombre_descuento VARCHAR(100) NOT NULL,
  descripcion VARCHAR(200) NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id_oferta),
  CONSTRAINT ck_valor CHECK (valor >= 0)
);


CREATE TABLE tb_productos (
  id_producto INT UNSIGNED AUTO_INCREMENT NOT NULL,
  nombre_producto VARCHAR(100) NOT NULL,
  id_marca INT UNSIGNED,
  id_categoria INT UNSIGNED,
  imagen VARCHAR(20) NOT NULL,
  estado_producto tinyint(1) NOT NULL,
  id_oferta INT UNSIGNED NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  existencias INT UNSIGNED NOT NULL,
  descripcion VARCHAR(1000) NOT NULL,
  capacidad_memoria_interna_celular varchar(50) NOT NULL,
  ram_celular varchar(50) NOT NULL,
  pantalla_tamaño varchar(50) NOT NULL,
  camara_trasera_celular varchar(50) NOT NULL,
  sistema_operativo_celular varchar(50) NOT NULL,
  camara_frontal_celular varchar(50) NOT NULL,
  procesador_celular varchar(50) NOT NULL,
  PRIMARY KEY (id_producto),	
  CONSTRAINT fk_marcas_ FOREIGN KEY (id_marca) REFERENCES tb_marcas(id_marca)ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_categorias FOREIGN KEY (id_categoria) REFERENCES tb_categorias(id_categoria)ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT ck_existencias  CHECK (existencias >= 0)
);



ALTER TABLE tb_productos
MODIFY COLUMN id_oferta INT UNSIGNED DEFAULT NULL,
ADD CONSTRAINT ck_oferta 
    FOREIGN KEY (id_oferta) 
    REFERENCES tb_ofertas(id_oferta) 
    ON DELETE CASCADE 
    ON UPDATE CASCADE;



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


ALTER TABLE tb_valoraciones
ADD COLUMN id_usuario INT UNSIGNED NOT NULL,
ADD CONSTRAINT fk_usuarios
FOREIGN KEY (id_usuario) REFERENCES tb_usuarios(id_usuario)
ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE tb_reservas (
  id_reserva INT UNSIGNED AUTO_INCREMENT NOT NULL,
  id_usuario INT UNSIGNED NOT NULL,
  fecha_registro date NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  estado_reserva ENUM ('Aceptado', 'Pendiente') NOT NULL,
  CONSTRAINT fk_reserva_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuarios (id_usuario)ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY (id_reserva) 
);




CREATE TABLE tb_detalles_reservas (
  id_detalle_reserva INT UNSIGNED AUTO_INCREMENT NOT NULL,
  id_reserva INT UNSIGNED NOT NULL,
  cantidad smallint(6) UNSIGNED NOT NULL,
  id_producto INT UNSIGNED NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (id_detalle_reserva),
  CONSTRAINT fk_reserva FOREIGN KEY (id_reserva) REFERENCES tb_reservas(id_reserva) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_producto FOREIGN KEY (id_producto) REFERENCES tb_productos(id_producto) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT ck_cantidad CHECK (cantidad >= 0),
  CONSTRAINT ck_precio_unitario CHECK (precio_unitario >= 0)
);

SELECT * FROM tb_detalles_reservas

DELIMITER //

CREATE TRIGGER actualizar_existencias
AFTER UPDATE ON tb_reservas
FOR EACH ROW
BEGIN
    IF NEW.estado_reserva = 'Aceptado' THEN
        UPDATE tb_productos p
        INNER JOIN tb_detalles_reservas dr ON p.id_producto = dr.id_producto
        SET p.existencias = p.existencias - dr.cantidad
        WHERE dr.id_reserva = NEW.id_reserva;
    END IF;
END //

DELIMITER ;