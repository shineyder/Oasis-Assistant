<?php

/**
 * Página:
 *      Oculta - Ação PHP - Enviar Email
 * Conteúdo:
 *      Envia email.
 * Detalhes:
 *      Necessário email de destino, nome e sobrenome do destinátario, mensagem, assunto e anexo. O anexo é a única informação opcional e, caso não exista, deve ser definida como string vazia "".
 */

namespace EnviarEmail;

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public function sendMail($email, $nome, $sobrenome, $message, $subject, $anexo)
    {
        //Load Composer's autoloader
        require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Configurações do Servidor
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;              // Enable verbose debug output
            $mail->isSMTP();                                    // Send using SMTP
            $mail->Host = 'smtp.gmail.com';                     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                           // Enable SMTP authentication
            $mail->Username   = 'oasisassistente@gmail.com';    // SMTP username
            $mail->Password   = 'Oasis.1914';                   // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('oasisassistente@gmail.com', 'Oasis Assistant'); // Origem do email
            $mail->addAddress($email, $nome . " " . $sobrenome);                                      // Destino do email

            // Anexos
            if ($anexo != "") {
                $mail->addAttachment($anexo);   // anexo = "" para não enviar anexos
            }

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
}
