<?php
// Se incluye la clase del modelo.
require_once('../../models/data/producto_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $producto = new productoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $producto->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$producto->setImagen($_FILES['ImagenP']) or
                    !$producto->setNombre($_POST['nombreP']) or
                    !$producto->setCategoria($_POST['Categoria']) or
                    !$producto->setEstado(isset($_POST['estadoProducto1']) ? 1 : 0) or
                    !$producto->setCategorias($_POST['Marca']) or!$producto->setCantidad1($_POST['PrecioP']) or
                    !$producto->setCantidad2($_POST['Exist']) or
                    !$producto->setNombre1($_POST['Descrp']) or
                    !$producto->setNombre7($_POST['MemoriaP']) or
                    !$producto->setNombre8($_POST['RamP']) or
                    !$producto->setNombre2($_POST['TamañoP']) or
                    !$producto->setNombre3($_POST['CamP']) or
                    !$producto->setNombre4($_POST['CamsP']) or
                    !$producto->setNombre5($_POST['SisP']) or
                    !$producto->setNombre6($_POST['SistP']) or
                    !$producto->setCategoria1($_POST['Oferta'])
                ) {
                    $result['error'] = $producto->getDataError();
                } elseif ($producto->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Productos agregado correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['ImagenP'], $producto::RUTA_IMAGEN, $producto->getFilename());
                } else {
                    $result['error'] = $producto->getDataError() ?: 'Ocurrió un problema al agregar el producto';
                }
                break;

            case 'readAll':
                if ($result['dataset'] = $producto->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen productos registrados';
                }
                break;
            case 'readAllS':
                if ($result['dataset'] = $producto->readAllS()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen categorias registrados';
                }
                break;
            case 'readAllSS':
                if ($result['dataset'] = $producto->readAllSS()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen marcas registrados';
                }
                break;
            case 'readAllSSS':
                if ($result['dataset'] = $producto->readAllSSS()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen descuentos registrados';
                }
                break;
            case 'readOne':
                if (!$producto->setId($_POST['idProducto'])) {
                    $result['error'] = 'Producto incorrecto';
                } elseif ($result['dataset'] = $producto->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Producto inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$producto->setId($_POST['idProducto']) or
                    !$producto->setNombre($_POST['nombreP']) or
                    !$producto->setCategoria($_POST['Categoria']) or
                    !$producto->setCategorias($_POST['Marca']) or
                    !$producto->setCantidad1($_POST['PrecioP']) or
                    !$producto->setCantidad2($_POST['Exist']) or
                    !$producto->setNombre1($_POST['Descrp']) or
                    !$producto->setCantidad3($_POST['MemoriaP']) or
                    !$producto->setCantidad4($_POST['RamP']) or
                    !$producto->setNombre2($_POST['TamañoP']) or
                    !$producto->setNombre3($_POST['CamP']) or
                    !$producto->setNombre4($_POST['CamsP']) or
                    !$producto->setNombre5($_POST['SisP']) or
                    !$producto->setNombre6($_POST['SistP']) or
                    !$producto->setEstado(isset($_POST['estadoProducto']) ? 1 : 0) or
                    !$producto->setCategoria1($_POST['Oferta']) or
                    !$producto->setFilename() or
                    !$producto->setImagen($_FILES['ImagenP'], $producto->getFilename())
                ) {
                    $result['error'] = $producto->getDataError();
                } elseif ($producto->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto modificada correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['ImagenP'], $producto::RUTA_IMAGEN, $producto->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el producto';
                }
                break;
            case 'deleteRow':
                if (
                    !$producto->setid($_POST['idProducto'])
                ) {
                    $result['error'] = $producto->getDataError();
                } elseif ($producto->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Producto eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el producto';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible fuera de la sesión';
        }
    }
    // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
    $result['exception'] = Database::getException();
    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('Content-type: application/json; charset=utf-8');
    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    print(json_encode('Recurso no disponible'));
}
