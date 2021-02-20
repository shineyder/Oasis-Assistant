<!--
Página:
    Oculta - Ação PHP - Criar publicador
Conteúdo:
    Insere informação no servidor com respeito a novos Publicadores. 
-->

<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Sessão
session_start();

use Assistant\PublicadorDAO;
use Assistant\Publicadores;
use Assistant\EventoDAO;
use Assistant\Eventos;

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
            $PublicadorDAO = PublicadorDAO::getInstance()->read('usuario', $user, 'usuario');
            if ($PublicadorDAO->rowCount() != 0) :
                $_SESSION['mensagem'] = "Usuário já registrado";
                redirect('http://oasisassistant.com/signup.php');
                exit();
            else :
                $PublicadorDAO = PublicadorDAO::getInstance()->read('email', $email, 'email');
                if ($PublicadorDAO->rowCount() != 0) :
                    $_SESSION['mensagem'] = "E-mail já cadastrado";
                    redirect('http://oasisassistant.com/signup.php');
                    exit();
                else :
                    $senha = md5($senha);
                    $publicador = new Publicadores(null, $nome, $sobrenome, null, $email, $user, $senha, null);
                    $PublicadorDAO = PublicadorDAO::getInstance()->create($publicador);

                    if ($PublicadorDAO) :
                        $_SESSION['mensagem'] = "Cadastrado com sucesso!";

                        $evento = new Eventos(null, null, null, null, "criatePub", "nome", $publicador->getNome(), "sobrenome", $publicador->getSobrenome(), "email", $publicador->getEmail(), "user", $publicador->getUsuario(), null);
                        EventoDAO::getInstance()->create($evento);

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
