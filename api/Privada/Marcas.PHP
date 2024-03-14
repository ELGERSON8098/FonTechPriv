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
        $sql = 'SELECT id_Marca_Fon, nombre_Marca, producto_marcar FROM tb_marcas_fon';
        $stmt = $conexion->query($sql);
        $marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 1, 'data' => $marcas]);
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
            $sql = 'INSERT INTO tb_marcas_fon (nombre_Marca) VALUES (:nombre)';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            
            if ($stmt->execute()) {
                echo json_encode(['status' => 1, 'message' => 'Marca creada correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 0, 'error' => 'Error al insertar la marca']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 0, 'error' => 'Error al insertar la marca: ' . $e->getMessage()]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['id']; // Obtener el ID de la marca desde la URL

    if (empty($id)) {
        http_response_code(400);
        echo json_encode(['status' => 0, 'error' => 'ID de marca no proporcionado']);
    } else {
        try {
            $sql = 'DELETE FROM tb_marcas_fon WHERE id_Marca_Fon = :id';
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                echo json_encode(['status' => 1, 'message' => 'Marca eliminada correctamente']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 0, 'error' => 'Error al eliminar la marca']);
            }
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['status' => 0, 'error' => 'Error al eliminar la marca: ' . $e->getMessage()]);
        }
    }
}
 else {
    http_response_code(405);
    echo json_encode(['status' => 0, 'error' => 'Método no permitido']);
}
?>
