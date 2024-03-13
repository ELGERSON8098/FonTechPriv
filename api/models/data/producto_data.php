<?php
require_once('../../helpers/validator.php');
require_once('../../models/handler/marca_handler.php');

class MarcaData extends MarcaHandler
{
    private $data_error = null;

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El ID de la marca debe ser un número natural';
            return false;
        }
    }

    public function setNombre($value, $min = 2, $max = 50)
    {
        if (!Validator::validateString($value)) {
            $this->data_error = 'El nombre de la marca contiene caracteres inválidos';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre de la marca debe tener entre ' . $min . ' y ' . $max . ' caracteres';
            return false;
        }
    }

    public function setProducto($value)
    {
        // No se necesita validación especial para el producto de la marca en este contexto
        $this->producto = $value;
        return true;
    }

    public function getDataError()
    {
        return $this->data_error;
    }
}
?>
