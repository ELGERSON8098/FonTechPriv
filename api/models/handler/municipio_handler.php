<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class municipioHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $Depa= null;
    protected $Muni = null;
    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_municipio, municipio, id_departamento
                FROM tb_municipios
                WHERE municipio LIKE ?
                ORDER BY municipio';
        $params = array($value);
        return Database::getRows($sql, $params);
    }
    

    public function createRow()
    {
        $sql = 'INSERT INTO tb_municipios(municipio, id_departamento)
                VALUES(?, ?)';
        $params = array($this->Muni, $this->Depa);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
{
    $sql = 'UPDATE tb_municipios AS m
            INNER JOIN tb_departamentos AS d ON m.id_departamento = d.id_departamento
            SET m.municipio = ?, m.id_departamento = ?
            WHERE m.id_municipio = ?';
    $params = array($this->Muni, $this->Depa, $this->id);
    return Database::executeRow($sql, $params);
}


    public function readAll()
    {
        $sql = 'SELECT id_municipio, municipio, departamento
        FROM tb_municipios
        INNER JOIN tb_departamentos USING(id_departamento)
        ORDER BY municipio';
        return Database::getRows($sql);
    }

    public function readAllS()
    {
        $sql = 'SELECT id_departamento, departamento
        FROM tb_departamentos
        ORDER BY departamento';
        return Database::getRows($sql);
    }
    

    public function readOne()
    {
        $sql = 'SELECT 
            id_municipio, 
            municipio,
            id_departamento,
            departamento
        FROM tb_municipios
        INNER JOIN tb_departamentos USING(id_departamento)
        WHERE id_municipio = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_municipios
                WHERE id_municipio = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
