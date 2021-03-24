<?php

namespace Models;

use utl\Hash;

class HomeModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updatePublisherEmail()
    {
        $id = $this->sanitize(5, 'id', "Home");
        $email = $this->sanitize(3, 'email-up', "Home");

        if (empty($email)) :
            $this->msg("Campo Novo E-mail não foi preenchido", "warning", "Home");
        endif;

        $publicadorUp = $this->db->read("publisher", "*", "id = $id");
        if ($publicadorUp->getEmail() == $email) :
            $this->msg("E-mail antigo e novo são iguais", "warning", "Home");
        endif;

        $this->db->update("publisher", ["email" => $email], "id = $id");

        //Registra log do ocorrido
        $log = ["id" => null,
                "idUser" => $publicadorUp->getId(),
                "idMapa" => null,
                "timeN" => date('d/m/Y H:i:s'),
                "eventType" => "attPub",
                "data1" => "AltEmail",
                "desc1" => $email,
                "data2" => null,
                "desc2" => null,
                "data3" => null,
                "desc3" => null,
                "data4" => null,
                "desc4" => null];
        $this->db->create("event", $log);

        $this->msg("E-mail alterado com sucesso!", "success", "Home");
        exit();
    }

    public function updatePublisherPassword()
    {
        $id = $this->sanitize(5, 'id', "Home");
        $senha_old = $this->sanitize(2, 'senha-old', "Home");
        $senha = $this->sanitize(2, 'senha-new', "Home");
        $senha_conf = $this->sanitize(2, 'senha-new-conf', "Home");

        if (empty($senha_old) or empty($senha) or empty($senha_conf)) :
            $this->msg("Todos os campos precisam ser preenchidos", "warning", "Home");
        endif;

        if ($senha != $senha_conf) :
            $this->msg("As novas senhas preenchidas não são iguais", "warning", "Home");
        endif;

        $senha_old = Hash::create('md5', $senha_old, HASH_PASS_KEY);
        $senha = Hash::create('md5', $senha, HASH_PASS_KEY);

        $publicadorUp = $this->db->read("publisher", "*", "id = $id");
        if ($publicadorUp->getSenha() != $senha_old) :
            $this->msg("Senha antiga não confere", "warning", "Home");
        endif;

        $this->db->update("publisher", ["senha" => $senha], "id = $id");

        $log = ["id" => null,
                "idUser" => $publicadorUp->getId(),
                "idMapa" => null,
                "timeN" => date('d/m/Y H:i:s'),
                "eventType" => "attPub",
                "data1" => "AltSenha",
                "desc1" => $senha,
                "data2" => null,
                "desc2" => null,
                "data3" => null,
                "desc3" => null,
                "data4" => null,
                "desc4" => null];
        $this->db->create("event", $log);

        $this->msg("Senha alterada com sucesso!", "success", "Home");
    }
}
