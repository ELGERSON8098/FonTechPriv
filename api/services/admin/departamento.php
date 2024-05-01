<?php
// Se incluye la clase del modelo.
require_once('../../models/data/departamento_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $departamento = new departamentoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $departamento->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
                case 'createRow':
                    $_POST = Validator::validateForm($_POST);
                    if (! $departamento->setNombre($_POST['NomDepa'])) {
                        $result['error'] = $ $departamento->getDataError();
                    } elseif ( $departamento->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Departamento agregado correctamente';
                    } else {
                        $result['error'] =  $departamento->getDataError() ?: 'Ocurrió un problema al agregar el departamento';
                    }
                    break;
                
            case 'readAll':
                if ($result['dataset'] =  $departamento->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen departamentos registrados';
                }
                break;
            case 'readOne':
                if (! $departamento->setId($_POST['idDepartamento'])) {
                    $result['error'] =  $departamento->getDataError();
                } elseif ($result['dataset'] =  $departamento->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Departamento inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    ! $departamento->setId($_POST['idDepartamento'])or
                    ! $departamento->setNombre($_POST['NomDepa']) 
                ) {
                    $result['error'] = $color->getDataError();
                } elseif ( $departamento->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Departamento modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el departamento';
                }
                break;
            case 'deleteRow':
                if (
                    ! $departamento->setid($_POST['idDepartamento'])
                ) {
                    $result['error'] =  $departamento->getDataError();
                } elseif ( $departamento->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Departamento eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el departamento';
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