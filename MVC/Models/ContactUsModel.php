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
        $id = $this->sanitize(5, "id", "ContactUs");
        $nome = $this->sanitize(6, "nome", "ContactUs");
        $sobrenome = $this->sanitize(6, "sobrenome", "ContactUs");
        $email = $this->sanitize(3, "email", "ContactUs");
        $mensagem = $this->sanitize(10, "mensag", "ContactUs");
        $assunto = $this->sanitize(6, "assunto", "ContactUs");
        $ticket = date_timestamp_get(date_create()) . $id;
        $targetFile = $this->verifyImg($_FILES["fileToUploadTalk"]);

        //Envia email com os dados da solicitação para o ADM
        $emailSend = new Mail();
        $emailSend->sendMail('adrianoshineyder@hotmail.com', 'Adriano', 'Shineyder', $mensagem, $assunto, $targetFile);

        //Envia email para o usuario da solicitação com o Ticket da solicitação
        $message = $emailSend->message(6, [$nome, $sobrenome, $ticket]);
        $emailSend->sendMail($email, $nome, $sobrenome, $message, "Confirmacao de envio - Fale Conosco", "");

        $talk = ["id" => null,
                "idUser" => $id,
                "assunto" => $assunto,
                "message" => $mensagem,
                "timeInitialize" => date('d/m/Y H:i:s'),
                "timeConclusion" => null,
                "statusNow" => "em Espera",
                "ticket" => $ticket];
        $this->db->create("contactus", $talk);

        //Apaga a img
        if ($targetFile != '') :
            unlink($targetFile);
        endif;

        $this->msg("Solicitação enviada!", "success");
        exit();
    }
}
