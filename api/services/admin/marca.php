<?php
header("Access-Control-Allow-Origin: *");

require_once('../../helpers/database.php');
require_once('../../models/data/marca_data.php');

if (isset($_GET['action'])) {
    session_start();
    $marca = new MarcaData;
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null);

    // Verificar sesión de administrador y manejar acciones según $_GET['action']
    if (isset($_SESSION['idAdministrador'])) {
        switch ($_GET['action']) {
            case 'searchRows':
                // Implementación para buscar marcas
                if (isset($_POST['search'])) {
                    // Realizar búsqueda con el término proporcionado
                    $result['dataset'] = $marca->searchRows($_POST['search']);
                    if ($result['dataset']) {
                        $result['status'] = 1;
                        $result['message'] = 'Búsqueda exitosa';
                    } else {
                        $result['error'] = 'No se encontraron resultados';
                    }
                } else {
                    $result['error'] = 'Se requiere un término de búsqueda';
                }
                break;

            case 'createRow':
                // Implementación para crear una nueva marca
                if (isset($_POST['nombre'])) {
                    if ($marca->setNombre($_POST['nombre'])) {
                        if ($marca->createRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Marca creada correctamente';
                        } else {
                            $result['error'] = 'Error al crear la marca';
                        }
                    } else {
                        $result['error'] = $marca->getDataError();
                    }
                } else {
                    $result['error'] = 'Se requiere el nombre de la marca';
                }
                break;

            case 'readAll':
                // Implementación para leer todas las marcas
                $result['dataset'] = $marca->readAll();
                if ($result['dataset']) {
                    $result['status'] = 1;
                    $result['message'] = 'Marcas obtenidas correctamente';
                } else {
                    $result['error'] = 'No se encontraron marcas';
                }
                break;

            case 'readOne':
                // Implementación para leer una marca específica
                if (isset($_POST['id'])) {
                    if ($marca->setId($_POST['id'])) {
                        $result['dataset'] = $marca->readOne();
                        if ($result['dataset']) {
                            $result['status'] = 1;
                        } else {
                            $result['error'] = 'La marca especificada no existe';
                        }
                    } else {
                        $result['error'] = $marca->getDataError();
                    }
                } else {
                    $result['error'] = 'Se requiere el ID de la marca';
                }
                break;

            case 'updateRow':
                // Implementación para actualizar una marca
                if (isset($_POST['id'], $_POST['nombre'])) {
                    if ($marca->setId($_POST['id']) && $marca->setNombre($_POST['nombre'])) {
                        if ($marca->updateRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Marca actualizada correctamente';
                        } else {
                            $result['error'] = 'Error al actualizar la marca';
                        }
                    } else {
                        $result['error'] = $marca->getDataError();
                    }
                } else {
                    $result['error'] = 'Se requieren el ID y el nombre de la marca';
                }
                break;

            case 'deleteRow':
                // Implementación para eliminar una marca
                if (isset($_POST['id'])) {
                    if ($marca->setId($_POST['id'])) {
                        if ($marca->deleteRow()) {
                            $result['status'] = 1;
                            $result['message'] = 'Marca eliminada correctamente';
                        } else {
                            $result['error'] = 'Error al eliminar la marca';
                        }
                    } else {
                        $result['error'] = $marca->getDataError();
                    }
                } else {
                    $result['error'] = 'Se requiere el ID de la marca';
                }
                break;

            default:
                $result['error'] = 'Acción no válida';
                break;
        }
    } else {
        $result['error'] = 'Acceso denegado. Inicie sesión como administrador';
    }

    // Obtener excepción de la base de datos, si la hubiera
    $result['exception'] = Database::getException();

    // Establecer tipo de contenido y devolver resultado como JSON
    header('Content-type: application/json; charset=utf-8');
    echo json_encode($result);
} else {
    echo json_encode('Acción no especificada');
}
?>
