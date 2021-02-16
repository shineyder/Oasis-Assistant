<?php

namespace Assistant;

class Mapas
{
    private $id;
    private $map;
    private $quadra;
    private $trab;
    private $res;
    private $com;
    private $edi;

    public function __construct($id, $map, $quadra, $trab, $res, $com, $edi)
    {
        $this->id = $id;
        $this->map = $map;
        $this->quadra = $quadra;
        $this->trab = $trab;
        $this->res = $res;
        $this->com = $com;
        $this->edi = $edi;
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

    public function getTrab()
    {
        return $this->trab;
    }

    public function setTrab($trab)
    {
        $this->trab = $trab;
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
