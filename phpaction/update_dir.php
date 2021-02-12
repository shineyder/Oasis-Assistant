<!--
Página:
    Oculta - Ação PHP - Atualizar dirigentes
Conteúdo:
    Atualiza a informação do servidor com respeito aos dados dos dirigentes. 
-->

<?php

// Sessão
session_start();

// Conexão
require_once 'connect.php';

if (isset($_POST['btn-up-email'])) :
    $id = $_POST['id'];
    $email = $_POST['email-up'];

    if (empty($email)) :
        $_SESSION['mensagem'] = "Campo Novo E-mail não foi preenchido";
        header('Location: ../home.php');
        exit();
    else :
        $sql = "SELECT email FROM dirigentes WHERE id = '$id'";
        $stmt = conectar\Connect::conn()->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetch(\PDO::FETCH_BOTH);
        if ($dados[0] == $email) :
            $_SESSION['mensagem'] = "E-mail antigo e novo são iguais";
            header('Location: ../home.php');
            exit();
        else :
            $sql = "UPDATE dirigentes SET email = '$email' WHERE id = '$id'";
            $stmt = conectar\Connect::conn()->prepare($sql);
            $stmt->execute();
            $_SESSION['mensagem'] = "E-mail alterado com sucesso!";
            $stmt = conectar\Connect::closeConn();
            header('Location: ../home.php');
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
        header('Location: ../home.php');
        exit();
    else :
        if ($senha != $senha_conf) :
            $_SESSION['mensagem'] = "As novas senhas preenchidas não são iguais";
            header('Location: ../home.php');
            exit();
        else :
            $sql = "SELECT senha FROM dirigentes WHERE id = '$id'";
            $stmt = conectar\Connect::conn()->prepare($sql);
            $stmt->execute();
            $dados = $stmt->fetch(\PDO::FETCH_BOTH);
            if ($dados[0] != md5($senha_old)) :
                $_SESSION['mensagem'] = "Senha antiga não confere";
                $stmt = conectar\Connect::closeConn();
                header('Location: ../home.php');
                exit();
            else :
                $senha = md5($senha);
                $sql = "UPDATE dirigentes SET senha = '$senha' WHERE id = '$id'";
                $stmt = conectar\Connect::conn()->prepare($sql);
                $stmt->execute();
                $_SESSION['mensagem'] = "Senha alterada com sucesso!";
                $stmt = conectar\Connect::closeConn();
                header('Location: ../home.php');
                exit();
            endif;
        endif;
    endif;
endif;
