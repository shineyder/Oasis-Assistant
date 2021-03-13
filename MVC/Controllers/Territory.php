<?php

namespace Controllers;

use utl\Auth;

class Territory extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    public function index()
    {
        $this->view->title = "Oasis Assistant: Territórios";
        $this->view->local = "Territórios";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('territory/index');
        $this->view->render('territory/inc/pageScript');
        $this->view->render('footer');
    }

    public function updateMaps()
    {
        $this->model->updateMaps();
    }

    // public function showRegionalMap($identificator);
    // {
    //     //
    // }
}
