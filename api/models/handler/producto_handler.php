<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class productoHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */

    protected $id_producto = null;
    protected $nombre_producto = null;
    protected $descripcion = null;
    protected $id_oferta = null;
    protected $existencias = null;
    protected $imagen = null;
    protected $id_categoria = null;
    protected $capacidad_memoria_interna_celular = null;
    protected $ram_celular = null;
    protected $pantalla_tamaño = null;
    protected $id_marca = null;
    protected $precio = null;
    protected $cantidad = null;
    protected $camara_trasera_celular = null;
    protected $sistema_operativo_celular = null;
    protected $camara_frontal_celular = null;
    protected $procesador_celular = null;
    protected $id_detalle_producto = null;
    protected $estado = null;
    protected $categoria = null;
    const RUTA_IMAGEN = '../../images/productos/';

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT p.id_producto, p.nombre_producto, m.marca, c.nombre_categoria, p.imagen, p.estado_producto
                FROM tb_productos p
                INNER JOIN tb_marcas m ON p.id_marca = m.id_marca
                INNER JOIN tb_categorias c ON p.id_categoria = c.id_categoria
                WHERE p.nombre_producto LIKE ?
                ORDER BY p.nombre_producto';
        $params = array($value);
        return Database::getRows($sql, $params);
    }




    public function createRow()
    {
        $sql = 'INSERT INTO tb_productos (nombre_producto, id_marca, id_categoria, imagen, estado_producto, id_oferta, precio, existencias, descripcion, capacidad_memoria_interna_celular, ram_celular, pantalla_tamaño, camara_trasera_celular, sistema_operativo_celular, camara_frontal_celular, procesador_celular)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array(
            $this->nombre_producto,
            $this->id_marca,
            $this->id_categoria,
            $this->imagen,
            $this->estado,
            $this->id_oferta,
            $this->precio,
            $this->existencias,
            $this->descripcion,
            $this->capacidad_memoria_interna_celular,
            $this->ram_celular,
            $this->pantalla_tamaño,
            $this->camara_trasera_celular,
            $this->sistema_operativo_celular,
            $this->camara_frontal_celular,
            $this->procesador_celular
        );
        return Database::executeRow($sql, $params);
    }
    


    public function readProductosCategoria()
    {
        $sql = 'SELECT 
                    p.id_producto, 
                    p.imagen, 
                    p.nombre_producto, 
                    p.descripcion, 
                    p.precio, 
                    p.existencias,
                    p.capacidad_memoria_interna_celular,
                    p.ram_celular,
                    p.pantalla_tamaño,
                    p.camara_trasera_celular,
                    p.sistema_operativo_celular,
                    p.camara_frontal_celular,
                    p.procesador_celular
                FROM 
                    tb_productos p
                INNER JOIN 
                    tb_categorias c ON p.id_categoria = c.id_categoria
                WHERE 
                    p.id_categoria = ? 
                    AND p.estado_producto = true
                ORDER BY 
                    p.nombre_producto';
        
        $params = array($this->id_categoria);
        return Database::getRows($sql, $params);
    }
    


    public function readAll()
    {
        $sql = 'SELECT 
                    p.id_producto,
                    p.nombre_producto,
                    m.marca,
                    c.nombre_categoria,
                    p.imagen,
                    p.estado_producto,
                    p.id_oferta,
                    p.precio,
                    p.existencias,
                    p.descripcion,
                    p.capacidad_memoria_interna_celular,
                    p.ram_celular,
                    p.pantalla_tamaño,
                    p.camara_trasera_celular,
                    p.sistema_operativo_celular,
                    p.camara_frontal_celular,
                    p.procesador_celular
                FROM 
                    tb_productos p
                INNER JOIN 
                    tb_marcas m ON p.id_marca = m.id_marca
                INNER JOIN 
                    tb_categorias c ON p.id_categoria = c.id_categoria
                ORDER BY 
                    p.nombre_producto';
    
        return Database::getRows($sql);
    }
    

    public function readAllS()
    {
        $sql = 'SELECT 
        id_categoria,
        nombre_categoria
    FROM 
        tb_categorias';

        return Database::getRows($sql);
    }

    public function readAllSS()
    {
        $sql = 'SELECT 
        id_marca,
        marca
    FROM 
        tb_marcas';

        return Database::getRows($sql);
    }

    public function readAllSSS()
    {
        $sql = 'SELECT 
        id_oferta,
        nombre_descuento
    FROM 
    tb_ofertas';

        return Database::getRows($sql);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen
            FROM tb_productos
            WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::getRow($sql, $params);
    }


    public function readOne()
    {
        $sql = 'SELECT 
                    p.id_producto,
                    p.nombre_producto,
                    m.id_marca,
                    c.id_categoria,
                    p.imagen,
                    p.estado_producto,
                    p.id_oferta,
                    p.precio,
                    p.existencias,
                    p.descripcion,
                    p.capacidad_memoria_interna_celular,
                    p.ram_celular,
                    p.pantalla_tamaño,
                    p.camara_trasera_celular,
                    p.sistema_operativo_celular,
                    p.camara_frontal_celular,
                    p.procesador_celular
                FROM 
                    tb_productos p
                INNER JOIN 
                    tb_marcas m ON p.id_marca = m.id_marca
                INNER JOIN 
                    tb_categorias c ON p.id_categoria = c.id_categoria
                WHERE 
                    p.id_producto = ?';
    
        $params = array($this->id_producto);
    
        return Database::getRow($sql, $params);
    }
    

    public function updateRow()
    {
        $sql = 'UPDATE tb_productos
                SET 
                    nombre_producto = ?,
                    id_marca = ?,
                    id_categoria = ?,
                    imagen = ?,
                    estado_producto = ?,
                    id_oferta = ?,
                    precio = ?,
                    existencias = ?,
                    descripcion = ?,
                    capacidad_memoria_interna_celular = ?,
                    ram_celular = ?,
                    pantalla_tamaño = ?,
                    camara_trasera_celular = ?,
                    sistema_operativo_celular = ?,
                    camara_frontal_celular = ?,
                    procesador_celular = ?
                WHERE id_producto = ?';
    
        $params = array(
            $this->nombre_producto,
            $this->id_marca,
            $this->id_categoria,
            $this->imagen,
            $this->estado,
            $this->id_oferta,
            $this->precio,
            $this->existencias,
            $this->descripcion,
            $this->capacidad_memoria_interna_celular,
            $this->ram_celular,
            $this->pantalla_tamaño,
            $this->camara_trasera_celular,
            $this->sistema_operativo_celular,
            $this->camara_frontal_celular,
            $this->procesador_celular,
            $this->id_producto
        );
        return Database::executeRow($sql, $params);
    }
    



    public function deleteRow()
    {
        //echo $this->id_producto;
        $sql = 'DELETE FROM tb_productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }
}
