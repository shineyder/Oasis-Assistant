<?php

session_start();

/** Página:
*     Criar Conta
*   Conteúdo:
*     Formulário para criar conta no sistema*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Verificação
if (isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/home.php');
    exit();
endif;

// Message
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/message.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Oasis Assistant - Signup</title>
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
    <link rel="shortcut icon" href="img/logo_oasis_assistant_min.ico">
</head>

<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <img id="logo" src="../img/logo_oasis_assistant.png" alt="Logo Oásis Assistant">
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Cadastrar novo Usuário</p>

            <form action="phpaction/create_pub.php" method="POST">
                <div class="row">
                    <div class="col-5">
                        <div class="input-group mb-3">
                            <input id="nome" name="nome" type="text" class="form-control" placeholder="Nome">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-7">
                        <div class="input-group mb-3">
                            <input id="sobrenome" name="sobrenome" type="text" class="form-control" placeholder="Sobrenome">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.col -->
                </div>
                <div class="input-group mb-3">
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input id="user" name="user" type="text" class="form-control" placeholder="Usuário">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
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
                <div class="input-group mb-3">
                    <input id="repeat-senha" name="repeat-senha" type="password" class="form-control" placeholder="Confirmar Senha">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <button type="submit" name="btn-confirm" class="btn btn-primary btn-block">Criar Conta</button>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <a href="index.php" class="btn btn-danger btn-block">Cancelar</a>
                    </div>
                <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->
        
<?php
// Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
