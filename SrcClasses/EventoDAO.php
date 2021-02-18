<?php

namespace Assistant;

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
        desc4)
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
        :desc4)";

        $p_sql = Connect::conn()->prepare($sql);

        date_default_timezone_set('America/Sao_Paulo');

        $p_sql->bindValue(":idUser", $evento->getIdUser());
        $p_sql->bindValue(":idMapa", $evento->getIdMap());
        $p_sql->bindValue(":timeN", date('d/m/Y \à\s H:i:s'));
        $p_sql->bindValue(":eventType", $evento->getEventType());
        $p_sql->bindValue(":data1", $evento->getData1());
        $p_sql->bindValue(":desc1", $evento->getDesc1());
        $p_sql->bindValue(":data2", $evento->getData2());
        $p_sql->bindValue(":desc2", $evento->getDesc2());
        $p_sql->bindValue(":data3", $evento->getData3());
        $p_sql->bindValue(":desc3", $evento->getDesc3());
        $p_sql->bindValue(":data4", $evento->getData4());
        $p_sql->bindValue(":desc4", $evento->getDesc4());

        return $p_sql->execute();
    }

    public function read($desc, $ini)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_user = :cod ORDER BY id LIMIT 1 OFFSET :ini";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->bindValue(":ini", $ini);
        $p_sql->execute();
        return $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    public function readRelatorio($desc, $ini)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_user = :cod AND event_type = 'doRel' ORDER BY id LIMIT 1 OFFSET :ini";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", intval($desc, 10), \PDO::PARAM_INT);
        $p_sql->bindValue(":ini", intval($ini, 10), \PDO::PARAM_INT);
        $p_sql->execute();
        $dados = $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));

        $sql = "SELECT * FROM log_eventos WHERE id_user = :cod AND id_mapa = :idMap AND (event_type = 'attRel' OR event_type = 'delRel') ORDER BY id DESC LIMIT 1 ";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", intval($desc, 10), \PDO::PARAM_INT);
        $p_sql->bindValue(":idMap", intval($dados->getIdMap(), 10), \PDO::PARAM_INT);
        $p_sql->execute();

        if ($p_sql->rowCount() != 0) :
            $dados2 = $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));
            if ($dados2->getEventType() == 'attRel') :
                return $dados2;
            else :
                return null;
            endif;
        else :
            return $dados;
        endif;
    }

    public function readLastRelatorio($desc)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_map = :cod  AND (event_type = 'doRel' OR event_type = 'attRel') ORDER BY id DESC LIMIT 1";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", intval($desc, 10), \PDO::PARAM_INT);
        $p_sql->execute();
        $dados = $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));
        return $dados;
    }

    public function isRel($desc)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_mapa = :cod  AND event_type = 'doRel' LIMIT 1";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->execute();
        return $p_sql->rowCount();
    }

    private function showEvento($row)
    {
        $Evento = new Eventos($row['id'], $row['id_user'], $row['id_mapa'], $row['timeN'], $row['event_type'], $row['data1'], $row['desc1'], $row['data2'], $row['desc2'], $row['data3'], $row['desc3'], $row['data4'], $row['desc4'], $row['cobert']);
        return $Evento;
    }

    public function relCount($desc)
    {
        $sql = "SELECT id FROM log_eventos WHERE id_user = :cod AND event_type = 'doRel' ORDER BY id DESC";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->execute();
        return $p_sql->rowCount();
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

        $event = new Eventos(null, null, null, null, 'terrComp', null, null, null, null, null, null, null, null, null);
        $this->create($event);

        return 0;
    }
}
