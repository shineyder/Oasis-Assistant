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
        $p_sql->bindValue(":timeN", date('d/m/Y H:i:s'));
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

    public function readRelatorio($desc, $ini, $cobert)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_user = :cod AND event_type = 'doRel' AND cobert = :cob ORDER BY id LIMIT 1 OFFSET :ini";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", intval($desc, 10), \PDO::PARAM_INT);
        $p_sql->bindValue(":cob", intval($cobert, 10), \PDO::PARAM_INT);
        $p_sql->bindValue(":ini", intval($ini, 10), \PDO::PARAM_INT);
        $p_sql->execute();
        $dados = $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));

        $sql = "SELECT * FROM log_eventos WHERE id_user = :cod AND id_mapa = :idMap AND (event_type = 'attRel' OR event_type = 'delRel') AND cobert = :cob ORDER BY id DESC LIMIT 1 ";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", intval($desc, 10), \PDO::PARAM_INT);
        $p_sql->bindValue(":idMap", intval($dados->getIdMap(), 10), \PDO::PARAM_INT);
        $p_sql->bindValue(":cob", intval($cobert, 10), \PDO::PARAM_INT);
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

    public function readLastRelatorio($desc, $desc2, $cobert)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_mapa = :cod AND id_user <> :cod2  AND (event_type = 'doRel' OR event_type = 'attRel') AND cobert = :cob ORDER BY id DESC LIMIT 1";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", intval($desc, 10), \PDO::PARAM_INT);
        $p_sql->bindValue(":cod2", intval($desc2, 10), \PDO::PARAM_INT);
        $p_sql->bindValue(":cob", intval($cobert, 10), \PDO::PARAM_INT);
        $p_sql->execute();

        if ($p_sql->rowCount() != 0) :
            $dados = $this->showEvento($p_sql->fetch(\PDO::FETCH_BOTH));
        else :
            $dados = 0;
        endif;

        return $dados;
    }

    public function isRel($desc, $cobert)
    {
        $sql = "SELECT * FROM log_eventos WHERE id_mapa = :cod  AND event_type = 'doRel' AND cobert = :cob LIMIT 1";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->bindValue(":cob", $cobert);
        $p_sql->execute();
        return $p_sql->rowCount();
    }

    private function showEvento($row)
    {
        $Evento = new Eventos($row['id'], $row['id_user'], $row['id_mapa'], $row['timeN'], $row['event_type'], $row['data1'], $row['desc1'], $row['data2'], $row['desc2'], $row['data3'], $row['desc3'], $row['data4'], $row['desc4'], $row['cobert']);
        return $Evento;
    }

    public function relCount($desc, $cobert)
    {
        $sql = "SELECT id FROM log_eventos WHERE id_user = :cod AND event_type = 'doRel' AND cobert = :cob ORDER BY id DESC";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->bindValue(":cob", $cobert);
        $p_sql->execute();
        return $p_sql->rowCount();
    }

    public function cobertNow()
    {
        $sql = "SELECT cobert, event_type FROM log_eventos ORDER BY id DESC LIMIT 1";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->execute();
        $data = $p_sql->fetch(\PDO::FETCH_BOTH);

        if ($data != false) :
            if ($data['event_type'] == "terrComp") :
                $cobertNow = $data['cobert'] + 1;
            else :
                $cobertNow = $data['cobert'];
            endif;
        else :
            $cobertNow = 1;
        endif;

        return $cobertNow;
    }

    public function idS13($ini, $end, $cobert)
    {
        $sql = "SELECT id_user, COUNT(id_user) AS Qtd FROM log_eventos WHERE cobert = :cob AND id_mapa BETWEEN :com AND :fim GROUP BY id_user ORDER BY COUNT(id_user) DESC LIMIT 1";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cob", $cobert);
        $p_sql->bindValue(":com", $ini);
        $p_sql->bindValue(":fim", $end);
        $p_sql->execute();
        return $p_sql->fetch(\PDO::FETCH_BOTH);
    }

    public function timeS13($ini, $end, $cobert)
    {
        $sql = "SELECT timeN FROM log_eventos WHERE cobert = :cob AND event_type = 'doRel' AND id_mapa BETWEEN :com AND :fim ORDER BY timeN LIMIT 1";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cob", $cobert);
        $p_sql->bindValue(":com", $ini);
        $p_sql->bindValue(":fim", $end);
        $p_sql->execute();
        $dados[0] = $p_sql->fetch(\PDO::FETCH_ASSOC);

        $sql = "SELECT COUNT(id_user) AS Qtd FROM log_eventos WHERE cobert = :cob AND event_type = 'doRel' AND id_mapa BETWEEN :com AND :fim";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cob", $cobert);
        $p_sql->bindValue(":com", $ini);
        $p_sql->bindValue(":fim", $end);
        $p_sql->execute();
        $conf = $p_sql->fetch(\PDO::FETCH_ASSOC);

        if ($conf['Qtd'] < ($end - $ini + 1)) :
            $dados[1]['timeN'] = "";
        else :
            $sql = "SELECT timeN FROM log_eventos WHERE cobert = :cob AND event_type = 'doRel' AND id_mapa BETWEEN :com AND :fim ORDER BY timeN DESC LIMIT 1";
            $p_sql = Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cob", $cobert);
            $p_sql->bindValue(":com", $ini);
            $p_sql->bindValue(":fim", $end);
            $p_sql->execute();
            $dados[1] = $p_sql->fetch(\PDO::FETCH_ASSOC);
        endif;

        return $dados;
    }

    public function completTerr()
    {
        $sql = "SELECT cobert FROM log_eventos ORDER BY id DESC LIMIT 1";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->execute();
        $cobertNow = $p_sql->fetch(\PDO::FETCH_BOTH);

        $event = new Eventos(null, null, null, null, 'terrComp', null, null, null, null, null, null, null, null, null);
        $this->create($event);

        $sql = "ALTER TABLE log_eventos ALTER cobert SET default :cobert";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cobert", $cobertNow['cobert'] + 1);
        $p_sql->execute();

        return 0;
    }
}
