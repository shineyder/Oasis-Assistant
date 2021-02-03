<?php
require_once 'connect.php';

// Sessão
session_start();

//Verificação
if (!isset($_SESSION['logado'])) :
    header('Location: index.php');
endif;

//Dados
$id = $_SESSION['id_usuario'];
$sql = "SELECT * FROM dirigentes WHERE id = '$id'";
$stmt = connect::conn()->prepare($sql);
$stmt->execute();
$dados = $stmt->fetch(\PDO::FETCH_BOTH);
$stmt = connect::closeConn();
?>

<?php
// Header
include_once 'includes/header.php';
// Message
include_once 'includes/message.php';
?>

        <h1> Olá <?php echo $dados['nome'];?></h1>
    <a href="logout.php">Sair</a>

<?php
//Footer
include_once 'includes/footer.php';
?>
