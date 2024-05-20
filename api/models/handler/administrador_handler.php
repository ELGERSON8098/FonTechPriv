<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class AdministradorHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $apellido = null;
    protected $correo = null;
    protected $alias = null;
    protected $clave = null;

    /*
     *  Métodos para gestionar la cuenta del administrador.
     */
    public function checkUser($username, $password)
    {
        // Consultar el usuario y la contraseña del administrador en la tabla tb_admins
        $sql = 'SELECT id_administrador, usuario_administrador, clave_administrador
                FROM tb_admins
                WHERE usuario_administrador = ?';
        $params = array($username);
        $data = Database::getRow($sql, $params);
    
        if ($data && password_verify($password, $data['clave_administrador'])) {
            // Si las credenciales son válidas, establecer las variables de sesión y devolver el id_administrador
            $_SESSION['idAdministrador'] = $data['id_administrador'];
            $_SESSION['aliasAdministrador'] = $data['usuario_administrador'];
            return true;
        } else {
            // Si las credenciales no son válidas, devolver false
            return false;
        }
    }
    

    public function checkPassword($password)
    {
        // Consultar la contraseña del administrador en la tabla tb_admins
        $sql = 'SELECT clave_administrador
                FROM tb_admins
                WHERE id_administrador = ?';
        $params = array($_SESSION['idAdministrador']);
        $data = Database::getRow($sql, $params);
    
        // Verificar si la contraseña coincide con el hash almacenado en la base de datos.
        if ($data && password_verify($password, $data['clave_administrador'])) {
            return true; // La contraseña es correcta
        } else {
            return false; // La contraseña es incorrecta o el usuario no existe
        }
    }
    

    public function changePassword()
    {
        $sql = 'UPDATE tb_admins
                SET clave_administrador = ?
                WHERE id_administrador = ?';
        $params = array($this->clave, $_SESSION['id_administrador']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        // Consultar el perfil del administrador actual
        $sql = 'SELECT id_administrador, nombre_administrador, usuario_administrador, correo_administrador
                FROM tb_admins
                WHERE id_administrador = ?';
        $params = array($_SESSION['idAdministrador']);
        return Database::getRow($sql, $params);
    }
    
    public function editProfile()
    {
        // Actualizar el perfil del administrador
        $sql = 'UPDATE tb_admins
                SET nombre_administrador = ?, usuario_administrador = ?, correo_administrador = ?
                WHERE id_administrador = ?';
        $params = array($this->nombre, $this->alias, $this->correo, $_SESSION['idAdministrador']);
        return Database::executeRow($sql, $params);
    }

    public function createRow()
    {
        // Insertar un nuevo administrador en la tabla tb_admins
        $sql = 'INSERT INTO tb_admins(nombre_administrador, usuario_administrador, correo_administrador, clave_administrador)
                VALUES (?, ?, ?, ?)';
        $params = array($this->nombre, $this->alias, $this->correo, $this->clave);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        // Consultar todos los administradores en la tabla tb_admins
        $sql = 'SELECT id_administrador, nombre_administrador, usuario_administrador, correo_administrador
                FROM tb_admins';
        return Database::getRows($sql);
    }
    
    public function readOne()
    {
        // Consultar un administrador específico en la tabla tb_admins
        $sql = 'SELECT id_administrador, nombre_administrador, usuario_administrador, correo_administrador, clave_administrador
                FROM tb_admins
                WHERE id_administrador = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
}