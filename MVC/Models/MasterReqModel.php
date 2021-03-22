<?php

namespace Models;

class MasterReqModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function searchUsers()
    {
        $idUser = $this->db->read("contactus", "idUser");
        $idUser = array_unique(array_column($idUser, 'idUser'));
        $i = 0;
        foreach ($idUser as $value) :
            $user[$i] = $this->db->read("publisher", "id, nome, sobrenome, email", "id = $value");
            $i++;
        endforeach;
        return $user;
    }

    public function updateReq()
    {
        //Validando POST
        $id = $this->sanitize(5, "id", "MasterReq");
        $statusN = $this->sanitize(7, "sol", "MasterReq");

        //Atualiza o grupo no cadastro
        $this->db->update("contactus", ["statusN" => $statusN], "id = $id");

        //Emite mensagem de sucesso e direciona para Master Solicitações
        $this->msg("Status atualizado com sucesso!", "success", "MasterReq");
        exit();
    }
}
