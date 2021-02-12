<!--
Página:
    Criar Conta
Conteúdo:
    Formulário para criar conta no sistema
-->

<?php

//Sessão
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
    <form class="col s12 push-s2 m8 push-m2" action="phpaction/create_dir.php" method="POST">
        <div class="row">
            <div class="input-field col s4">
                <input id="nome" name="nome" type="text" class="validate">
                <label for="nome">Nome</label>
            </div>
            <div class="input-field col s4">
                <input id="sobrenome" name="sobrenome" type="text" class="validate">
                <label for="sobrenome">Sobrenome</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="email" name="email" type="email" class="validate">
                <label for="email">E-mail</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="user" name="user" type="text" class="validate">
                <label for="user">Usuário</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="senha" name="senha" type="password" class="validate">
                <label for="senha">Senha</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <input id="repeat-senha" name="repeat-senha" type="password" class="validate">
                <label for="repeat-senha">Confirmar Senha</label>
            </div>
        </div>
        
        <button type="submit" name="btn-confirm" class="btn blue darken-2">Criar Conta</button>
        <a href="index.php" class="btn red darken-2">Cancelar</a>
    </form>
</div>
        
<?php
// Footer
require_once 'includes/footer.php';
?>
