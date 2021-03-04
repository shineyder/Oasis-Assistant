<?php
session_start();
?>
<!--
Página:
    Oculta - Ação PHP - LogIn
Conteúdo:
    Confere usuário e senha e inicia sessão. 
-->

<?php
// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\PublicadorDAO;

if (isset($_POST['btn-entrar'])) :
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) or empty($senha)) :
        $_SESSION['mensagem'] = "Os campos Login e Senha precisam ser preenchidos";
        redirect('https://oasisassistant.000webhostapp.com/');
        exit();
    else :
        $PublicadorDAO = PublicadorDAO::getInstance()->read('usuario', $login, 'usuario');
        
        if ($PublicadorDAO->rowCount() == 1) :
            $senha = md5($senha);
            $PublicadorDAO = PublicadorDAO::getInstance()->logIn($login, $senha);
            if ($PublicadorDAO->getAccess() === null) :
                $_SESSION['mensagem'] = "Usuário e senha não conferem";
                redirect('https://oasisassistant.000webhostapp.com/');
                exit();
            else :
                if ($PublicadorDAO->getAccess() != 0) :
                    $_SESSION['logado'] = true;
                    $_SESSION['obj'] = serialize($PublicadorDAO);
                    redirect('https://oasisassistant.000webhostapp.com/home.php');
                    exit();
                else :
                    $_SESSION['mensagem'] = "Acesse o email de verificação para liberar o acesso a conta";
                    redirect('https://oasisassistant.000webhostapp.com/');
                    exit();
                endif;
            endif;
        else :
            $_SESSION['mensagem'] = "Usuário inexistente";
            redirect('https://oasisassistant.000webhostapp.com/');
            exit();
        endif;
    endif;
endif;
?>
