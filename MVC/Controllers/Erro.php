<?php

namespace Controllers;

class Erro extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index($msg)
    {
        $this->view->title = "Error 404";
        $this->view->msg = $msg;
        $this->view->render('error/index');
    }
}
