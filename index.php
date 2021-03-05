<?php

session_start();

/** Página:
*     Inicial
*   Conteúdo:
*     Área de LogIn, opções de Criar Conta e Problemas de LogIn.*/

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Verificação
if (isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/home.php');
    exit();
endif;

// Header
require_once 'includes/header.php';
// Message
require_once 'includes/message.php';
?>

<!-- ABERTURA DAS ESTRUTURAS DE CONTEUDO-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Login</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Login</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
<!-- /.ABERTURA DAS ESTRUTURAS DE CONTEUDO-->

<div class="row">
    <form class="col s12 m8 push-m2" action="phpaction/login.php" method="POST">
        <div class="row">
            <div class="input-field col s8">
                <input id="login" name="login" type="text" class="validate">
                <label for="login">Login</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="senha" name="senha" type="password" class="validate">
                <label for="senha">Senha</label>
            </div>
        </div>
        <button type="submit" name="btn-entrar" class="btn blue darken-2">Entrar</button>
        <a href="signup.php" class="btn blue darken-2">Criar conta</a>
        <a href="problem.php" class="btn red lighten-2">Problemas com Login</a>
    </form>
</div>

<!-- FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->
</div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<!-- /.FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->
    
<?php
//Footer
require_once 'includes/footer.php';
?>
