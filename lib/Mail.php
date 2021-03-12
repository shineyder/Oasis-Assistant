<?php

namespace lib;

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public function sendMail($email, $nome, $sobrenome, $message, $subject, $anexo)
    {
        // Load Composer's autoloader
        require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Configurações do Servidor
            $mail->SMTPDebug = 0;              // Enable verbose debug output
            $mail->isSMTP();                                    // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                           // Enable SMTP authentication
            $mail->Username   = 'oasisassistente@gmail.com';    // SMTP username
            $mail->Password   = 'Oasis.1914';                   // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('oasisassistente@gmail.com', 'Oasis Assistant'); // Origem do email
            $mail->addAddress($email, $nome . " " . $sobrenome);            // Destino do email

            // Anexos
            if ($anexo != "") :
                $mail->addAttachment($anexo);   // anexo = "" para não enviar anexos
            endif;

            // Content
            $mail->isHTML(true);                // Formato HTML
            $mail->Subject = $subject;          // Assunto
            $mail->Body    = $message;          // Mensagem

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    /**
     * message
     * @param int $tipo Tipo de mensagem que será enviado (1 => Esquece user / 2 => Esquece senha / 3 => Email de autenticação / 4 => Outro problema)
     * @param string $data Dados a serem escrito na mensagem
     * @return string Mensagem criada
     */
    public function message($tipo, $data)
    {
        switch ($tipo) :
            case 1:
                $message = "<h3>Obrigado por usar o Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $data[0] . " " . $data[1] . ", houve uma solicita&ccedil;&atilde;o de recuperar usu&aacute;rio em sua conta.<br>Seu nome de usu&aacute;rio &eacute; <b>" . $data[2] . "</b>.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";
                break;
            case 2:
                $message = "<h3>Obrigado por usar o Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $data[0] . " " . $data[1] . ", houve uma solicita&ccedil;&atilde;o de recuperar senha em sua conta.<br>Sua senha foi redefinida para <b>123456</b>.<br> Note que essa &eacute; uma senha padr&atilde;o e de baixa seguran&ccedil;a, favor trocar sua senha o mais breve poss&iacute;vel.</p><p>A equipe do <b>Setor de Suporte</b> do <b>Oasis Assistant</b> nunca entra em contato com seus usu&aacute;rios solicitando sua senha, portanto n&atilde;o a compartilhe com ningu&eacute;m.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";
                break;
            case 3:
                $message = "<h3>Obrigado por usar o Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $data[0] . " " . $data[1] . ", houve uma solicita&ccedil;&atilde;o para reenviar o email de autentica&ccedil;&atilde;o em sua conta. Para evitar que tal problema se repita, ser&aacute; enviado um email automaticamente e pouco depois o mesmo e-mail ser&aacute; enviado manualmente, favor desconsiderar duplicatas.<br>Sua conta j&aacute; est&aacute; quase pronta, para concluir seu cadastro e liberar seu acesso basta clicar no link abaixo:<br><br>http://oasisassistant.com/autenticate/autenticate/" . md5($data[2]) . "<br><br>No Oasis Assistant voc&ecirc; ter&aacute; acesso a diversas informa&ccedil;&otilde;es &uacute;teis para o servi&ccedil;o de campo local, fa&ccedil;a bom proveito dessa ferramenta.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";
                break;
            case 4:
                $message = "<h3>Uma solicita&ccedil;&atilde;o foi enviada no Oasis Assistant!</h3><br><p>Prezado irm&atilde;o Adriano Shineyder, houve uma solicita&ccedil;&atilde;o de resolu&ccedil;&atilde;o de problema n&atilde;o padr&atilde;o feita pelo usu&aacute;rio (ou dono do e-mail) <b>" . $data[0] . "</b>. Segue abaixo a descri&ccedil;&atilde;o do problema:</p><br>" . $data[1] . "";
                break;
            case 5:
                $message = "<h3>Bem vindo ao Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $data[0] . " " . $data[1] . ", sua conta j&aacute; est&aacute; quase pronta, para concluir seu cadastro e liberar seu acesso basta clicar no link abaixo:<br><br>http://oasisassistant.com/autenticate/autenticate/" . md5($data[2]) . "<br><br>No Oasis Assistant voc&ecirc; ter&aacute; acesso a diversas informa&ccedil;&otilde;es &uacute;teis para o servi&ccedil;o de campo local, fa&ccedil;a bom proveito dessa ferramenta.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";
                break;
        endswitch;

        return $message;
    }
}
