<?php

namespace Controllers;

use utl\Auth;

class MasterReq extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleAccess(8);
    }

    public function index()
    {
        $this->view->problem = $this->model->db->read("contactus", "*", "assunto = 'Problema'", "ORDER BY id DESC");
        $this->view->sugest = $this->model->db->read("contactus", "*", "assunto = 'Sugestão'", "ORDER BY id DESC");
        $this->view->other = $this->model->db->read("contactus", "*", "assunto = 'Outro'", "ORDER BY id DESC");
        $this->view->publishers = $this->model->searchUsers();

        $this->view->title = "Oasis Assistant Master: Solicitações";
        $this->view->local = "Master: Solicitações";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('masterReq/index');
        $this->view->render('masterReq/inc/footer');
    }

    public function updateReq()
    {
        $this->model->updateReq();
    }
}
