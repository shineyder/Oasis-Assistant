<?php

session_start();

/** Página:
*     Oculta - Ação PHP - LogOut
*   Conteúdo:
*     Encerra a sessão.*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Encerrando a sessão
session_unset();
session_destroy();
redirect('https://oasisassistant.000webhostapp.com/');
exit();
