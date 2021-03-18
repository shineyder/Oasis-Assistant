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
        $this->view->render('footer');
    }

    public function updateMaps($identificator)
    {
        $this->model->updateMaps($identificator);
    }

    public function showRegio($regio)
    {
        $this->view->regio = $regio;
        $this->view->title = "Oasis Assistant: Territórios";
        $this->view->local = "Territórios";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('territory/mapaRegio');
        $this->view->render('footer');
    }

    public function showLoc($regio, $loc)
    {
        $this->view->regio = $regio;
        $this->view->loc = $loc;
        $this->view->title = "Oasis Assistant: Territórios";
        $this->view->local = "Territórios";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('territory/mapaLoc');
        $this->view->render('footer');
    }

    public function frame($identificator)
    {
        $this->view->data = $this->model->db->read("map", "*", "maps = $identificator");
        $this->view->reportLoc = $identificator;
        $this->view->render('message');
        $this->view->render('territory/report');
    }
}
