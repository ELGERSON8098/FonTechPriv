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


             -- Este es el inner join de productos, en la cual se ven  
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
            tb_categorias c ON p.id_categoria = c.id_categoria;


            -- Este inner join es el que se mostraria en la tabla dentro de la reserva, antes del segundo modal (readDetalles) en reservaHandler
SELECT 
    p.nombre_producto, 
    p.imagen, 
    r.fecha_reserva,
    dr.id_detalle_reserva
FROM 
    tb_detalles_reservas dr
INNER JOIN 
    tb_reservas r ON dr.id_reserva = r.id_reserva
INNER JOIN 
    tb_detalles_productos dp ON dr.id_detalle_producto = dp.id_detalle_producto
INNER JOIN 
    tb_productos p ON dp.id_producto = p.id_producto
WHERE 
    dr.id_reserva = 1;

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
                tb_departamentos dept ON m.id_departamento = dept.id_departamento;

                 -- Este es el inner join que se ocupa en readOne de reservaHandler
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
				WHERE r.id_reserva = 1;

                -- Este es el inner join para mandar a llamar el nombre del producto, imagen y fecha de reserva (tambien se ocupa en reservaHandler)
	SELECT 
    p.nombre_producto,
    p.imagen,
    r.fecha_reserva
FROM 
    tb_reservas r
INNER JOIN 
    tb_detalles_reservas dr ON r.id_reserva = dr.id_reserva
INNER JOIN 
    tb_detalles_productos dp ON dr.id_detalle_producto = dp.id_detalle_producto
INNER JOIN 
    tb_productos p ON dp.id_producto = p.id_producto;

     select * from tb_detalles_reservas
    where id_reserva=2;

     -- Este es el inner join para el detalles del producto en el segundo modal de la reserva, reservaHandler (readDetalles2)
    SELECT 
    dr.cantidad,
    r.fecha_reserva,
    dp.capacidad_memoria_interna_celular,
    dp.ram_celular,
    dp.pantalla_tamaño,
    dp.camara_trasera_celular,
    dp.sistema_operativo_celular,
    dp.camara_frontal_celular,
    dp.procesador_celular,
    m.marca AS marca,
    o.nombre_descuento
FROM 
    tb_detalles_reservas dr
INNER JOIN 
    tb_reservas r ON dr.id_reserva = r.id_reserva
INNER JOIN 
    tb_detalles_productos dp ON dr.id_detalle_producto = dp.id_detalle_producto
INNER JOIN 
    tb_productos p ON dp.id_producto = p.id_producto
INNER JOIN 
    tb_marcas m ON p.id_marca = m.id_marca
INNER JOIN 
    tb_ofertas o ON dp.id_oferta = o.id_oferta
WHERE 
    dr.id_detalle_reserva = 1;


