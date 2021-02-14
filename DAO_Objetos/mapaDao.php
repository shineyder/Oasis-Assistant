<?php

namespace Mapa;

require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/mapa.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/connect.php';

class MapasDAO
{
    public static $instance;

    private function __construct()
    {
        //
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new MapasDAO();
        }

        return self::$instance;
    }

    public function create()
    {
        //
    }

    public function read($desc)
    {
        $sql = "SELECT * FROM mapas WHERE id = :cod ";
        $p_sql = \Conectar\Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->execute();
        return $this->showMapa($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    private function showMapa($row)
    {
        $mapa = new Mapas($row['id'], $row['maps'], $row['quadra'], $row['trab'], $row['n_residencia'], $row['n_comercio'], $row['n_edificio']);
        return $mapa;
    }

    public function update(Mapas $mapas)
    {
        $sql = "UPDATE mapas SET
                    trab = :trab,
                    n_residencia = :res,
                    n_comercio = :com,
                    n_edificio = :edi
                    WHERE id = :cod";

        $p_sql = \Conectar\Connect::conn()->prepare($sql);

        $p_sql->bindValue(":trab", $mapas->getTrab());
        $p_sql->bindValue(":res", $mapas->getRes());
        $p_sql->bindValue(":com", $mapas->getCom());
        $p_sql->bindValue(":edi", $mapas->getEdi());
        $p_sql->bindValue(":cod", $mapas->getId());

        return $p_sql->execute();
    }

    public function delete()
    {
        //
    }

    public function firstLast($data)
    {
        $sql = "SELECT id FROM mapas WHERE maps = '$data'";
        $p_sql = \Conectar\Connect::conn()->prepare($sql);
        $p_sql->execute();
        $dados[0] = $p_sql->fetch(\PDO::FETCH_ASSOC);

        $sql = "SELECT id FROM mapas WHERE maps = '$data' ORDER BY id DESC";
        $p_sql = \Conectar\Connect::conn()->prepare($sql);
        $p_sql->execute();
        $dados[1] = $p_sql->fetch(\PDO::FETCH_ASSOC);

        return $dados;
    }
}
