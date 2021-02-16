<!--
Página:
    Oculta - Ação PHP - Atualizar dirigentes
Conteúdo:
    Atualiza a informação do servidor com respeito aos dados dos dirigentes. 
-->

<?php

// Função redirect

require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Sessão
session_start();

use Assistant\DirigenteDAO;

if (isset($_POST['btn-up-email'])) :
    $id = $_POST['id'];
    $email = $_POST['email-up'];

    if (empty($email)) :
        $_SESSION['mensagem'] = "Campo Novo E-mail não foi preenchido";
        redirect('http://oasisassistant.com/home.php');
        exit();
    else :
        $data_type = ['id', 'email'];
        $detail = [$id, $email];
        $dirigenteup = DirigenteDAO::getInstance()->readAll($data_type, $detail);

        if ($dirigenteup->getAccess() !== null) :
            $_SESSION['mensagem'] = "E-mail antigo e novo são iguais";
            redirect('http://oasisassistant.com/home.php');
            exit();
        else :
            $data_type = ['id', ""];
            $detail = [$id, ""];
            $dirigenteup = DirigenteDAO::getInstance()->readAll($data_type, $detail);
            $dirigenteup->setEmail($email);
            $dirigenteDAO = DirigenteDAO::getInstance()->update($dirigenteup);
            $_SESSION['obj'] = serialize($dirigenteup);
            $_SESSION['mensagem'] = "E-mail alterado com sucesso!";
            redirect('http://oasisassistant.com/home.php');
            exit();
        endif;
    endif;
endif;

if (isset($_POST['btn-up-senha'])) :
    $id = $_POST['id'];
    $senha_old = $_POST['senha-old'];
    $senha = $_POST['senha-up'];
    $senha_conf = $_POST['senha-up-conf'];

    if (empty($senha_old) or empty($senha) or empty($senha_conf)) :
        $_SESSION['mensagem'] = "Todos os campos precisam ser preenchidos";
        redirect('http://oasisassistant.com/home.php');
        exit();
    else :
        if ($senha != $senha_conf) :
            $_SESSION['mensagem'] = "As novas senhas preenchidas não são iguais";
            redirect('http://oasisassistant.com/home.php');
            exit();
        else :
            $data_type = ['id', 'senha'];
            $detail = [$id, md5($senha_old)];
            $dirigenteup = DirigenteDAO::getInstance()->readAll($data_type, $detail);

            if ($dirigenteup->getAccess() === null) :
                $_SESSION['mensagem'] = "Senha antiga não confere";
                redirect('http://oasisassistant.com/home.php');
                exit();
            else :
                $senha = md5($senha);
                $dirigenteup->setSenha($senha);
                $dirigenteDAO = DirigenteDAO::getInstance()->update($dirigenteup);
                $_SESSION['obj'] = serialize($dirigenteup);
                $_SESSION['mensagem'] = "Senha alterada com sucesso!";
                redirect('http://oasisassistant.com/home.php');
                exit();
            endif;
        endif;
    endif;
endif;
?>
