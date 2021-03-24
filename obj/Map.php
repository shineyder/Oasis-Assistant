<?php

namespace obj;

class Map
{
    private $id;
    private $map;
    private $quadra;
    private $worked;
    private $res;
    private $com;
    private $edi;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->map = $row['maps'];
        $this->quadra = $row['quadra'];
        $this->worked = $row['worked'];
        $this->res = $row['nResidencia'];
        $this->com = $row['nComercio'];
        $this->edi = $row['nEdificio'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getMap()
    {
        return $this->map;
    }

    public function setMap($map)
    {
        $this->map = $map;
        return $this;
    }

    public function getQuadra()
    {
        return $this->quadra;
    }


    public function setQuadra($quadra)
    {
        $this->quadra = $quadra;
        return $this;
    }

    public function getWorked()
    {
        return $this->worked;
    }

    public function setWorked($worked)
    {
        $this->worked = $worked;
        return $this;
    }


    public function getRes()
    {
        return $this->res;
    }

    public function setRes($res)
    {
        $this->res = $res;
        return $this;
    }

    public function getCom()
    {
        return $this->com;
    }

    public function setCom($com)
    {
        $this->com = $com;
        return $this;
    }

    public function getEdi()
    {
        return $this->edi;
    }

    public function setEdi($edi)
    {
        $this->edi = $edi;
        return $this;
    }
}
