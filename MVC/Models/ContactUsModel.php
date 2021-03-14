<?php

namespace Models;

use lib\Mail;

class ContactUsModel extends \lib\Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function sendTalk()
    {
        //Validando POST e verificando Anexo
        $id = $this->sanitize(5, "id", "contactus");
        $nome = $this->sanitize(6, "nome", "contactus");
        $sobrenome = $this->sanitize(6, "sobrenome", "contactus");
        $email = $this->sanitize(3, "email", "contactus");
        $mensag = $this->sanitize(10, "mensag", "contactus");
        $assunto = $this->sanitize(6, "assunto", "contactus");
        $ticket = date_timestamp_get(date_create()) . $id;
        $target_file = $this->verifyImg($_FILES["fileToUploadTalk"]);

        //Envia email com os dados da solicitação para o ADM
        $email_send = new Mail();
        $email_send->sendMail('adrianoshineyder@hotmail.com', 'Adriano', 'Shineyder', $mensag, $assunto, $target_file);

        //Envia email para o usuario da solicitação com o Ticket da solicitação
        $message = $email_send->message(6, [$nome, $sobrenome, $ticket]);
        $email_send->sendMail($email, $nome, $sobrenome, $message, "Confirmacao de envio - Fale Conosco", "");

        //Salva solicitação no banco de dados
        $talk = ["id" => null, "idUser" => $id, "assunto" => $assunto, "mensag" => $mensag, "timeN" => date('d/m/Y H:i:s'), "timeC" => null, "statusN" => "em Espera", "ticket" => $ticket];
        $this->db->create("contactus", $talk);

        //Apaga a img
        if ($target_file != '') :
            unlink($target_file);
        endif;

        //Se tudo deu certo emite mensagem de sucesso e retorna a index
        $this->msg("Solicitação enviada!", "success");
        exit();
    }
}