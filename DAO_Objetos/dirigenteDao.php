<?php

namespace Dirigente;

require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/dirigente.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/sendemail.php';

class DirigenteDAO
{
    public static $instance;

    private function __construct()
    {
        //
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new DirigenteDAO();
        }

        return self::$instance;
    }

    public function create(Dirigentes $dirigente)
    {
        $sql = "INSERT INTO dirigentes 
                    (nome, 
                    sobrenome, 
                    email, 
                    usuario, 
                    senha)
                    VALUES 
                    (:nome,
                    :sobrenome, 
                    :email, 
                    :usuario, 
                    :senha)";

        $p_sql = \Conectar\Connect::conn()->prepare($sql);

        $p_sql->bindValue(":nome", $dirigente->getNome());
        $p_sql->bindValue(":sobrenome", $dirigente->getSobrenome());
        $p_sql->bindValue(":email", $dirigente->getEmail());
        $p_sql->bindValue(":usuario", $dirigente->getUsuario());
        $p_sql->bindValue(":senha", $dirigente->getSenha());

        $message = "<h3>Bem vindo ao Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $dirigente->getNome() . " " . $dirigente->getSobrenome() . ", sua conta j&aacute; est&aacute; quase pronta, para concluir seu cadastro e liberar seu acesso basta clicar no link abaixo:<br><br>http://oasisassistant.com/autenticate.php?cd=" . md5($dirigente->getUsuario()) . "<br><br>No Oasis Assistant voc&ecirc; ter&aacute; acesso a diversas informa&ccedil;&otilde;es &uacute;teis para o servi&ccedil;o de campo local, fa&ccedil;a bom proveito dessa ferramenta.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";

        $email_send = new \EnviarEmail\Mail();
        $email_send->sendMail($dirigente->getEmail(), $dirigente->getNome(), $dirigente->getSobrenome(), $message, "E-mail de Autenticacao", "");

        return $p_sql->execute();
    }

    public function readAll($data_type, $desc)
    {
        // $data_type = id ou usuario ou email ou access,
        // $desc = dado propriamente dito
        // Exemplo: $data_type = email - $desc = adrianoshineyder@hotmail.com
        if ($data_type[1] != "") :
            $sql = "SELECT * FROM dirigentes WHERE $data_type[0] = :cod AND $data_type[1] = :cod2";
            $p_sql = \Conectar\Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cod", $desc[0]);
            $p_sql->bindValue(":cod2", $desc[1]);
        else :
            $sql = "SELECT * FROM dirigentes WHERE $data_type[0] = :cod ";
            $p_sql = \Conectar\Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cod", $desc[0]);
        endif;
        $p_sql->execute();
        return $this->showDirigente($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    public function logIn($user, $senha)
    {
        // $data_type = id ou usuario ou email
        // $desc = dado propriamente dito
        // Exemplo: $data_type = email - $desc = adrianoshineyder@hotmail.com

        $sql = "SELECT * FROM dirigentes WHERE usuario = :user AND senha = :senha";
        $p_sql = \Conectar\Connect::conn()->prepare($sql);
        $p_sql->bindValue(":user", $user);
        $p_sql->bindValue(":senha", $senha);
        $p_sql->execute();
        return $this->showDirigente($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    private function showDirigente($row)
    {
        $dirigente = new Dirigentes($row['id'], $row['nome'], $row['sobrenome'], $row['email'], $row['usuario'], $row['senha'], $row['access']);
        return $dirigente;
    }

    public function read($data_type, $desc, $subject)
    {
        // $data_type = id ou usuario ou email  (até 2)
        // $desc = dado propriamente dito       (até 2)
        // $subject = dado desejado
        // Exemplo: $data_type = email - $desc = adrianoshineyder@hotmail.com

        if (is_array($data_type)) :
            $sql = "SELECT $subject FROM dirigentes WHERE $data_type[0] = :cod AND $data_type[1] = :cod2";
            $p_sql = \Conectar\Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cod", $desc[0]);
            $p_sql->bindValue(":cod2", $desc[1]);
        else :
            $sql = "SELECT $subject FROM dirigentes WHERE $data_type = :cod";
            $p_sql = \Conectar\Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cod", $desc);
        endif;
            $p_sql->execute();
            return $p_sql;
    }

    public function lastId()
    {
        $sql = "SELECT id FROM dirigentes ORDER BY id DESC";
        $p_sql = \Conectar\Connect::conn()->prepare($sql);
        $p_sql->execute();
        return $p_sql->fetch(\PDO::FETCH_BOTH);
    }

    public function update(Dirigentes $dirigente)
    {
        $sql = "UPDATE dirigentes SET
                    nome = :nome,
                    sobrenome = :sobrenome,
                    email = :email,
                    usuario = :usuario,
                    senha = :senha,
                    access = :access
                    WHERE id = :cod";

        $p_sql = \Conectar\Connect::conn()->prepare($sql);

        $p_sql->bindValue(":nome", $dirigente->getNome());
        $p_sql->bindValue(":sobrenome", $dirigente->getSobrenome());
        $p_sql->bindValue(":email", $dirigente->getEmail());
        $p_sql->bindValue(":usuario", $dirigente->getUsuario());
        $p_sql->bindValue(":senha", $dirigente->getSenha());
        $p_sql->bindValue(":access", $dirigente->getAccess());
        $p_sql->bindValue(":cod", $dirigente->getId());

        return $p_sql->execute();
    }

    public function delete($cod)
    {
        $sql = "DELETE FROM dirigentes WHERE id = :cod";
        $p_sql = \Conectar\Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $cod);

        return $p_sql->execute();
    }
}
