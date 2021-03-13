<?php

namespace obj;

class ContactUs
{
    private $id;
    private $idUser;
    private $assunto;
    private $mensag;
    private $timeN;
    private $timeC;
    private $statusN;
    private $ticket;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->idUser = $row['idUser'];
        $this->assunto = $row['assunto']; // Problema - Sugestão - Outro
        $this->mensag = $row['mensag'];
        $this->timeN = $row['timeN'];
        $this->timeC = $row['timeC'];
        $this->statusN = $row['statusN']; // em Espera - em Analise - Concluido
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

    public function getTimeC()
    {
        return $this->timeC;
    }

    public function setTimeC($timeC)
    {
        $this->timeN = $timeC;
        return $this;
    }

    public function getStatusN()
    {
        return $this->statusN;
    }

    public function setStatusN($statusN)
    {
        $this->status = $statusN;
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
