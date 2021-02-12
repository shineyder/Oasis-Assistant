<!--
Página:
    Oculta - Ação PHP - LogIn
Conteúdo:
    Confere usuário e senha e inicia sessão. 
-->

<?php

// Sessão
session_start();

// Conexão
require_once 'connect.php';

if (isset($_POST['btn-entrar'])) :
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) or empty($senha)) :
        $_SESSION['mensagem'] = "Os campos Login e Senha precisam ser preenchidos";
        header('Location: ../index.php');
        exit();
    else :
        $sql = "SELECT usuario FROM dirigentes WHERE usuario = '$login'";
        $stmt = conectar\Connect::conn()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 1) :
            $senha = md5($senha);
            $sql = "SELECT * FROM dirigentes WHERE usuario = '$login' AND senha = '$senha'";
            $stmt = conectar\Connect::conn()->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_BOTH);
            if ($stmt->rowCount() == 1 and $dados['access'] != 0) :
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                $stmt = conectar\Connect::closeConn();
                header('Location: ../home.php');
                exit();
            else :
                if ($stmt->rowCount() != 1) :
                    $_SESSION['mensagem'] = "Usuário e senha não conferem";
                    $stmt = conectar\Connect::closeConn();
                    header('Location: ../index.php');
                    exit();
                else :
                    $_SESSION['mensagem'] = "Acesse o email de verificação para liberar o acesso a conta";
                    $stmt = conectar\Connect::closeConn();
                    header('Location: ../index.php');
                    exit();
                endif;
            endif;
        else :
            $_SESSION['mensagem'] = "Usuário inexistente";
            $stmt = conectar\Connect::closeConn();
            header('Location: ../index.php');
            exit();
        endif;
    endif;
endif;
