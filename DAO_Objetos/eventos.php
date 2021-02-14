<?php

namespace Evento;

class Eventos
{
    private $id;
    private $data;
    private $user;
    private $quadra;
    private $mapa;
    private $eventType;
    private $event;
    private $cobert;

    public function __construct($id, $data, $user, $quadra, $mapa, $eventType, $event, $cobert)
    {
        $this->id = $id;
        $this->data = $data;
        $this->user = $user;
        $this->quadra = $quadra;
        $this->mapa = $mapa;
        $this->eventType = $eventType;
        $this->event = $event;
        $this->cobert = $cobert;
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

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
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

    public function getMapa()
    {
        return $this->mapa;
    }

    public function setMapa($mapa)
    {
        $this->mapa = $mapa;
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

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent($event)
    {
        $this->event = $event;
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
