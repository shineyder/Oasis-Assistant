<?php

// Sessão
session_start();

// Conexão
require_once 'connect.php';

if (isset($_POST['btn-confirm'])) :
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $user = $_POST['user'];
    $senha = $_POST['senha'];
    $repeatsenha = $_POST['repeat-senha'];

    if (empty($nome) or empty($sobrenome) or empty($email) or empty($user) or empty($senha) or empty($repeatsenha)) :
        $_SESSION['mensagem'] = "Todos os campos precisam ser preenchidos";
        header('Location: ../signup.php');
    else :
        if ($senha != $repeatsenha) :
            $_SESSION['mensagem'] = "As senhas preenchidas não são iguais";
            header('Location: ../signup.php');
        else :
            $sql = "SELECT usuario FROM dirigentes WHERE usuario = '$user'";
            $stmt = connect::conn()->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() != 0) :
                $_SESSION['mensagem'] = "Usuário já registrado";
                header('Location: ../signup.php');
            else :
                $senha = md5($senha);
                $sql = "INSERT INTO dirigentes (nome, sobrenome, email, usuario, senha) VALUES ('$nome', '$sobrenome', '$email', '$user', '$senha')";
                $stmt = connect::conn()->prepare($sql);
                $stmt->execute();
                $stmt = connect::closeConn();
                $_SESSION['mensagem'] = "Cadastrado com sucesso!";
                header('Location: ../index.php');
            endif;
        endif;
    endif;
endif;
