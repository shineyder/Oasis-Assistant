<!--
Página:
    Master
Conteúdo:
    Apresenta todos os usuários cadastrados, histórico de alterações nos cadastros, histórico de relatórios emitidos e a opção de emitir a S-13. Nível de visibilidade da página será definido pelo nível de acesso do usuário
-->
<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Dirigente e DirigenteDAO
require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/dirigente.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/dirigenteDao.php';

//Conexão
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/connect.php';

// Sessão
session_start();

//Verificação
if (!isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/');
    exit();
endif;

//Dados
$dirigente = unserialize($_SESSION['obj']);

//Verificação de nível de acesso
if ($dirigente->getAccess() <= 2) :
    redirect('http://oasisassistant.com/home.php');
    exit();
endif;

// Header
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
// Message
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/message.php';
?>

TEM Q FAZER ISSO AE TAOKEY?
    
<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
