<?php
// Se incluye la clase del modelo.
require_once('../../models/data/distritos_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $Distrito = new distritoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $Distrito->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
                case 'createRow':
                    $_POST = Validator::validateForm($_POST);
                    if (
                        ! $Distrito->setNombre($_POST['nombreDis']) or
                        ! $Distrito->setCategorias($_POST['Municipio'])or
                        ! $Distrito->setCategoria($_POST['Departamento'])
                    ) {
                        $result['error'] = $Distrito->getDataError();
                    } elseif ($Distrito->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Distrito creado correctamente';
                    } else {
                        $result['error'] = 'Ocurrió un problema al crear el distrito';
                    }
                    break;
                
            case 'readAll':
                if ($result['dataset'] =  $Distrito->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen distritos registrados';
                }
                break;
                case 'readAllS':
                    if ($result['dataset'] =  $Distrito->readAllS()) {
                        $result['status'] = 1;
                        $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                    } else {
                        $result['error'] = 'No existen departamentos registrados';
                    }
                    break;
                    case 'readAllSS':
                        if ($result['dataset'] =  $Distrito->readAllSS()) {
                            $result['status'] = 1;
                            $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                        } else {
                            $result['error'] = 'No existen municipios registrados';
                        }
                        break;
            case 'readOne':
                if (! $Distrito->setId($_POST['idDistrito'])) {
                    $result['error'] =  $Distrito->getDataError();
                } elseif ($result['dataset'] =  $Distrito->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Distrito inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    ! $Distrito->setId($_POST['idDistrito'])or
                    ! $Distrito->setCategorias($_POST['Municipio'])or
                    ! $Distrito->setCategoria($_POST['Departamento'])or
                    ! $Distrito->setNombre($_POST['nombreDis']) 
                ) {
                    $result['error'] = $Distrito->getDataError();
                } elseif ( $Distrito->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Distrito modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el distrito';
                }
                break;
            case 'deleteRow':
                if (
                    ! $Distrito->setid($_POST['idDistrito'])
                ) {
                    $result['error'] =  $Distrito->getDataError();
                } elseif ( $Distrito->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Distrito eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el distrito';
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