<?php

namespace obj;

class Event
{
    private $id;
    private $idUser;
    private $idMap;
    private $time;
    private $eventType;
    private $data1;
    private $desc1;
    private $data2;
    private $desc2;
    private $data3;
    private $desc3;
    private $data4;
    private $desc4;
    private $cobert;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->idUser = $row['id_user'];
        $this->idMap = $row['id_mapa'];
        $this->time = $row['timeN'];
        $this->eventType = $row['event_type'];
        $this->data1 = $row['data1'];
        $this->desc1 = $row['desc1'];
        $this->data2 = $row['data2'];
        $this->desc2 = $row['desc2'];
        $this->data3 = $row['data3'];
        $this->desc3 = $row['desc3'];
        $this->data4 = $row['data4'];
        $this->desc4 = $row['desc4'];
        $this->cobert = $row['cobert'];
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

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getIdMap()
    {
        return $this->idMap;
    }

    public function setIdMap($idMap)
    {
        $this->idMap = $idMap;
        return $this;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    public function getEventType()
    {
        return $this->eventType;
    }

    public function setEventType($eventType)
    {
        $this->eventType = $eventType;
        return $this;
    }

    public function getData1()
    {
        return $this->data1;
    }

    public function setData1($data1)
    {
        $this->data1 = $data1;
        return $this;
    }

    public function getDesc1()
    {
        return $this->desc1;
    }

    public function setDesc1($desc1)
    {
        $this->desc1 = $desc1;
        return $this;
    }

    public function getData2()
    {
        return $this->data2;
    }

    public function setData2($data2)
    {
        $this->data2 = $data2;
        return $this;
    }

    public function getDesc2()
    {
        return $this->desc2;
    }

    public function setDesc2($desc2)
    {
        $this->desc2 = $desc2;
        return $this;
    }

    public function getData3()
    {
        return $this->data3;
    }

    public function setData3($data3)
    {
        $this->data3 = $data3;
        return $this;
    }

    public function getDesc3()
    {
        return $this->desc3;
    }

    public function setDesc3($desc3)
    {
        $this->desc3 = $desc3;
        return $this;
    }

    public function getData4()
    {
        return $this->data4;
    }

    public function setData4($data4)
    {
        $this->data4 = $data4;
        return $this;
    }

    public function getDesc4()
    {
        return $this->desc4;
    }

    public function setDesc4($desc4)
    {
        $this->desc4 = $desc4;
        return $this;
    }

    public function getCobert()
    {
        return $this->cobert;
    }

    public function setCobert($cobert)
    {
        $this->cobert = $cobert;
        return $this;
    }
}
