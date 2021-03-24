<?php

namespace Models;

class MasterRequestModel extends \lib\Model
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

    public function updateRequest()
    {
        $id = $this->sanitize(5, "id", "MasterRequest");
        $statusNow = $this->sanitize(7, "sol", "MasterRequest");

        $this->db->update("contactus", ["statusNow" => $statusNow], "id = $id");

        $this->msg("Status atualizado com sucesso!", "success", "MasterRequest");
        exit();
    }
}
