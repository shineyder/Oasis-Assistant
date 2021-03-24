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
        $this->view->title = "Oasis Assistant: Relatórios";
        $this->view->local = "Relatórios";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('report/index');
        $this->view->render('footer');
    }

    public function updateReport()
    {
        $this->model->updateReport();
    }

    public function deleteReport()
    {
        $this->model->deleteReport();
    }

    public function doS13()
    {
        $this->model->doS13();
    }

    public function frame($pubId, $pg = 1)
    {
        $this->view->report = $this->model->readReport($pubId, $pg);
        $this->view->pg = $pg;
        $this->view->count = $this->model->count;
        $this->view->read = $pubId;
        $this->view->render('message');
        $this->view->render('report/report');
    }
}
