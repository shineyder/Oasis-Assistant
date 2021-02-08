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

// Header
include_once 'includes/header.php';
// Message
include_once 'includes/message.php';
?>

<img src="mapas/Mapa_completo.jpg" alt="">

<?php
//Footer
include_once 'includes/footer.php';
?>
