<!--
Página:
    Autenticação
Conteúdo:
    Sessão de autenticação de email.
Detalhes:
    Usuários sem email autenticado tem permissão de acesso nível 0 e não conseguem logar, ao autenticar o email o nivel de acesso se torna 1. 
-->

<?php

// Função redirect
require_once 'phpaction/redirect.php';

//Conexão
require_once 'phpaction/connect.php';

// Sessão
session_start();

//Verificação
if (!isset($_GET['cd'])) :
    redirect('http://oasisassistant.com/');
    exit();
endif;

//Dados
$sql = "SELECT id FROM dirigentes ORDER BY id DESC";
$stmt = conectar\Connect::conn()->prepare($sql);
$stmt->execute();
$dados_last = $stmt->fetch(\PDO::FETCH_BOTH);

for ($i = 1; $i <= $dados_last['id']; $i++) {
    $sql = "SELECT usuario FROM dirigentes WHERE id = '$i' AND access = 0";
    $stmt = conectar\Connect::conn()->prepare($sql);
    $stmt->execute();
    $dadostemp = $stmt->fetch(\PDO::FETCH_BOTH);

    if ($dadostemp != false) {
        if ($_GET['cd'] == md5($dadostemp['usuario'])) {
            $sql = "UPDATE dirigentes SET access = 1 WHERE id = '$i'";
            $stmt = conectar\Connect::conn()->prepare($sql);
            $stmt->execute();
            break;
        }
    }
}

$stmt = conectar\Connect::closeConn();

// Header
require_once 'includes/header.php';
// Message
require_once 'includes/message.php';
?>

<div class="center">
    <h4>Autenticação concluida com sucesso!</h4>
    <p>Seu email foi autenticado e seu acesso ao Oasis Assistant foi liberado.</p>
    <a href="index.php" class="btn blue darken-2">Fazer LogIn</a>
</div>

<?php
//Footer
require_once 'includes/footer.php';
?>
