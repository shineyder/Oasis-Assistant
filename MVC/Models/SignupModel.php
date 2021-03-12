<?php

namespace Models;

use utl\Hash;

class SignupModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registerPub()
    {
        //Verifica se as informações foram preenchidas
        if (empty($_POST['nome']) or empty($_POST['sobrenome']) or empty($_POST['email']) or empty($_POST['usuario']) or empty($_POST['senha']) or empty($_POST['repeat-senha'])) :
            $this->msg("Todos os campos precisam ser preenchidos", "warning", "signup");
        endif;

        //Verifica se as senhas são iguais
        if ($_POST['senha'] != $_POST['repeat-senha']) :
            $this->msg("As senhas preenchidas não são iguais", "warning", "signup");
        endif;

        //Valida as variaveis em POST
        $nome = $this->sanitize(6, "nome", "signup");
        $sobrenome = $this->sanitize(6, "sobrenome", "signup");
        $email = $this->sanitize(3, "email", "signup");
        $usuario = $this->sanitize(1, "usuario", "signup");
        $senha = Hash::create('md5', $this->sanitize(2, "senha", "signup"), HASH_PASS_KEY);

        //Verifica se o nome de usuario já está em uso
        $info = $this->db->read("publisher", "usuario", "usuario = '$usuario'", "");
        if ($info != false) :
            $this->msg("Usuário já registrado", "warning", "signup");
        endif;

        //Verifica se o email já está em uso
        $info = $this->db->read("publisher", "email", "email = '$email'", "");
        if ($info != false) :
            $this->msg("E-mail já cadastrado", "warning", "signup");
        endif;

        //Registra o novo publicador
        $publicador = ["nome" => $nome, "sobrenome" => $sobrenome, "email" => $email, "usuario" => $usuario, "senha" => $senha];
        $this->db->create("publisher", $publicador);

        //Registra na log de eventos
        $log = ["id" => null, "id_user" => null, "id_mapa" => null, "timeN" => date('d/m/Y H:i:s'), "event_type" => "createPub", "data1" => "nome", "desc1" => $nome, "data2" => "sobrenome", "desc2" => $sobrenome, "data3" => "email", "desc3" => $email, "data4" => "usuario", "desc4" => $usuario];
        $this->db->create("event", $log);

        //Emite mensagem de sucesso e redireciona para a index
        $this->msg("Cadastrado com sucesso!", "success", "");
    }
}
