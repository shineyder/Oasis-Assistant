<?php

session_start();

/** Página:
*     Inicial
*   Conteúdo:
*     Área de LogIn, opções de Criar Conta e Problemas de LogIn.*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Verificação
if (isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/home.php');
    exit();
endif;

// Message
require_once 'includes/message.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Oasis Assistant - Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="_CSS/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="_CSS/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="_CSS/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="_CSS/toastr.min.css">

    <link rel="stylesheet" href= "_CSS/style.css"/>
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <img id="logo" src="../img/logo_oasis_assistant.png" alt="Logo Oásis Assistant">
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Login</p>

            <form action="phpaction/login.php" method="POST">
                <div class="input-group mb-3">
                    <input id="login" name="login" type="text" class="form-control" placeholder="Usuário">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="senha" name="senha" type="password" class="form-control" placeholder="Senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <button type="submit" name="btn-entrar" class="btn btn-primary btn-block">Entrar</button>
            </form>
            <p class="mb-1">
                <a href="problem.php">Problemas com Login?</a>
            </p>
            <p class="mb-0">
                <a href="signup.php" class="text-center">Criar conta</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<?php
//Footer
require_once 'includes/footer.php';
?>
