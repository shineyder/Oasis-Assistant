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
    else :
        $sql = "SELECT usuario FROM dirigentes WHERE usuario = '$login'";
        $stmt = connect::conn()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 1) :
            $senha = md5($senha);
            $sql = "SELECT * FROM dirigentes WHERE usuario = '$login' AND senha = '$senha'";
            $stmt = connect::conn()->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_BOTH);
            if ($stmt->rowCount() == 1 and $dados['access'] != 0) :
                $stmt = connect::closeConn();
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                header('Location: ../home.php');
            else :
                if ($stmt->rowCount() != 1) :
                    $_SESSION['mensagem'] = "Usuário e senha não conferem";
                    header('Location: ../index.php');
                else :
                    $_SESSION['mensagem'] = "Acesse o email de verificação para liberar o acesso a conta";
                    header('Location: ../index.php');
                endif;
            endif;
        else :
            $_SESSION['mensagem'] = "Usuário inexistente";
            header('Location: ../index.php');
        endif;
    endif;
endif;
