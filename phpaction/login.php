<?php

session_start();

/** Página:
*     Oculta - Ação PHP - LogIn
*   Conteúdo:
*     Confere usuário e senha e inicia sessão.*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\PublishersDAO;

if (isset($_POST['btn-entrar'])) :
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) or empty($senha)) :
        $_SESSION['message'] = "Os campos Login e Senha precisam ser preenchidos";
        $_SESSION['tipo'] = "warning";
        redirect('http://oasisassistant.com/');
        exit();
    else :
        $PublicadorDAO = PublishersDAO::getInstance()->read('usuario', $login, 'usuario');

        if ($PublicadorDAO->rowCount() == 1) :
            $senha = md5($senha);
            $PublicadorDAO = PublishersDAO::getInstance()->logIn($login, $senha);
            if ($PublicadorDAO->getAccess() === null) :
                $_SESSION['message'] = "Usuário e senha não conferem";
                $_SESSION['tipo'] = "warning";
                redirect('http://oasisassistant.com/');
                exit();
            else :
                if ($PublicadorDAO->getAccess() != 0) :
                    $_SESSION['logado'] = true;
                    $_SESSION['obj'] = serialize($PublicadorDAO);
                    redirect('http://oasisassistant.com/home.php');
                    exit();
                else :
                    $_SESSION['message'] = "Acesse o email de verificação para liberar o acesso a conta";
                    $_SESSION['tipo'] = "info";
                    redirect('http://oasisassistant.com/');
                    exit();
                endif;
            endif;
        else :
            $_SESSION['message'] = "Usuário inexistente";
            $_SESSION['tipo'] = "warning";
            redirect('http://oasisassistant.com/');
            exit();
        endif;
    endif;
endif;
