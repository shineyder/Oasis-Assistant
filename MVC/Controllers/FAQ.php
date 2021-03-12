<?php

namespace Controllers;

class FAQ extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        //QUANDO HOME TIVER PRONTO PODE DESCOMENTAR
        //Auth::handleLogin();
    }

    public function index()
    {
        $this->view->title = "Oasis Assistant: F.A.Q.";
        $this->view->local = "F.A.Q";
        $this->view->render('header');
        $this->view->render('FAQ/index');
        $this->view->render('footer');
    }
}
