<?php 
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla marcas.
 */

 class MarcasHandler
 {
    /*
    * Declaración de atributos para el manejo de datos
    */
    
    protected $id = null;
    protected $nombre = null;
    protected $producto = null;

    /*
    *   Métodos para realizar las operaciones SCRUD (create, read, update, and delete).
    */

    public function readAll()
    {
        $sql = 'SELECT id_Marca_Fon, nombre_Marca,producto_marcar
                FROM tb_marcas_fon' ;
        return Database::getRows($sql);
    }
 }