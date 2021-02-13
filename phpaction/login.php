<!--
Página:
    Oculta - Ação PHP - LogIn
Conteúdo:
    Confere usuário e senha e inicia sessão. 
-->

<?php

// Função redirect

require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Sessão
session_start();

//Dirigente e DirigenteDAO
require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/dirigente.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/dirigenteDao.php';

if (isset($_POST['btn-entrar'])) :
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) or empty($senha)) :
        $_SESSION['mensagem'] = "Os campos Login e Senha precisam ser preenchidos";
        redirect('http://oasisassistant.com/');
        exit();
    else :
        $dirigenteDAO = Dirigente\DirigenteDAO::getInstance()->read('usuario', $login, 'usuario');

        if ($dirigenteDAO->rowCount() == 1) :
            $senha = md5($senha);
            $dirigenteDAO = Dirigente\DirigenteDAO::getInstance()->logIn($login, $senha);
            if ($dirigenteDAO->getAccess() === null) :
                $_SESSION['mensagem'] = "Usuário e senha não conferem";
                redirect('http://oasisassistant.com/');
                exit();
            else :
                if ($dirigenteDAO->getAccess() != 0) :
                    $_SESSION['logado'] = true;
                    $_SESSION['obj'] = serialize($dirigenteDAO);
                    redirect('http://oasisassistant.com/home.php');
                    exit();
                else :
                    $_SESSION['mensagem'] = "Acesse o email de verificação para liberar o acesso a conta";
                    redirect('http://oasisassistant.com/');
                    exit();
                endif;
            endif;
        else :
            $_SESSION['mensagem'] = "Usuário inexistente";
            redirect('http://oasisassistant.com/');
            exit();
        endif;
    endif;
endif;

?>
