<!--
Página:
    Problemas de login
Conteúdo:
    Sessão com opção de recuperar senha e reenviar email de autenticação. 
-->
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

NÃO CONSIGO LOGAR QQEUFAÇO?

<?php
//Footer
require_once 'includes/footer.php';
?>