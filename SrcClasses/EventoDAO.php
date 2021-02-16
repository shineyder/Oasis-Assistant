<?php

namespace Assistant;

use Assistant\Connect;
use Assistant\Eventos;

class EventoDAO
{
    public static $instance;

    private function __construct()
    {
        //
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new EventoDAO();
        }

        return self::$instance;
    }

    public function create(Eventos $evento)
    {
        $sql = "INSERT INTO log_eventos 
        (id_user,
        id_mapa,
        timeN,
        event_type,
        data1,
        desc1,
        data2,
        desc2,
        data3,
        desc3,
        data4,
        desc4,
        cobert)
        VALUES 
        (:idUser,
        :idMapa,
        :timeN,
        :eventType,
        :data1,
        :desc1,
        :data2,
        :desc2,
        :data3,
        :desc3,
        :data4,
        :desc4,
        :cobert)";

        $p_sql = Connect::conn()->prepare($sql);

        $p_sql->bindValue(":idUser", $evento->getIdUser());
        $p_sql->bindValue(":idMapa", $evento->getIdMap());
        $p_sql->bindValue(":timeN", $evento->getTime());
        $p_sql->bindValue(":eventType", $evento->getEventType());
        $p_sql->bindValue(":data1", $evento->getData1());
        $p_sql->bindValue(":desc1", $evento->getDesc1());
        $p_sql->bindValue(":data2", $evento->getData2());
        $p_sql->bindValue(":desc2", $evento->getDesc2());
        $p_sql->bindValue(":data3", $evento->getData3());
        $p_sql->bindValue(":desc3", $evento->getDesc3());
        $p_sql->bindValue(":data4", $evento->getData4());
        $p_sql->bindValue(":desc4", $evento->getDesc4());
        $p_sql->bindValue(":cobert", $evento->getCobert());

        return $p_sql->execute();
    }

    public function read($desc, $ini)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_user = :cod ORDER BY id LIMIT 1 OFFSET :ini";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->bindValue(":cod", $ini);
        $p_sql->execute();
        return $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    public function readRelatorio($desc, $ini)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_user = :cod AND event_type = 'doRel' ORDER BY id LIMIT 1 OFFSET :ini";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->bindValue(":ini", $ini);
        $p_sql->execute();
        $dados = $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));

        $sql = "SELECT * FROM log_eventos WHERE id_user = :cod AND id_mapa = ':idMap' AND (event_type = 'attRel' OR event_type = 'delRel') ORDER BY id DESC";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->bindValue(":idMap", $dados->getIdMap());
        $p_sql->execute();
        $p_sql->fetch(\PDO::FETCH_BOTH);

        if ($p_sql->getEventType() === 'attRel') :
            return $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));
        else :
            if ($p_sql->getEventType() === 'delRel') :
                return null;
            else :
                return $dados;
            endif;
        endif;
    }

    private function showEvento($row)
    {
        $Evento = new Eventos($row['id'], $row['id_user'], $row['id_mapa'], $row['timeN'], $row['event_type'], $row['data1'], $row['desc1'], $row['data2'], $row['desc2'], $row['data3'], $row['desc3'], $row['data4'], $row['desc4'], $row['cobert']);
        return $Evento;
    }

    public function lastId($desc)
    {
        $sql = "SELECT id FROM log_eventos WHERE id_user = :cod ORDER BY id DESC";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->execute();
        return $p_sql->fetch(\PDO::FETCH_BOTH);
    }

    public function completTerr()
    {
        $sql = "SELECT cobert FROM log_eventos ORDER BY id LIMIT 1 DESC";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->execute();
        $cobertNow = $p_sql->fetch(\PDO::FETCH_BOTH);

        $sql = "ALTER TABLE log_eventos ALTER cobert SET default :cobert";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cobert", $cobertNow['cobert'] + 1);
        $p_sql->execute();

        date_default_timezone_set('America/Sao_Paulo');

        $event = new Eventos(null, null, null, date('d/m/Y \à\s H:i:s'), 'terrComp', null, null, null, null, null, null, null, null, null);
        $this->create($event);

        return 0;
    }
}
