<?php

namespace Controllers;

class Autenticate extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view->title = "Oasis Assistant: Autenticação";
        $this->view->verify = 0;
        $this->view->render('autenticate/inc/header');
        $this->view->render('autenticate/index');
        $this->view->render('autenticate/inc/footer');
    }

    public function autenticate($cod)
    {
        $this->view->title = "Oasis Assistant: Autenticação";
        $this->view->verify = $this->model->autenticate($cod);
        $this->view->render('autenticate/inc/header');
        $this->view->render('autenticate/index');
        $this->view->render('autenticate/inc/footer');
    }
}
