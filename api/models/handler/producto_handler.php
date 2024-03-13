<?php
require_once('../../helpers/database.php');

class MarcaHandler
{
    protected $id = null;
    protected $nombre = null;
    protected $producto = null;

    public function searchRows()
    {
        // Query para buscar marcas
        $sql = 'SELECT * FROM tb_marcas_fon';
        return Database::getRows($sql);
    }

    public function createRow()
    {
        // Query para crear una nueva marca
        $sql = 'INSERT INTO tb_marcas_fon (nombre_Marca, producto_marcar) VALUES (?, ?)';
        $params = array($this->nombre, $this->producto);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        // Query para leer todas las marcas
        $sql = 'SELECT * FROM tb_marcas_fon';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        // Query para leer una marca específica
        $sql = 'SELECT * FROM tb_marcas_fon WHERE id_Marca_Fon = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        // Query para actualizar una marca
        $sql = 'UPDATE tb_marcas_fon SET nombre_Marca = ?, producto_marcar = ? WHERE id_Marca_Fon = ?';
        $params = array($this->nombre, $this->producto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        // Query para eliminar una marca
        $sql = 'DELETE FROM tb_marcas_fon WHERE id_Marca_Fon = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
?>
