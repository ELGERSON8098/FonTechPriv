<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class distritoHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $Depa = null;
    protected $Muni = null;
    protected $Distrito = null;
    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT d.distrito, m.municipio, dp.departamento
                FROM tb_distritos d
                INNER JOIN tb_municipios m ON d.id_municipio = m.id_municipio
                INNER JOIN tb_departamentos dp ON m.id_departamento = dp.id_departamento
                WHERE d.distrito LIKE ? OR m.municipio LIKE ? OR dp.departamento LIKE ?
                ORDER BY d.distrito';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }


    public function createRow()
    {
        $sql = 'INSERT INTO tb_distritos(distrito, id_municipio)
                VALUES(?, ?)';
        $params = array($this->Distrito, $this->Muni);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_distritos AS d
                INNER JOIN tb_municipios AS m ON d.id_municipio = m.id_municipio
                INNER JOIN tb_departamentos AS depto ON m.id_departamento = depto.id_departamento
                SET d.distrito = ?, m.municipio = ?, m.id_departamento = ?
                WHERE d.id_distrito = ?';
        $params = array($this->Distrito, $this->Muni, $this->Depa, $this->id);
        return Database::executeRow($sql, $params);
    }



    public function readAll()
    {
        $sql = 'SELECT d.id_distrito, d.distrito, m.municipio, dep.departamento
                FROM tb_distritos AS d
                INNER JOIN tb_municipios AS m ON d.id_municipio = m.id_municipio
                INNER JOIN tb_departamentos AS dep ON m.id_departamento = dep.id_departamento
                ORDER BY d.distrito';
        return Database::getRows($sql);
    }

    public function readMunicipios()
    {
        $sql = 'SELECT id_municipio, municipio FROM tb_municipios WHERE id_departamento = ?';
        $params = array($this->Depa);
        return Database::getRows($sql, $params);
    }


    public function readAllS()
    {
        $sql = 'SELECT id_departamento, departamento
        FROM tb_departamentos
        ORDER BY departamento';
        return Database::getRows($sql);
    }

    public function readAllSS()
    {
        $sql = 'SELECT id_municipio, municipio
            FROM tb_municipios
            ORDER BY municipio';
        return Database::getRows($sql);
    }


    public function readOne()
    {
        $sql = 'SELECT 
                d.id_distrito, 
                d.distrito,
                m.id_municipio,
                m.municipio,
                dept.id_departamento,
                dept.departamento
            FROM 
                tb_distritos d
            INNER JOIN 
                tb_municipios m ON d.id_municipio = m.id_municipio
            INNER JOIN 
                tb_departamentos dept ON m.id_departamento = dept.id_departamento
            WHERE 
                d.id_distrito = ?';

        $params = array($this->id);
        return Database::getRow($sql, $params);
    }


    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_distritos
                WHERE id_distrito = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
