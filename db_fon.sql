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
  CONSTRAINT muni FOREIGN KEY (id_departamento) REFERENCES tb_departamentos (id_departamento)
);

CREATE TABLE tb_distritos (
  id_distrito INT UNSIGNED AUTO_INCREMENT NOT NULL,
  distrito VARCHAR(1000) NOT NULL,
  id_municipio INT UNSIGNED NOT NULL,
  PRIMARY KEY (id_distrito),
  CONSTRAINT distrito FOREIGN KEY (id_municipio) REFERENCES tb_municipios (id_municipio)
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
  PRIMARY KEY (id_producto),
  CONSTRAINT fk_marcas_ FOREIGN KEY (id_marca) REFERENCES tb_marcas(id_marca),
  CONSTRAINT fk_categorias FOREIGN KEY (id_categoria) REFERENCES tb_categorias(id_categoria)
);



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
  sistema_operativo_celular enum('Android','IOS') NOT NULL,
  camara_frontal_celular varchar(50) NOT NULL,
  procesador_celular varchar(50) NOT NULL,
  PRIMARY KEY (id_detalle_producto),
  CONSTRAINT fk_producto FOREIGN KEY (id_producto) REFERENCES tb_productos(id_producto),
  CONSTRAINT fk_oferta FOREIGN KEY (id_oferta) REFERENCES tb_ofertas(id_oferta),
  CONSTRAINT ck_precio  CHECK (precio >= 0),
  CONSTRAINT ck_existencias  CHECK (existencias >= 0)
);

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


	CREATE TABLE tb_reservas (
	  id_reserva INT UNSIGNED AUTO_INCREMENT NOT NULL,
	  id_usuario INT UNSIGNED NOT NULL,
	  fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
	  estado_reserva ENUM ('Aceptado', 'Pendiente') NOT NULL,
	  id_distrito INT UNSIGNED NOT NULL,
	  CONSTRAINT fk_direcciones FOREIGN KEY (id_distrito) REFERENCES tb_distritos (id_distrito),
	  CONSTRAINT fk_reserva_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuarios (id_usuario),
	  PRIMARY KEY (id_reserva) -- Asegurando que id_reserva sea una clave primaria
	);

CREATE TABLE tb_detalles_reservas (
  id_detalle_reserva INT UNSIGNED AUTO_INCREMENT NOT NULL,
  id_reserva INT UNSIGNED NOT NULL,
  id_producto INT UNSIGNED NOT NULL,
  cantidad INT UNSIGNED NOT NULL,
  precio_unitario DECIMAL(10,2) NOT NULL,
  id_detalle_producto INT UNSIGNED NOT NULL,
  PRIMARY KEY (id_detalle_reserva),
  CONSTRAINT fk_reserva FOREIGN KEY (id_reserva) REFERENCES tb_reservas(id_reserva),
  CONSTRAINT fk_detalle_producto FOREIGN KEY (id_detalle_producto) REFERENCES tb_detalles_productos(id_detalle_producto),
  CONSTRAINT ck_cantidad  CHECK (cantidad >= 0),
  CONSTRAINT ck_precio_unitario CHECK (precio_unitario >= 0)
);