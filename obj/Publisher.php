<?php

namespace obj;

class Publisher
{
    private $id;
    private $nome;
    private $sobrenome;
    private $grupo;
    private $email;
    private $usuario;
    private $senha;
    private $access;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->nome = $row['nome'];
        $this->sobrenome = $row['sobrenome'];
        $this->grupo = $row['grupo'];
        $this->email = $row['email'];
        $this->usuario = $row['usuario'];
        $this->senha = $row['senha'];
        $this->access = $row['access'];
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
