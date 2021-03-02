<?php

/** Página:
*       Oculta - Ação PHP - Enviar sugestão
*   Conteúdo:
*       Recebe a mensagem do Fale conosco e envia por email para o ADM.
*/

use Assistant\FaleConosco;
use Assistant\FaleConoscoDAO;
use Assistant\Mail;

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Sessão
session_start();

if (isset($_POST['btn-talk'])) :
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $message = $_POST['mensag'];
    $subject = $_POST['assunto'];

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUploadTalk"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES["fileToUploadTalk"]["error"] == 0) :
        // Verifica se é mesmo uma imagem
        $check = getimagesize($_FILES["fileToUploadTalk"]["tmp_name"]);
        if ($check !== false) :
            $uploadOk = 1;
        else :
            $uploadOk = 0;
        endif;

        // Verifica tamanho do arquivo
        if ($_FILES["fileToUploadTalk"]["size"] > 1000000) :
            $uploadOk = 0;
        endif;
    else :
        $uploadOk = 0;
    endif;

    if ($uploadOk == 0) :        // Verifica se houve algum erro
        $target_file = '';
    else :                      // Faz upload se nada deu errado
        if (move_uploaded_file($_FILES["fileToUploadTalk"]["tmp_name"], $target_file)) :
        else :
            $target_file = '';
        endif;
    endif;
    $email_send = new Mail();

    // Sanitização
    $what = array( 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','Â','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

    $by   = array( 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','A','E','I','O','U','n','n','c','C','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_','_' );

    $email_send->sendMail("adrianoshineyder@hotmail.com", 'Adriano', 'Shineyder', str_replace($what, $by, $message), str_replace($what, $by, $subject), $target_file);
    $_SESSION['mensagem'] = "Solicitação enviada!";

    if ($target_file != '') :
        unlink($target_file);
    endif;

    $faleConosco = new FaleConosco(null, $id, $subject, $message, null, null, null);
    FaleConoscoDAO::getInstance()->create($faleConosco);

    redirect('http://oasisassistant.com/');
    exit();
endif;
