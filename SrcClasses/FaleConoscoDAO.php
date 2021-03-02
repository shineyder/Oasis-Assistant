<?php

namespace Assistant;

class FaleConoscoDAO
{
    public static $instance;

    private function __construct()
    {
        //
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new FaleConoscoDAO();
        }

        return self::$instance;
    }

    public function create(FaleConosco $faleConosco)
    {
        $sql = "INSERT INTO fale_conosco 
        (id_user,
        assunto,
        mensag,
        timeN,
        statusN,
        ticket)
        VALUES 
        (:idUser,
        :assunto,
        :mensag,
        :timeN,
        :statusN,
        :ticket)";

        $p_sql = Connect::conn()->prepare($sql);

        date_default_timezone_set('America/Sao_Paulo');
        $ticket = date_timestamp_get(date_create()) . $faleConosco->getIdUser();

        $publicador = PublicadorDAO::getInstance()->readAll(['id', ''], [$faleConosco->getIdUser(), '']);

        $message = "<h3>Obrigado por usar o Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $publicador->getNome() . " " . $publicador->getSobrenome() . ", houve um envio de solicita&ccedil;&atilde;o em Fale Conosco em sua conta.<br>Seu ticket de atendimento &eacute; <b>" . $ticket . "</b>.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";

        $email_send = new Mail();
        $email_send->sendMail($publicador->getEmail(), $publicador->getNome(), $publicador->getSobrenome(), $message, "Confirmacao de envio - Fale Conosco", "");

        $p_sql->bindValue(":idUser", $faleConosco->getIdUser());
        $p_sql->bindValue(":assunto", $faleConosco->getAssunto());
        $p_sql->bindValue(":mensag", $faleConosco->getMensag());
        $p_sql->bindValue(":timeN", date('d/m/Y H:i:s'));
        $p_sql->bindValue(":statusN", "em Espera");
        $p_sql->bindValue(":ticket", $ticket);
        return $p_sql->execute();
    }

    public function read($assunto, $ini)
    {
        $sql = "SELECT * FROM fale_conosco WHERE (statusN = 'em Espera' OR statusN = 'em Analise') AND assunto = '$assunto' ORDER BY id LIMIT 1 OFFSET $ini ";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->execute();
        return $this->showSol($p_sql->fetch(\PDO::FETCH_BOTH));
    }

    private function showSol($row)
    {
        $Sol = new FaleConosco($row['id'], $row['id_user'], $row['assunto'], $row['mensag'], $row['timeN'], $row['statusN'], $row['ticket']);
        return $Sol;
    }

    public function solCount($desc)
    {
        $sql = "SELECT id FROM fale_conosco WHERE assunto = :cod AND (statusN = 'em Espera' OR statusN = 'em Analise')  ORDER BY id DESC";
        $p_sql = Connect::conn()->prepare($sql);
        $p_sql->bindValue(":cod", $desc);
        $p_sql->execute();
        return $p_sql->rowCount();
    }

    public function update(FaleConosco $faleConosco)
    {
        if ($faleConosco->getStatus() == 'Concluido') :
            $sql = "UPDATE fale_conosco SET statusN = :statusN, timeC = :timeC WHERE id = :cod";
            $p_sql = Connect::conn()->prepare($sql);
            $p_sql->bindValue(":statusN", $faleConosco->getStatus());
            date_default_timezone_set('America/Sao_Paulo');
            $p_sql->bindValue(":timeC", date('d/m/Y H:i:s'));
            $p_sql->bindValue(":cod", $faleConosco->getId());
        else :
            $sql = "UPDATE fale_conosco SET statusN = :statusN WHERE id = :cod";
            $p_sql = Connect::conn()->prepare($sql);
            $p_sql->bindValue(":statusN", $faleConosco->getStatus());
            $p_sql->bindValue(":cod", $faleConosco->getId());
        endif;

        return $p_sql->execute();
    }
}
