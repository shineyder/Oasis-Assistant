<?php

namespace Assistant;

class Publishers
{
    private $id;
    private $nome;
    private $sobrenome;
    private $grupo; // 1 = Porto Novo 1; 2 = Porto Novo 2; 3 = Presidente Médici; 4 = Morro do Sesi; 5 = Del Porto
    private $email;
    private $usuario;
    private $senha;
    private $access; // -1 = Desassociado; 0 = E-mail não autenticado; 1 = Conta em analise; 2 = Publicador; 8 = Ancião; 9 = Ancião Plus; 10 = Mestre Supremo

    public function __construct($id, $nome, $sobrenome, $grupo, $email, $usuario, $senha, $access)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->grupo = $grupo;
        $this->email = $email;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->access = $access;
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

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    public function setSobrenome($sobrenome)
    {
        $this->sobrenome = $sobrenome;
        return $this;
    }

    public function getGrupo()
    {
        return $this->grupo;
    }

    public function setGrupo($grupo)
    {
        $this->grupo = $grupo;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    public function getAccess()
    {
        return $this->access;
    }

    public function setAccess($access)
    {
        $this->access = $access;
        return $this;
    }
}
