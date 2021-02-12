<!--
Página:
    Inicial
Conteúdo:
    Área de LogIn, opções de Criar Conta e Problemas de LogIn. 
-->
<?php

// Função redirect
require_once 'phpaction/redirect.php';

// Sessão
session_start();

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
    
<?php
//Footer
require_once 'includes/footer.php';
?>
