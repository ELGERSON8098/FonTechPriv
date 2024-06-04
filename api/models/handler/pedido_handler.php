<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de las tablas PEDIDO y DETALLE_PEDIDO.
*/
class PedidoHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id_pedido = null;
    protected $id_detalle = null;
    protected $cliente = null;
    protected $producto = null;
    protected $cantidad = null;
    protected $precio = null;
    protected $estado = null;

    /*
    *   ESTADOS DEL PEDIDO
    *   Pendiente (valor por defecto en la base de datos). Pedido en proceso y se puede modificar el detalle.
    *   Finalizado. Pedido terminado por el cliente y ya no es posible modificar el detalle.
    *   Entregado. Pedido enviado al cliente.
    *   Anulado. Pedido cancelado por el cliente después de ser finalizado.
    */

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    // Método para verificar si existe un pedido en proceso con el fin de iniciar o continuar una compra.
    public function getOrder()
    {
        $this->estado = 'Pendiente';
        $sql = 'SELECT id_reserva
                FROM tb_reservas
                WHERE estado_reserva = ? AND id_usuario = ?';
        $params = array($this->estado, $_SESSION['idUsuario']);
        if ($data = Database::getRow($sql, $params)) {
            $_SESSION['idPedido'] = $data['id_reserva'];
            return true;
        } else {
            return false;
        }
    }

    // Método para iniciar un pedido en proceso.
    public function startOrder()
    {
        if ($this->getOrder()) {
            return true;
        } else {
            $sql = 'INSERT INTO tb_reservas(id_usuario, fecha_reserva, estado_reserva)
                VALUES(?,now(),?,"Pendiente",1)';
            $params = array($_SESSION['idUsuario']);
            // Se obtiene el ultimo valor insertado de la llave primaria en la tabla pedido.
            if ($_SESSION['idPedido'] = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        // Se realiza una subconsulta para obtener el precio del producto.
        $sql = 'INSERT INTO tb_detalles_reservas(id_producto, precio_unitario, cantidad, id_reserva)
                VALUES(?, ?,(SELECT precio FROM tb_productos WHERE id_producto = ?), ?)';
        $params = array($this->producto, $this->producto, $this->cantidad, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readDetail()
    {
        $sql = 'SELECT 
        dr.id_detalle_reserva, 
        p.nombre_producto, 
        dr.precio_unitario, 
        dr.cantidad, 
        r.estado_reserva
    FROM 
        tb_detalles_reservas dr
    INNER JOIN 
        tb_reservas r ON dr.id_reserva = r.id_reserva
    INNER JOIN 
        tb_productos p ON dr.id_producto = p.id_producto
    WHERE 
        dr.id_reserva = ?';
        $params = array($_SESSION['idPedido']);
        return Database::getRows($sql, $params);
    }

    // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
        $this->estado = 'Aceptado';
        $sql = 'UPDATE tb_reservas
                SET estado_reserva = ?
                WHERE id_reserva = ?';
        $params = array($this->estado, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE tb_detalles_reservas
                SET cantidad = ?
                WHERE id_detalle_reserva = ? AND id_reserva = ?';
        $params = array($this->cantidad, $this->id_detalle, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }

    // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM tb_detalles_reservas
                WHERE id_detalle_reserva = ? AND id_reserva = ?';
        $params = array($this->id_detalle, $_SESSION['idPedido']);
        return Database::executeRow($sql, $params);
    }
}
