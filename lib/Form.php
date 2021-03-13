<?php

namespace lib;

use Exception;
use utl\Validator;

class Form
{
    /** @var object $validator The validator object */
    private $validator;

    /** @var array $postData Stores the posted data */
    private $postData = array();

    /** @var string $currentItem Stores the immediately posted item */
    private $currentItem = null;

    /** @var array $error Holds the current form erros */
    private $currentError = array();

    /** Construct: Instantiate the validator class */
    public function __construct()
    {
        $this->validator = new Validator();
    }

    /** This is to run $_POST */
    public function post($field, $clean = false)
    {
        if ($clean) :
            $this->postData[$field] = $this->clean($_POST[$field]);
        else :
            $this->postData[$field] = $_POST[$field];
        endif;
        $this->currentItem = $field;
        return $this;
    }

    /**
     * clean
     * @return string Retorna string sem caracter especial
     */
    public function clean($data)
    {
        return strtr(utf8_decode($data), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    /** This is to return the posted data */
    public function fetch($fieldName = false)
    {
        if ($fieldName) :
            if (isset($this->postData[$fieldName])) :
                return $this->postData[$fieldName];
            else :
                return false;
            endif;
        else :
            return $this->postData;
        endif;
    }

    /**
     * This is to validate
     * @param string $typeOfValidator The function of Validator to call
     * @param mixed $arg The argument of Validator, can be a string or a integer
     */
    public function val($typeOfValidator, $arg = null)
    {
        if ($arg == null) :
            $result = $this->validator->$typeOfValidator($this->postData[$this->currentItem]);
        else :
            $result = $this->validator->$typeOfValidator($this->postData[$this->currentItem], $arg);
        endif;

        if ($result) :
            $this->currentError[$this->currentItem] = "Erro no campo " . $this->currentItem . ": " . $result;
        endif;

        return $this;
    }

    /** Check for an error and throw an exception if necessary */
    public function submit()
    {
        if (empty($this->currentError)) :
            return true;
        else :
            $e = implode(';<br> ', $this->currentError);
            throw new Exception($e);
        endif;
    }
}
