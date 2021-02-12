<!--
Página:
    Oculta - Ação PHP - Criar Dirigente
Conteúdo:
    Insere informação no servidor com respeito a novos dirigentes. 
-->

<?php

// Função redirect
require_once 'redirect.php';

// Sessão
session_start();

// Conexão
require_once 'connect.php';
require_once 'sendemail.php';

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
            $sql = "SELECT usuario FROM dirigentes WHERE usuario = '$user'";
            $stmt = conectar\Connect::conn()->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() != 0) :
                $_SESSION['mensagem'] = "Usuário já registrado";
                $stmt = conectar\Connect::closeConn();
                redirect('http://oasisassistant.com/signup.php');
                exit();
            else :
                $sql = "SELECT email FROM dirigentes WHERE email = '$email'";
                $stmt = conectar\Connect::conn()->prepare($sql);
                $stmt->execute();
                if ($stmt->rowCount() != 0) :
                    $_SESSION['mensagem'] = "E-mail já cadastrado";
                    $stmt = conectar\Connect::closeConn();
                    redirect('http://oasisassistant.com/signup.php');
                    exit();
                else :
                    $senha = md5($senha);
                    $sql = "INSERT INTO dirigentes (nome, sobrenome, email, usuario, senha) VALUES ('$nome', '$sobrenome', '$email', '$user', '$senha')";
                    $stmt = conectar\Connect::conn()->prepare($sql);
                    $stmt->execute();
                    $stmt = conectar\Connect::closeConn();
                    $_SESSION['mensagem'] = "Cadastrado com sucesso!";

                    $message = "<h3>Bem vindo ao Oasis Assistant!</h3><br><p>Prezado irm&atilde;o " . $nome . " " . $sobrenome . ", sua conta j&aacute; est&aacute; quase pronta, para concluir seu cadastro e liberar seu acesso basta clicar no link abaixo:<br><br>http://oasisassistant.com/autenticate.php?cd=" . md5($user) . "<br><br>No Oasis Assistant voc&ecirc; ter&aacute; acesso a diversas informa&ccedil;&otilde;es &uacute;teis para o servi&ccedil;o de campo local, fa&ccedil;a bom proveito dessa ferramenta.</p><p>Se voc&ecirc; n&atilde;o &eacute; a pessoa a quem foi destinado esse e-mail, favor desconsidere-o.</p><p>Qualquer d&uacute;vida estamos &agrave; disposi&ccedil;&atilde;o.</p><br><p>Seus irm&atilde;os,<br><b>Oasis Assistant<br>Setor de Suporte</b></p>";

                    $email_send = new EnviarEmail\Mail();
                    $email_send->sendMail($email, $nome, $sobrenome, $message, "E-mail de Autenticacao", "");
                    header('Location: ../index.php');
                    exit();
                endif;
            endif;
        endif;
    endif;
endif;
