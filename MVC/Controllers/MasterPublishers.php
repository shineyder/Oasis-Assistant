<?php

namespace Controllers;

use utl\Auth;

class MasterPublishers extends \lib\Controller
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
        $this->view->render('masterPublishers/index');
        $this->view->render('masterPublishers/inc/footer');
    }

    public function updatePublisherGroup()
    {
        $this->model->updatePublisherGroup();
    }

    public function updatePublisherAccess()
    {
        $this->model->updatePublisherAccess();
    }
}
