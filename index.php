<?php

// Sessão
session_start();

//Verificação
if (isset($_SESSION['logado'])) :
    header('Location: home.php');
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
        <a href="recovery.php" class="btn red lighten-2">Recuperar senha</a>
    </form>
</div>
    
<?php
//Footer
require_once 'includes/footer.php';
?>
