<!--
Página:
    Master
Conteúdo:
    Apresenta todos os usuários cadastrados, histórico de alterações nos cadastros, histórico de relatórios emitidos e a opção de emitir a S-13. Nível de visibilidade da página será definido pelo nível de acesso do usuário
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

//Verificação de nível de acesso
if ($dados['access'] <= 2) :
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
