<!--
Página:
    Meus Relatórios
Conteúdo:
    Apresenta todos os relatórios feitos pelo usuário e permite alterar ou deletar relatórios feitos nas últimas 24hrs.
-->
<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

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
$id = $_SESSION['id_usuario'];
$sql = "SELECT * FROM dirigentes WHERE id = '$id'";
$stmt = conectar\Connect::conn()->prepare($sql);
$stmt->execute();
$dados = $stmt->fetch(\PDO::FETCH_BOTH);
$stmt = conectar\Connect::closeConn();

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
