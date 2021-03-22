<?php

namespace Controllers;

use lib\Session;
use utl\Auth;

class ContactUs extends \lib\Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::handleLogin();
    }

    public function index()
    {
        $id = Session::get('id');
        $this->view->publicador = $this->model->db->read("publisher", "*", "id = $id");
        $this->view->title = "Oasis Assistant: Fale Conosco";
        $this->view->local = "Fale Conosco";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('contactUs/index');
        $this->view->render('footer');
    }

    public function sendTalk()
    {
        $this->model->sendTalk();
    }
}
