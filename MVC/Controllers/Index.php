<?php

namespace Controllers;

use utl\Auth;

class Index extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleLogSession();
    }

    public function index()
    {
        $this->view->title = "Oasis Assistant: Login";
        $this->view->render('index/inc/header');
        $this->view->render('message');
        $this->view->render('index/index');
        $this->view->render('index/inc/footer');
    }

    public function loginRun()
    {
        $this->model->loginRun();
    }
}
