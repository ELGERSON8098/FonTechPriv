<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla cupones.
 */
class ValoracionesHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $idValoracion = null;
    protected $calificacionValoracion = null;
    protected $comentarioValoracion = null;
    protected $fechaValoracion = null;
    protected $estadoValoracion = null;
    protected $idDetalleedido = null;

    const RUTA_IMAGEN = '../../images/productos/';


    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     * Aunque ahorita solo haré el de agregar cupones
     */
    // SEARCH
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_valoracion, nombre_producto, imagen_producto, calificacion_valoracion, comentario_valoracion, fecha_valoracion, estado_valoracion
                FROM valoraciones v
                INNER JOIN  id_producto dp ON v. id_producto = dp. id_producto
                WHERE nombre_producto LIKE ?
                ORDER BY c.nombre_producto;';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    // READ ALL
    public function readAll()
    {
        $sql = 'SELECT v.id_valoracion, p.nombre_producto, p.imagen, v.calificacion_valoracion, v.comentario_valoracion, v.fecha_valoracion, v.estado_valoracion
        FROM tb_valoraciones v
        INNER JOIN tb_productos p ON v.id_producto = p.id_producto
        ORDER BY p.nombre_producto;';
        return Database::getRows($sql);
    }

    //    Leer un registro de una valoracion
    public function readOne(){
        $sql = 'SELECT v.id_valoracion, p.nombre_producto, p.imagen, v.calificacion_valoracion, v.comentario_valoracion, v.fecha_valoracion, v.estado_valoracion
        FROM tb_valoraciones v
        INNER JOIN tb_productos p ON v.id_producto = p.id_producto
        where id_valoracion = ?
        ORDER BY p.nombre_producto;';
        $params = array($this->idValoracion);
        return Database::getRows($sql, $params);
    }

    //    Actualizar una valoracion
    public function updateRow(){
        $sql = 'UPDATE valoraciones 
                SET estado_valoracion = ?
                WHERE id_valoracion = ?';
        $params = array(
            $this->estadoValoracion,
            $this->idValoracion
        );
        return Database::executeRow($sql, $params);
    }
}

