<?php
// Se incluye la clase del modelo.
require_once('../../models/data/municipio_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $municipio = new municipioData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $municipio->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$municipio->setNombre($_POST['nombreMun']) or
                    !$municipio->setCategoria($_POST['Departamento'])
                ) {
                    $result['error'] = $municipio->getDataError();
                } elseif ($municipio->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Municipio creado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear el municipio';
                }
                break;

            case 'readAll':
                if ($result['dataset'] =  $municipio->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen municipios registrados';
                }
                break;
            case 'readAllS':
                if ($result['dataset'] =  $municipio->readAllS()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen municipios registrados';
                }
                break;
            case 'readOne':
                if (!$municipio->setId($_POST['idMunicipio'])) {
                    $result['error'] =  $municipio->getDataError();
                } elseif ($result['dataset'] =  $municipio->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Municipio inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$municipio->setId($_POST['idMunicipio']) or
                    !$municipio->setCategoria($_POST['Departamento']) or
                    !$municipio->setNombre($_POST['nombreMun'])
                ) {
                    $result['error'] = $municipio->getDataError();
                } elseif ($municipio->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Municipio modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el municipio';
                }
                break;
            case 'deleteRow':
                if (
                    !$municipio->setid($_POST['idMunicipio'])
                ) {
                    $result['error'] =  $municipio->getDataError();
                } elseif ($municipio->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Municipio eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el municipio';
                }
                break;
        }
        // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
        $result['exception'] = Database::getException();
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('Content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
