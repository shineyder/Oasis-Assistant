<!DOCTYPE html>
<?php
require_once 'connect.php';

//Sessão
session_start();

//Verificação
if(!isset($_SESSION['logado'])):
	header('Location: index.php');
endif;

//Dados
$id= $_SESSION['id_usuario'];
$sql = "SELECT * FROM dirigentes WHERE id = '$id'";
$stmt = connect::conn()->prepare($sql);
$stmt->execute();
$dados = $stmt->fetch(\PDO::FETCH_BOTH);
$stmt = connect::closeConn();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Página Restrita</title>
    </head>
    <body>
        <h1> Olá <?php echo $dados['nome'];?></h1>
	<a href="logout.php">Sair</a>
    </body>
</html>
