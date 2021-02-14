<?php

namespace Eventos;

require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/eventos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/connect.php';

class EventoDAO
{
    public static $instance;

    private function __construct()
    {
        //
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new EventoDAO();
        }

        return self::$instance;
    }

    public function create()
    {
    }

    public function read()
    {
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
