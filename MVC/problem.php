<?php

session_start();

/** Página:
*     Problemas de login
*   Conteúdo:
*     Sessão com opção de recuperar senha e reenviar email de autenticação.*/

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

<body class="hold-transition register-page"> <!--adaptado para PROBLEMAS COM LOGIN-->
<div class="register-box">
    <div class="register-logo">
        <img id="logo" src="../img/logo_oasis_assistant.png" alt="Logo Oásis Assistant">
    </div>

    <form action="#" method="POST">
        <div class="form-group">
            <label>Selecione a opção que se enquadra com seu caso</label>
            <select id="problem" name="problem" class="form-control select2bs4" style="width: 100%;">
                <option value="" disabled selected>Selecione uma opção</option>
                <option value="1">Esqueci meu usuário</option>
                <option value="2">Esqueci minha senha</option>
                <option value="3">Não recebi e-mail de autenticação</option>
                <option value="4">Outro</option>
            </select>
        </div>
        <button type="submit" name="btn-prox" class="btn btn-primary btn-block">Próximo</button>
    </form>

    <div class="card">
        <div class="card-body register-card-body">
            <form action="phpaction/recover.php" method="POST" enctype="multipart/form-data" role="form">
                <?php
                if (isset($_POST['btn-prox'])) {
                    ?>
                    <p class="login-box-msg">Recuperação de conta</p>
                    <?php
                    switch ($_POST['problem']) {
                        case 1:
                            ?>
                            <div class="input-group mb-3">
                                <input id="rec" name="rec" type="email" class="form-control" placeholder="Digite o E-mail usado no cadastro">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="cod_err" value="<?php echo $_POST['problem'];?>">
                            <br>
                            <button type="submit" name="btn-pro" class="btn btn-primary btn-block">Enviar</button>
                            <?php
                            break;
                        case 2:
                            ?>
                            <div class="input-group mb-3">
                                <input id="rec" name="rec" type="text" class="form-control" placeholder="Digite o Usuário usado no cadastro">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input id="rec2" name="rec2" type="email" class="form-control" placeholder="Digite o E-mail usado no cadastro">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="cod_err" value="<?php echo $_POST['problem'];?>">
                            <br>
                            <button type="submit" name="btn-pro" class="btn btn-primary btn-block">Enviar</button>
                            <?php
                            break;
                        case 3:
                            ?>
                            <div class="input-group mb-3">
                                <input id="rec" name="rec" type="text" class="form-control" placeholder="Digite o Usuário usado no cadastro">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input id="rec2" name="rec2" type="email" class="form-control" placeholder="Digite o E-mail usado no cadastro">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="cod_err" value="<?php echo $_POST['problem'];?>">
                            <br>
                            <button type="submit" name="btn-pro" class="btn btn-primary btn-block">Enviar</button>
                            <?php
                            break;
                        case 4:
                            ?>
                            <div class="form-group">
                                <label>Explique qual problema está tendo</label>
                                <textarea id="rec" name="rec" class="form-control" rows="3" placeholder="Digite ..."></textarea>
                            </div>
                            <div class="input-group mb-3">
                                <input id="rec2" name="rec2" type="text" class="form-control" placeholder="Digite o Usuário ou E-mail usado no cadastro">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                        &nbsp;
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" id="fileToUpload" name="fileToUpload" accept="image/png, image/jpeg" class="custom-file-input">
                                    <label class="custom-file-label" for="fileToUpload">Envie uma foto do problema</label>
                                    <span>Arquivo limitado a 1Mb (.png ou .jpeg)</span>
                                </div>
                            </div>
                            <br>
                            <button type="submit" name="btn-pro-plus" class="btn btn-primary btn-block">Enviar</button>
                            <?php
                            break;
                    }
                }
                ?>
            </form>
        </div>
        <!-- /.form-box -->
        <a href="index.php" class="btn btn-danger btn-block">Cancelar</a>
    </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- Page script -->
<script>
    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
</script>

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>