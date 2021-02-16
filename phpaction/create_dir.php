<!--
Página:
    Oculta - Ação PHP - Criar Dirigente
Conteúdo:
    Insere informação no servidor com respeito a novos dirigentes. 
-->

<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Sessão
session_start();

use Assistant\DirigenteDAO;
use Assistant\Dirigentes;

if (isset($_POST['btn-confirm'])) :
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    $repeatsenha = $_POST['repeat-senha'];

    if (empty($nome) or empty($sobrenome) or empty($email) or empty($user) or empty($senha) or empty($repeatsenha)) :
        $_SESSION['mensagem'] = "Todos os campos precisam ser preenchidos";
        redirect('http://oasisassistant.com/signup.php');
        exit();
    else :
        if ($senha != $repeatsenha) :
            $_SESSION['mensagem'] = "As senhas preenchidas não são iguais";
            redirect('http://oasisassistant.com/signup.php');
            exit();
        else :
            $dirigenteDAO = DirigenteDAO::getInstance()->read('usuario', $user, 'usuario');
            if ($dirigenteDAO->rowCount() != 0) :
                $_SESSION['mensagem'] = "Usuário já registrado";
                redirect('http://oasisassistant.com/signup.php');
                exit();
            else :
                $dirigenteDAO = DirigenteDAO::getInstance()->read('email', $email, 'email');
                if ($dirigenteDAO->rowCount() != 0) :
                    $_SESSION['mensagem'] = "E-mail já cadastrado";
                    redirect('http://oasisassistant.com/signup.php');
                    exit();
                else :
                    $senha = md5($senha);
                    $dirigente = new Dirigentes(null, $nome, $sobrenome, $email, $user, $senha, null);
                    $dirigenteDAO = DirigenteDAO::getInstance()->create($dirigente);

                    if ($dirigenteDAO) :
                        $_SESSION['mensagem'] = "Cadastrado com sucesso!";
                        header('Location: ../index.php');
                        exit();
                    else :
                        $_SESSION['mensagem'] = "Ocorreu algum erro em sua solicitação, tente novamente mais tarde";
                        header('Location: ../index.php');
                        exit();
                    endif;
                endif;
            endif;
        endif;
    endif;
endif;
