<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class reservaHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $id_reserva = null;
    protected $nombre = null;
    protected $apellido = null;
    protected $correo = null;
    protected $alias = null;
    protected $clave = null;
    protected $nivel = null;
    const RUTA_IMAGEN = '../../images/productos/';

    public function readAll()
    {
        $sql = 'SELECT 
                    r.id_reserva,
                    r.id_usuario,
                    u.usuario,
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
                INNER JOIN 
                    tb_usuarios u ON r.id_usuario = u.id_usuario';
        return Database::getRows($sql);
    }


    public function readOne()
    {
        $sql = 'SELECT 
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
                WHERE r.id_reserva = ?';

        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function readDetalles()
    {
        $sql = 'SELECT 
    p.nombre_producto, 
    p.imagen, 
    r.fecha_reserva,
    dr.id_detalle_reserva
FROM 
    tb_detalles_reservas dr
INNER JOIN 
    tb_reservas r ON dr.id_reserva = r.id_reserva
INNER JOIN 
    tb_productos p ON r.id_producto = p.id_producto
WHERE 
    dr.id_reserva = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function readDetalles2()
    {
        $sql = ' SELECT 
        dr.id_detalle_reserva,
        dr.precio_unitario,
        dr.cantidad,
        r.fecha_reserva,
        p.capacidad_memoria_interna_celular,
        p.ram_celular,
        p.pantalla_tamaño,
        p.camara_trasera_celular,
        p.sistema_operativo_celular,
        p.camara_frontal_celular,
        p.procesador_celular,
        m.marca AS marca,
        o.nombre_descuento
    FROM 
        tb_detalles_reservas dr
    INNER JOIN 
        tb_reservas r ON dr.id_reserva = r.id_reserva
    INNER JOIN 
        tb_productos p ON r.id_producto = p.id_producto
    INNER JOIN 
        tb_marcas m ON p.id_marca = m.id_marca
    LEFT JOIN 
        tb_ofertas o ON p.id_oferta = o.id_oferta
    WHERE 
        dr.id_detalle_reserva = ?'; // Ajusta esta condición según tus necesidades

        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function readOneS()
    {
        $sql = 'SELECT 
                dr.id_detalle_reserva,
                dr.id_reserva,
                dr.cantidad,
                dr.precio_unitario,
                r.estado_reserva,
                r.fecha_reserva,
                u.nombre AS nombre_usuario,
                d.distrito,
                m.municipio,
                dept.departamento
            FROM 
                tb_detalles_reservas dr
            INNER JOIN 
                tb_reservas r ON dr.id_reserva = r.id_reserva
            INNER JOIN 
                tb_usuarios u ON r.id_usuario = u.id_usuario
            INNER JOIN 
                tb_distritos d ON r.id_distrito = d.id_distrito
            INNER JOIN 
                tb_municipios m ON d.id_municipio = m.id_municipio
            INNER JOIN 
                tb_departamentos dept ON m.id_departamento = dept.id_departamento
            WHERE dr.id_detalle_reserva = ?'; // Agregamos una condición para seleccionar un solo detalle de reserva

        $params = array($this->id);
        return Database::getRow($sql, $params);
    }




    public function readAlls()
    {
        $sql = 'SELECT 
                dr.id_detalle_reserva,
                dr.id_reserva,
                dr.cantidad,
                dr.precio_unitario,
                r.estado_reserva,
                r.fecha_reserva,
                u.nombre AS nombre_usuario,
                d.distrito,
                m.municipio,
                dept.departamento
            FROM 
                tb_detalles_reservas dr
            INNER JOIN 
                tb_reservas r ON dr.id_reserva = r.id_reserva
            INNER JOIN 
                tb_usuarios u ON r.id_usuario = u.id_usuario
            INNER JOIN 
                tb_distritos d ON r.id_distrito = d.id_distrito
            INNER JOIN 
                tb_municipios m ON d.id_municipio = m.id_municipio
            INNER JOIN 
                tb_departamentos dept ON m.id_departamento = dept.id_departamento';
        return Database::getRows($sql);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM administrador
                WHERE id_administrador = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
