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

    <b>Nome: </b> <?php echo $dados['nome'];?> <br>
    <b>Sobrenome: </b> <?php echo $dados['sobrenome'];?> <br>
    <b>Email: </b> <?php echo $dados['email'];?> <br>
    <b>Usuário: </b> <?php echo $dados['usuario'];?> <br><br>
    <a href="" class="btn-small blue darken-4">Alterar Email</a>
    <a href="" class="btn-small blue darken-4">Alterar Senha</a>

<?php
//Footer
include_once 'includes/footer.php';
?>
