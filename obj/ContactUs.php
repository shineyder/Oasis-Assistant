<?php

namespace obj;

class ContactUs
{
    private $id;
    private $idUser;
    private $assunto;
    private $message;
    private $timeInitialize;
    private $timeConclusion;
    private $statusNow;
    private $ticket;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->idUser = $row['idUser'];
        $this->assunto = $row['assunto'];
        $this->message = $row['message'];
        $this->timeInitialize = $row['timeInitialize'];
        $this->timeConclusion = $row['timeConclusion'];
        $this->statusNow = $row['statusNow'];
        $this->ticket = $row['ticket'];
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

    public function getAssunto()
    {
        return $this->assunto;
    }

    public function setAssunto($assunto)
    {
        $this->assunto = $assunto;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    public function getTimeInitialize()
    {
        return $this->timeInitialize;
    }

    public function setTimeInitialize($timeInitialize)
    {
        $this->timeInitialize = $timeInitialize;
        return $this;
    }

    public function getTimeConclusion()
    {
        return $this->timeConclusion;
    }

    public function setTimeConclusion($timeConclusion)
    {
        $this->timeConclusion = $timeConclusion;
        return $this;
    }

    public function getStatusNow()
    {
        return $this->statusNow;
    }

    public function setStatusNow($statusNow)
    {
        $this->statusNow = $statusNow;
        return $this;
    }

    public function getTicket()
    {
        return $this->ticket;
    }

    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
        return $this;
    }
}
