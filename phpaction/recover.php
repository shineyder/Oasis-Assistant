<!--
Página:
    Oculta - Ação PHP - Recuperar cadastro
Conteúdo:
    Recebe o problema encontrado ao fazer Login e o soluciona.
Detalhes:
    Existem três problemas com soluções padrão: Perca de usuário, perca de senha e email de autenticação não recebido. Caso o usuário não tenha nenhum desses três problemas, ele poderá descrever o que está ocorrendo e mandar uma foto, essas informações serão encaminhadas ao administrador.
-->

<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Sessão
session_start();

use Assistant\Mail;
use Assistant\PublicadorDAO;
use Assistant\EventoDAO;
use Assistant\Eventos;

if (isset($_POST['btn-pro'])) :
    $tipo = $_POST['cod_err'];
    $detail = [$_POST['rec'], (isset($_POST['rec2']) ? $_POST['rec2'] : "")];
    $data_type = ["", ""];

    if (empty($tipo)) :
        $_SESSION['mensagem'] = "Nenhum problema selecionado";
        redirect('http://oasisassistant.com/problem.php');
        exit();
    else :
        if (empty($detail[0]) or (isset($_POST['rec2']) ? empty($detail[1]) : false)) :
            $_SESSION['mensagem'] = "Informações solicitadas não preenchidas";
            redirect('http://oasisassistant.com/problem.php');
            exit();
        else :
            switch ($tipo) {
                case 1:
                    $data_type[0] = "email";
                    $publicador = PublicadorDAO::getInstance()->readAll($data_type, $detail);

                    if ($publicador->getAccess() === null) :
                        $_SESSION['mensagem'] = "E-mail não cadastrado";
                        redirect('http://oasisassistant.com/problem.php');
                        exit();
                    else :
                        $message = "<h3>Obrigado por usar o Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $publicador->getNome() . " " . $publicador->getSobrenome() . ", houve uma solicita&ccedil;&atilde;o de recuperar usu&aacute;rio em sua conta.<br>Seu nome de usu&aacute;rio &eacute; <b>" . $publicador->getUsuario() . "</b>.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";

                        $email_send = new Mail();
                        $email_send->sendMail($publicador->getEmail(), $publicador->getNome(), $publicador->getSobrenome(), $message, "Recuperacao de usuario", "");
                        $_SESSION['mensagem'] = "Um e-mail para recuperação do usuario foi enviado!";

                        $event = new Eventos(null, $publicador->getId(), null, null, "recPub", "RecUser", $publicador->getUsuario(), null, null, null, null, null, null, null);
                        EventoDAO::getInstance()->create($event);

                        redirect('http://oasisassistant.com/');
                        exit();
                    endif;
                    break;

                case 2:
                    $data_type[0] = "usuario";
                    $data_type[1] = "email";
                    $publicador = PublicadorDAO::getInstance()->readAll($data_type, $detail);

                    if ($publicador->getAccess() === null) :
                        $_SESSION['mensagem'] = "E-mail e/ou Usuário não cadastrado";
                        redirect('http://oasisassistant.com/problem.php');
                        exit();
                    else :
                        $publicador->setSenha('e10adc3949ba59abbe56e057f20f883e');
                        $PublicadorDAO = PublicadorDAO::getInstance()->update($publicador);

                        $message = "<h3>Obrigado por usar o Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $publicador->getNome() . " " . $publicador->getSobrenome() . ", houve uma solicita&ccedil;&atilde;o de recuperar senha em sua conta.<br>Sua senha foi redefinida para <b>123456</b>.<br> Note que essa &eacute; uma senha padr&atilde;o e de baixa seguran&ccedil;a, favor trocar sua senha o mais breve poss&iacute;vel.</p><p>A equipe do <b>Setor de Suporte</b> do <b>Oasis Assistant</b> nunca entra em contato com seus usu&aacute;rios solicitando sua senha, portanto n&atilde;o a compartilhe com ningu&eacute;m.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";

                        $email_send = new Mail();
                        $email_send->sendMail($publicador->getEmail(), $publicador->getNome(), $publicador->getSobrenome(), $message, "Recuperacao de senha", "");
                        $_SESSION['mensagem'] = "Um e-mail para recuperação de senha foi enviado!";

                        $event = new Eventos(null, $publicador->getId(), null, null, "recPub", "RecSenha", "e10adc3949ba59abbe56e057f20f883e", null, null, null, null, null, null, null);
                        EventoDAO::getInstance()->create($event);

                        redirect('http://oasisassistant.com/');
                        exit();
                    endif;
                    break;

                case 3:
                    $data_type[0] = "usuario";
                    $publicador = PublicadorDAO::getInstance()->readAll($data_type, $detail);

                    if ($publicador->getAccess() === null) :
                        $_SESSION['mensagem'] = "Usuário não cadastrado";
                        redirect('http://oasisassistant.com/problem.php');
                        exit();
                    else :
                        $data_type[0] = "usuario";
                        $data_type[1] = "access";
                        $$detail[1] = 0;

                        $publicador = PublicadorDAO::getInstance()->readAll($data_type, $detail);

                        if ($publicador->getAccess() === null) :
                            $_SESSION['mensagem'] = "E-mail da conta já foi autenticado";
                            redirect('http://oasisassistant.com/problem.php');
                            exit();
                        else :
                            $data_type[0] = "usuario";
                            $data_type[1] = "email";
                            $$detail[1] = $_POST['rec2'];

                            $publicador = PublicadorDAO::getInstance()->readAll($data_type, $detail);

                            if ($publicador->getAccess() === null) :
                                $_SESSION['mensagem'] = "E-mail informado no cadastro não confere";
                                redirect('http://oasisassistant.com/problem.php');
                                exit();
                            else :
                                $message = "<h3>Obrigado por usar o Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $publicador->getNome() . " " . $publicador->getSobrenome() . ", houve uma solicita&ccedil;&atilde;o para reenviar o email de autentica&ccedil;&atilde;o em sua conta. Para evitar que tal problema se repita, ser&aacute; enviado um email automaticamente e pouco depois o mesmo e-mail ser&aacute; enviado manualmente, favor desconsiderar duplicatas.<br>Sua conta j&aacute; est&aacute; quase pronta, para concluir seu cadastro e liberar seu acesso basta clicar no link abaixo:<br><br>http://oasisassistant.com/autenticate.php?cd=" . md5($publicador->getUsuario()) . "<br><br>No Oasis Assistant voc&ecirc; ter&aacute; acesso a diversas informa&ccedil;&otilde;es &uacute;teis para o servi&ccedil;o de campo local, fa&ccedil;a bom proveito dessa ferramenta.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";

                                $email_send = new Mail();
                                $email_send->sendMail($publicador->getEmail(), $publicador->getNome(), $publicador->getSobrenome(), $message, "Reenvio de email de autenticacao", "");

                                $event = new Eventos(null, $publicador->getId(), null, null, "recPub", "ReEmailAut", null, null, null, null, null, null, null, null);
                                EventoDAO::getInstance()->create($event);

                                $_SESSION['mensagem'] = "E-mail de autenticação foi reenviado!";

                                redirect('http://oasisassistant.com/');
                                exit();
                            endif;
                        endif;
                    endif;
                    break;
            }
        endif;
    endif;
