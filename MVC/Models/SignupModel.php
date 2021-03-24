<?php

namespace Models;

use lib\Mail;
use utl\Hash;

class SignupModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registerPublisher()
    {
        if (empty($_POST['nome']) or empty($_POST['sobrenome']) or empty($_POST['email']) or empty($_POST['usuario']) or empty($_POST['senha']) or empty($_POST['repeat-senha'])) :
            $this->msg("Todos os campos precisam ser preenchidos", "warning", "Signup");
        endif;

        if ($_POST['senha'] != $_POST['repeat-senha']) :
            $this->msg("As senhas preenchidas não são iguais", "warning", "Signup");
        endif;

        $nome = $this->sanitize(6, "nome", "Signup");
        $sobrenome = $this->sanitize(6, "sobrenome", "Signup");
        $email = $this->sanitize(3, "email", "Signup");
        $usuario = $this->sanitize(1, "usuario", "Signup");
        $senha = Hash::create('md5', $this->sanitize(2, "senha", "Signup"), HASH_PASS_KEY);

        $info = $this->db->read("publisher", "usuario", "usuario = '$usuario'");
        if ($info != false) :
            $this->msg("Usuário já registrado", "warning", "Signup");
        endif;

        $info = $this->db->read("publisher", "email", "email = '$email'");
        if ($info != false) :
            $this->msg("E-mail já cadastrado", "warning", "Signup");
        endif;

        $publicador = ["nome" => $nome, "sobrenome" => $sobrenome, "email" => $email, "usuario" => $usuario, "senha" => $senha];
        $this->db->create("publisher", $publicador);

        //Envia email de Bem-Vindo e Autenticação para o novo publicador
        $email_send = new Mail();
        $message = $email_send->message(5, [$nome, $sobrenome, $usuario]);
        $email_send->sendMail($publicador['email'], $publicador['nome'], $publicador['sobrenome'], $message, "E-mail de Autenticacao", "");

        $log = ["id" => null,
                "idUser" => null,
                "idMapa" => null,
                "timeN" => date('d/m/Y H:i:s'),
                "eventType" => "createPub",
                "data1" => "nome",
                "desc1" => $nome,
                "data2" => "sobrenome",
                "desc2" => $sobrenome,
                "data3" => "email",
                "desc3" => $email,
                "data4" => "usuario",
                "desc4" => $usuario];
        $this->db->create("event", $log);

        $this->msg("Cadastrado com sucesso!", "success", "");
    }
}
