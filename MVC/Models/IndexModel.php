<?php

namespace Models;

use Exception;
use lib\Form;
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
        $data = $this->sanitize();
        $senha = Hash::create('md5', $data['senha'], HASH_PASS_KEY);
        $usuario = $data['usuario'];

        //Verifica se usuário existe
        $verify = $this->db->read("Publicadores", "id", "usuario = '$usuario'", "");
        if ($verify == false) :
            Session::init();
            Session::set('message', "Usuário inexistente");
            Session::set('tipo', "warning");
            Redirect::redirect(URL);
        endif;

        //Verifica se a senha confere
        $verify = $this->db->read("Publicadores", "id, access", "usuario = '$usuario' AND senha = '$senha'", "");
        if ($verify == false) :
            Session::init();
            Session::set('message', "Usuário e senha não conferem");
            Session::set('tipo', "warning");
            Redirect::redirect(URL);
        endif;

        //Verifica se a conta está com email autenticado
        if ($verify['access'] == 0) :
            Session::init();
            Session::set('message', "Acesse o email de verificação para liberar o acesso a conta");
            Session::set('tipo', "info");
            Redirect::redirect(URL);
        endif;

        //Se não houver problemas, faz login
        Session::init();
        Session::set('loggedIn', true);
        Session::set('id', $verify['id']);
        Session::set('access', $verify['access']);
        Redirect::redirect(URL . 'home');
    }

    public function sanitize()
    {
        try {
            $form = new Form();
            $form   ->post('usuario')
                    ->val('alpha')
                    ->val('minLength', 1)
                    ->val('maxLength', 32)

                    ->post('senha')
                    ->val('minLength', 1)

                    ->submit();
            $data = $form->fetch();
        } catch (Exception $e) {
            Session::init();
            Session::set('message', $e->getMessage());
            Session::set('tipo', "info");
            Redirect::redirect(URL);
        }

        $data = filter_var_array(array_map('trim', $data), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return $data;
    }
}
