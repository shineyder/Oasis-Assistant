<!--
Página:
    Oculta - Ação PHP - LogOut
Conteúdo:
    Encerra a sessão. 
-->

<?php

//Encerrando a sessão
session_start();
session_unset();
session_destroy();
header('Location: ../index.php');
