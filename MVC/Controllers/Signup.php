<?php

namespace Controllers;

use utl\Auth;

class Signup extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleLogSession();
    }

    public function index()
    {
        $this->view->title = "Oasis Assistant: Criar Conta";
        $this->view->render('signup/inc/header');
        $this->view->render('message');
        $this->view->render('signup/index');
        $this->view->render('signup/inc/footer');
    }

    public function registerPublisher()
    {
        $this->model->registerPublisher();
    }
}
