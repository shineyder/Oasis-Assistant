<?php

namespace Assistant;

class PublicadorDAO
{
    public static $instance;

    private function __construct()
    {
        //
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new PublicadorDAO();
        }

        return self::$instance;
    }

    public function create(Publicadores $publicador)
    {
        $sql = "INSERT INTO Publicadores 
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

        $p_sql = Connect::conn()->prepare($sql);

        $p_sql->bindValue(":nome", $publicador->getNome());
        $p_sql->bindValue(":sobrenome", $publicador->getSobrenome());
        $p_sql->bindValue(":email", $publicador->getEmail());
        $p_sql->bindValue(":usuario", $publicador->getUsuario());
        $p_sql->bindValue(":senha", $publicador->getSenha());

        $message = "<h3>Bem vindo ao Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $publicador->getNome() . " " . $publicador->getSobrenome() . ", sua conta j&aacute; est&aacute; quase pronta, para concluir seu cadastro e liberar seu acesso basta clicar no link abaixo:<br><br>http://oasisassistant.com/autenticate.php?cd=" . md5($publicador->getUsuario()) . "<br><br>No Oasis Assistant voc&ecirc; ter&aacute; acesso a diversas informa&ccedil;&otilde;es &uacute;teis para o servi&ccedil;o de campo local, fa&ccedil;a bom proveito dessa ferramenta.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";

        $email_send = new Mail();
        $email_send->sendMail($publicador->getEmail(), $publicador->getNome(), $publicador->getSobrenome(), $message, "E-mail de Autenticacao", "");

        return $p_sql->execute();
    }

    public function readAll($data_type, $desc)
    {
        // $data_type = id ou usuario ou email ou access
        // $desc = dado propriamente dito
        // Exemplo: $data_type = email - $desc = adrianoshineyder@hotmail.com
        if ($data_type[1] != "") :
            $sql = "SELECT * FROM Publicadores WHERE $data_type[0] = :cod AND $data_type[1] = :cod2";
            $p_sql = Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cod", $desc[0]);
            $p_sql->bindValue(":cod2", $desc[1]);
        else :
            $sql = "SELECT * FROM Publicadores WHERE $data_type[0] = :cod ";
            $p_sql = Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cod", $desc[0]);
        endif;
        $p_sql->execute();
        return $this->showPublicador($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    public function logIn($user, $senha)
    {
        // $data_type = id ou usuario ou email
        // $desc = dado propriamente dito
        // Exemplo: $data_type = email - $desc = adrianoshineyder@hotmail.com

        $sql = "SELECT * FROM Publicadores WHERE usuario = :user AND senha = :senha";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":user", $user);
        $p_sql->bindValue(":senha", $senha);
        $p_sql->execute();
        return $this->showPublicador($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    private function showPublicador($row)
    {
        $publicador = new Publicadores($row['id'], $row['nome'], $row['sobrenome'], $row['grupo'], $row['email'], $row['usuario'], $row['senha'], $row['access']);
        return $publicador;
    }

    public function read($data_type, $desc, $subject)
    {
        // $data_type = id ou usuario ou email  (até 2)
        // $desc = dado propriamente dito       (até 2)
        // $subject = dado desejado
        // Exemplo: $data_type = email - $desc = adrianoshineyder@hotmail.com

        if (is_array($data_type)) :
            $sql = "SELECT $subject FROM Publicadores WHERE $data_type[0] = :cod AND $data_type[1] = :cod2";
            $p_sql = Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cod", $desc[0]);
            $p_sql->bindValue(":cod2", $desc[1]);
        else :
            $sql = "SELECT $subject FROM Publicadores WHERE $data_type = :cod";
            $p_sql = Connect::conn()->prepare($sql);
            $p_sql->bindValue(":cod", $desc);
        endif;
        $p_sql->execute();
        return $p_sql;
    }

    public function readTable($desc, $action, $ini)
    {
        $sql = "SELECT * FROM Publicadores ORDER BY $desc $action LIMIT 1 OFFSET $ini";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->execute();
        return $this->showPublicador($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    public function lastId()
    {
        $sql = "SELECT id FROM Publicadores ORDER BY id DESC";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->execute();
        return $p_sql->fetch(\PDO::FETCH_BOTH);
    }

    public function update(Publicadores $publicador)
    {
        $sql = "UPDATE Publicadores SET
                    nome = :nome,
                    sobrenome = :sobrenome,
                    grupo = :grupo,
                    email = :email,
                    usuario = :usuario,
                    senha = :senha,
                    access = :access
                    WHERE id = :cod";

        $p_sql = Connect::conn()->prepare($sql);

        $p_sql->bindValue(":nome", $publicador->getNome());
        $p_sql->bindValue(":sobrenome", $publicador->getSobrenome());
        $p_sql->bindValue(":grupo", $publicador->getGrupo());
        $p_sql->bindValue(":email", $publicador->getEmail());
        $p_sql->bindValue(":usuario", $publicador->getUsuario());
        $p_sql->bindValue(":senha", $publicador->getSenha());
        $p_sql->bindValue(":access", $publicador->getAccess());
        $p_sql->bindValue(":cod", $publicador->getId());

        return $p_sql->execute();
    }

    public function delete($cod)
    {
        $sql = "DELETE FROM Publicadores WHERE id = :cod";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $cod);

        return $p_sql->execute();
    }
}
