<?php

namespace Models;

class MasterPublishersModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function updatePublisherGroup()
    {
        $id = $this->sanitize(5, "id", "MasterPublishers");
        $grupo = $this->sanitize(4, "group", "MasterPublishers");

        $this->db->update("publisher", ["grupo" => $grupo], "id = $id");

        $log = ["id" => null,
                "idUser" => $id,
                "idMapa" => null,
                "timeN" => date('d/m/Y H:i:s'),
                "eventType" => "attPub",
                "data1" => "AltGrup",
                "desc1" => $grupo,
                "data2" => null,
                "desc2" => null,
                "data3" => null,
                "desc3" => null,
                "data4" => null,
                "desc4" => null];
        $this->db->create("event", $log);

        $this->msg("Grupo alterado com sucesso!", "success", "MasterPublishers");
        exit();
    }

    public function updatePublisherAccess()
    {
        $id = $this->sanitize(5, "id", "MasterPublishers");
        $access = $this->sanitize(4, "acc", "MasterPublishers");

        $this->db->update("publisher", ["access" => $access], "id = $id");

        $log = ["id" => null,
                "idUser" => $id,
                "idMapa" => null,
                "timeN" => date('d/m/Y H:i:s'),
                "eventType" => "attPub",
                "data1" => "AltAcc",
                "desc1" => $access,
                "data2" => null,
                "desc2" => null,
                "data3" => null,
                "desc3" => null,
                "data4" => null,
                "desc4" => null];
        $this->db->create("event", $log);

        $this->msg("Acesso alterado com sucesso!", "success", "MasterPublishers");
        exit();
    }
}
