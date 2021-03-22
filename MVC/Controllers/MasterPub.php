<?php

namespace Controllers;

use utl\Auth;

class MasterPub extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleAccess(8);
    }

    public function index()
    {
        $this->view->publicadores = $this->model->db->read("publisher", "*", "", "ORDER BY grupo ASC, access DESC");
        $this->view->title = "Oasis Assistant Master: Publicadores";
        $this->view->local = "Master: Publicadores";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('masterPub/index');
        $this->view->render('masterPub/inc/footer');
    }

    public function updatePubGrupo()
    {
        $this->model->updatePubGrupo();
    }

    public function updatePubAccess()
    {
        $this->model->updatePubAccess();
    }
}
