<?php

namespace Controllers;

use utl\Auth;

class Problem extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleLogSession();
    }

    public function index()
    {
        $this->view->title = "Oasis Assistant: Recuperação";
        $this->view->render('problem/inc/header');
        $this->view->render('message');
        $this->view->render('problem/index');
        $this->view->render('problem/inc/footer');
    }

    public function recover()
    {
        $this->model->recover();
    }
}