endif;

if (isset($_POST['btn-pro-plus'])) :
    $detail = $_POST['rec'];
    $detail2 = $_POST['rec2'];

    if (empty($detail) or empty($detail2)) :
        $_SESSION['mensagem'] = "Informações solicitadas não preenchidas";
        redirect('http://oasisassistant.com/problem.php');
        exit();
    else :
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["fileToUpload"]["error"] == 0) :
            // Verifica se é mesmo uma imagem
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) :
                $uploadOk = 1;
            else :
                $uploadOk = 0;
            endif;

            // Verifica tamanho do arquivo
            if ($_FILES["fileToUpload"]["size"] > 1000000) :
                $uploadOk = 0;
            endif;
        else :
            $uploadOk = 0;
        endif;

        if ($uploadOk == 0) :        // Verifica se houve algum erro
            $target_file = '';
        else :                      // Faz upload se nada deu errado
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) :
            else :
                $target_file = '';
            endif;
        endif;

        $message = "<h3>Uma solicita&ccedil;&atilde;o foi enviada no Oasis Assistant!</h3><br><p>Prezado irm&atilde;o Adriano Shineyder, houve uma solicita&ccedil;&atilde;o de resolu&ccedil;&atilde;o de problema n&atilde;o padr&atilde;o feita pelo usu&aacute;rio (ou dono do e-mail) <b>" . $detail2 . "</b>. Segue abaixo a descri&ccedil;&atilde;o do problema:</p><br>" . $detail . "";

        $email_send = new Mail();
        $email_send->sendMail('adrianoshineyder@hotmail.com', 'Adriano', 'Shineyder', strtr($message, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"), "Problema nao padrao", $target_file);
        $_SESSION['mensagem'] = "Solicitação enviada!";

        if ($target_file != '') :
            unlink($target_file);
        endif;

        redirect('http://oasisassistant.com/');
        exit();
    endif;
endif;
