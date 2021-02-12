<!--
Página:
    Oculta - Ação PHP - LogOut
Conteúdo:
    Encerra a sessão. 
-->

<?php
// Função redirect
require_once 'redirect.php';

//Encerrando a sessão
session_start();
session_unset();
session_destroy();
redirect('http://oasisassistant.com/');
exit();
