<?php

session_start();

/** Página:
*     Oculta - Ação PHP - Criar publicador
*   Conteúdo:
*     Insere informação no servidor com respeito a novos Publicadores.*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\PublishersDAO;
use Assistant\Publishers;
use Assistant\EventsDAO;
use Assistant\Events;

if (isset($_POST['btn-confirm'])) :
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    $repeatsenha = $_POST['repeat-senha'];

    if (empty($nome) or empty($sobrenome) or empty($email) or empty($user) or empty($senha) or empty($repeatsenha)) :
        $_SESSION['message'] = "Todos os campos precisam ser preenchidos";
        $_SESSION['tipo'] = "warning";
        redirect('http://oasisassistant.com/signup.php');
        exit();
    else :
        if ($senha != $repeatsenha) :
            $_SESSION['message'] = "As senhas preenchidas não são iguais";
            $_SESSION['tipo'] = "warning";
            redirect('http://oasisassistant.com/signup.php');
            exit();
        else :
            $PublicadorDAO = PublishersDAO::getInstance()->read('usuario', $user, 'usuario');
            if ($PublicadorDAO->rowCount() != 0) :
                $_SESSION['message'] = "Usuário já registrado";
                $_SESSION['tipo'] = "warning";
                redirect('http://oasisassistant.com/signup.php');
                exit();
            else :
                $PublicadorDAO = PublishersDAO::getInstance()->read('email', $email, 'email');
                if ($PublicadorDAO->rowCount() != 0) :
                    $_SESSION['message'] = "E-mail já cadastrado";
                    $_SESSION['tipo'] = "warning";
                    redirect('http://oasisassistant.com/signup.php');
                    exit();
                else :
                    $senha = md5($senha);
                    $publicador = new Publishers(null, $nome, $sobrenome, null, $email, $user, $senha, null);
                    $PublicadorDAO = PublishersDAO::getInstance()->create($publicador);

                    if ($PublicadorDAO) :
                        $_SESSION['message'] = "Cadastrado com sucesso!";
                        $_SESSION['tipo'] = "success";

                        $evento = new Events(null, null, null, null, "createPub", "nome", $publicador->getNome(), "sobrenome", $publicador->getSobrenome(), "email", $publicador->getEmail(), "user", $publicador->getUsuario(), null);
                        EventsDAO::getInstance()->create($evento);

                        header('Location: ../index.php');
                        exit();
                    else :
                        $_SESSION['message'] = "Ocorreu algum erro em sua solicitação, tente novamente mais tarde";
                        $_SESSION['tipo'] = "error";
                        header('Location: ../index.php');
                        exit();
                    endif;
                endif;
            endif;
        endif;
    endif;
endif;
