<?php

namespace lib;

use Exception;
use utl\Validator;

class Form
{
    private $validator;
    private $postData = array();
    private $currentItem = null;
    private $currentError = array();

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function post($field)
    {
        $this->postData[$field] = $_POST[$field];
        $this->currentItem = $field;
        return $this;
    }

    public function clean()
    {
        $this->postData[$this->currentItem] = strtr(utf8_decode($this->postData[$this->currentItem]), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
        return $this;
    }

    public function fetch()
    {
        return $this->postData;
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
