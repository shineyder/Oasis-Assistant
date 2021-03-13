<?php

namespace Models;

use utl\Hash;

class HomeModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updatePubEmail()
    {
        echo "<pre>";
        print_r($_POST);
        //Validando POST
        $id = $this->sanitize(5, 'id', "home");
        $email = $this->sanitize(3, 'email-up', "home");

        //Verificando se os campos foram preenchidos
        if (empty($email)) :
            $this->msg("Campo Novo E-mail não foi preenchido", "warning", "home");
        endif;

        //Verificando se o novo email e o anterior são iguais
        $publicadorUp = $this->db->read("publisher", "*", "id = $id");
        if ($publicadorUp->getEmail() == $email) :
            $this->msg("E-mail antigo e novo são iguais", "warning", "home");
        endif;

        //Atualiza o email no cadastro
        $this->db->update("publisher", ["email" => $email], "id = $id");

        //Registra log do ocorrido
        $log = ["id" => null, "id_user" => $publicadorUp->getId(), "id_mapa" => null, "timeN" => date('d/m/Y H:i:s'), "event_type" => "attPub", "data1" => "AltEmail", "desc1" => $email, "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
        $this->db->create("event", $log);

        //Emite mensagem de sucesso e direciona para home
        $this->msg("E-mail alterado com sucesso!", "success", "home");
        exit();
    }

    public function updatePubPass()
    {
        //Validando POST
        $id = $this->sanitize(5, 'id', "home");
        $senha_old = $this->sanitize(2, 'senha-old', "home");
        $senha = $this->sanitize(2, 'senha-new', "home");
        $senha_conf = $this->sanitize(2, 'senha-new-conf', "home");

        //Verificando se os campos foram preenchidos
        if (empty($senha_old) or empty($senha) or empty($senha_conf)) :
            $this->msg("Todos os campos precisam ser preenchidos", "warning", "home");
        endif;

        //Verifica se as senhas novas digitadas são iguais
        if ($senha != $senha_conf) :
            $this->msg("As novas senhas preenchidas não são iguais", "warning", "home");
        endif;

        //Criptografa as senhas
        $senha_old = Hash::create('md5', $senha_old, HASH_PASS_KEY);
        $senha = Hash::create('md5', $senha, HASH_PASS_KEY);

        //Verifica se a senha antiga confere
        $publicadorUp = $this->db->read("publisher", "*", "id = $id");
        if ($publicadorUp->getSenha() != $senha_old) :
            $this->msg("Senha antiga não confere", "warning", "home");
        endif;

        //Atualiza a senha no cadastro
        $this->db->update("publisher", ["senha" => $senha], "id = $id");

        //Registra log do ocorrido
        $log = ["id" => null, "id_user" => $publicadorUp->getId(), "id_mapa" => null, "timeN" => date('d/m/Y H:i:s'), "event_type" => "attPub", "data1" => "AltSenha", "desc1" => $senha, "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
        $this->db->create("event", $log);

        //Emite mensagem de sucesso e direciona para home
        $this->msg("Senha alterada com sucesso!", "success", "home");
    }
}