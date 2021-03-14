<?php

namespace Controllers;

use utl\Auth;

class Report extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    public function index()
    {
        $this->view->pub = $this->model->db->read("publisher", "id, nome, sobrenome");
        $this->view->report = $this->model->readRelatorio();
        $this->view->title = "Oasis Assistant: Relatórios";
        $this->view->local = "Relatórios";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('report/index');
        $this->view->render('footer');
    }

    public function updatePub()
    {
        $this->model->updatePub();
    }

    public function doS13()
    {
        $this->model->doS13();
    }
}
