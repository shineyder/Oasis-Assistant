<?php

namespace Controllers;

class Signup extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        //QUANDO HOME TIVER PRONTO PODE DESCOMENTAR
        //Auth::handleLogSession();
    }

    public function index()
    {
        $this->view->title = "Oasis Assistant: Criar Conta";
        $this->view->render('signup/inc/header');
        $this->view->render('message');
        $this->view->render('signup/index');
        $this->view->render('signup/inc/footer');
    }

    public function registerPub()
    {
        $this->model->registerPub();
    }
}
