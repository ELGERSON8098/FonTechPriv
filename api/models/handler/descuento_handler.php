<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class descuentoHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $descripcion = null;
    protected $valor = null;

    /*
     *  Métodos para gestionar la cuenta del administrador.
     */

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_oferta, nombre_descuento, descripcion, valor
                 FROM tb_ofertas
                 WHERE nombre_descuento LIKE ? OR descripcion LIKE ?
                 ORDER BY nombre_descuento';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_ofertas(nombre_descuento, descripcion, valor)
                 VALUES(?, ?, ?)';
        $params = array($this->nombre, $this->descripcion, $this->valor);
        return Database::executeRow($sql, $params);
    }





    //Llamar los datos de la base de datos 
    public function readAll()
    {
        $sql = 'SELECT id_oferta, nombre_descuento, descripcion, valor
                FROM tb_ofertas';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_oferta, nombre_descuento, descripcion, valor
                FROM tb_ofertas
                WHERE id_oferta = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_ofertas
                SET nombre_descuento = ?, descripcion = ?, valor = ?
                WHERE id_oferta = ?';
        $params = array($this->nombre, $this->descripcion, $this->valor, $this->id);
        return Database::executeRow($sql, $params);
    }


    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_ofertas
                WHERE id_oferta = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
