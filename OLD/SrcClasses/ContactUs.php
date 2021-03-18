<?php

namespace Assistant;

class ContactUs
{
    private $id;
    private $idUser;
    private $assunto;
    private $mensag;
    private $timeN;
    private $status;
    private $ticket;

    public function __construct($id, $idUser, $assunto, $mensag, $timeN, $status, $ticket)
    {
        $this->id = $id;
        $this->idUser = $idUser;
        $this->assunto = $assunto; // Problema - Sugestão - Outro
        $this->mensag = $mensag;
        $this->timeN = $timeN;
        $this->status = $status; // em Espera - em Analise - Concluido
        $this->ticket = $ticket;
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

    public function getMensag()
    {
        return $this->mensag;
    }

    public function setMensag($mensag)
    {
        $this->mensag = $mensag;
        return $this;
    }

    public function getTimeN()
    {
        return $this->timeN;
    }

    public function setTimeN($timeN)
    {
        $this->timeN = $timeN;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
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
