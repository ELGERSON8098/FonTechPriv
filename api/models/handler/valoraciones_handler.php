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
    protected $id_producto = null;
    protected $calificacionValoracion = null;
    protected $comentarioValoracion = null;
    protected $fechaValoracion = null;
    protected $estadoValoracion = null;


    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     * Aunque ahorita solo haré el de agregar cupones
     */
    // SEARCH
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT v.id_valoracion, p.nombre_producto, p.imagen AS imagen_producto, v.calificacion_valoracion, v.comentario_valoracion, v.fecha_valoracion, v.estado_valoracion
        FROM tb_valoraciones v
        INNER JOIN tb_productos p ON v.id_producto = p.id_producto
        WHERE p.nombre_producto LIKE ?
        ORDER BY p.id_producto';
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
    public function readAllByProducto()
    {
        $sql = 'SELECT id_valoracion,nombre_producto, imagen, calificacion_valoracion, comentario_valoracion, fecha_valoracion, estado_valoracion,nombre
        FROM tb_valoraciones v
        INNER JOIN tb_productos USING(id_producto)
        INNER JOIN tb_usuarios  USING(id_usuario)
        WHERE id_producto=?
        ORDER BY nombre_producto;';
        $params = array($this->id_producto);
        return Database::getRows($sql, $params);
    }

    //    Leer un registro de una valoracion
    public function readOne()
    {
        $sql = 'SELECT v.id_valoracion, p.nombre_producto, p.imagen AS imagen_producto, v.calificacion_valoracion, v.comentario_valoracion, v.fecha_valoracion, v.estado_valoracion
        FROM tb_valoraciones v
        INNER JOIN tb_productos p ON v.id_producto = p.id_producto
        WHERE id_valoracion = ?';
        $params = array($this->idValoracion);
        return Database::getRows($sql, $params);
    }

    public function verifComent()
    {
        $sql = 'SELECT v.id_valoracion, p.nombre_producto, p.imagen AS imagen_producto, v.calificacion_valoracion, v.comentario_valoracion, v.fecha_valoracion, v.estado_valoracion
        FROM tb_valoraciones v
        INNER JOIN tb_productos p ON v.id_producto = p.id_producto
        INNER JOIN tb_usuarios u ON v.id_usuario = u.id_usuario
        WHERE id_producto = ? and v.id_usuario=?';
        $params = array($this->id_producto,$_SESSION['idUsuario']);
        return Database::getRows($sql, $params);
    }

    //    Actualizar una valoracion
    public function updateRow()
    {
        $sql = 'UPDATE tb_valoraciones 
                SET estado_valoracion = ?
                WHERE id_valoracion = ?';
        $params = array(
            $this->estadoValoracion,
            $this->idValoracion
        );
        return Database::executeRow($sql, $params);
    }
    public function createComentario()
    {
        $sql = 'INSERT INTO tb_valoraciones (calificacion_valoracion, comentario_valoracion, estado_valoracion, id_producto,id_usuario)
        VALUES ( ?,  ?, false,  ?,?);';
        $params = array(
            $this->calificacionValoracion,
            $this->comentarioValoracion,
            $this->id_producto,
            $_SESSION['idUsuario']
        );
        return Database::executeRow($sql, $params);
    }
    public function editComentario()
    {
        $sql = 'update tb_valoraciones set calificacion_valoracion=? comentario_valoracion=? id_valoracion = ? ;';
        $params = array(
            $this->calificacionValoracion,
            $this->comentarioValoracion,
            $this->idValoracion
        );
        return Database::executeRow($sql, $params);
    }
}
