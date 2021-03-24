<?php

namespace Controllers;

use lib\Session;
use utl\Auth;
use utl\Redirect;

class Home extends \lib\Controller
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
        $this->view->title = "Oasis Assistant: Home";
        $this->view->local = "Home";
        $this->view->render('header');
        $this->view->render('message');
        $this->view->render('home/index');
        $this->view->render('footer');
    }

    public function logout()
    {
        Session::destroy();
        Redirect::redirect(URL);
        exit();
    }

    public function updatePublisherEmail()
    {
        $this->model->updatePublisherEmail();
    }

    public function updatePublisherPassword()
    {
        $this->model->updatePublisherPassword();
    }
}
