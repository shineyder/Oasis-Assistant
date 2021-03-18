<?php

namespace lib;

class Controller
{
    public function __construct()
    {
        $this->view = new View();
    }

    public function loadModel($name)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/MVC/Models/' . $name . 'Model.php';
        if (file_exists($path)) :
            $ModelName = "\Models\\" . $name . 'Model';
            $this->model = new $ModelName();
        endif;
    }
}
