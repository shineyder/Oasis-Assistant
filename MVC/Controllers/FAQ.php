<?php

namespace Controllers;

use utl\Auth;

class FAQ extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
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
