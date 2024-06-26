<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/distritos_handler.php');
/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla CATEGORIA.
 */
class distritoData extends distritoHandler
{
    private $data_error = null;

    /*
     *  Métodos para validar y asignar valores de los atributos.
     */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del departamento es incorrecto';
            return false;
        }
    }

    public function setNombre($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El nombre debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->Distrito = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->Depa = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del departamento es incorrecto';
            return false;
        }
    }

    public function setCategorias($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->Muni = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del municipio es incorrecto';
            return false;
        }
    }



    // Método para obtener el error de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }
}
