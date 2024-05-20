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
        $sql = 'INSERT INTO tb_productos (nombre_producto, id_marca, id_categoria, imagen, estado_producto)
                VALUES (?, ?, ?, ?, ?)';
        $params = array($this->nombre_producto, $this->id_marca, $this->id_categoria, $this->imagen, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function createRowS()
{
    $sql = 'INSERT INTO tb_detalles_productos (
                id_producto,
                id_oferta,
                precio,
                existencias,
                descripcion,
                capacidad_memoria_interna_celular,
                ram_celular,
                pantalla_tamaño,
                camara_trasera_celular,
                sistema_operativo_celular,
                camara_frontal_celular,
                procesador_celular
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    $params = array(
        $this->id_producto,
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
    
    public function readAll()
    {
        $sql = /*'    SELECT * FROM tb_productos'*/'SELECT 
            p.id_producto,
            p.nombre_producto,
            m.marca,
            c.nombre_categoria,
            p.imagen,
            p.estado_producto
        FROM 
            tb_productos p
        INNER JOIN 
            tb_marcas m ON p.id_marca = m.id_marca
        INNER JOIN 
            tb_categorias c ON p.id_categoria = c.id_categoria';
    
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
            m.marca,
            c.nombre_categoria,
            p.imagen
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
    
    public function readOneS()
    {
        $sql = 'SELECT 
                    dp.id_detalle_producto,
                    dp.id_producto,
                    m.id_marca,
                    c.id_categoria,
                    dp.id_oferta,
                    dp.precio,
                    dp.existencias,
                    dp.descripcion,
                    dp.capacidad_memoria_interna_celular,
                    dp.ram_celular,
                    dp.pantalla_tamaño,
                    dp.camara_trasera_celular,
                    dp.sistema_operativo_celular,
                    dp.camara_frontal_celular,
                    dp.procesador_celular,
                    p.nombre_producto,
                    m.marca,
                    c.nombre_categoria,
                    p.imagen,
                    p.estado_producto
                FROM 
                    tb_detalles_productos AS dp
                INNER JOIN 
                    tb_productos AS p ON dp.id_producto = p.id_producto
                INNER JOIN 
                    tb_marcas AS m ON p.id_marca = m.id_marca
                INNER JOIN 
                    tb_categorias AS c ON p.id_categoria = c.id_categoria
                WHERE 
                    dp.id_producto = ?';
    
        $params = array($this->id_producto);
    
        return Database::getRow($sql, $params);
    }
    

public function updateRow()
{
    $sql = 'UPDATE tb_detalles_productos AS dp
            INNER JOIN tb_productos AS p ON dp.id_producto = p.id_producto
            SET dp.id_producto = ?,
                dp.id_oferta = ?,
                dp.precio = ?,
                dp.existencias = ?,
                dp.descripcion = ?,
                dp.capacidad_memoria_interna_celular = ?,
                dp.ram_celular = ?,
                dp.pantalla_tamaño = ?,
                dp.camara_trasera_celular = ?,
                dp.sistema_operativo_celular = ?,
                dp.camara_frontal_celular = ?,
                dp.procesador_celular = ?,
                p.nombre_producto = ?,
                p.imagen = ?,
                p.id_marca = ?, 
                p.id_categoria = ? ,
                p.estado_producto = ?
            WHERE dp.id_detalle_producto = ?';
    
    $params = array(
        $this->id_producto,
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
        $this->nombre_producto,
        $this->imagen,
        $this->id_marca,  // Asegúrate de ajustar el nombre de la propiedad según corresponda
        $this->id_categoria,  // Asegúrate de ajustar el nombre de la propiedad según corresponda
        $this->estado,
        $this->id_detalle_producto
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
