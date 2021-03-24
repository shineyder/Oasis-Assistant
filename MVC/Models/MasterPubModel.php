<?php

namespace Models;

class MasterPubModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updatePubGrupo()
    {
        //Validando POST
        $id = $this->sanitize(5, "id", "MasterPub");
        $grupo = $this->sanitize(4, "group", "MasterPub");

        //Atualiza o grupo no cadastro
        $this->db->update("publisher", ["grupo" => $grupo], "id = $id");

        //Registra log do ocorrido
        $log = ["id" => null, "idUser" => $id, "idMapa" => null, "timeN" => date('d/m/Y H:i:s'), "eventType" => "attPub", "data1" => "AltGrup", "desc1" => $grupo, "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
        $this->db->create("event", $log);

        //Emite mensagem de sucesso e direciona para Master Publicador
        $this->msg("Grupo alterado com sucesso!", "success", "MasterPub");
        exit();
    }

    public function updatePubAccess()
    {
        //Validando POST
        $id = $this->sanitize(5, "id", "MasterPub");
        $access = $this->sanitize(4, "acc", "MasterPub");

        //Atualiza o access no cadastro
        $this->db->update("publisher", ["access" => $access], "id = $id");

        //Registra log do ocorrido
        $log = ["id" => null, "idUser" => $id, "idMapa" => null, "timeN" => date('d/m/Y H:i:s'), "eventType" => "attPub", "data1" => "AltAcc", "desc1" => $access, "data2" => null, "desc2" => null, "data3" => null, "desc3" => null, "data4" => null, "desc4" => null];
        $this->db->create("event", $log);

        //Emite mensagem de sucesso e direciona para Master Publicador
        $this->msg("Acesso alterado com sucesso!", "success", "MasterPub");
        exit();
    }
}
