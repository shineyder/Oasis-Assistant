<?php

namespace Models;

use utl\Hash;
use utl\Redirect;
use lib\Session;

class IndexModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function loginRun()
    {
        //Validando POST
        $usuario = $this->sanitize(1, "usuario", "");
        $senha = Hash::create('md5', $this->sanitize(2, "senha", ""), HASH_PASS_KEY);

        //Verifica se usuário existe
        $verify = $this->db->read("publisher", "id", "usuario = '$usuario'", "");
        if ($verify == false) :
            $this->msg("Usuário inexistente", "warning");
        endif;

        //Verifica se a senha confere
        $verify = $this->db->read("publisher", "id, access", "usuario = '$usuario' AND senha = '$senha'", "");
        if ($verify == false) :
            $this->msg("Usuário e senha não conferem", "warning");
        endif;

        //Verifica se a conta está com email autenticado
        if ($verify['access'] == 0) :
            $this->msg("Acesse o email de verificação para liberar o acesso a conta", "info");
        endif;

        //Se não houver problemas, faz login
        Session::init();
        Session::set('loggedIn', true);
        Session::set('id', $verify['id']);
        Session::set('access', $verify['access']);
        Redirect::redirect(URL . 'home');
    }
}
