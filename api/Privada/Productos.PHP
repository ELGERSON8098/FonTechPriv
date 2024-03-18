<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

define('SERVER', 'localhost');
define('DATABASE', 'db_fon');
define('USERNAME', 'root');
define('PASSWORD', '');

try {
    $conexion = new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE, USERNAME, PASSWORD);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 0, 'error' => 'Error de conexión: ' . $e->getMessage()]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $sql = 'SELECT id_producto, nombre_producto, descripcion, precio FROM productos';
        $stmt = $conexion->query($sql);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 1, 'data' => $productos]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['status' => 0, 'error' => 'Error al obtener los productos: ' . $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (empty($data) || !isset($data['nombre_producto']) || !isset($data['descripcion']) || !isset($data['precio'])) {
        http_response_code(400);
        echo json_encode(['status' => 0, 'error' => 'Datos insuficientes']);
    } else {
        try {
            $nombre_producto = $data['nombre_producto'];
            $descripcion = $data['descripcion'];
            $precio = $data['precio'];

            $sql = 'INSERT INTO productos (nombre_producto, descripcion, precio) VALUES (:nombre_producto, :descripcion, :precio)';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre_producto', $nombre_producto);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':precio', $precio);
            
            if ($stmt->execute()) {
                echo json_encode(['status' => 1, 'message' => 'Producto creado correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 0, 'error' => 'Error al insertar el producto']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 0, 'error' => 'Error al insertar el producto: ' . $e->getMessage()]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id']; // Obtener el ID del producto desde la URL

    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['status' => 0, 'error' => 'ID de producto no proporcionado']);
    } else {
        try {
            $sql = 'DELETE FROM productos WHERE id_producto = :id';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo json_encode(['status' => 1, 'message' => 'Producto eliminado correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 0, 'error' => 'Error al eliminar el producto']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 0, 'error' => 'Error al eliminar el producto: ' . $e->getMessage()]);
        }
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 0, 'error' => 'Método no permitido']);
}
?>
