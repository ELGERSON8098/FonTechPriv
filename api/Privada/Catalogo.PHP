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
        $sql = 'SELECT id_Categoria_Fon, nombre_Categoria, producto_Categoria, id_Marca_Fon FROM tb_categorias_fon';
        $stmt = $conexion->query($sql);
        $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 1, 'data' => $catalogo]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['status' => 0, 'error' => 'Error al obtener las marcas: ' . $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (empty($data) || !isset($data['nombre'])) {
        http_response_code(400);
        echo json_encode(['status' => 0, 'error' => 'Datos insuficientes']);
    } else {
        try {
            $nombre = $data['nombre'];
            $sql = 'INSERT INTO tb_categorias_fon (nombre_Categoria) VALUES (:nombre)';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            
            if ($stmt->execute()) {
                echo json_encode(['status' => 1, 'message' => 'Marca creada correctamente']);
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
    $id = $_GET['id']; // Obtener el ID de catalogo desde la URL

    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['status' => 0, 'error' => 'ID catalogo no proporcionado']);
    } else {
        try {
            $sql = 'DELETE FROM tb_categorias_fon WHERE id_Categoria_Fon = :id';
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
}
 else {
    http_response_code(405);
    echo json_encode(['status' => 0, 'error' => 'Método no permitido']);
}
?>
